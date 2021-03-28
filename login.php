<?php
 require_once('connexionPdo.php');
 
 // on teste si nos variables sont définies et remplies
 if (isset($_POST['login']) && isset($_POST['pwd']) && !empty($_POST['login'])&& !
empty($_POST['login'])) {
	 
	 // on appele la fonction getAuthentification en lui passant en paramètre le login et password
	 function getAuthentifications($login,$pass){
		 global $pdo;
		 $query = "SELECT * FROM informations_utilisateurs where login=:login and password=:pass";
		 $prep = $pdo->prepare($query);
		 $prep->bindValue(':login', $login);
		 $prep->bindValue(':pass', $pass);
		 $prep->execute();
		 // on vérifie que la requête ne retourne qu'une seule ligne
		 if($prep->rowCount() == 1){
		 $result = $prep->fetch();
		 return $result;
		 }
		 else
		 return false;
	}

	$result = getAuthentifications($_POST['login'],$_POST['pwd']);
	 print_r($result);
	 // si le résulat n'est pas false
	 if($result){
		// on la démarre la session
		session_start ();
		// on enregistre les paramètres de notre visiteur comme variables de session
		$_SESSION['login'] = $result->login;
		$_SESSION['pwd'] = $result->password;
		$_SESSION['role'] = $result->role;
		// on redirige notre visiteur vers une page de notre section membre
		header ('location: index.php');
	 }
	 
	 //si le résultat est false on redirige vers la page d'authentification
	 else{
	 header ('location: authentification.php');
	 }
 }

 //si nos variables ne sont pas renseignées on redirige vers la page d'authentification
 else {
 header ('location: authentification.php');
 }
 ?> 