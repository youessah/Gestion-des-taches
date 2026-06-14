<?php
session_start();
require '../app/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = Database::Connect();
    
    $id = $_POST['id'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // We only update tasks, not leaves
    if (strpos($id, 'task_') === 0) {
        $realId = str_replace('task_', '', $id);
        
        $sql = "UPDATE tache SET date_debut = ?, date_fin = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $success = $stmt->execute([$start, $end, $realId]);
        
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Impossible de modifier un congé via le calendrier.']);
    }
}
