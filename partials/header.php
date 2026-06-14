<?php
    if(isset($_SESSION['id'])){
        $db = Database::Connect();
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$_SESSION['id']]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/design/style.css?v=<?= time() . '2' ?>">
    <link rel="stylesheet" href="./public/design/premium.css?v=<?= time() ?>">
    <link rel="stylesheet" href="./public/boxicons-2.1.4/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="./public/scripts/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <title><?= $title ?></title>
</head>
<header style="<?php if(isset($_GET['p']) && $_GET['p'] == 'login'){ echo 'display: none;'; } ?>">
    <?php if(isset($_SESSION['status'])): ?>
        <?php if($_SESSION['status'] == 'employe'): ?>
            <a href="index.php?p=userHome" class="logo"> <i class="bx bxl-apple"></i> <h2>CAT</h2></a>
        <?php else: ?>
            <a href="index.php?p=home" class="logo"> <i class="bx bxl-apple"></i> <h2>CAT</h2></a>
        <?php endif; ?>
    <?php else: ?>
        <a href="#" class="logo"> <i class="bx bxl-apple"></i> <h2>CAT</h2></a>
    <?php endif; ?>
    <?php if(isset($_SESSION['id'])): ?>
        <div class="header-right" style="display: flex; align-items: center;">
            <button class="theme-toggle" id="theme-toggle" title="Basculer le thème">
                <i class='bx bx-moon'></i>
            </button>
            <div class="notification-wrapper" id="notif-btn">
                <i class="bx bx-bell"></i>
                <span id="notif-badge">0</span>
                
                <div class="notif-dropdown" id="notif-dropdown">
                    <div class="notif-header">
                        <h4>Notifications</h4>
                        <a href="#" id="mark-all-read">Tout marquer comme lu</a>
                    </div>
                    <div class="notif-list" id="notif-list">
                        <div style="padding: 20px; text-align: center; color: var(--text-light); font-size: 0.8rem;">Chargement...</div>
                    </div>
                    <div class="notif-footer">
                        <a href="#">Voir tout l'historique</a>
                    </div>
                </div>
            </div>

            <div class="profile">
                <div class="username">
                    <span class="username-infos">Hey,</span><b><?= $user->nom ?></b><br>
                    <span class="username-infos"><?= $user->status ?></span>
                </div>
                <div class="img-circle">
                    <img src="./public/pictures/<?= $user->photo ?>" alt="">
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifBtn = document.getElementById('notif-btn');
        const notifDropdown = document.getElementById('notif-dropdown');
        const notifBadge = document.getElementById('notif-badge');
        const notifList = document.getElementById('notif-list');
        const markAllBtn = document.getElementById('mark-all-read');

        if (!notifBtn) return;

        // Toggle dropdown
        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notifDropdown.classList.toggle('show');
            if (notifDropdown.classList.contains('show')) {
                fetchNotifications();
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            notifDropdown.classList.remove('show');
        });

        notifDropdown.addEventListener('click', (e) => e.stopPropagation());

        // Fetch notifications
        function fetchNotifications() {
            fetch('./api/getNotifications.php')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Update badge
                        if (data.unread_count > 0) {
                            notifBadge.textContent = data.unread_count;
                            notifBadge.style.visibility = 'visible';
                        } else {
                            notifBadge.style.visibility = 'hidden';
                        }

                        // Update list
                        if (data.notifications.length === 0) {
                            notifList.innerHTML = '<div style="padding: 20px; text-align: center; color: var(--text-light); font-size: 0.8rem;">Aucune notification</div>';
                        } else {
                            notifList.innerHTML = data.notifications.map(n => `
                                <div class="notif-item ${n.type} ${n.is_read ? '' : 'unread'}" onclick="markAsRead(${n.id})">
                                    <div class="notif-icon">
                                        <i class="bx ${n.type === 'task' ? 'bx-task' : 'bx-calendar-event'}"></i>
                                    </div>
                                    <div class="notif-content">
                                        <div class="notif-text">${n.message}</div>
                                        <div class="notif-time">${n.relative_time}</div>
                                    </div>
                                </div>
                            `).join('');
                        }
                    }
                });
        }

        // Initial fetch for badge
        fetchNotifications();
        // Polling every 30 seconds
        setInterval(fetchNotifications, 30000);

        // Mark as read
        window.markAsRead = function(id) {
            const formData = new FormData();
            formData.append('id', id);
            fetch('./api/markRead.php', { method: 'POST', body: formData })
                .then(() => fetchNotifications());
        };

        markAllBtn.addEventListener('click', (e) => {
            e.preventDefault();
            fetch('./api/markRead.php', { method: 'POST' })
                .then(() => fetchNotifications());
        });
    });
    </script>
</header>