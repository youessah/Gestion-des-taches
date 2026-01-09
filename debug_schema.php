<?php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'gestiont_des_taches';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "--- Table 'tache' Schema ---\n";
    $stmt = $pdo->query("DESCRIBE tache");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $col) {
        echo $col['Field'] . " (" . $col['Type'] . ")\n";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
