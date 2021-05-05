<?php
	include_once('../BDD/reqEquipeTournoi.php');
    include_once('../BDD/reqGestionnaire.php');
	include_once('../BDD/reqEquipeTournoi.php');
	include_once('../BDD/reqEquipe.php');
	include_once('../module/TasMax.php');
	include_once('../BDD/reqMatchT.php');
	include_once('../module/MatchT.php');
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
    
	$TournoiEnGestion = getTournoi($_SESSION['tournoi']);
	if($TournoiEnGestion == NULL){
		trigger_error("QQCH VA MAL");
	}
	$tabEquipe = getEquipeTournoiWithIdTournoi($_SESSION['tournoi']);
	if(count($tabEquipe)<2){
		echo "Attention!!! pas assez d'equipe est inscrit pour programmer cette tournoi";
	}
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
		if (!IsAlreadyProgrammed($_SESSION['tournoi'])){
			echo '<h1>ATTENTION!!! Vous ne pouvez faire aucun changement après la programmation de ce tournoi</h1>';
		}
		if ($TournoiEnGestion->aVenir()){
			$tasTournoi = new TasMax(count($tabEquipe));
			$tasTournoi->insererAuxFeuilles($tabEquipe);
			$nombreDetabe = 0;
			$dureeDechaquetour = ($TournoiEnGestion->getDuree()) / ($tasTournoi->nbTours() + 1);
			$dureeDechaquetour = (int)$dureeDechaquetour;
			$dateDeb = strtotime($TournoiEnGestion->getDateDeb());
			echo '<form method="post" action="SaisieDateTournoi.php" >';
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
							if(estGestionnaire($ut->getIdUtilisateur()) && !IsAlreadyProgrammed(1));
							{
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
							}
							$nombreDetabe++;
							$machDansCeTour = $nombrequipe / 2;
							$nombrequipe = $nombrequipe / 2;
							$dateDeb = strtotime("+1 days", $dateFin);
							$dureeDechaquetour--;
							echo '</tr>';
				}	
			if(!IsAlreadyProgrammed($_SESSION['tournoi'])){
			$idT = $_SESSION['tournoi'];
			echo '</table>';
			echo '<input id="nbTour" name="nbTour" value="'.($tasTournoi->nbTours() + 1).'" type="hidden" >';
			echo '<input id="idT" name="idT" value="'.$idT.'" type="hidden" >';
			echo '<input id="nbEquipes" name="nbEquipe" value="'.count($tabEquipe).'" type="hidden" >';
			echo '<button type="submit" class="btn"  name="envoiValeurs" value="Envoyer">programmer les matchs </button> ';
			echo '</form>';
			}
	
		}
		if(IsAlreadyProgrammed($_SESSION['tournoi'])){
			$indexMatchT = 0;
			$tabMachT =  getAllMatchT(1);
			$machDansCeTour = count($tabEquipe)/2;
			for($i=1;$i < ($tasTournoi->nbTours() + 1);++$i){
				for($j=0;$j <= $machDansCeTour;++$j){
					echo 'match '.($j+1).' de tour '.$i.' est le '.$tabMachT[$indexMatchT]->getDate().' a '.$tabMachT[$indexMatchT]->getHoraire().'  ';
					echo '<br>';
					$machDansCeTour = $machDansCeTour/2;
					$indexMatchT++;
				}
			}
		}

		if ($_SESSION['tournoi']){
			$machDansCeTour = $_POST['nbEquipe']/2;
			for($i=1;$i < $_POST['nbTour'];++$i){
				for($j=0;$j <= $machDansCeTour;++$j){
					$time = explode(' ', $_POST["datetimepicker$i$j"]);
					$date = $time[0];
					$horaire = $time[1];
					insertMatchT($_SESSION['tournoi'],$date,$horaire);
					$machDansCeTour = $machDansCeTour/2;
				}
			}
		}

		?>
	</body>
</html>