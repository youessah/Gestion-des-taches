<?php
session_start();
require '../app/Database.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$db = Database::Connect();
$userId = $_SESSION['id'];

// Fetch unread count
$countQuery = $db->prepare("SELECT COUNT(*) as unread_count FROM notification WHERE user_id = ? AND is_read = FALSE");
$countQuery->execute([$userId]);
$unreadCount = $countQuery->fetch(PDO::FETCH_ASSOC)['unread_count'];

// Fetch recent notifications
$notifQuery = $db->prepare("SELECT * FROM notification WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$notifQuery->execute([$userId]);
$notifications = $notifQuery->fetchAll(PDO::FETCH_ASSOC);

// Format relative time (optional but nice)
function formatTime($timestamp) {
    $diff = time() - strtotime($timestamp);
    if ($diff < 60) return "À l'instant";
    if ($diff < 3600) return floor($diff / 60) . " min";
    if ($diff < 86400) return floor($diff / 3600) . " h";
    return date('d/m', strtotime($timestamp));
}

foreach ($notifications as &$n) {
    $n['relative_time'] = formatTime($n['created_at']);
}

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'unread_count' => $unreadCount,
    'notifications' => $notifications
]);
