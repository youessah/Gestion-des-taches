<?php
    $db = Database::Connect();
    $query = $db->query("SELECT * FROM utilisateur WHERE status = 'employe'");
    $employeList = $query->fetchAll(PDO::FETCH_OBJ);
    

?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Liste des employes</h2>
                        <button class="btnShowForm">Ajouter <i class="bx bx-user-plus"></i></button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Photo</td>
                                <td>Nom</td>
                                <td>Prénom</td>
                                <td>Téléphone</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($employeList as $employe): ?>
                                <tr>
                                    <td>
                                        <div class="image-circle">
                                            <img src="./public/pictures/<?= $employe->photo ?>" alt="">
                                        </div>
                                    </td>
                                    <td><a href="index.php?p=detailEmploye&id=<?= $employe->id ?>"><?= $employe->nom ?></a></td>
                                    <td><a href="index.php?p=detailEmploye&id=<?= $employe->id ?>"><?= $employe->prenom ?></a></td>
                                    <td><?= $employe->telephone ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn" href="index.php?p=updateEmploye&id=<?= $employe->id ?>">Modifier <i class="bx bx-edit"></i></a>
                                            <a class="btn" href="index.php?p=deleteEmploye&id=<?= $employe->id ?>">Supprimer <i class="bx bx-trash"></i></a>
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
    <form method="post" action="index.php?p=addEmploye" class="add formAddEmploye" enctype="multipart/form-data">
        <div class="close">
            <span>X</span>
        </div>
        <h2>Ajouter employe</h2>
        <input type="text" name="nom" placeholder="Entrez le nom" required>
        <input type="text" name="prenom" placeholder="Entrez le prénom" required>
        <input type="number" name="telephone" placeholder="Entrez numéro téléphone" required>
        <input type="text" name="adresse" placeholder="Entrez l'adresse" required>
        <input type="password" name="password" placeholder="Entrez un mot de passe" required>
        <input name="photo" type="file">
        <button name="ajouter">Ajouter</button>
    </form>
</body>
</html>