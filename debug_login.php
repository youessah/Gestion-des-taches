<?php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'gestiont_des_taches';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "--- Testing Login Logic for status 'employe' and password 'employe' ---\n";
    
    $stmt = $pdo->query("SELECT id, nom, password FROM utilisateur WHERE status = 'employe'");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($users) . " employees.\n";
    
    $input_pass = 'employe';
    $success_count = 0;
    
    foreach($users as $u) {
        $check = password_verify($input_pass, $u['password']);
        echo "User: " . $u['nom'] . " (ID: " . $u['id'] . ") -> " . ($check ? "MATCH!" : "No match") . "\n";
        if($check) $success_count++;
    }
    
    if($success_count > 0) {
        echo "\nCONCLUSION: Login SHOULD work. $success_count user(s) have this password.\n";
    } else {
        echo "\nCONCLUSION: Login will FAIL. No user has this password.\n";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
