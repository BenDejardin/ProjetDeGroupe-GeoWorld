<?php
/**
 * Fragment Header HTML page
 *
 * PHP version 7
 *
 * @category  Page_Fragment
 * @package   Application
 * @author    SIO-SLAM <sio@ldv-melun.org>
 * @copyright 2019-2021 SIO-SLAM
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      https://github.com/sio-melun/geoworld
 */

session_start ();
require_once 'inc/manager-db.php';

$continents = getContinents();
?>

<!doctype html>
<html lang="fr" class="h-100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>GeoWorld</title>
  <link rel="icon" type="image/png" sizes="16x16" href="./images/logo_nav.png">

  <!-- Bootstrap core CSS -->
  <link href="assets/bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="css/custom.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">GeoWorld</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="false">Continents</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
   
          <?php foreach ($continents as $continent) :?>
              <a class="dropdown-item" href="index.php?continent=<?php echo $continent->Continent; ?>"><?php echo $continent->Continent; ?></a>
          <?php endforeach ; ?>   

          </div>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if(!isset($_SESSION['login'])):?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <?php endif ?>
        <?php if(isset($_SESSION['login'])):?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="false"><?php echo $_SESSION['login']?></a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="deconnexion.php">Déconnexion</a>
            <?php if($_SESSION['role'] == "admin"):?>
            <a class="dropdown-item" href="updateUtil.php">Modifier les informations Utilisateurs</a>
            <?php else : ?>
            <a class="dropdown-item" href="updateUtil.php">Modifier votre Password</a>
            <?php endif; ?>
          </div>
        </li>
        <?php endif ?>
        <li class="nav-item">
          <a class="nav-link " href="todo-projet.php">
            Présentation-Atelier-de-Prof-SLAM
          </a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Rechercher votre pays" aria-label="Search" name="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
      <?php if (isset($_GET['Search'])){
        
        $recherche = $_GET['Search'];
        header('Location: moreInfo.php?Name='.$recherche);

      } 
        

      ?>
    </div>
  </nav>
</header>
