<?php $error = $_GET["new"] ?? null; ?>
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
		<a href="/login.php" class="btn-login">Login</a>
		<form class="registrar-usuario" id="box" method="post" action="register.php">
			<h1>Register</h1>
			<input type="text" placeholder="Username" name="username" minlength="6" autofocus />
			<input type="password" placeholder="Password" name="password" minlength="6" />
			<?php if($error): ?>
				<p style="text-align: center;">User already exists.</p>
			<?php endif; ?>
			<button type="submit" name="submit" value="register">Register</button>
		</form>
		<script src="/assets/js/app.js"></script>
	</body>

</html>
