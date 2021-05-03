<?php
	include_once('../BDD/reqEquipeTournoi.php');
    include_once('../BDD/reqGestionnaire.php');
	include_once('../BDD/reqEquipeTournoi.php');
	include_once('../BDD/reqEquipe.php');
	include_once('../module/TasMax.php');
	include_once('../BDD/reqMatchT.php');
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
    if(!estGestionnaire($ut->getIdUtilisateur()))
	{
		trigger_error("Vous n'êtes pas gestionnaire");
		header('Location: ../index.php');
		exit();
	}
	$TournoiEnGestion = getTournoiWithIdGestionnaire($ut->getIdUtilisateur(),$_GET['idTournoi']);
	if($TournoiEnGestion == NULL){
		trigger_error("Vous etes pas gestionnaire de ce tournoi");
	}
	$tabEquipe = getEquipeTournoiWithIdTournoi($_GET['idTournoi']);
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title> Gestion de Tournoi</title>
		<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> 
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.full.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.css " /> 
	</head>
	<body>
		<?php
		if ($TournoiEnGestion->enCours()){
			$tasTournoi = new TasMax(count($tabEquipe));
			$tasTournoi->insererAuxFeuilles($tabEquipe);
			$nombreDetabe = 0;
			$dureeDechaquetour = ((int)$TournoiEnGestion->getDuree()) / ($tasTournoi->nbTours() + 1);
			$dateDeb = strtotime($TournoiEnGestion->getDateDeb());
			echo '<form method="post" action="InsertionMatchTResult.php" >';
			echo '<table>
					<tr>
					<th>Etape</th>
					<th>Debut du Tour</th>
					<th>Fin du Tour</th>
					</tr>';
					$machDansCeTour = 0;
					$nombrequipe = count($tabEquipe);
					for($i=0;$i < ($tasTournoi->nbTours() + 1);++$i){
							$dateFin = strtotime("+$dureeDechaquetour days",$dateDeb);
							echo '<tr>';
							echo '<td>Etape '.$nombreDetabe.'</td>';
							echo '<td>'.date("jS F, Y", $dateDeb).'</td>';
							echo '<td>'.date("jS F, Y", $dateFin).'</td>';
							for($j=0;$j<$machDansCeTour;$j++){
								echo '<td>Entrez la date et heure de match '.($j+1).' de tour '.$nombreDetabe.'<input id="datetimepicker'.$nombreDetabe.$j.'" name="datetimepicker'.$nombreDetabe.$j.'" type="text" ></td> ';
								echo "<script>
								jQuery('#datetimepicker".$nombreDetabe.$j."').datetimepicker({
									format:'Y-m-d H:i', 
									minDate: '".date('Y-m-d', $dateDeb)."',
									maxDate: '". date('Y-m-d', $dateFin)."',
									allowTimes:[
									'12:00', '13:00', '15:00', 
									'17:00', '17:05', '17:20', '19:00', '20:00'
									]
								}); 
								</script>";
							}
						
							$nombreDetabe++;
							$machDansCeTour = $nombrequipe / 2;
							$nombrequipe = $nombrequipe / 2;
							$dateDeb = strtotime("+1 days", $dateFin);
							$dureeDechaquetour--;
							echo '</tr>';
				}	
			$idT = $_GET['idTournoi'];
			echo '</table>';
			echo '<input id="nbTour" name="nbTour" value="'.($tasTournoi->nbTours() + 1).'" type="hidden" >';
			echo '<input id="nbEquipes" name="nbEquipe" value="'.count($tabEquipe).'" type="hidden" >';
			echo '<input id="idTournoi" name="idTournoi	" value="'.$idT.'" type="hidden" >';
			echo '<button type="submit" class="btn"  name="envoiValeurs" value="Envoyer">programmer les matchs </button> ';
			echo '</form>';
	
		}
		
		?>
	</body>
</html>

