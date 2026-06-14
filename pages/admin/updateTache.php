<?php
    $db = Database::Connect();

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $db->prepare("SELECT * FROM tache WHERE id = ?");
        $stmt->execute([$id]);
        $tache = $stmt->fetch(PDO::FETCH_OBJ);

        if(isset($_POST['modifier'])){
            $titre = trim($_POST['titre']);
            $description = trim($_POST['description']);
            $duree = trim($_POST['duree']);
            $status = trim($_POST['status']);
            $date_debut = $_POST['date_debut'];
            $date_fin = $_POST['date_fin'];

            $update = $db->prepare('UPDATE tache SET titre = ?, description = ?, date_debut = ?, date_fin = ?, duree = ?, status = ? WHERE id = ?');
            $update->execute(array($titre, $description, $date_debut, $date_fin, $duree, $status, $id));

            header('location: index.php?p=tache');
            exit();
        }
    }
    
    // Formatting dates for input value
    $start_val = $tache->date_debut ? date('Y-m-d\TH:i', strtotime($tache->date_debut)) : '';
    $end_val = $tache->date_fin ? date('Y-m-d\TH:i', strtotime($tache->date_fin)) : '';
?>

<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="title-row">
                    <h3>Modifier la tâche</h3>
                    <a href="index.php?p=tache" class="link-sm"><i class="bx bx-arrow-back"></i> Retour à la liste</a>
                </div>

                <div class="card-responsive" style="max-width: 700px; margin: 0 auto; padding: 30px;">
                    <form method="post" class="info-edit" style="width: 100%;">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Titre de la tâche</label>
                            <input type="text" name="titre" value="<?= htmlspecialchars($tache->titre) ?>" placeholder="Titre" required>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Description détaillée</label>
                            <textarea name="description" placeholder="Description de la tâche..." style="min-height: 120px; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 0.9rem; resize: vertical;"><?= htmlspecialchars($tache->description) ?></textarea>
                        </div>

                        <div class="form-row" style="margin-bottom: 20px;">
                            <div class="form-group" style="flex: 1;">
                                <label>Date de début</label>
                                <input type="datetime-local" name="date_debut" value="<?= $start_val ?>" required>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Date de fin</label>
                                <input type="datetime-local" name="date_fin" value="<?= $end_val ?>" required>
                            </div>
                        </div>

                        <div class="form-row" style="margin-bottom: 20px;">
                            <div class="form-group" style="flex: 1;">
                                <label>Durée (heures)</label>
                                <input type="number" name="duree" value="<?= $tache->duree ?>" placeholder="Heures" required>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Statut actuel</label>
                                <select name="status" class="form-control" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; background: #fff; width: 100%;">
                                    <option value="En cours..." <?= $tache->status == 'En cours...' ? 'selected' : '' ?>>En cours</option>
                                    <option value="Terminée" <?= $tache->status == 'Terminée' ? 'selected' : '' ?>>Terminée</option>
                                    <option value="En attente" <?= $tache->status == 'En attente' ? 'selected' : '' ?>>En attente</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: flex; gap: 15px; margin-top: 10px;">
                            <button type="submit" name="modifier" class="btn-save">
                                <i class="bx bx-check-circle"></i> Mettre à jour la tâche
                            </button>
                            <a href="index.php?p=tache" class="btn" style="background: #f1f5f9; color: #64748b; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; gap: 8px; font-weight: 500;">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>