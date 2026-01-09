<?php
    $db = Database::Connect();
    $query = $db->query("SELECT c.*, u.nom FROM conge c INNER JOIN utilisateur u ON u.id = c.id_user");
    $conges = $query->fetchAll(PDO::FETCH_OBJ);
    

?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Liste des congés</h2>
                        <a href="index.php?p=demandeConge" class="btnShowForm">Demander un congé <i class="bx bx-plus-circle"></i></a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Employe</td>
                                <td>motif</td>
                                <td>Date de départ</td>
                                <td>Date fin</td>
                                <td>statut</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($conges as $con): ?>
                                <tr>
                                    <td><a href="index.php?p=detailEmploye&id=<?= $con->id ?>"><?= $con->nom ?></a></td>
                                    <td><a href="index.php?p=detailEmploye&id=<?= $con->id ?>"><?= $con->motif ?></a></td>
                                    <td><?= $con->date_debut ?></td>
                                    <td><?= $con->date_fin ?></td>
                                    <?php if($con->statut == 'Refuser'): ?>
                                        <td><span class="badge danger"><?= $con->statut ?></span></td>
                                    <?php elseif( $con->statut == 'Accepter'): ?>
                                        <td><span class="badge success"><?= $con->statut ?></span></td>
                                    <?php elseif( $con->statut == 'En cours..'): ?>
                                        <td><span class="badge warning"><?= $con->statut ?></span></td>
                                    <?php endif; ?>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn" href="index.php?p=acceptLeave&id=<?= $con->id ?>">Accepter <i class="bx bx-check"></i></a>
                                            <a class="btn" href="index.php?p=rejectLeave&id=<?= $con->id ?>">Refuser <i class="bx bx-x"></i></a>
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