<?php

    $db = Database::Connect();
    if(isset($_POST['ajouter'])){
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $duree = $_POST['duree'];
        $employe = $_POST['employe'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];

        $query = $db->prepare("INSERT INTO tache(titre, description, date_debut, date_fin, duree, status, employe) VALUES(?,?,?,?,?,'En cours...',?)");
        $query->execute(array($titre, $description, $date_debut, $date_fin, $duree, $employe));

        // Create Notification
        $notifMsg = "Une nouvelle tâche vous a été assignée : " . $titre;
        $notifReq = $db->prepare("INSERT INTO notification (user_id, message, type) VALUES (?, ?, 'task')");
        $notifReq->execute([$employe, $notifMsg]);

        header('location: index.php?p=tache');
    }