<?php
session_start();

require './app/Database.php';

// Initialisation de la page par défaut
$p = isset($_GET['p']) ? $_GET['p'] : 'home';

// Pages accessibles sans être connecté
$public_pages = ['login', 'deconnexion'];

// Vérification de l'authentification
if (!isset($_SESSION['id']) && !in_array($p, $public_pages)) {
    header('Location: index.php?p=login');
    exit();
}

$status = isset($_SESSION['status']) ? $_SESSION['status'] : null;

// --- LOGIQUE DE ROUTAGE & RBAC ---
switch ($p) {
    case 'login':
        $title = 'Connexion';
        require './pages/login.php';
        break;

    case 'deconnexion':
        session_destroy();
        header('location: index.php?p=login');
        exit();

    // PAGES ADMINISTRATEUR
    case 'home':
    case 'employe':
    case 'tache':
    case 'detailEmploye':
    case 'detailTache':
    case 'updateEmploye':
    case 'deleteEmploye':
    case 'updateTache':
    case 'deleteTache':
    case 'parametre':
    case 'conge':
    case 'addEmploye':
    case 'addTache':
    case 'acceptLeave':
    case 'rejectLeave':
        // Sécurité : Seul l'admin accède à ces pages
        if ($status !== 'admin') {
            header('Location: index.php?p=userHome');
            exit();
        }
        
        switch ($p) {
            case 'home': $title = 'Dashboard'; require './pages/admin/accueil.php'; break;
            case 'employe': $title = 'Employe'; require './pages/admin/employe.php'; break;
            case 'tache': $title = 'Tache'; require './pages/admin/tache.php'; break;
            case 'detailEmploye': $title = 'Infos Employe'; require './pages/admin/detailEmploye.php'; break;
            case 'detailTache': $title = 'Infos Tache'; require './pages/admin/detailTache.php'; break;
            case 'updateEmploye': $title = 'Modifier Employe'; require './pages/admin/updateEmploye.php'; break;
            case 'deleteEmploye': $title = 'Supprimer Employe'; require './pages/admin/deleteEmploye.php'; break;
            case 'updateTache': $title = 'Modifier Tache'; require './pages/admin/updateTache.php'; break;
            case 'deleteTache': $title = 'Supprimer Tache'; require './pages/admin/deleteTache.php'; break;
            case 'parametre': $title = 'Mes informations'; require './pages/admin/parametre.php'; break;
            case 'conge': $title = 'Congés'; require './pages/admin/conge.php'; break;
            case 'addEmploye': require './controller/addEmploye.php'; break;
            case 'addTache': require './controller/addTache.php'; break;
            
            case 'acceptLeave':
                $db = Database::Connect();
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    // Requête préparée pour éviter l'injection SQL
                    $stmt = $db->prepare("SELECT id_user FROM conge WHERE id = ?");
                    $stmt->execute([$id]);
                    $getU = $stmt->fetch(PDO::FETCH_OBJ);
                    
                    if($getU){
                        $db->prepare("UPDATE conge SET statut = 'Accepter' WHERE id = ?")->execute([$id]);
                        // Création d'une notification sécurisée
                        $db->prepare("INSERT INTO notification (user_id, message, type) VALUES (?, 'Votre demande de congé a été acceptée.', 'leave')")
                           ->execute([$getU->id_user]);
                    }
                }
                header('location: index.php?p=conge');
                exit();

            case 'rejectLeave':
                $db = Database::Connect();
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $stmt = $db->prepare("SELECT id_user FROM conge WHERE id = ?");
                    $stmt->execute([$id]);
                    $getU = $stmt->fetch(PDO::FETCH_OBJ);
                    
                    if($getU){
                        $db->prepare("UPDATE conge SET statut = 'Refuser' WHERE id = ?")->execute([$id]);
                        $db->prepare("INSERT INTO notification (user_id, message, type) VALUES (?, 'Votre demande de congé a été refusée.', 'leave')")
                           ->execute([$getU->id_user]);
                    }
                }
                header('location: index.php?p=conge');
                exit();
        }
        break;

    // PAGES EMPLOYE
    case 'userHome':
    case 'mesTaches':
    case 'detailTacheUser':
    case 'tacheDone':
    case 'historique':
    case 'agenda':
    case 'addAgenda':
    case 'demandeConge':
    case 'addTaskUser':
    case 'congeUser':
        // Sécurité : Accès restreint aux employés (et admin par commodité)
        if ($status !== 'employe' && $status !== 'admin') {
            header('Location: index.php?p=login');
            exit();
        }
        
        switch ($p) {
            case 'userHome': $title = 'Dashboard'; require './pages/employe/userHome.php'; break;
            case 'mesTaches': $title = 'Mes taches'; require './pages/employe/mesTache.php'; break;
            case 'detailTacheUser': $title = 'Infos Tâche'; require './pages/employe/detailTacheUser.php'; break;
            case 'tacheDone': $title = 'Tache terminée'; require './pages/employe/tacheDone.php'; break;
            case 'historique': $title = 'Mon Historique'; require './pages/employe/historique.php'; break;
            case 'agenda': $title = 'Agenda'; require './pages/employe/agenda.php'; break;
            case 'addAgenda': $title = 'Ajouter agenda'; require './pages/employe/addAgenda.php'; break;
            case 'demandeConge': $title = 'Demander un congé'; require './pages/employe/demandeConge.php'; break;
            case 'addTaskUser': $title = 'Ajouter une tâche'; require './pages/employe/addTaskUser.php'; break;
            case 'congeUser': $title = 'Congés'; require './pages/employe/congeUser.php'; break;
        }
        break;

    default:
        // Redirection par défaut selon le rôle
        header('Location: index.php?p=' . ($status === 'admin' ? 'home' : 'userHome'));
        exit();
}