<?php

    $db = Database::Connect();
    $query = $db->query("SELECT nom, prenom, tache.* FROM tache INNER JOIN utilisateur ON utilisateur.id = tache.employe");
    $tacheList = $query->fetchAll(PDO::FETCH_OBJ);

    $query2 = $db->query("SELECT id, nom, prenom FROM utilisateur WHERE status = 'employe'");
    $employeList = $query2->fetchAll(PDO::FETCH_OBJ);
?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Liste des tâches</h2>
                        <button class="btnShowForm">Ajouter <i class="bx bx-plus-circle"></i></button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Titre</td>
                                <td>Employe</td>
                                <td>Durée</td>
                                <td>Status</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tacheList as $tache): ?>
                                <tr>
                                    <td><a href="index.php?p=detailTache&id=<?= $tache->id ?>"><?= $tache->titre ?></a></td>
                                    <td><?= $tache->nom.' '.$tache->prenom  ?></td>
                                    <td><?= $tache->duree ?>H</td>
                                    <td><?= $tache->status ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn" href="index.php?p=updateTache&id=<?= $tache->id ?>">Modifier <i class="bx bx-edit"></i></a>
                                            <a class="btn" href="index.php?p=deleteTache&id=<?= $tache->id ?>">Supprimer <i class="bx bx-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Removed right-side sidebar -->
        </div>
    </div>

    <form method="post" action="index.php?p=addTache" class="add formAddTache">
        <div class="close">
            <span>X</span>
        </div>
        <h2>Nouvelle tâche</h2>
        <input name="titre" type="text" placeholder="Entrez le titre">
        <select name="employe">
            <option value="">---Sélectionner l'employe---</option>
            <?php foreach($employeList as $employe): ?>
                <option value="<?= $employe->id ?>"><?= $employe->nom.' '.$employe->prenom ?></option>
            <?php endforeach; ?>
        </select>
        <textarea name="description" cols="30" rows="10" placeholder="Entrez la description"></textarea>
        <input type="number" name="duree" placeholder="Entrez la durée (heures)">
        <div class="form-group">
            <label style="font-size: 0.8rem; color: #666; display: block; margin-top: 10px;">Date de début</label>
            <input type="datetime-local" name="date_debut" required>
        </div>
        <div class="form-group">
            <label style="font-size: 0.8rem; color: #666; display: block; margin-top: 10px;">Date de fin (ou échéance)</label>
            <input type="datetime-local" name="date_fin" required>
        </div>
        <button type="submit" name="ajouter">Nouvelle tâche</button>
    </form>
</body>
</html>