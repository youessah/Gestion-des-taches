<?php

    $db = Database::Connect();
    if(isset($_POST['ajouter'])){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];
        $pass = $_POST['password'];
        
        $password = password_hash($pass, PASSWORD_DEFAULT);
        
        $photoName = null;
        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
            $extensions_valides = array('jpg', 'jpeg', 'png');
            $extension_upload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
            
            if(in_array($extension_upload, $extensions_valides)){
                $photoName = uniqid() . '.' . $extension_upload;
                move_uploaded_file($_FILES['photo']['tmp_name'], './public/pictures/' . $photoName);
            }
        }

        if($photoName){
            $query = $db->prepare("INSERT INTO utilisateur(nom, prenom, telephone, adresse, password, status, photo) VALUES(?,?,?,?,?,'employe',?)");
            $query->execute(array($nom,$prenom,$telephone,$adresse,$password,$photoName));
        }else{
            $query = $db->prepare("INSERT INTO utilisateur(nom, prenom, telephone, adresse, password, status) VALUES(?,?,?,?,?,'employe')");
            $query->execute(array($nom,$prenom,$telephone,$adresse,$password));
        }

        header('location: index.php?p=employe');
    }