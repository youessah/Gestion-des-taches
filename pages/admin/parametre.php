<?php
    $db = Database::Connect();

    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if(isset($_POST['modifier'])){
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $telephone = trim($_POST['telephone']);
            $adresse = trim($_POST['adresse']);
            $pass = $_POST['password'];
            
            // Gestion Photo
            $photoName = $user->photo; 
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                $extensions_valides = array('jpg', 'jpeg', 'png', 'webp');
                $extension_upload = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                
                if(in_array($extension_upload, $extensions_valides)){
                    $photoName = uniqid() . '.' . $extension_upload;
                    move_uploaded_file($_FILES['photo']['tmp_name'], './public/pictures/' . $photoName);
                }
            }
    
            if(!empty($pass)){
                // Hash password if changed
                $password = password_hash($pass, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, telephone = ?, adresse = ?, password = ?, photo = ? WHERE id = ?");
                $stmt->execute([$nom, $prenom, $telephone, $adresse, $password, $photoName, $id]);
            } else {
                $stmt = $db->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, telephone = ?, adresse = ?, photo = ? WHERE id = ?");
                $stmt->execute([$nom, $prenom, $telephone, $adresse, $photoName, $id]);
            }
    
            header('location: index.php?p=parametre');
            exit();
        }
    }
?>

<body>
    <form method="post" action="" enctype="multipart/form-data">
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive settings-card">
                    <div class="title">
                        <h2>Vos informations</h2>
                        <?php if($_SESSION['status'] == 'employe'): ?>
                            <a href="index.php?p=userHome"><i class="bx bx-left-arrow"></i> Retour</a>
                        <?php else: ?>
                            <a href="index.php?p=home"><i class="bx bx-left-arrow"></i> Retour</a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-settings-content">
                        <!-- Colonne Photo -->
                        <div class="card-profile-edit">
                            <div class="card-image circle">
                                <?php if($user->photo): ?>
                                    <img src="./public/pictures/<?= $user->photo ?>" alt="Photo de profil">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/150" alt="Pas de photo">
                                <?php endif; ?>
                            </div>
                            <label for="file-upload" class="custom-file-upload">
                                <i class="bx bx-camera"></i> Changer la photo
                            </label>
                            <input id="file-upload" type="file" name="photo">
                        </div>

                        <!-- Colonne Formulaire -->
                        <div class="info-edit">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nom</label>
                                    <input type="text" name="nom" value="<?= $user->nom ?>" placeholder="Entrez le nom" required>
                                </div>
                                <div class="form-group">
                                    <label>Prénom</label>
                                    <input type="text" name="prenom" value="<?= $user->prenom ?>" placeholder="Entrez le prénom" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Téléphone</label>
                                    <input type="number" name="telephone" value="<?= $user->telephone ?>" placeholder="Numéro téléphone" required>
                                </div>
                                <div class="form-group">
                                    <label>Adresse</label>
                                    <input type="text" name="adresse" value="<?= $user->adresse ?>" placeholder="Adresse" required>
                                </div>
                            </div>
                            
                            <hr class="divider">
                            
                            <div class="form-group">
                                <label>Nouveau mot de passe</label>
                                <input type="password" name="password" placeholder="Entrez un nouveau mot de passe" required>
                            </div>

                            <button type="submit" name="modifier" class="btn-save">
                                Enregistrer les modifications <i class="bx bx-save"></i>
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