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

function getCountriesWithId($id)
{
   global $pdo;
    $query = 'SELECT * FROM Country WHERE id = :id;';
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':id', $id, PDO::PARAM_STR);
    $prep->execute();
   

    return $prep->fetchAll();
}

function LangueParler($id)
{
   global $pdo;
    $query = "SELECT idCountry,language.Name,countrylanguage.Percentage FROM countrylanguage,country,language WHERE countrylanguage.idLanguage=language.id AND countrylanguage.idCountry=country.id AND countrylanguage.idCountry = :id ORDER BY countrylanguage.Percentage DESC;";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':id', $id, PDO::PARAM_STR);
    $prep->execute();
   

    return $prep->fetchAll();
}

function DataEconomiqueSociale($id)
{
    global $pdo;
    $query = "SELECT `Population`,`GNP`,`HeadOfState` FROM `country` WHERE id = :id;";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':id', $id, PDO::PARAM_STR);
    $prep->execute();
   

    return $prep->fetchAll();
}