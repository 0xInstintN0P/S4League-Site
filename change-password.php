<?php
    require __DIR__ . "/config.php";
    require __DIR__ . "/crypt.php";
    validarSesion();
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $nickname = $_SESSION["nickname"];
        
        $db = getDBConection();
        $actalPassword = $db -> escape_string($_POST['actual-password']) ?? null;
		$newPassword = $db -> escape_string($_POST['new-password']) ?? null;
		$newPasswordConfirm = $db -> escape_string($_POST['new-password-confirmation']) ?? null;
        $query = "SELECT * FROM accounts WHERE Nickname = '$nickname'";
        $result = $db -> query($query) -> fetch_assoc();
        
        if(check_password($actalPassword, $result["Password"], $result["Salt"])) {
            if(!empty(trim($newPassword)) || !empty(trim($newPasswordConfirm))) {
                if($newPassword == $newPasswordConfirm) {
                    $result_hash = create_password($newPassword);
                    $p = $result_hash -> hash;
                    $s = $result_hash -> salt;
    
                    $query = "UPDATE accounts SET  Password = '$p', Salt = '$s' WHERE Nickname = '$nickname' LIMIT 1";
                    $result = $db -> query($query);
                    if($result) {
                        $_SESSION["change"] = true;
                        header("Location: /account.php?change=true");
                    }
                } else {
                    $error = "Confirm that the new password is the same in both fields.";
                }
            } else {
                $error = "The new password must not be left empty.";
            }
        } else {
            $error = "The current password is not correct.";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<link rel="icon" href="assets/img/favicon.png" type="image/png" />
    <head>
        <meta charset="utf-8"/>
		<title>S4 Return - Register </title>
        
		<!-- The main CSS file -->
		<link href="assets/css/style.css" rel="stylesheet" />
	</head>
	<body>
        <form class="cambiar-contraseña" id="box" method="post">
            <h1>Change password</h1>
            <input type="password" placeholder="Actual Password" name="actual-password" minlength="6" autofocus />
            <input type="password" placeholder="New Password" name="new-password" minlength="6" autofocus />
            <input type="password" placeholder="Confirm your new password" name="new-password-confirmation" minlength="6" />
            <?php if(isset($error)): ?>
            <p style="text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" name="submit" value="register">Register</button>
            
        </form>
		<script src="/assets/js/app.js"></script>
	</body>

</html>