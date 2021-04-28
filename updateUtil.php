<?php
	require_once 'header.php';
	require_once 'javascripts.php';
	require_once 'fonctionBDD_Login.php';

	
?>

<table class="table table-striped table-bordered dt-responsive nowrap">

	<th>Login</th>
	<th>Password</th>
	<th>Rôle</th>
	<th></th>
	
	<?php if ($_SESSION['role'] == "admin" ): 
		$allUtilsGeoworld = getAllUtilisateurs();
		foreach ($allUtilsGeoworld as $util):?>
		 	<form action="updateUtil.php">
		 		<tr>
		 			<input type="hidden" name="login" value=<?php echo $util->login; ?>>
			 		<td><?php echo $util->login; ?></td>
			 		<td><input type="text" name="password" value=<?php echo $util->password; ?>></td>
			 		<td><input type="text" name="role" value=<?php echo $util->role; ?>></td>
			 		<td><input type="submit" name="Modifier"></td>
			 	</tr>
		 	</form>
	<?php 
		endforeach; 
	 

	else :
		$utilGeoworld = getUtilisateurs($_SESSION['login']);
		foreach ($utilGeoworld as $util):?>
		 	<form action="updateUtil.php">
		 		<tr>
		 			<input type="hidden" name="login" value=<?php echo $util->login; ?>>
			 		<td><?php echo $util->login; ?></td>
			 		<td><input type="text" name="password" value=<?php echo $util->password; ?>></td>
			 		<input type="hidden" name="role" value=<?php echo $util->role; ?>>
			 		<td><?php echo $util->role; ?></td>
			 		<td><input type="submit" name="Modifier"></td>
			 	</tr>
		 	</form>

	<?php 
		endforeach; 
		endif;
	?>	
		
</table>	


<?php
        	if (isset($_GET['Modifier'])) {
        		
        		$login=$_GET['login'];
		        $pwd=$_GET['password'];
		        $role=$_GET['role'];
		       
		        // global $pdo;
		        $query="UPDATE informations_utilisateurs SET login='$login',password='$pwd',role='$role' WHERE login='$login'";
		        // echo $query;
		        $pdo->query($query);
?>
		        <meta http-equiv="refresh" content="0; url=updateUtil.php"/>
		    <?php
		    }
		    ?>