<?php
    $db = Database::Connect();
    $query = $db->query($sql = "SELECT * FROM conge c INNER JOIN utilisateur u ON u.id = c.id_user WHERE c.id_user = " . (int) $_SESSION['id']);
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
                        <h2>Mes congés</h2>
                        <a href="index.php?p=demandeConge" class="btnShowForm">Demander un congé <i class="bx bx-plus-circle"></i></a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Employe</td>
                                <td>Motif</td>
                                <td>Date de départ</td>
                                <td>Date fin</td>
                                <td>Statut</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($conges as $con): ?>
                            <tr>
                                <td><a href="#"><?= $con->nom ?></a></td>
                                <td><a href="#"><?= $con->motif ?></a></td>
                                <td><?= $con->date_debut ?></td>
                                <td><?= $con->date_fin ?></td>
                                <?php if($con->statut == 'Refuser'): ?>
                                    <td><span class="badge danger"><?= $con->statut ?></span></td>
                                <?php elseif( $con->statut == 'Accepter'): ?>
                                    <td><span class="badge success"><?= $con->statut ?></span></td>
                                <?php elseif( $con->statut == 'En cours..'): ?>
                                    <td><span class="badge warning"><?= $con->statut ?></span></td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
</body>
</html>