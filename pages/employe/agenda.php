<?php
    $db = Database::Connect();
    $query = $db->query("SELECT * FROM utilisateur WHERE status = 'employe' AND agenda != '' ");
    $employeList = $query->fetchAll(PDO::FETCH_OBJ);

?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Proramme de la semaine</h2>
                        <a href="index.php?p=addAgenda" class="btnShowForm">Ajouter <i class="bx bx-plus-circle"></i></a>
                        </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th class="employee-header" style="text-align: left; padding-left: 15px;">Employé</th>
                                <th class="employee-header">Lun</th>
                                <th class="employee-header">Mar</th>
                                <th class="employee-header">Mer</th>
                                <th class="employee-header">Jeu</th>
                                <th class="employee-header">Ven</th>
                                <th class="employee-header">Sam</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employeList as $emp): ?>
                        <tr>
                            <td style="font-weight: 600; text-align: left; padding-left: 15px;"><?= htmlspecialchars($emp->nom) ?></td>
                            <td><?php if(strpos($emp->agenda, 'lundi') !== false){ echo "<span class='badge success'><i class='bx bx-check'></i></span>"; }else{ echo "<span style='color: #ccc;'>-</span>"; } ?></td>
                            <td><?php if(strpos($emp->agenda, 'mardi') !== false){ echo "<span class='badge success'><i class='bx bx-check'></i></span>"; }else{ echo "<span style='color: #ccc;'>-</span>"; } ?></td>
                            <td><?php if(strpos($emp->agenda, 'mercredi') !== false){ echo "<span class='badge success'><i class='bx bx-check'></i></span>"; }else{ echo "<span style='color: #ccc;'>-</span>"; } ?></td>
                            <td><?php if(strpos($emp->agenda, 'jeudi') !== false){ echo "<span class='badge success'><i class='bx bx-check'></i></span>"; }else{ echo "<span style='color: #ccc;'>-</span>"; } ?></td>
                            <td><?php if(strpos($emp->agenda, 'vendredi') !== false){ echo "<span class='badge success'><i class='bx bx-check'></i></span>"; }else{ echo "<span style='color: #ccc;'>-</span>"; } ?></td>
                            <td><?php if(strpos($emp->agenda, 'samedi') !== false){ echo "<span class='badge success'><i class='bx bx-check'></i></span>"; }else{ echo "<span style='color: #ccc;'>-</span>"; } ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
</body>
</html>