<?php
	include_once('../BDD/reqTournoi.php');
	include_once('../BDD/reqGestionnaire.php');
	
	session_start();	
	if(!isset($_SESSION['login']))
	{
		trigger_error("Vous n'êtes pas authentifié.");
	}
	
	if(!verifLoginMdp(strval($_SESSION['login']), strval($_SESSION['motDePasse'])))
	{
		trigger_error("Mauvais login/mot de passe.");
		header('Location: Login.php');
		exit();
	}
	
	$ut = getUtilisateurWithEmail($_SESSION['login']);
	/*
	if(!estGestionnaire($ut->getIdUtilisateur()))
	{
		trigger_error("Vous n'êtes pas un gestionnaire.");
		header('Location: ../index.php');
		exit();
	}
	*/

	$estAdministrateur = ($ut->getRole() === "Administrateur");
	
	if(!$estAdministrateur)
	{
		trigger_error("Vous n'êtes pas un administrateur du site.");
		header('Location: ../index.php');
		exit();
	}




	$tabGestionnaires = getAllGestionnaire();
	
	$champChoixGestionnaire = "<div>
	<select id=\"Gestionnaire\" name=\"Gestionnaire\">
		<option value=\"\">Choisir un gestionnaire</option>";
	
	for($i=0;$i<count($tabGestionnaires);++$i)
	{
		$idGestionnaireTemp = strval($tabGestionnaires[$i]->getIdGestionnaire());
		$nomGestionnaireTemp = strval($tabGestionnaires[$i]->getNom());
		$prenomGestionnaireTemp = strval($tabGestionnaires[$i]->getPrenom());
		
		$champChoixGestionnaire = $champChoixGestionnaire."<option value=\"$idGestionnaireTemp\">$idGestionnaireTemp - $nomGestionnaireTemp $prenomGestionnaireTemp</option>";
	}
	
	$champChoixGestionnaire = $champChoixGestionnaire."</select>
	</div>";






	
	if(isset($_POST) && isset($_POST['envoiValeurs']))
	{   
		$nbEquipes = $_POST['nombreTotalEquipes'] ;
		
		creerTournoi(strval($_POST['nom']),$_POST['dateDeb'], $_POST['duree'],$_POST['Gestionnaire'], strval($_POST['lieu']),$_POST['nombreTotalEquipes']);
	}
	
	$_POST = array();
	
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/syleIndex.css" />
		<style>
			.btn:hover {
				opacity:1;
				color:red;
			}
			
			.btn {
				background-color: #0d0d0d;
				color: white;
				padding: 16px 20px;
				margin: 15px 0;
				border: none;
				cursor: pointer;
				width: 100%;
				opacity: 0.9;
				border-radius:5px;
			}

			#Gestionnaire {
				background-color:white;
				color:#333333;
				font-family:Helvetica Neue,Helvetica,Arial,sans-serif;
				width:40%;
				height:40px;
				text-align: center;
				font-size:18px;
				border-radius:5px;
			}
			body .bandeau-haut img {
				width:70px;
				padding:5px 0 0 5px;
				margin:5px 0 0 5px;
				float:left;
			}

			#bis {
				font-family:tournois;
				font-size:25px;
				padding:15px 0 0 0;
				float:left;
				margin:10px 0 0 20px;
				color:black;
			}

		</style>
	</head>
	<body>
		<div class="bandeau-haut">
			<a href="../index.php">
				<img src="../img/prev.png">
				<h3 id="bis">RETOUR</h3>
			</a>
		</div>
		
		<h2 style="text-align:center">Création d'un tournoi</h2> 
		
		<div id="container">
			<form action="CreerTournoi.php" method="post">
				<p>
					<label for="nom"><b>Nom</b></label>
					<input type="text" name="nom" id="nom" placeholder="(max 30 caractères)" required /><br />
					
					<label for="lieu"><b>Lieu</b></label>
					<input type="text" name="lieu" id="lieu" placeholder="(max 30 caractères)" required/><br />
					
					<label for="duree"><b>Durée</b></label>
					<input type="number" name="duree" id="duree" required/><br />
					
					<label for="nombreTotalEquipes"><b>Nombre d'équipes</b></label>
					<input type="number" name="nombreTotalEquipes" id="nombreTotalEquipes" required/><br />
					
					<label for="dateDeb"><b>Date de début</b></label>
					<input type="date" name="dateDeb" id="dateDeb" required/><br />
					<hr>

					
					<select id="Gestionnaire" name="type">
						<option value="">Choisir un type de Tournois</option>
						<option value="Championnat">Championnat</option>
						<option value="Coupe">Coupe</option>
						<option value="Tournoi">Tournoi</option>
					</select>
					</br>

					<?php
					echo $champChoixGestionnaire;
					?>
					
					<!--<input type="text" name="descriptif" id="descriptif" placeholder="Bref descriptif du tournoi"/><br />-->
					
					<button type="submit" class="btn"  name="envoiValeurs" value="Envoyer">Créer</button> 
				</p>
			</form>
		</div>
	</body>
</html>