<?php
	if(isset($_POST) && isset($_POST['envoiValeurs']))
	{
		$_POST['psw'] = strval(hash("sha256", strval($_POST['psw'])));
		$_POST['psw_repeat'] = strval(hash("sha256", strval($_POST['psw_repeat'])));
		
		include('../BDD/reqUtilisateur.php');
		if(isset($_POST['role']) && $_POST['role'] == 'Utilisateur'){
			insertUser(strval($_POST['Nom']), strval($_POST['Prenom']), strval($_POST['Mail']), strval($_POST['psw']), strval($_POST['psw_repeat']), strval($_POST['role']));
			header('Location: ../php/Login.php');
		}
		else if(isset($_POST['role']) && $_POST['role'] == 'Joueur'){
			if(isset($_POST['estCapitane']) && $_POST['estCapitane'] == 'oui') {
				insertUser(strval($_POST['Nom']), strval($_POST['Prenom']), strval($_POST['Mail']), strval($_POST['psw']), strval($_POST['psw_repeat']), strval($_POST['role']));
				insertJouer(true);
				header('Location: ../php/Login.php');
			}
			else { 
				insertUser(strval($_POST['Nom']), strval($_POST['Prenom']), strval($_POST['Mail']), strval($_POST['psw']), strval($_POST['psw_repeat']), strval($_POST['role']));
				insertJouer(false);
				header('Location: ../php/Login.php');
			}
		}
		else 
			trigger_error("Qqch va mal sur Register.php");
	}
	else 
		trigger_error("Qqch va mal sur Register.php");
	unset($_POST);
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../css/styleRegLog.css" />
		<script type="text/javascript" src="../js/RegisterJS.js"></script>
		<title>Inscription</title>
	</head>
	
	<body>
		<form action="Register.php" method="POST" onreset="return vider();" class="container">
			<h1>
				<p style="text-align: center;">Inscription</p>
			</h1>
			
			<p style="text-align: center;">Entrez vos information pour créer votre compte</p>
			
			<hr>
			
			<label for="Prenom"><b>Prénom</b></label>
			<input type="text" placeholder="Entrez votre prénom" name="Prenom" id="Prenom" required>        
			
			<label for="Nom"><b>Nom</b></label>
			<input type="text" placeholder="Entrez votre nom" name="Nom" id="Nom" required>
			
			<label for="Mail"><b>Mail</b></label>
			<input type="email" placeholder="Entrez votre mail" name="Mail" id="Mail" required>
			
			<label for="psw"><b>Mot de passe</b></label>
			<input type="password" placeholder="Entrez votre mot de passe" name="psw" id="psw" required>
			
			<label for="psw-repeat"><b>Confirmation</b></label>
			<input type="password" placeholder="Répétez votre mot de passe" name="psw_repeat" id="psw_repeat" required>
			
			<br>
			
			<b>Sélectionnez votre rôle dans le tournoi</b>
			
			</br>estCapitane
			
			<div class ="container_role">
				
				
				<label for="Utilisateur">Utilisateur</label>
				<input type="radio" name="role" id="Utilisateur" value="Utilisateur">
				
				<br>
				
				<label for="Joueur">Joueur</label>
				<input type="radio" name="role" id="Joueur" value="Joueur">
				<br>

			
				<input type="checkbox" id="estCapitane" name="estCapitane" value="oui">
				<label for="estCapitane"> Je suis Capitanne</label><br>
				
			</div>
			
			<hr>
			
			<button type="submit" class="registerbtn" name="envoiValeurs" value="Envoyer">Voilà</button>
			<button type="reset" name="effacerValeurs" value="Effacer">Voilà 2</button>
		</form>
		
		<div class="container signin">
			<p>Vous avez un compte? <a href="Login.php">Sign in</a>.</p>
		</div>
	</body>
</html>
