<?php
	include_once('../BDD/reqEquipe.php');
	
	session_start();
	
	if(!isset($_SESSION['login']))
	{
		trigger_error("Vous n'êtes pas connecté.");
	}
	
	if(!verifLoginMdp(strval($_SESSION['login']), strval($_SESSION['motDePasse'])))
	{
		trigger_error("Erreur de login et/ou de mot de passe.");
		header('Location: Login.php');
		exit();
	}
	
	if(isset($_POST) && isset($_POST['envoiValeurs']))
	{
		insertEquipe(strval($_POST['NomEquipe']), strval($_POST['Adresse']), strval($_POST['NumTel']));
	}
	
	$_POST = array();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../css/styleLogin.css" />
		<script type="text/javascript" src="../js/RegisterJS.js"></script>
		<title>Création d'une équipe</title>
	</head>
	
	<body>
		<div>
			<a href="../index.php">
			<img src="../img/home.png">
			</a>
		</div>
		<style>
			body div img {
				width:50px;
				border:5px groove white;
				padding:5px;
				float:left;
			}
		</style>
		
		<form action="CreerEquipe.php" method="POST" onreset="return vider();" class="container">
			<h1>
				<p style="text-align: center;">Création d'une équipe</p>
			</h1>
			
			<hr>
			
			<label for="NomEquipe"><b>Nom de l'équipe</b></label>
			<input type="text" placeholder="Entrez le nom d'équipe" name="NomEquipe" id="NomEquipe" required>        
			
			<label for="Adresse"><b>Adresse</b></label>
			<input type="text" placeholder="Entrez l'adresse de l'équipe" name="Adresse" id="Adresse" required>
			
			<label for="NumTel"><b>Numéro de téléphone</b></label>
			<input type="tel" id="NumTel" name="NumTel" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="XX-XX-XX-XX"required>
			<br /> <br />
			<hr>
			
			<button type="submit" class="registerbtn" name="envoiValeurs" value="Envoyer">Voilà</button>
			<button type="reset" name="effacerValeurs" value="Effacer">Voilà 2</button>
		</form>
		
		<div class="container-signin">
			<p>Déjà inscrit ? 
				<a href="Login.php">Connectez-vous</a>
			</p>
		</div>
	</body>
</html>