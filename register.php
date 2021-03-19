<?php

	require_once('header.php'); 
	require_once 'javascripts.php';

	// on la démarre la session
	// session_start ();
	// on enregistre les paramètres de notre visiteur comme variables de session
	if (isset($_POST['login'])) {
		$_SESSION['login'] = $_POST['login'];
		$_SESSION['pwd'] = $_POST['pwd'];
		$_SESSION['role'] = $_POST['role'];

		$servername = "localhost";
		$username = "root";
		$password = ""; 
		$dbname = "bdd_geoworld";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);

		$login = $_SESSION['login'];
		$password = $_SESSION['pwd'];
		$role = $_SESSION['role']; 
		
		$requete = "INSERT INTO `salaries` (`login`,`password`,`role`) VALUES('$login','$password','$role')";
		//echo $requete;
		mysqli_query($conn,$requete);
		header ('location: index.php');

	}
?>
	<form action="register.php" method="POST">
		<p>Login : <input type="text" name="login" required></p>
		<p>Password : <input type="password" name="pwd" required></p>
		<p>Mon rôle : </p>
		<p><input type="radio" name="role" value="Eleve"> Élève</p>
		<p><input type="radio" name="role" value="Professeur"> Professeur</p>
		<input type="submit" value="S'inscrire">
	</form>