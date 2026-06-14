<?php
session_start();
require '../app/Database.php';

$db = Database::Connect();
$events = [];

// Fetch Tasks
$queryTaches = $db->query("SELECT t.id, t.titre as title, t.date_debut as start, t.date_fin as end, t.status, u.nom as employee 
                           FROM tache t 
                           LEFT JOIN utilisateur u ON t.employe = u.id");
$taches = $queryTaches->fetchAll(PDO::FETCH_ASSOC);

foreach ($taches as $t) {
    // If dates are null, we don't show them on calendar or we set a default
    if ($t['start']) {
        $events[] = [
            'id' => 'task_' . $t['id'],
            'title' => '[' . $t['employee'] . '] ' . $t['title'],
            'start' => $t['start'],
            'end' => $t['end'],
            'backgroundColor' => ($t['status'] == 'Terminée' ? '#22c55e' : '#6366f1'),
            'borderColor' => ($t['status'] == 'Terminée' ? '#22c55e' : '#6366f1'),
            'extendedProps' => ['type' => 'task', 'real_id' => $t['id']]
        ];
    }
}

// Fetch Leaves (Congés)
$queryConges = $db->query("SELECT c.id, u.nom as employee, c.date_debut as start, c.date_fin as end, c.statut 
                           FROM conge c 
                           JOIN utilisateur u ON c.id_user = u.id 
                           WHERE c.statut = 'Accepter'");
$conges = $queryConges->fetchAll(PDO::FETCH_ASSOC);

foreach ($conges as $c) {
    if ($c['start'] && $c['end']) {
        $events[] = [
            'id' => 'leave_' . $c['id'],
            'title' => '🏖️ Congé: ' . $c['employee'],
            'start' => $c['start'],
            'end' => $c['end'] . 'T23:59:59', // End date for leaves is inclusive
            'backgroundColor' => '#f59e0b',
            'borderColor' => '#f59e0b',
            'allDay' => true,
            'extendedProps' => ['type' => 'leave']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($events);
