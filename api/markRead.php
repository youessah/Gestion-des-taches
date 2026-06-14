<?php
session_start();
require '../app/Database.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = Database::Connect();
    $userId = $_SESSION['id'];
    
    // Mark all as read if no ID provided, else mark specific one
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $db->prepare("UPDATE notification SET is_read = TRUE WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
    } else {
        $stmt = $db->prepare("UPDATE notification SET is_read = TRUE WHERE user_id = ?");
        $stmt->execute([$userId]);
    }
    
    echo json_encode(['success' => true]);
}
