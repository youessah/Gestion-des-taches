<?php
    $db = Database::Connect();
    $query1 = $db->query("SELECT count(*) FROM utilisateur WHERE status = 'employe'");
    $nbEmploye = $query1->fetch();

    $query2 = $db->query("SELECT count(*) FROM tache");
    $nbTache = $query2->fetch();

    $query3 = $db->query("SELECT count(*) FROM conge");
    $nbConge = $query3->fetch();

    $query = $db->query("SELECT utilisateur.*, COUNT(*) AS nbTache FROM utilisateur LEFT JOIN tache ON tache.employe = utilisateur.id WHERE utilisateur.status = 'employe' GROUP BY(utilisateur.id)");
    $employeList = $query->fetchAll(PDO::FETCH_OBJ);


    $query = $db->query("SELECT nom, prenom, tache.* FROM tache INNER JOIN utilisateur ON utilisateur.id = tache.employe");
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
                            <span>Employes</span>
                            <h3><?= $nbEmploye[0] ?></h3>
                        </div>
                        <div>
                            <div class="icon-circle blue">
                                <i class="bx bx-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div>
                            <span>Congés</span>
                            <h3><?= $nbConge[0] ?></h3>
                        </div>
                        <div>
                            <div class="icon-circle green">
                                <i class="bx bx-send"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div>
                            <span>Tâches</span>
                            <h3><?= $nbTache[0] ?></h3>
                        </div>
                        <div>
                            <div class="icon-circle red">
                                <i class="bx bx-task"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-responsive" style="margin-bottom: 20px;">
                    <div class="title">
                        <h2>Employés</h2>
                        <a href="index.php?p=employe">Voir tout <i class="bx bx-right-arrow-alt"></i></a>
                    </div>
                    <div class="users">
                        <div class="scroll">
                            <?php foreach($employeList as $employe): ?>
                                <div class="user-card">
                                    <a href="index.php?p=detailEmploye&id=<?= $employe->id ?>">
                                        <div class="image-circle">
                                            <img src="./public/pictures/<?= $employe->photo ?>" alt="">
                                        </div>
                                        <h4><?= $employe->nom ?></h4>
                                        <span><?= $employe->nbTache ?> tâches</span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                            <div class="user-card" style="justify-content: center;">
                                <a href="index.php?p=employe" style="flex-direction: column; display: flex; align-items: center; color: var(--primary-color);">
                                    <i class="bx bx-plus-circle" style="font-size: 2rem;"></i>
                                    <h4>Ajouter</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-responsive">
                    <div class="title">
                        <h2>Tâches en cours</h2>
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
                                    <td><a href="index.php?p=detailTache&id=<?= $tache->id ?>" class="btn" style="background: var(--primary-light); color: var(--primary-color);">Détail</a></td>
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