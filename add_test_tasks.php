<?php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$dbname = 'gestiont_des_taches';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get EmployeTest ID
    $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE nom = ?");
    $stmt->execute(['EmployeTest']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $id = $user['id'];
        echo "Found EmployeTest with ID: $id\n";

        // Check if tasks exist
        $stmt = $pdo->query("SELECT count(*) FROM tache WHERE employe = $id");
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            echo "No tasks found. Creating test tasks...\n";
            
            // Add 'En cours...' task
            $sql1 = "INSERT INTO tache (titre, duree, status, employe, description) VALUES (?, ?, ?, ?, ?)";
            $pdo->prepare($sql1)->execute([
                'Rédaction rapport', 
                '4', 
                'En cours...', 
                $id, 
                'Rédiger le rapport mensuel'
            ]);
            echo "Added 'En cours...' task.\n";

            // Add 'Terminée' task
            $sql2 = "INSERT INTO tache (titre, duree, status, employe, description) VALUES (?, ?, ?, ?, ?)";
            $pdo->prepare($sql2)->execute([
                'Mise à jour site', 
                '2', 
                'Terminée', 
                $id, 
                'Update des plugins'
            ]);
            echo "Added 'Terminée' task.\n";
            
        } else {
            echo "User already has $count tasks.\n";
        }
    } else {
        echo "User 'EmployeTest' not found!\n";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
