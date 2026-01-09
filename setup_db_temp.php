<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'gestiont_des_taches';

try {
    // 1. Connect without Database to create it
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Create Database
    echo "Creating database '$dbname'...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
    echo "Database created successfully.\n";

    // 3. Connect to the Database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. Create Tables
    
    // Table utilisateur
    echo "Creating table 'utilisateur'...\n";
    $sqlUser = "CREATE TABLE IF NOT EXISTS `utilisateur` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nom` varchar(255) DEFAULT NULL,
        `prenom` varchar(255) DEFAULT NULL,
        `telephone` varchar(20) DEFAULT NULL,
        `adresse` text,
        `password` varchar(255) NOT NULL,
        `status` enum('admin','employe') NOT NULL,
        `photo` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $pdo->exec($sqlUser);

    // Table tache
    echo "Creating table 'tache'...\n";
    $sqlTache = "CREATE TABLE IF NOT EXISTS `tache` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `titre` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `duree` varchar(50) DEFAULT NULL,
        `status` varchar(50) DEFAULT 'En cours...',
        `employe` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
        -- Foreign key constraint could be added but let's keep it simple as per original likely schema
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $pdo->exec($sqlTache);

    // Table conge
    echo "Creating table 'conge'...\n";
    $sqlConge = "CREATE TABLE IF NOT EXISTS `conge` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `id_user` int(11) NOT NULL,
        `motif` text NOT NULL,
        `date_debut` date NOT NULL,
        `date_fin` date NOT NULL,
        `statut` varchar(50) DEFAULT 'En cours..',
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $pdo->exec($sqlConge);

    // 5. Insert Default Admin if not exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM utilisateur WHERE status = 'admin'");
    if ($stmt->fetchColumn() == 0) {
        echo "Inserting default admin user...\n";
        $adminPass = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, password, status) VALUES ('Admin', 'System', ?, 'admin')");
        $stmt->execute([$adminPass]);
        echo "Admin user created (login: admin, pass: admin).\n";
    } else {
        echo "Admin user already exists.\n";
    }

    echo "Setup completed successfully!\n";

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage() . "\n");
}
?>
