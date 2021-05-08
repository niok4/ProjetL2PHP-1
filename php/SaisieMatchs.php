<?php
	include_once('../BDD/reqGestionnaire.php');
	include_once('../BDD/reqJoueur.php');
	include_once('../BDD/reqEquipeTournoi.php');
	include_once('../BDD/reqEquipeMatchT.php');
	include_once('../module/TasMax.php');

	//Si le nombre d'inscription n'atteint pas le bon nombre le gestionnaire pourra modifier le nbr d'équipes total dans la base de données

	//Tester cas pour les non puissance de 2


//vériff date ?
session_start();
//$_SESSION['idT'] = $_GET['tournoi'];
if(!isset($_SESSION['login']))
	{
		trigger_error("Vous ne pouvez pas accéder à cette page.");
		header('Location: Tournois.php');
		exit();
	}
$ut = getUtilisateurWithEmail($_SESSION['login']);
$estAdministrateur = ($ut->getRole() === "Administrateur");
$estGestionnaire = estGestionnaire($ut->getIdUtilisateur());
$id = $ut->getIdUtilisateur();

	if(!$estGestionnaire)
	{
		if(!$estAdministrateur)
		{
			trigger_error("Vous n'avez pas les droits !");
			header('Location: Tournois.php');
			exit();
		}
	}


	$id = $_SESSION['tournoi'] ;
	$tournoi = getTournoi($id);
	$tabEquipesTournoi = getEquipeTournoiWithIdTournoi($tournoi->getIdTournoi());
	$nbEquipesInscrites = 0 ;
	$tabEquipes = array();
	for($i=0;$i<sizeof($tabEquipesTournoi);++$i)
	{
		if($tabEquipesTournoi[$i]->getEstInscrite())
			++$nbEquipesInscrites;
		array_push($tabEquipes,getEquipe($tabEquipesTournoi[$i]->getIdEquipe()));
	}
	$nbEquipesTotal = $tournoi->getNombreTotalEquipes() ;
	$tabEquipesDejaChoisies = array();
	$tabMatchs = getAllMatchT($tournoi->getIdTournoi()) ;
	if(!$tabMatchs)//car l'insertion est trop lente.
		$tabMatchs = getAllMatchT($tournoi->getIdTournoi()) ;
	$i = 0 ;
	while($i<sizeof($tabMatchs))
	{
		$idmatch = $tabMatchs[$i]->getIdMatchT() ;
		$equipematch = getEquipesMatchT($idmatch);
		sizeof($equipematch);
		if(sizeof($equipematch)!=0)
		{
			array_push($tabEquipesDejaChoisies,$equipematch[0]->getIdEquipe());
			array_push($tabEquipesDejaChoisies,$equipematch[1]->getIdEquipe());
		}
		++$i;
	}
	//echo "EDC=".sizeof($tabEquipesDejaChoisies);

	if(isset($_POST['melanger']) && $nbEquipesInscrites==$nbEquipesTotal && sizeof($tabEquipesDejaChoisies)==0 && sizeof($tabMatchs)>=$nbEquipesTotal/2)
	{
		$tabMelange = melanger($id);
		for($i=0;$i<$nbEquipesTotal/2;+$i)
		{
			echo $tabMelange[$i] ;
			//insertEquipeMatchT($tabMatchs[2*$i]->getIdMatchT(),$tabMelange[$i],$tabMelange[2*$i+1]);
			/*
				<form action="StatutTournoisAVenir.php" method="post">
				<button type"submit" id="btn3" name="melanger" value="" style="margin:auto">Mélanger équipes</button>
				</form>
			*/
		}

	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<link rel="stylesheet" type="text/css" href="../css/styleStatut.css" />
	<title> Saisie Matchs </title>
</head>
<body>
	<div class="bandeau-haut">
		<?php 
			echo'<h1>'.$tournoi->getNom().'</h1>';
		?>
	</div>
	<hr>
	<hr>

	<div class="container-main2">
		<h1 style="font-size:35px"></h1>
		<?php
		echo '<div id="tab1">
		<form action="SaisieMatchs.php" method="post">
		<table>
		<tr>
		<th rowspan="1">/</th>
		<th>Equipe A</th>
		<th>Equipe B</th>
		<th>Date</th>
		<th>Valider match</th>
		</tr>
		';


		
		for($i=0;$i<$nbEquipesTotal-1;++$i)
		{
			if($i<(sizeof($tabMatchs)-1) && sizeof($tabEquipesDejaChoisies)>0 && $i<(sizeof($tabEquipesDejaChoisies)-1))
			{
				$equipe1 = getEquipe($tabEquipesDejaChoisies[$i]);
				$nom1 = $equipe1->getNomEquipe();
				$equipe2 = getEquipe($tabEquipesDejaChoisies[$i+1]);
				$nom2 = $equipe2->getNomEquipe();
				$matchTemp = $tabMatchs[$i] ;


				echo '<tr><td>Match n°'.($i+1).'</td><td>'.$nom1.'</td><td>'.$nom2.'</td><td>'.$matchTemp->getDate().'</td><td>'.$matchTemp->getHoraire().'</td></tr>';
			}
			else
			{
				$matchTemp = $tabMatchs[$i] ;
				echo'<tr><td>Match n°'.($i+1).'</td>';


				echo '
					<td>
					<select id="Equipe" name="Equipe1">
					<option value="none">Choisir équipe</option>';
					for($j=0;$j<$nbEquipesInscrites;++$j)
					{
						$k=0;
						while($k<sizeof($tabEquipesDejaChoisies) && $tabEquipesDejaChoisies[$k]!=$tabEquipes[$j]->getIdEquipe())
							++$k;
						if($k==sizeof($tabEquipesDejaChoisies))
							echo '<option value="'.$tabEquipes[$j]->getIdEquipe().'">'.$tabEquipes[$j]->getNomEquipe().'</option>';
					}
					echo'
					</select>
					</td>
					<td>
					<select id="Equipe" name="Equipe2">
					<option value="none">Choisir équipe</option>';
					for($j=0;$j<$nbEquipesInscrites;++$j)
					{
						$k=0;
						while($k<sizeof($tabEquipesDejaChoisies) && $tabEquipesDejaChoisies[$k]!=$tabEquipes[$j]->getIdEquipe())
							++$k;
						if($k==sizeof($tabEquipesDejaChoisies))
							echo '<option value="'.$tabEquipes[$j]->getIdEquipe().'">'.$tabEquipes[$j]->getNomEquipe().'</option>';
					}

					echo'</select>
						</td>
						<td>'.$matchTemp->getDate().' '.$matchTemp->getHoraire().'</td>';
					if(sizeof($tabEquipesDejaChoisies)!=$nbEquipesTotal)
						echo'<td><button type=submit name="valider" value="valider">Valider</button></td>';
					else
						echo'<td><button type=submit name="valider" value="valider" disabled>Valider</button></td></tr>';	
				}
			}

		
		echo '</table>
		</form>
		</div>';

		if(isset($_POST['valider']) && isset($_POST['Equipe1']) && isset($_POST['Equipe2']) /*&& sizeof($tabMatchs)<($nbEquipesTotal/2)*/)
		{
			if($_POST['Equipe1']==$_POST['Equipe2'] || ($_POST['Equipe1']=="none" || $_POST['Equipe2']=="none"))
			{
					echo '<p style=" font-family:Helvetica Neue,Helvetica,Arial,sans-serif;color:red;text-align:center">
				ATTENTION : Il faut entrer des équipes différentes</p>';
			}
			else
			{
				for($i=0;$i<sizeof($tabMatchs);++$i)
				{
					if(!estEquipeMatchT($tabMatchs[$i]->getIdMatchT()))
					{
						insertEquipeMatchT($tabMatchs[$i]->getIdMatchT(),$_POST["Equipe1"],$_POST["Equipe2"]);
						unset($_POST);
					}
				}	
				
			}
		}


		echo '
		</table>
		</div>';
		?>	

	</div>
	<div class="envoi">
		<!--
		<form action="StatutTournoisAVenir.php" method="get">
			<?php
			//echo'<button  type=submit name="tournoi" >Placer équipes</button>';
			?>
		</form>
	-->
	</div>

</body>
</html>