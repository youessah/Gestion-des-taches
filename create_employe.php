<?php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'gestiont_des_taches';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pass = password_hash('employe', PASSWORD_DEFAULT);
    // Check if user exists first to avoid duplicate errors if run multiple times
    $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE nom = ?");
    $stmt->execute(['EmployeTest']);
    
    if(!$stmt->fetch()){
        $sql = "INSERT INTO utilisateur (nom, prenom, telephone, adresse, password, status, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute(['EmployeTest', 'User', '600000000', 'Libreville', $pass, 'employe', 'default.jpg']);
        echo "Employe created: Nom='EmployeTest', Password='employe'\n";
    } else {
        echo "Employe 'EmployeTest' already exists. Password is 'employe' (unless changed).\n";
    }

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage() . "\n");
}
?>
