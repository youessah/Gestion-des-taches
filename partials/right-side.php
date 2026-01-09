<?php

    $db = Database::Connect();
    $query = $db->query("SELECT * FROM utilisateur LIMIT 2");
    $employe = $query->fetchAll(PDO::FETCH_OBJ);

?>

<div class="right-side">
    <div class="card-logo">
        <h2>
        </h2>
        <span class="date">2/27/2024</span>
    </div>
    <div class="card-list">
        <div class="title">
            <h4>Meilleurs Employés</h4>
            <div><i class="bx bx-bell"></i></div>
        </div>
        <?php foreach($employe as $emp): ?>
            <div class="card-item">
                <div class="box">
                    <div class="icon-square">
                        <img src="./public/pictures/<?= $emp->photo ?>" alt="">
                    </div>
                    <div>
                        <h6><?= $emp->nom ?></h6>
                        <span><?= $emp->id ?> tâches</span>
                    </div>
                </div>
                <i class="bx bx-menu-alt-right"></i>
            </div>
        <?php endforeach; ?>
        <!-- <div class="card-item">
            <div class="box">
                <div class="icon-square green">
                    <i class="bx bx-laptop"></i>
                </div>
                <div>
                    <h6>Back-end</h6>
                    <span>08:00 AM - 12:00 PM</span>
                </div>
            </div>
            <i class="bx bx-menu-alt-right"></i>
        </div> -->
        <a href="index.php?p=employe">+ Afficher les employés</a>
    </div>
</div>