<?php
    $db = Database::Connect();


    if(isset($_POST['valider'])){
        $motif = $_POST['motif'];
        $date_fin = $_POST['date_fin'];
        $date_debut = $_POST['date_debut'];

        $query = $db->prepare("INSERT INTO conge(id_user, motif, date_debut, date_fin, statut) VALUES(?, ?, ?, ?, ?)");
        $query->execute(array($_SESSION['id'],$motif,$date_debut,$date_fin,'En cours..'));

        header('location: index.php?p=congeUser');
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
                        <h2>Demander un congé</h2>
                        <a href="index.php?p=congeUser"><i class="bx bx-left-arrow"></i> Retour</a>
                    </div>
                    <div class="card-settings-content">
                        <div class="info-edit">
                            <div class="form-group">
                                <label for="motif">Motif de la demande</label>
                                <textarea name="motif" id="motif" cols="30" rows="5" placeholder="Expliquez la raison de votre congé..." style="padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-family: 'Poppins';"></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="date_debut">Date de début</label>
                                    <input type="date" name="date_debut" id="date_debut" required>
                                </div>
                                <div class="form-group">
                                    <label for="date_fin">Date de fin</label>
                                    <input type="date" name="date_fin" id="date_fin" required>
                                </div>
                            </div>

                            <button type="submit" name="valider" class="btn-save">
                                Envoyer la demande <i class="bx bx-send"></i>
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