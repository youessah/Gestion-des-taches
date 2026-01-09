<?php
    $db = Database::Connect();
    $error = null;
    if(isset($_POST['connexion'])){
        $statut = trim($_POST['statut']);
        $password = trim($_POST['password']);

        $query = $db->query("SELECT * FROM utilisateur WHERE status = '$statut'");
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $authenticated = false;
        foreach($result as $usr){
            if($usr){
                if(password_verify($password, $usr->password)){
                    $_SESSION['id'] = $usr->id;
                    $_SESSION['status'] = $usr->status;
                    $authenticated = true;

                    if($usr->status == 'employe'){
                        header('location: index.php?p=userHome');
                    }else{
                        header('location: index.php?p=home');
                    }
                    exit(); // Stop execution immediately after redirect
                }
            }
        }

        if(!$authenticated){
            $error = "Mot de passe incorrect pour le status " . htmlspecialchars($statut) . ". (Reçu: " . strlen($password) . " caractères)";
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
                    <label for="poste">Poste</label>
                    <div class="input-icon">
                        <i class='bx bx-user'></i>
                        <select name="statut" id="poste" class="form-control">
                            <option value="admin">Administrateur</option>
                            <option value="employe">Employé</option>
                        </select>
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