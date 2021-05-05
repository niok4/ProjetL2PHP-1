<!DOCTYPE html>
<html lang="fr">
	<head>
	</head>
	
	<body>
		<div>
			<a href="Login.php">Se connecter</a>
			<a href="Logout.php">Se déconnecter</a>
			<a href="Register.php">Créer un compte</a>
			<a href="CreerEquipe.php">Créer une équipe</a>
			<a href="Preinscription.php">Pré-inscrire une équipe</a>
			<a href="ChoixInscription.php">Gérer les inscriptions d'un tournoi</a>
		</div>
	</body>
</html>

<?php
include_once('../BDD/reqMatchT.php');
include_once('../BDD/reqTournoi.php');
if (IsAlreadyProgrammed((int)strval($_POST['idT']))){
	echo 'ce tournoi est deja programmé';
}
else{
	if (isset($_POST['idT'])){
		$machDansCeTour = $_POST['nbEquipe']/2;
		for($i=1;$i < $_POST['nbTour'];++$i){
			for($j=0;$j <= $machDansCeTour;++$j){
				$time = explode(' ', $_POST["datetimepicker$i$j"]);
				$date = $time[0];
				$horaire = $time[1];
				inserMatchT((int)strval($_POST['idT']),$date,$horaire);
				echo (int)strval($_POST['idT']);
				echo '  ';
				echo $date;
				echo '  ';
				echo $horaire;
				echo '  ';
				echo '<br>';
				$machDansCeTour = $machDansCeTour/2;
			}
		}
		unset($_POST);
		echo '<h4>Tous les maches de ce tournoi ont bien programmé';
	}
}
?>
