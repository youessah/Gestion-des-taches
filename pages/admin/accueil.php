<?php
    $db = Database::Connect();
    $query1 = $db->query("SELECT count(*) FROM utilisateur WHERE status = 'employe'");
    $nbEmploye = $query1->fetch();

    $query2 = $db->query("SELECT count(*) FROM tache");
    $nbTache = $query2->fetch();

    $query3 = $db->query("SELECT count(*) FROM conge");
    $nbConge = $query3->fetch();

    $query = $db->query("SELECT utilisateur.*, COUNT(*) AS nbTache FROM utilisateur LEFT JOIN tache ON tache.employe = utilisateur.id WHERE utilisateur.status = 'employe' GROUP BY(utilisateur.id)");
    $employeList = $query->fetchAll(PDO::FETCH_OBJ);


    $query = $db->query("SELECT nom, prenom, tache.* FROM tache INNER JOIN utilisateur ON utilisateur.id = tache.employe");
    $tacheList = $query->fetchAll(PDO::FETCH_OBJ);

?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>            
            <div class="content dashboard-grid">
                <!-- Left Column: Tasks & Actions -->
                <div class="dash-main">
                    <div class="title-row" style="margin-bottom: 20px;">
                        <h2 style="font-size: 1.8rem; font-weight: 700; color: var(--primary-color);">Bonjour, <?= isset($user) ? $user->nom : 'Administrateur' ?> 👋</h2>
                        <p id="current-date-time" style="color: var(--text-light); font-size: 0.95rem; margin-top: 5px;"></p>
                    </div>
                    <script>
                        function updateDateTime() {
                            const now = new Date();
                            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                            document.getElementById('current-date-time').innerText = now.toLocaleDateString('fr-FR', options);
                        }
                        updateDateTime();
                        setInterval(updateDateTime, 60000);
                    </script>

                    <div class="card-responsive tasks-card" style="flex: 1;">
                        <div class="title">
                            <h2>Tâches en cours</h2>
                        </div>
                        <div class="table-scroll">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Nom</td>
                                        <td>Tâche</td>
                                        <td>Status</td>
                                        <td style="text-align: right;">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tacheList as $tache): ?>
                                        <tr>
                                            <td><?= $tache->nom ?></td>
                                            <td><?= $tache->titre ?></td>
                                            <td><span class="badge warning"><?= $tache->status ?></span></td>
                                            <td style="text-align: right;"><a href="index.php?p=detailTache&id=<?= $tache->id ?>" class="btn-sm">Détail</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-responsive employees-mini-card" style="margin-top: 15px;">
                        <div class="title">
                            <h2>Équipe</h2>
                            <a href="index.php?p=employe" class="link-sm">Gérer <i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                        <div class="users-mini-grid">
                            <?php foreach(array_slice($employeList, 0, 5) as $employe): ?>
                                <div class="user-mini-item">
                                    <div class="image-avatar">
                                        <img src="./public/pictures/<?= $employe->photo ?>" alt="">
                                    </div>
                                    <div class="user-info">
                                        <b><?= $employe->nom ?></b>
                                        <span><?= $employe->nbTache ?> tâches</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Stats & Analytics -->
                <div class="dash-side">
                    <div class="stats-mini-cards">
                        <div class="mini-card blue">
                            <i class="bx bx-user"></i>
                            <div>
                                <span>Employés</span>
                                <b><?= $nbEmploye[0] ?></b>
                            </div>
                        </div>
                        <div class="mini-card green">
                            <i class="bx bx-send"></i>
                            <div>
                                <span>Congés</span>
                                <b><?= $nbConge[0] ?></b>
                            </div>
                        </div>
                        <div class="mini-card red">
                            <i class="bx bx-task"></i>
                            <div>
                                <span>Tâches</span>
                                <b><?= $nbTache[0] ?></b>
                            </div>
                        </div>
                    </div>

                    <div class="card-responsive chart-mini">
                        <div class="title">
                            <h2>Répartition</h2>
                        </div>
                        <div style="height: 140px;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>

                    <div class="card-responsive chart-mini">
                        <div class="title">
                            <h2>Performance</h2>
                        </div>
                        <div style="height: 140px;">
                            <canvas id="employeeChart"></canvas>
                        </div>
                    </div>
                </div>

                <script>
                    const statusData = {
                        labels: ['En cours', 'Terminée'],
                        datasets: [{
                            data: [
                                <?= $db->query("SELECT count(*) FROM tache WHERE status LIKE 'En cours%'")->fetchColumn() ?>, 
                                <?= $db->query("SELECT count(*) FROM tache WHERE status = 'Terminée'")->fetchColumn() ?>
                            ],
                            backgroundColor: ['#fbbf24', '#10b981'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    };

                    const employeeData = {
                        labels: [
                            <?php 
                                $topEmp = $db->query("SELECT u.nom, count(t.id) as nbt FROM utilisateur u JOIN tache t ON t.employe = u.id WHERE t.status = 'Terminée' GROUP BY u.id ORDER BY nbt DESC LIMIT 5")->fetchAll(PDO::FETCH_OBJ);
                                foreach($topEmp as $e) echo "'".htmlspecialchars($e->nom)."',"; 
                            ?>
                        ],
                        datasets: [{
                            label: 'Tâches',
                            data: [
                                <?php foreach($topEmp as $e) echo $e->nbt . ","; ?>
                            ],
                            backgroundColor: '#6366f1',
                            borderRadius: 4,
                            barPercentage: 0.6
                        }]
                    };

                    new Chart(document.getElementById('statusChart'), {
                        type: 'doughnut',
                        data: statusData,
                        options: { 
                            responsive: true, 
                            maintainAspectRatio: false,
                            cutout: '75%',
                            plugins: {
                                legend: { position: 'right', labels: { boxWidth: 8, font: { size: 9 } } }
                            }
                        }
                    });

                    new Chart(document.getElementById('employeeChart'), {
                        type: 'bar',
                        data: employeeData,
                        options: { 
                            indexAxis: 'y', // Horizontal bars for compact side look
                            responsive: true, 
                            maintainAspectRatio: false,
                            scales: { 
                                x: { beginAtZero: true, ticks: { display: false }, grid: { display: false } },
                                y: { grid: { display: false }, ticks: { font: { size: 9 } } }
                            },
                            plugins: { legend: { display: false } }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</body>
</html>