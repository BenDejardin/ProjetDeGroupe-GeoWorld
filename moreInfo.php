<?php
	require_once 'header.php';
	require_once 'inc/manager-db.php';
	require_once 'inc/connect-db.php';
	require_once 'javascripts.php';
	
    ?> 
    <style type="text/css">
        h2{
            text-align: center;
        }
        h3{
            font-size: 20px;
            text-decoration: underline;
        }
        p,h3{
            font-weight: bold;
        }
        form,h3{
            padding-left: 12px;
        }
        .Formligne { 
            display: block;
            width:300px; 
        }
        .FormLibelle { 
            display: inline-block;
            width:100px; 
        }
        .FormInput { 
            width:100px;
        }
        table{
            width: 100%;
        }
    </style>
    
    <?php

	if (!isset ($_GET['id'])) {
		$nomPays = $_GET['Name'];
		$infosPays = getInfosPays($nomPays);
		foreach ($infosPays as $pays) {
			$idCountry = $pays->id;
		}
	}
	else{
		$idCountry = $_GET['id'];
	}

    if (!isset($idCountry)):?>
        <!-- <meta http-equiv="refresh" content="0; url=index.php"/> -->
        <p>Erreur : le nom du pays ne figure pas dans notre base de donnée</p>
    <?php
    else :
       $langues = getDifferentesLangues($idCountry);
        $donneesEconomiqueSociale = getDonneesEconomiqueSociale($idCountry);
        $cities = getCityFromIdCountry($idCountry); 
    endif;
	
	
?>


	


	<?php foreach ($infosPays as $pays) :?>  
    <?php if (!empty($pays->Name)): ?> 
        <h2><?php echo $pays->Name ?>
            
            <?php 
                $filename = strtolower($pays->Code2);
                if (file_exists("images/drapeau/".$filename.".png")):?>
                	<img src="images/drapeau/<?php echo $filename; ?>.png"/>
            <?php endif;?>

        </h2>

        <h3>Informations Villes :</h3>

        <table class="table table-striped table-bordered dt-responsive nowrap"> 
        	<tr>
        		<th>Nom de la Ville</th>
        		<th>District</th>
        		<th>Population</th>
        	</tr>
        	<tr>	
        		<?php foreach ($cities as $ville) :?>
        			<tr>
        				<td><?php echo $ville->Name ; ?></td>
        				<td><?php echo $ville->District?></td>	
        				<td>
        					<?php 
				        		$population = number_format($ville->Population, 0,' ', ' ');
				                echo $population." hab."; 
	                		?>	
        				</td>
        			</tr>
        		<?php endforeach;?>
        	</tr>
        </table>

        <h3>Langues parlées :</h3>

        <table class="table table-striped table-bordered dt-responsive nowrap">
        	<tr>
        		<th>Nom</th>
        		<th>Pourcentage</th>
        	</tr>
        	<tr>
        		<?php foreach ($langues as $langue) :?>
        			<tr>
        				<td><?php echo $langue->Name ; ?></td>
        				<td><?php echo $langue->Percentage." %"; ?></td>	
        			</tr>
        		<?php endforeach;?>
        	</tr>
        </table>

        <h3>Données économiques et sociales :</h3>

        <table class="table table-striped table-bordered dt-responsive nowrap">
        	<tr> 
        		<th>Population</th>
        	
        	<?php foreach ($donneesEconomiqueSociale as $ecoSociale) :?>
        		<td>
	        		<?php 
		        		$Population = number_format($ecoSociale->Population, 0,' ', ' ');
		                echo $Population." hab."; 
	                ?>
                </td>		
        	</tr>
        		
        	<tr>
        		<th>PNB</th>
        		<td>
	        		<?php 
		        		$PNB = number_format($ecoSociale->GNP, 0,' ', ' ');
		                echo $PNB." €"; 
	                ?>
                </td>
        	</tr>
       
        	<tr>
        		<th>Chef D'état</th>
        		<td><?php echo $ecoSociale->HeadOfState; ?></td>
        	</tr>
				
        </table>

        <?php if(!empty($_SESSION['role']) && $_SESSION['role']=="Professeur"): ?>
        <h3>Données actualisées :</h3>

        <form action="moreInfo.php?Name=<?php echo $pays->Name ?>">
        	<input type="hidden" name="Name" value=<?php echo $nomPays ?>>
        	<div class="FormLigne">
   				<span class="FormLibelle">Population :</span>
   				<input type="number" name="Population" class="FormInput" value=<?php echo $ecoSociale->Population; ?>>
			</div>
			<div class="FormLigne">
   				<span class="FormLibelle">PNB :</span>
   				<input type="number" name="PNB" class="FormInput" value=<?php echo $ecoSociale->GNP; ?>>
			</div>

			<div class="FormLigne">
   				<span class="FormLibelle">Chef D'état :</span>
   				<input type="text" name="ChefEtat" class="FormInput" value=<?php echo $ecoSociale->HeadOfState; ?>>
			</div>

        	<input type="submit" name="ok" value="Modifier">
		</form>

        	<?php
        	if (isset($_REQUEST['ok'])) {
        		
        		$nomPays=$_REQUEST['Name'];
		        $population=$_REQUEST['Population'];
		        $pnb=$_REQUEST['PNB'];
		        $chefEtat=$_REQUEST['ChefEtat'];
		       

		        $query="UPDATE country SET Population=$population,GNP=$pnb,HeadOfState='$chefEtat' WHERE Name='$nomPays'";
		        $result = $pdo->query($query)->fetchAll();?>
		         <meta http-equiv="refresh" content="0; url=moreInfo.php?Name=<?php echo $pays->Name ?>"/><?php
		    }	?>
        <?php endif;

		 endforeach;
        endif;
     endforeach;

?>