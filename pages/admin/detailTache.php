<?php
    $db = Database::Connect();

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $db->prepare("SELECT tache.*, nom, prenom FROM tache INNER JOIN utilisateur ON utilisateur.id = tache.employe WHERE tache.id = ?");
        $stmt->execute([$id]);
        $tache = $stmt->fetch(PDO::FETCH_OBJ);
    }
?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content" style="display: flex; justify-content: center; align-items: flex-start; padding-top: 40px;">
                <div class="card-responsive" style="max-width: 800px; width: 100%;">
                    <div class="title" style="border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 25px;">
                        <h2 style="display: flex; align-items: center; gap: 10px;">
                            <i class="bx bx-info-circle" style="color: var(--primary-color);"></i>
                            Détails de la Tâche
                        </h2>
                        <a href="index.php?p=tache" class="btn-sm" style="display: flex; align-items: center; gap: 5px;">
                            <i class="bx bx-chevron-left"></i> Retour
                        </a>
                    </div>

                    <div class="task-detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div class="detail-group">
                            <label style="font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Titre de la tâche</label>
                            <p style="font-size: 1.1rem; font-weight: 600; color: var(--text-color);"><?= htmlspecialchars($tache->titre) ?></p>
                        </div>

                        <div class="detail-group">
                            <label style="font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Statut actuel</label>
                            <?php 
                                $statusClass = 'warning';
                                if($tache->status == 'terminer') $statusClass = 'success';
                                if($tache->status == 'En cours...') $statusClass = 'info';
                            ?>
                            <span class="badge <?= $statusClass ?>" style="font-size: 0.85rem; padding: 6px 12px;"><?= htmlspecialchars($tache->status) ?></span>
                        </div>

                        <div class="detail-group" style="grid-column: span 2;">
                            <label style="font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Description</label>
                            <p style="color: var(--text-color); line-height: 1.6; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #f1f5f9;">
                                <?= nl2br(htmlspecialchars($tache->description)) ?>
                            </p>
                        </div>

                        <div class="detail-group">
                            <label style="font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Employé assigné</label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bx bx-user" style="color: var(--primary-color);"></i>
                                <span style="font-weight: 500;"><?= htmlspecialchars($tache->nom.' '.$tache->prenom) ?></span>
                            </div>
                        </div>

                        <div class="detail-group">
                            <label style="font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Durée estimée</label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bx bx-time-five" style="color: var(--primary-color);"></i>
                                <span style="font-weight: 500; color: var(--text-color);"><?= $tache->duree ?> Heures</span>
                            </div>
                        </div>

                        <div class="detail-group">
                            <label style="font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Date de début</label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bx bx-calendar" style="color: var(--primary-color);"></i>
                                <span style="font-weight: 500;"><?= $tache->date_debut ? date('d/m/Y H:i', strtotime($tache->date_debut)) : '<i style="color: #94a3b8;">Non définie</i>' ?></span>
                            </div>
                        </div>

                        <div class="detail-group">
                            <label style="font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px;">Date de fin</label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="bx bx-calendar-check" style="color: var(--primary-color);"></i>
                                <span style="font-weight: 500;"><?= $tache->date_fin ? date('d/m/Y H:i', strtotime($tache->date_fin)) : '<i style="color: #94a3b8;">Non définie</i>' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="actions" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; gap: 15px; justify-content: flex-end;">
                        <a href="index.php?p=updateTache&id=<?= $tache->id ?>" class="btn" style="background: var(--primary-light); color: var(--primary-color); padding: 10px 20px; display: flex; align-items: center; gap: 8px; border: none;">
                            <i class="bx bx-edit"></i> Modifier
                        </a>
                        <a href="index.php?p=deleteTache&id=<?= $tache->id ?>" class="btn" style="background: #fee2e2; color: #dc2626; padding: 10px 20px; display: flex; align-items: center; gap: 8px; border: none;">
                            <i class="bx bx-trash"></i> Supprimer
                        </a>
                    </div>
                </div>
            </div>
            <!-- Removed right sidebar for cleaner detail view -->
        </div>
    </div>
</body>
</html>