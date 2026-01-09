<?php
    $db = Database::Connect();
    $query = $db->query($sql = "SELECT * FROM conge c INNER JOIN utilisateur u ON u.id = c.id_user WHERE c.id_user = " . (int) $_SESSION['id']);
    $con = $query->fetch(PDO::FETCH_OBJ);
    

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
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Employe</td>
                                <td>motif</td>
                                <td>Date de départ</td>
                                <td>Date fin</td>
                                <td>statut</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="index.php?p=detailEmploye&id=<?= $con->id ?>"><?= $con->nom ?></a></td>
                                <td><a href="index.php?p=detailEmploye&id=<?= $con->id ?>"><?= $con->motif ?></a></td>
                                <td><?= $con->date_debut ?></td>
                                <td><?= $con->date_fin ?></td>
                                <?php if($con->statut == 'Refuser'): ?>
                                    <td style="color: red"><?= $con->statut ?></td>
                                <?php elseif( $con->statut == 'Accepter'): ?>
                                    <td style="color: green"><?= $con->statut ?></td>
                                <?php elseif( $con->statut == 'En cours..'): ?>
                                    <td style="color: blue"><?= $con->statut ?></td>
                                <?php endif; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
</body>
</html>