<?php 
	require_once('header.php'); 
	require_once 'javascripts.php';
?>
 
<form action="login.php" method="post">
	Votre login : <input type="text" name="login"><br />
	Votre mot de passe : <input type="password" name="pwd"><br />
	<input type="submit" value="Connexion">
</form>
