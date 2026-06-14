<?php
    $db = Database::Connect();
    $query = $db->query("SELECT * FROM utilisateur WHERE status = 'employe' AND agenda != '' ");
    $employeList = $query->fetchAll(PDO::FETCH_OBJ);

?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive" style="padding: 20px;">
                    <div class="title" style="margin-bottom: 20px;">
                        <h2>Agenda Interactif</h2>
                        <div>
                            <span class="badge" style="background: #6366f1; color: white;">Tâches</span>
                            <span class="badge" style="background: #f59e0b; color: white;">Congés</span>
                            <a href="index.php?p=addAgenda" class="btnShowForm" style="margin-left: 10px;">Gérer disponibilités <i class="bx bx-cog"></i></a>
                        </div>
                    </div>
                    
                    <div id='calendar-container'>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>

    <!-- Styles spécifiques au calendrier -->
    <style>
        #calendar-container {
            background: white;
            padding: 10px;
            border-radius: 12px;
        }
        .fc {
            max-height: 700px;
            font-family: 'Poppins', sans-serif;
        }
        .fc .fc-toolbar-title {
            font-size: 1.2rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        .fc .fc-button-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .fc .fc-button-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .fc-event {
            cursor: pointer;
            padding: 2px 5px;
            border-radius: 4px;
            border: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: './api/getEvents.php',
                editable: true, // Permet le drag & drop
                eventDrop: function(info) {
                    updateEvent(info.event);
                },
                eventResize: function(info) {
                    updateEvent(info.event);
                },
                eventClick: function(info) {
                    // Si c'est une tâche, on peut rediriger vers le détail
                    if (info.event.extendedProps.type === 'task') {
                        window.location.href = 'index.php?p=detailTacheUser&id=' + info.event.extendedProps.real_id;
                    }
                }
            });
            calendar.render();

            function updateEvent(event) {
                let start = event.startStr;
                let end = event.endStr || start; // FullCalendar peut avoir end null pour les événements d'un jour

                let formData = new FormData();
                formData.append('id', event.id);
                formData.append('start', start);
                formData.append('end', end);

                fetch('./api/updateEvent.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(!data.success) {
                        alert(data.message || "Erreur lors de la mise à jour");
                        calendar.refetchEvents(); // Recharger pour annuler visuellement
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    calendar.refetchEvents();
                });
            }
        });
    </script>
</body>
</html>