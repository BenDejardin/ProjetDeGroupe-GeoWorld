<?php
/**
 * Home Page
 *
 * PHP version 7
 *
 * @category  Page
 * @package   Application
 * @author    SIO-SLAM <sio@ldv-melun.org>
 * @copyright 2019-2021 SIO-SLAM
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      https://github.com/sio-melun/geoworld
 */

require_once 'header.php'; 
// session_start ();
// echo $_SESSION['login'];
// echo $_SESSION['pwd'];
// echo $_SESSION['role'];

require_once 'inc/manager-db.php';
if (!isset($_GET["continent"])) {
 ?>


 <!-- <style type="text/css">
  body{
   background-image: url("images/map-index.png");
   background-repeat:no-repeat;
   background-position: center 3em;
  }
 </style> -->

 <?php
 require_once 'demo_world.html';
}

else{
  $continent = $_GET["continent"];
  $desPays = getCountriesByContinent($continent);
?>

<main role="main" class="flex-shrink-0">

  <div class="container">
    <h1>Les pays en <?php echo"$continent"; ?></h1>
    <div>
     <table class="table">
        <tr>
          <th>Drapeau</th>
          <th>Nom</th>
          <th>Population</th>
          <th>Superficie</th>
          <th>Information</th>
        </tr>
            <?php foreach ($desPays as $pays) :?>    
          <tr>
            <?php 
              $filename = strtolower($pays->Code2);
              if (file_exists("images/drapeau/".$filename.".png")):?>
                <td><img src="images/drapeau/<?php echo $filename; ?>.png"/></td>
              <?php endif; 

              if (!file_exists("images/drapeau/".$filename.".png")):?>
                <td></td>
              <?php endif;?>

            <td><?php echo $pays->Name ?></td>
            
            <td>
              <?php 
                $Population =number_format($pays->Population, 0,' ', ' ');
                echo $Population." hab."; 
              ?>
            </td>

            <td>
              <?php 
                $Superficie =number_format($pays->SurfaceArea, 0,' ', ' ');
                echo $Superficie." km²"; 
              ?>
            </td>

            <td><a href="moreInfo.php?id=<?php echo $pays->id ?> " >+ d'Information</a></td>

          </tr>
       <?php endforeach;?>
          </tr>
     </table>
    </div>
    <p>
        <code>
      <?php
        //var_dump($desPays[0]);
        ?>
        </code>
    </p>
  </div>
</main>

<?php
}
require_once 'javascripts.php';
require_once 'footer.php';
?>
