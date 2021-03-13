<?php
require_once('connexionPdo.php');


function getNbSalaries(){
  global $pdo;
  $query = "SELECT count(*) as nb FROM salaries ;";
  try {
    $result = $pdo->query($query)->fetch();
    return $result->nb;
  }
   catch ( Exception $e ) {
  die ("erreur dans la requete ".$e->getMessage());
}
}

function getAllSalaries(){
    global $pdo;
    $query = 'SELECT idsalaries,nom,prenom,date_naissance,date_embauche,salaire,service FROM salaries ';

    try { 
      $result = $pdo->query($query)->fetchAll(); 
      return $result;
    }
    catch ( Exception $e ) {
      die ("erreur dans la requete ".$e->getMessage());
    }

}

function deleteSalaries($id){
      global $pdo;
      $query = "delete from salaries where idsalaries = :id ;";
      try {
	$prep = $pdo->prepare($query);
	$prep->bindValue(':id', $id);
	$prep->execute();
      }
      catch ( Exception $e ) {
	die ("erreur dans la requete ".$e->getMessage());
      }    
}

function updateSalarie($params){
  //print_r($params);
  global $pdo;
  $requete = "update salaries set nom=:nom,prenom=:prenom,date_naissance=:naissance,date_embauche=:embauche,salaire=:salaire,service=:service where idsalaries=:id";
  $prep = $pdo->prepare($requete);
  $prep->bindValue(':id', $params['id']);
  $prep->bindValue(':nom', $params['nom']);
  $prep->bindValue(':prenom', $params['prenom']);
  $prep->bindValue(':naissance', $params['dateNaissance']);
  $prep->bindValue(':embauche', $params['dateEmbauche']);
  $prep->bindValue(':salaire', $params['salaire']);
  $prep->bindValue(':service', $params['service']);
  $prep->execute();


}



function getSalarie($id){

    global $pdo;
    $requete = "SELECT * FROM salaries where idsalaries = :id";

    $prep = $pdo->prepare($requete);
    $prep->bindValue(':id', $id);
    $prep->execute();

    $result = $prep->fetch(); 
    return $result; 
    
}





?>
