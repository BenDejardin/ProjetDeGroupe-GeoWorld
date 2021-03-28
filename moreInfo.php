<?php
	require_once 'header.php';
	require_once 'inc/manager-db.php';
	require_once 'inc/connect-db.php';
	require_once 'javascripts.php';
	
	$nomPays = $_GET['Name'];
	$infosPays = getInfosPays($nomPays);
	foreach ($infosPays as $pays) {
		$idCountry = $pays->id;
	}
	$langues = getDifferentesLangues($idCountry);
	$donneesEconomiqueSociale = getDonneesEconomiqueSociale($idCountry);
	$cities = getCityFromIdCountry($idCountry);
	
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
	
	<?php foreach ($infosPays as $pays) :?>  
        <h2><?php echo $pays->Name ?>
            
        <?php 
            $filename = strtolower($pays->Code2);
            if (file_exists("images/drapeau/".$filename.".png")):?>
            	<img src="images/drapeau/<?php echo $filename; ?>.png"/>
        <?php endif;?> </h2>

        <?php
            if (!file_exists("images/drapeau/".$filename.".png")):?>
            	</h2>
        <?php endif;?>

        <h3>Informations Villes :</h3>

        <table class="table">
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

        <table class="table">
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

        <table class="table">
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

        <form action="moreInfo.php?id=<?php echo $pays->id ?>">
        	<input type="hidden" name="id" value=<?php echo $idCountry ?>>
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
        
		        $population=$_REQUEST['Population'];
		        $pnb=$_REQUEST['PNB'];
		        $chefEtat=$_REQUEST['ChefEtat'];
		       

		        $query="UPDATE country SET Population=$population,GNP=$pnb,HeadOfState='$chefEtat' WHERE id=$idCountry";
		        $result = $pdo->query($query)->fetchAll();?>
		         <meta http-equiv="refresh" content="0; url=moreInfo.php?id=<?php echo $pays->id ?>"/><?php
		    }	?>
        <?php endif;

		 endforeach;
     endforeach;?>
