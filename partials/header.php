
<?php
    if(isset($_SESSION['id'])){
        $db = Database::Connect();
        $query = $db->query("SELECT * FROM utilisateur WHERE id = ". $_SESSION['id']);
        $user = $query->fetch(PDO::FETCH_OBJ);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/design/style.css">
    <link rel="stylesheet" href="./public/boxicons-2.1.4/css/boxicons.min.css">
    <script defer src="./public/scripts/app.js"></script>
    <title><?= $title ?></title>
</head>
<header>
    <?php if(isset($_SESSION['status'])): ?>
        <?php if($_SESSION['status'] == 'employe'): ?>
            <a href="index.php?p=userHome" class="logo"> <i class="bx bxl-apple"></i> <h2>CAT</h2></a>
        <?php else: ?>
            <a href="index.php?p=home" class="logo"> <i class="bx bxl-apple"></i> <h2>CAT</h2></a>
        <?php endif; ?>
    <?php else: ?>
        <a href="#" class="logo"> <i class="bx bxl-apple"></i> <h2>CAT</h2></a>
    <?php endif; ?>
    <?php if(isset($_SESSION['id'])): ?>
        <div class="profile">
            <div class="username">
                <span class="username-infos">Hey,</span><b><?= $user->nom ?></b><br>
                <span class="username-infos"><?= $user->status ?></span>
            </div>
            <div class="img-circle">
                <img src="./public/pictures/<?= $user->photo ?>" alt="">
            </div>
        </div>
    <?php endif; ?>
</header>