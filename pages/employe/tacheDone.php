<?php
    $db = Database::Connect();
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        if(isset($_POST['update'])){
            // Vérification de sécurité : la tâche doit appartenir à l'utilisateur
            $stmtCheck = $db->prepare("SELECT employe FROM tache WHERE id = ?");
            $stmtCheck->execute([$id]);
            $task = $stmtCheck->fetch(PDO::FETCH_OBJ);

            if($task && ($task->employe == $_SESSION['id'] || $_SESSION['status'] == 'admin')){
                $stmt = $db->prepare("UPDATE tache SET status = 'Terminée' WHERE id = ?");
                $stmt->execute([$id]);
            }
            
            header('location: index.php?p=mesTaches');
            exit();
        }
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
                        <h2>Tâche terminée ?</h2>
                        <a href="index.php?p=mesTaches"><i class="bx bx-left-arrow"></i> Retour</a>
                    </div>
                    <div class="question">
                        <h3>Avez-vous vraiment terminée cette tache ?</h3>
                        <div class="btn-group">
                            <a href="index.php?p=mesTaches">Non</a>
                            <form method="post">
                                <button type="submit" name="update">Oui</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
</body>
</html>