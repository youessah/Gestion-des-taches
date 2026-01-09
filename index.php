<?php
session_start();

require './app/Database.php';

if(isset($_GET['p'])){
    $p = $_GET['p'];
}else{
    $p = 'home';
}


if(isset($_SESSION['id'])){
    if($p === 'home'){
    
        $title = 'Dashboard';
        require './pages/admin/accueil.php';
    }elseif($p === 'employe'){
        
        $title = 'Employe';
        require './pages/admin/employe.php';
    }elseif($p === 'tache'){
        
        $title = 'Tache';
        require './pages/admin/tache.php';
    }elseif($p === 'detailEmploye'){
    
        $title = 'Infos Employe';
        require './pages/admin/detailEmploye.php';
    }elseif($p == 'detailTache'){
    
        $title = 'Infos Tache';
        require './pages/admin/detailTache.php';
    }elseif($p === 'updateEmploye'){
        
        $title = 'Modifier Employe';
        require './pages/admin/updateEmploye.php';
    }elseif($p === 'deleteEmploye'){
        
        $title = 'Supprimer Employe';
        require './pages/admin/deleteEmploye.php';
    }elseif($p === 'updateTache'){
        
        $title = 'Modifier Tache';
        require './pages/admin/updateTache.php';
    }elseif($p === 'deleteTache'){
        
        $title = 'Supprimer Tache';
        require './pages/admin/deleteTache.php';
    }elseif($p === 'parametre'){
        
        $title = 'Mes informations';
        require './pages/admin/parametre.php';
    }elseif($p === 'addEmploye'){
        
        $title = '';
        require './controller/addEmploye.php';
    }elseif($p === 'updateEmploye'){
        
        $title = '';
        require './controller/updateEmploye.php';
    }elseif($p === 'addTache'){
        
        $title = '';
        require './controller/addTache.php';
    }elseif($p === 'login'){
    
        $title = 'Connexion';
        require './pages/login.php';
    }elseif($p === 'deconnexion'){
        session_destroy();
        header('location: index.php?p=login');
    }elseif($p === 'userHome'){
    
        $title = 'Dashboard';
        require './pages/employe/userHome.php';
    }elseif($p === 'mesTaches'){
    
        $title = 'Mes taches';
        require './pages/employe/mesTache.php';
    }elseif($p === 'detailTacheUser'){

        $title = 'Infos Tâche';
        require './pages/employe/detailTacheUser.php';
    }elseif($p === 'tacheDone'){

        $title = 'Tache terminée';
        require './pages/employe/tacheDone.php';
    }    elseif($p === 'historique'){

        $title = 'Mon Historique';
        require './pages/employe/historique.php';
    }elseif($p === 'agenda'){

        $title = 'Agenda';
        require './pages/employe/agenda.php';
    }elseif($p === 'addAgenda'){

        $title = 'Ajouter agenda';
        require './pages/employe/addAgenda.php';
    }elseif($p === 'conge'){

        $title = 'Congés';
        require './pages/admin/conge.php';
    }elseif($p === 'demandeConge'){

        $title = 'Demander un congé';
        require './pages/employe/demandeConge.php';
    }elseif($p === 'addTaskUser'){

        $title = 'Ajouter une tâche';
        require './pages/employe/addTaskUser.php';
    }elseif($p === 'congeUser'){

        $title = 'Congés';
        require './pages/employe/congeUser.php';
    }elseif($p === 'acceptLeave'){

        $db = Database::connect();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $req = $db->query("UPDATE conge SET statut = 'Accepter' WHERE id = '$id'");
            header('location: index.php?p=conge');
        }
    }elseif($p === 'rejectLeave'){
        $db = Database::connect();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $req = $db->query("UPDATE conge SET statut = 'Refuser' WHERE id = '$id'");
            header('location: index.php?p=conge');
        }
    }
}else{
    $title = 'Connexion';
    require './pages/login.php';
}