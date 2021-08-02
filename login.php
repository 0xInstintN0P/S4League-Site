<?php
	$logout = $_GET["logout"] ?? null;
	session_start();
	$create = $_SESSION["create"] ?? null;

	if($logout) {
		session_start();
		session_destroy();
		header("Location: /login.php");
	}

    if($_SERVER["REQUEST_METHOD"] == "POST"){
		require __DIR__ . "/config.php";
		require __DIR__ . "/crypt.php";

		$db = getDBConection();
        $username = $db -> escape_string($_POST['username']) ?? null;
		$password = $db -> escape_string($_POST['password']) ?? null;
		$query = "SELECT * FROM accounts WHERE Username = '$username'";
		$result = $db -> query($query) -> fetch_assoc();
		if($result) {
			$success = check_password($password, $result["Password"], $result["Salt"]);
			if($success) {
				session_start();
				$_SESSION["logueado"] = true;
				$_SESSION["id"] = $result["Id"];
				$_SESSION["name"] = $result["Username"];
				$_SESSION["nickname"] = $result["Nickname"];
				$_SESSION["lastlogin"] = $result["LastLogin"];
				header("Location: /account.php");
			} else {
				$error = "Incorrect password.";
			}
		} else {
			$error = "Username does not exist.";
		}
    }
?>

<!DOCTYPE html>
<html lang="es">
<link rel="icon" href="assets/img/favicon.png" type="image/png" />
	<head>
		<meta charset="utf-8"/>
		<title>S4 Return - Login </title>

		<!-- The main CSS file -->
		<link href="assets/css/style.css" rel="stylesheet" />
	</head>
	<body>
		<?php if($create): ?>
			<input type="hidden" value="success" id="register">
			<?php $_SESSION["create"] = null; ?>
		<?php endif; ?>
		<form id="box" method="post">
			<h1>Login</h1>
			<input type="text" placeholder="User Name" name="username" minlength="6" autofocus />
			<input type="password" placeholder="Password" name="password" minlength="6" />

			<?php if(isset($error) && !empty($error)): ?>
			<p class="error"><?php echo $error; ?></p>
			<?php endif; ?>

			<button type="submit" name="submit" value="login">Login</button>
		</form>
		<script src="/assets/js/app.js"></script>
	</body>

</html>