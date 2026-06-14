<?php
    $db = Database::Connect();
    $error = null;
    if(isset($_POST['connexion'])){
        $telephone = trim($_POST['telephone']);
        $password = trim($_POST['password']);

        // Utilisation d'une requête préparée pour éviter l'injection SQL
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE telephone = ?");
        $stmt->execute([$telephone]);
        $usr = $stmt->fetch(PDO::FETCH_OBJ);

        $authenticated = false;
        if($usr && password_verify($password, $usr->password)){
            // Régénérer l'ID de session pour prévenir la fixation de session
            session_regenerate_id(true);
            
            $_SESSION['id'] = $usr->id;
            $_SESSION['status'] = $usr->status;
            $_SESSION['nom'] = $usr->prenom . ' ' . $usr->nom;
            $authenticated = true;

            if($usr->status == 'employe'){
                header('location: index.php?p=userHome');
            }else{
                header('location: index.php?p=home');
            }
            exit(); 
        }

        if(!$authenticated){
            $error = "Identifiants incorrects. Veuillez réessayer.";
        }
    }

?>


<body>
    <?php include('./partials/header.php') ?>
    <div class="login-wrapper">
        <div class="login-side">
            <div class="login-overlay"></div>
            <div class="login-content">
                <h1>Task Manager</h1>
                <p>Planifiez, Organisez, Réussissez.</p>
            </div>
        </div>
        <div class="login-form-container">
            <form method="post" class="loginForm" action="">
                <h2>Connexion</h2>
                <p class="login-subtitle">Entrez vos identifiants pour accéder à votre espace.</p>
                
                <?php if(isset($error)): ?>
                    <div class="alert-error">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="telephone">Identifiant (Téléphone)</label>
                    <div class="input-icon">
                        <i class='bx bx-phone'></i>
                        <input type="text" name="telephone" id="telephone" placeholder="Entrez votre numéro" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-icon">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" id="password" placeholder="Votre mot de passe">
                    </div>
                </div>

                <button type="submit" name="connexion" class="btn-login">
                    Se connecter <i class='bx bx-right-arrow-alt'></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>