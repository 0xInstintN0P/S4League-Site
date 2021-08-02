<?php
    require __DIR__ . "/config.php";
    require __DIR__ . "/crypt.php";
    validarSesion();

    $change = $_SESSION["change"] ?? null;  
    $id = $_SESSION["id"];
    
    $db = getDBConection();
    $query = "SELECT * FROM players WHERE id = $id";
    $result = $db -> query($query) -> fetch_assoc();
    $query2 = "SELECT * FROM club_players WHERE PlayerId = $id";
    $clubId = $db -> query($query2) -> fetch_assoc();
    $clubId = $clubId["ClubId"] ?? null;
    if($clubId) {
        $query3 = "SELECT * FROM clubs WHERE Id = $clubId";
        $club = $db -> query($query3) -> fetch_assoc();
    }
?>
<!DOCTYPE html>
<html lang="es">
<link rel="icon" href="assets/img/favicon.png" type="image/png" />
    <head>
        <meta charset="utf-8"/>
		<title>S4 Return - Register </title>
        <script src="https://kit.fontawesome.com/4a44549445.js" crossorigin="anonymous"></script>
		<!-- The main CSS file -->
		<link href="assets/css/style.css" rel="stylesheet" />
	</head>
	<body>
        <?php if($change): ?>
            <input type="hidden" name="change" value="true" id="change">
            <?php $_SESSION["change"] = null; ?>
        <?php endif;?>
        <div class="registrar-usuario" id="box" method="post" action="register.php">
            <h1>Hi :) - <?php echo $_SESSION["name"]; ?></h1>
            <?php if($result): ?>
                <div class="items-container">
                    <div class="image">
                        <img src="/assets/img/levels/<?php echo $result["Level"]; ?>.png" alt="Imagen del nivel del jugador">
                    </div>
                    <div class="item">
                        <p><em class="fas fa-user"></em><span>NickName: </span><?php echo $_SESSION["nickname"] ? $_SESSION["nickname"] : "No ha registrado su Nickname"; ?></p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-stopwatch"></em><span>Play Time: </span><?php echo $result["PlayTime"]; ?> Seconds</p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-dumbbell"></em><span>Tutorial: </span><?php echo $result["TutorialState"] == 0 ? "No completado" : "Completado"; ?></p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-skiing-nordic"></em><span>Level: </span><?php echo $result["Level"]; ?></p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-vial"></em><span>TotalExperience: </span><?php echo $result["TotalExperience"]; ?> puntos</p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-coins"></em><span>PEN: </span><?php echo $result["PEN"]; ?></p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-coins"></em><span>AP: </span><?php echo $result["AP"]; ?></p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-equals"></em><span>TotalMatches: </span><?php echo $result["TotalMatches"]; ?> Partidas</p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-trophy"></em><span>TotalWins: </span><?php echo $result["TotalWins"]; ?> Partidas</p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-window-close"></em><span>TotalLosses: </span><?php echo $result["TotalLosses"]; ?> Partidas</p>
                    </div>
                    <div class="item">
                        <p><em class="fas fa-laptop-house"></em><span>Clan: </span><?php echo isset($club) ? $club["Name"] : "No pertenece a ningún clan"; ?></p>
                    </div>
                </div>
            <?php else: ?>
            <div class="empty-player">
                <em class="fas fa-file-excel"></em>
                <h3>It cannot be displayed because you never entered the game.</h3>
            </div>
            <?php endif; ?>
            <div class="options-links">
                <a href="/login.php?logout=true" class="logout">Logout</a>
                <a href="/change-password.php" class="change-password">Change Password</a>
            </div>
        </div>
		<script src="/assets/js/app.js"></script>
	</body>

</html>