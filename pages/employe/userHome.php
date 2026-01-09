<?php
    $db = Database::Connect();

    $query1 = $db->query("SELECT count(*) FROM tache WHERE employe = ".$_SESSION['id']. " AND status = 'En cours...'");
    $nbTacheEncours = $query1->fetch();

    $query2 = $db->query("SELECT count(*) FROM tache WHERE employe = ".$_SESSION['id']);
    $nbTacheTotal = $query2->fetch();

    $query2 = $db->query("SELECT count(*) FROM conge WHERE conge.id_user = ".$_SESSION['id']);
    $nbCongeTotal = $query2->fetch();

    $query = $db->query("SELECT * FROM utilisateur WHERE status = 'employe'");
    $employeList = $query->fetchAll(PDO::FETCH_OBJ);


    $query = $db->query("SELECT nom, prenom, tache.* FROM tache INNER JOIN utilisateur ON utilisateur.id = ".$_SESSION['id']);
    $tacheList = $query->fetchAll(PDO::FETCH_OBJ);

?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>            
            <div class="content">
                <h3>Dashboard</h3>
                <div class="cards">
                    <div class="card">
                        <div>
                            <span>Tâches</span>
                            <h3><?= $nbTacheEncours[0] ?></h3>
                        </div>
                        <div>
                            <div class="icon-circle blue">
                                <i class="bx bx-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div>
                            <span>Mes Congés</span>
                            <h3><?= $nbCongeTotal[0] ?></h3>
                        </div>
                        <div>
                            <div class="icon-circle green">
                                <i class="bx bx-send"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div>
                            <span>Historiques</span>
                            <h3><?= $nbTacheTotal[0] ?></h3>
                        </div>
                        <div>
                            <div class="icon-circle red">
                                <i class="bx bx-task"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-responsive">
                    <div class="title">
                        <h2>Tâches Récentes</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Nom</td>
                                <td>Tache</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tacheList as $tache): ?>
                                <tr>
                                    <td><?= $tache->nom ?></td>
                                    <td><?= $tache->titre ?></td>
                                    <td><span style="padding: 5px 10px; background: #e0f2fe; color: #0284c7; border-radius: 20px; font-size: 0.8rem;"><?= $tache->status ?></span></td>
                                    <td><a href="index.php?p=detailTacheUser&id=<?= $tache->id ?>" class="btn" style="background: var(--primary-light); color: var(--primary-color);">Détail</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
</body>
</html>