<?php
    $db = Database::Connect();
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        // Fetch employee details for context
        $stmt = $db->prepare("SELECT nom, prenom FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        $employe = $stmt->fetch(PDO::FETCH_OBJ);

        if(isset($_POST['delete'])){
            $stmt = $db->prepare("DELETE FROM utilisateur WHERE id = ?");
            $stmt->execute([$id]);
            header('location: index.php?p=employe');
            exit();
        }
    }
?>

<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content" style="display: flex; align-items: center; justify-content: center;">
                <div class="card-responsive" style="max-width: 450px; text-align: center; padding: 40px; border-top: 5px solid #ef4444;">
                    <div style="font-size: 3.5rem; color: #ef4444; margin-bottom: 20px;">
                        <i class="bx bx-error-circle"></i>
                    </div>
                    <h2 style="margin-bottom: 10px;">Suppression définitive</h2>
                    <p style="color: var(--text-light); margin-bottom: 30px; line-height: 1.6;">
                        Êtes-vous sûr de vouloir supprimer l'employé <br>
                        <strong style="color: var(--text-color); font-size: 1.1rem;"><?= htmlspecialchars($employe->nom . ' ' . $employe->prenom) ?></strong> ? 
                        <br>Cette action est irréversible.
                    </p>
                    
                    <div style="display: flex; gap: 15px; justify-content: center;">
                        <a href="index.php?p=employe" class="btn" style="background: #f1f5f9; color: #64748b; padding: 12px 25px;">
                            <i class="bx bx-x-circle"></i> Annuler
                        </a>
                        <form method="post" style="display: inline-block;">
                            <button type="submit" name="delete" class="btn" style="background: #ef4444; color: white; padding: 12px 25px;">
                                <i class="bx bx-trash"></i> Oui, supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>