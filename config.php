<?php

	function getDBConection() {
		$db = new mysqli("localhost", "root", "", "yourdatabase");
		if(!$db) {
			die("Could not connect to the database.");
		}
		return $db;
	}

	function validarSesion() {
		session_start();
		if(!isset($_SESSION["logueado"]) && !$_SESSION["logueado"]) {
			header("Location: /login.php");
		}
	}
?>
