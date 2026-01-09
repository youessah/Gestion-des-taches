<?php
    $db = Database::Connect();
    // Reusing the addTache controller logic directly here for simplicity or pointing to it?
    // Let's check if we can submit to the existing controller.
    // The existing controller is 'controller/addTache.php' designated by p=addTache.
    // But we need a specific redirection.
    // Let's just put the logic here to keep it self-contained for the employee view or create a specific controller logic.
    
    if(isset($_POST['ajouter'])){
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $duree = $_POST['duree'];
        $employe = $_SESSION['id']; // Auto-assign

        $query = $db->prepare("INSERT INTO tache(titre, description, duree, status, employe) VALUES(?,?,?,'En cours...',?)");
        $query->execute(array($titre,$description,$duree,$employe));

        header('location: index.php?p=mesTaches');
        exit();
    }
?>

<body>
    <form method="post" action="">
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive settings-card">
                    <div class="title">
                        <h2>Nouvelle tâche</h2>
                        <a href="index.php?p=mesTaches"><i class="bx bx-left-arrow"></i> Retour</a>
                    </div>
                    
                    <div class="card-settings-content">
                        <div class="info-edit">
                            <div class="form-group">
                                <label>Titre de la tâche</label>
                                <input type="text" name="titre" placeholder="Ex: Rédaction rapport" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="4" placeholder="Description détaillée..." style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-family: 'Poppins';"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Durée estimée (Heures)</label>
                                <input type="number" name="duree" placeholder="Ex: 2" required>
                            </div>

                            <button type="submit" name="ajouter" class="btn-save">
                                Créer la tâche <i class="bx bx-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
    </form>
</body>
</html>
