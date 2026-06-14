<?php
    $db = Database::Connect();
    
    $agenda = "";
    if(isset($_POST['ajouter'])){
    $id = $_SESSION['id'];
    if(isset($_POST['lundi'])){
      $agenda .= $_POST['lundi']. "\n";
    }
    if(isset($_POST['mardi'])){
      $agenda .= $_POST['mardi']. "\n";
    }
    if(isset($_POST['mercredi'])){
      $agenda .= $_POST['mercredi']. "\n";
    }
    if(isset($_POST['jeudi'])){
      $agenda .= $_POST['jeudi']. "\n";
    }
    if(isset($_POST['vendredi'])){
      $agenda .= $_POST['vendredi']. "\n";
    }
    if(isset($_POST['samedi'])){
      $agenda .= $_POST['samedi']. "\n";
    }

    $req = $db->prepare("UPDATE utilisateur SET agenda = ? WHERE id = ?");
    $req->execute(array($agenda, $id));
    header('location: index.php?p=agenda');
  }

?>


<body>
    <div class="container">
        <?php include('./partials/header.php') ?>
        <div class="main">
            <?php include('./partials/left-side.php') ?>
            <div class="content">
                <div class="card-responsive">
                    <div class="title">
                        <h2>Jours de travail</h2>
                        <a href="index.php?p=agenda" ><i class="bx bx-chevron-left"></i> Retour </a>
                    </div>
                    <div class="container">
                      <form action="" method="post">
                        <p style="margin: 10px 0; color: var(--text-color);">Cochez les jours où vous êtes disponible :</p>
                        <div class="days-container">
                            <div class="workday-container">
                            <input type="checkbox" id="lundi" name="lundi" value="lundi">
                            <label for="lundi">Lundi</label>
                            </div>
                            <div class="workday-container">
                            <input type="checkbox" id="mardi" name="mardi" value="mardi">
                            <label for="mardi">Mardi</label>
                            </div>
                            <div class="workday-container">
                            <input type="checkbox" id="mercredi" name="mercredi" value="mercredi">
                            <label for="mercredi">Mercredi</label>
                            </div>
                            <div class="workday-container">
                            <input type="checkbox" id="jeudi" name="jeudi" value="jeudi">
                            <label for="jeudi">Jeudi</label>
                            </div>
                            <div class="workday-container">
                            <input type="checkbox" id="vendredi" name="vendredi" value="vendredi">
                            <label for="vendredi">Vendredi</label>
                            </div>
                            <div class="workday-container">
                            <input type="checkbox" id="samedi" name="samedi" value="samedi">
                            <label for="samedi">Samedi</label>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="ajouter">Ajouter</button>
                        </form>
                        </div>
                </div>
            </div>
            <?php include('./partials/right-side.php') ?>
        </div>
    </div>
</body>

<style>
    

.employee-container {
  margin: 10px 0;
  animation: slide-down 1s ease;
}

.days-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin: 10px 0;
  animation: slide-up 1s ease;
}

.workday-container {
  display: flex;
  align-items: center;
  margin: 10px;
  animation: fade-in 1s ease;
}

input[type="checkbox"] {
  appearance: none;
  width: 20px;
  height: 20px;
  border: 1px solid #ccc;
  border-radius: 50%;
  margin-right: 10px;
  cursor: pointer;
  animation: scale-up 1s ease;
}

input[type="checkbox"]:checked {
  background-color: #4caf50;
  animation: scale-down 1s ease;
}

label {
  cursor: pointer;
  animation: fade-in 1s ease;
}

button {
  margin-left: 40%;
  width: 200px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  font-size: 16px;
  animation: slide-up 1s ease;
}

button:hover {
  background-color: #3e8e41;
}

@keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}


</style>
</html>