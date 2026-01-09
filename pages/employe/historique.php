<?php

    $db = Database::Connect();
    $query = $db->query("SELECT nom, prenom, tache.* FROM tache INNER JOIN utilisateur ON utilisateur.id = tache.employe WHERE tache.employe = ".$_SESSION['id']);
    $tacheList = $query->fetchAll(PDO::FETCH_OBJ);
?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Mon historique de tâche</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Titre</td>
                                <td>Durée</td>
                                <td>Status</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tacheList as $tache): ?>
                                <tr>
                                    <td><?= $tache->titre ?></td>
                                    <td><?= $tache->duree ?>H</td>
                                    <?php if($tache->status == 'Terminée'): ?>
                                        <td><span class="badge success"><?= $tache->status ?></span></td>
                                    <?php else: ?>
                                        <td><span class="badge warning"><?= $tache->status ?></span></td>
                                    <?php endif; ?>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn" href="index.php?p=detailTacheUser&id=<?= $tache->id ?>">Détails <i class="bx bx-show"></i></a>
                                        </div>
                                    </td>
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