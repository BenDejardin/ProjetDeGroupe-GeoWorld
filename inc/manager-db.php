<?php
/**
 * Ce script est composé de fonctions d'exploitation des données
 * détenues pas le SGBDR MySQL utilisées par la logique de l'application.
 *
 * C'est le seul endroit dans l'application où a lieu la communication entre
 * la logique métier de l'application et les données en base de données, que
 * ce soit en lecture ou en écriture.
 *
 * PHP version 7
 *
 * @category  Database_Access_Function
 * @package   Application
 * @author    SIO-SLAM <sio@ldv-melun.org>
 * @copyright 2019-2021 SIO-SLAM
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      https://github.com/sio-melun/geoworld
 */

/**
 *  Les fonctions dépendent d'une connection à la base de données,
 *  cette fonction est déportée dans un autre script.
 */
require_once 'connect-db.php';

/**
 * Obtenir la liste de tous les pays référencés d'un continent donné
 *
 * @param string $continent le nom d'un continent
 * 
 * @return array tableau d'objets (des pays)
 */
function getCountriesByContinent($continent)
{
    // pour utiliser la variable globale dans la fonction
    global $pdo;
    $query = 'SELECT * FROM Country WHERE Continent = :cont;';
    $prep = $pdo->prepare($query);
    // on associe ici (bind) le paramètre (:cont) de la req SQL,
    // avec la valeur reçue en paramètre de la fonction ($continent)
    // on prend soin de spécifier le type de la valeur (String) afin
    // de se prémunir d'injections SQL (des filtres seront appliqués)
    $prep->bindValue(':cont', $continent, PDO::PARAM_STR);
    $prep->execute();
    // var_dump($prep);  pour du debug
    // var_dump($continent);

    // on retourne un tableau d'objets (car spécifié dans connect-db.php)
    return $prep->fetchAll();
}

/**
 * Obtenir la liste des pays
 *
 * @return liste d'objets
 */
function getAllCountries()
{
    global $pdo;
    $query = 'SELECT * FROM Country;';
    return $pdo->query($query)->fetchAll();
}


/**
* Obtenir la liste avec toute les informations du pays
* @param $nameCountry nom d'un pays
* @return array d'objet de type info
*/
function getInfosPays($nameCountry)
{
   global $pdo;
    $query = "SELECT * FROM `country` WHERE name = :nameCountry;";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':nameCountry', $nameCountry, PDO::PARAM_STR);
    $prep->execute();
   

    return $prep->fetchAll();
}

/**
* Obtenir la liste des langues parlees dans un pays 
* @param $idCountry id d'un pays
* @return array d'objet de type langues
*/
function getDifferentesLangues($idCountry)
{
   global $pdo;
    $query = "SELECT idCountry,language.Name,countrylanguage.Percentage FROM countrylanguage,country,language WHERE countrylanguage.idLanguage=language.id AND countrylanguage.idCountry=country.id AND countrylanguage.idCountry = :id ORDER BY countrylanguage.Percentage DESC;";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':id', $idCountry, PDO::PARAM_INT);
    $prep->execute();
   

    return $prep->fetchAll();
}

/**
* Obtenir la liste des continents dans le monde
* @param $idCountry id d'un pays
* @return array d'objet de type economiques et sociales
*/
function getDonneesEconomiqueSociale($idCountry)
{
    global $pdo;
    $query = "SELECT `Population`,`GNP`,`HeadOfState` FROM `country` WHERE id = :id;";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':id', $idCountry, PDO::PARAM_INT);
    $prep->execute();
   

    return $prep->fetchAll();
}

/**
* Obtenir la liste des continents dans le monde
* 
* @return array d'objet de type contients
*/
function getContinents()
{
    global $pdo;
    $query = 'SELECT DISTINCT `Continent` FROM `country` ORDER BY `Continent` ASC';
    return $pdo->query($query)->fetchAll();
}

/**
* Obtenir la liste des villes d'un pays
* @param $idCountry id d'un pays
* @return array d'objet de type city
*/
function getCityFromIdCountry($idCountry)
{
    global $pdo;
    $query = "SELECT * FROM `city` WHERE idCountry = :idCountry;";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':idCountry', $idCountry, PDO::PARAM_INT);
    $prep->execute();
   

    return $prep->fetchAll();
}

