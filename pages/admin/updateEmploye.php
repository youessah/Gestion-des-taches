<?php
    $db = Database::Connect();

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        $employe = $stmt->fetch(PDO::FETCH_OBJ);

        if(isset($_POST['modifier'])){
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $telephone = trim($_POST['telephone']);
            $adresse = trim($_POST['adresse']);
            $pass = $_POST['password'];
            $old_photo = $employe->photo;
            
            // Photo handling
            $photo_name = $old_photo;
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                $file = $_FILES['photo'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                
                if(in_array(strtolower($ext), $allowed)){
                    $photo_name = time() . '_' . $file['name'];
                    move_uploaded_file($file['tmp_name'], './public/pictures/' . $photo_name);
                }
            }

            if(!empty($pass)){
                $password = password_hash($pass, PASSWORD_DEFAULT);
                $query = $db->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, telephone = ?, adresse = ?, password = ?, photo = ? WHERE id = ?");
                $query->execute(array($nom, $prenom, $telephone, $adresse, $password, $photo_name, $id));
            } else {
                $query = $db->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, telephone = ?, adresse = ?, photo = ? WHERE id = ?");
                $query->execute(array($nom, $prenom, $telephone, $adresse, $photo_name, $id));
            }
    
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
            <div class="content">
                <div class="title-row">
                    <h3>Modifier l'employé</h3>
                    <a href="index.php?p=employe" class="link-sm"><i class="bx bx-arrow-back"></i> Retour à la liste</a>
                </div>

                <div class="card-responsive settings-card">
                    <form method="post" action="" enctype="multipart/form-data" class="card-settings-content">
                        <!-- Left Side: Profile Photo -->
                        <div class="card-profile-edit">
                            <div class="card-image circle">
                                <img src="./public/pictures/<?= $employe->photo ?>" alt="Photo de profil" id="preview-img">
                            </div>
                            <label for="file-upload" class="custom-file-upload">
                                <i class="bx bx-camera"></i> Changer la photo
                            </label>
                            <input id="file-upload" type="file" name="photo" onchange="previewFile()"/>
                            <p style="font-size: 0.7rem; color: var(--text-light); text-align: center;">Format JPG, PNG ou WebP accepté.</p>
                        </div>

                        <!-- Right Side: Information -->
                        <div class="info-edit">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nom</label>
                                    <input type="text" name="nom" value="<?= $employe->nom ?>" placeholder="Nom" required>
                                </div>
                                <div class="form-group">
                                    <label>Prénom</label>
                                    <input type="text" name="prenom" value="<?= $employe->prenom ?>" placeholder="Prénom" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Téléphone</label>
                                    <input type="number" name="telephone" value="<?= $employe->telephone ?>" placeholder="Téléphone" required>
                                </div>
                                <div class="form-group">
                                    <label>Adresse</label>
                                    <input type="text" name="adresse" value="<?= $employe->adresse ?>" placeholder="Adresse" required>
                                </div>
                            </div>

                            <hr class="divider">
                            
                            <div class="form-group">
                                <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                                <input type="password" name="password" placeholder="••••••••">
                            </div>

                            <button type="submit" name="modifier" class="btn-save">
                                <i class="bx bx-check-circle"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('preview-img');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>