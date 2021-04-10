<?php

require_once 'connexionPdo.php';

/**
* Obtenir la liste des Utisateurs de Geoworld
* 
* @return array d'objet de type utilisateur
*/
function getAllUtilisateurs()
{
    global $pdo;
    $query = 'SELECT * FROM `informations_utilisateurs`';
    return $pdo->query($query)->fetchAll();
}

/**
* Obtenir la liste des Utisateurs de Geoworld
* 
* @return array d'objet de type utilisateur
*/
function getUtilisateurs($login)
{
    global $pdo;
    $query = "SELECT * FROM `informations_utilisateurs` WHERE login = :login;";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':login', $login, PDO::PARAM_STR);
    $prep->execute();
   

    return $prep->fetchAll();
}

?>