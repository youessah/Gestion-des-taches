<?php
    $db = Database::Connect();

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $db->prepare("SELECT utilisateur.*, COUNT(tache.id) AS nbTache FROM utilisateur LEFT JOIN tache ON tache.employe = utilisateur.id WHERE utilisateur.id = ? GROUP BY utilisateur.id");
        $stmt->execute([$id]);
        $employe = $stmt->fetch(PDO::FETCH_OBJ);
    }
?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Information sur l'employe</h2>
                        <a href="index.php?p=employe"><i class="bx bx-left-arrow"></i> Retour</a>
                    </div>
                    <div class="card">
                        <div class="card-profile">
                            <div class="card-image circle">
                                <img src="./public/pictures/<?= $employe->photo ?>" alt="">
                            </div>
                            <h2><?= $employe->nom ?></h2>
                        </div>
                        <div class="info">
                            <div class="card-detail">
                                <div>
                                    <h4>Nom</h4> : <span> <?= $employe->nom ?> </span>
                                </div>
                                <div>
                                    <h4>Prénom</h4> : <span> <?= $employe->prenom ?> </span>
                                </div>
                                <div>
                                    <h4>Téléphone</h4> : <span> <?= $employe->telephone ?> </span>
                                </div>
                                <div>
                                    <h4>Adresse</h4> : <span> <?= $employe->adresse ?> </span>
                                </div>
                                <div>
                                    <h4>Tâches en cours </h4> : <span> <?= $employe->nbTache ?> </span>
                                </div>
                                <div>
                                    <h4>Tâches total</h4> : <span> <?= $employe->nbTache ?> </span>
                                </div>
                                <div>
                                    <a class="btn" href="index.php?p=updateEmploye&id=<?= $employe->id ?>">Modifier <i class="bx bx-edit"></i></a>
                                    <a class="btn" href="index.php?p=deleteEmploye&id=<?= $employe->id ?>">Supprimer <i class="bx bx-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
</body>
</html>