<?php
    $db = Database::Connect();
    $stmt = $db->prepare("SELECT u.nom, u.prenom, t.* FROM tache t INNER JOIN utilisateur u ON u.id = t.employe WHERE t.employe = ? AND t.status = 'En cours...'");
    $stmt->execute([$_SESSION['id']]);
    $tacheList = $stmt->fetchAll(PDO::FETCH_OBJ);
?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Mes tâches</h2>
                        <a href="index.php?p=addTaskUser" class="btnShowForm">Ajouter une tâche <i class="bx bx-plus-circle"></i></a>
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
                                    <td><span class="badge warning"><?= $tache->status ?></span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn" href="index.php?p=detailTacheUser&id=<?= $tache->id ?>">Détails <i class="bx bx-edit"></i></a>
                                            <a class="btn success" href="index.php?p=tacheDone&id=<?= $tache->id ?>">Terminer <i class="bx bx-check"></i></a>
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