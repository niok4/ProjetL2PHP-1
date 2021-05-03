<?php
include_once('../BDD/reqMatchT.php');
$machDansCeTour = $_POST['nbEquipe']/2;
for($i=1;$i < $_POST['nbTour'];++$i){
	for($j=0;$j < $machDansCeTour;++$j){
		$time = explode(' ', $_POST["datetimepicker$i$j"]);
		$date = $time[0];
		$horaire = $time[1];
		inserMatchT($_POST['idTournoi'],$date,$horaire);
		$machDansCeTour = $machDansCeTour/2;
	}
}
?>