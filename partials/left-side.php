<?php
    if(isset($_SESSION['id'])){
        $db = Database::Connect();
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$_SESSION['id']]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
    }
?>

<div class="left-side">
    <ul>
        <?php if($_SESSION['status'] == 'employe'): ?>
            <li>
                <a href="index.php?p=userHome"><i class="bx bx-notification"></i> Dashboard</a>
            </li>
        <?php else: ?>
            <li>
                <a href="index.php?p=home"><i class="bx bx-notification"></i> Dashboard</a>
            </li>
        <?php endif; ?>
        <?php if($_SESSION['status'] == 'admin'): ?>
            <li>
                <a href="index.php?p=employe"><i class="bx bx-user"></i> Employes</a>
            </li>
            <li>
                <a href="index.php?p=tache" class="active"><i class="bx bx-task"> </i>Taches</a>
            </li>
            <li>
                <a href="index.php?p=conge"><i class="bx bx-send"></i> Congé</a>
            </li>
        <?php endif; ?>
        <?php if($_SESSION['status'] == 'employe'): ?>
            <li>
                <a href="index.php?p=mesTaches" class="active"><i class="bx bx-task"> </i>Mes Taches</a>
            </li>
            <li>
                <a href="index.php?p=demandeConge" class="active"><i class="bx bx-plus-circle"> </i>Demander congé</a>
            </li>
            <li>
                <a href="index.php?p=historique" class="active"><i class="bx bx-task"> </i>Historique</a>
            </li>
            <li>
                <a href="index.php?p=congeUser"><i class="bx bx-send"></i>Mes Congé</a>
            </li>
        <?php endif; ?>
        <li>
            <a href="index.php?p=agenda"><i class="bx bx-calendar"></i> Agenda</a>
        </li>
        <li>
            <a href="index.php?p=parametre"><i class="bx bx-edit"></i> Parametres</a>
        </li>
    </ul>
    <ul>
        <li>
            <a href="index.php?p=deconnexion"><i class="bx bx-power-off"></i> Deconnexion</a>
        </li>
    </ul>
</div>