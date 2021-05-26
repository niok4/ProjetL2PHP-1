<?php
	include_once('../BDD/reqEquipeTournoi.php');
	$tabTournois= getAllTournoi();
	session_start();

	if(isset($_SESSION['login']))
	{
		$ut = getUtilisateurWithEmail($_SESSION['login']);
		$estAdministrateur = ($ut->getRole() === "Administrateur");
		$estGestionnaire = estGestionnaire($ut->getIdUtilisateur());
	}

	if($estGestionnaire || $estAdministrateur)
	{
		if(isset($_POST['tournoi']))
		{
			$_SESSION['tournoi'] = strval($_POST['tournoi']) ;
			header('Location: StatutTournoisAVenir.php');
		}

		if(isset($_POST['tournoiEnCours']))
		{
			$_SESSION['tournoiEnCours'] = strval($_POST['tournoiEnCours']) ;
			header('Location: StatutTournoiEnCours.php');
		}

		if(isset($_POST['tournoiPasse']))
		{
			$_SESSION['tournoiPasse'] = strval($_POST['tournoiPasse']);
			header('Location: statutTournoiPasses.php');
		}
	}
	else
	{
		if($_POST && strval($_POST['tournoiEnCours'])!=null)
		{
			$_SESSION['tournoiEnCours'] = strval($_POST['tournoiEnCours']);
			header('Location: AffichageTournoi.php');
		}
	
		if($_POST && strval($_POST['tournoiPasse'])!=null)
		{
			$_SESSION['tournoiPasse'] = strval($_POST['tournoiPasse']);
			header('Location: statutTournoiPasses.php');
		}
	}
	
	$_POST = array();

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<link rel="stylesheet" type="text/css" href=".././css/styleTournois.css" />
		<title> Liste des Tournois </title>
		<style>
			body .bandeau-haut img {
				width:70px;
				padding:5px 0 0 5px;
				margin:5px 0 0 5px;
				float:left;
			}
		</style>
	</head>

	<body>
		<div class="bandeau-haut">
			<a href="../index.php">
				<img src="../img/prev.png">
				<h3>RETOUR</h3>
			</a>
		</div>

		<div class="cadre">   
			<h1>
				<p style="text-align: center;">Tournois passés</p>
			</h1>
			<?php
				echo '<form action="Tournois.php" method="post">
				<table>
				<tr>
				<th>Nom</th>
				<th>Lieu</th>
				<th>Début</th>
				<th>Fin</th>
				<th>Durée</th>
				<th>Equipes</th>
				</tr>';
				for($i=0;$i<sizeof($tabTournois);++$i)
				{
					echo'<tr>';
					if($tabTournois[$i]->termine())
					{
						echo '<td><button type=submit name="tournoiPasse" value="'.$tabTournois[$i]->getIdTournoi().'" class="btn">'.$tabTournois[$i]->getNom().'</button></td>';
						echo '<td>'.$tabTournois[$i]->getLieu().'</td>';
						echo '<td>'.date("jS F, Y", strtotime($tabTournois[$i]->getDateDeb())).'</td>';
						echo '<td>'.date("jS F, Y", strtotime($tabTournois[$i]->getDateDeb(). '+'.$tabTournois[$i]->getDuree().' days')).'</td>';
						echo '<td>'.$tabTournois[$i]->getDuree().' jours</td>';
						echo '<td>'.$tabTournois[$i]->getNombreTotalEquipes().'</td>';
					}
					echo'</tr>';
				}
				echo'</table>
				</form>';
			?>
		</div>
		<div class="cadre">   
			<h1>
				<p style="text-align: center;">Tournois en cours</p>
			</h1>
			<?php
				echo '<form action="Tournois.php" method="post">
				<table>
				<tr>
				<th>Nom</th>
				<th>Lieu</th>
				<th>Début</th>
				<th>Fin</th>
				<th>Durée</th>
				<th>Equipes</th>
				</tr>';
				for($i=0;$i<sizeof($tabTournois);++$i)
				{
					echo'<tr>';
					if($tabTournois[$i]->enCours())
					{
						echo '<td><button type=submit name="tournoiEnCours" value="'.$tabTournois[$i]->getIdTournoi().'" class="btn">'.$tabTournois[$i]->getNom().'</button></td>';
						echo '<td>'.$tabTournois[$i]->getLieu().'</td>';
						echo '<td>'.date("jS F, Y", strtotime($tabTournois[$i]->getDateDeb())).'</td>';
						echo '<td>'.date("jS F, Y", strtotime($tabTournois[$i]->getDateDeb(). '+'.$tabTournois[$i]->getDuree().' days')).'</td>';
						echo '<td>'.$tabTournois[$i]->getDuree().' jours</td>';
						echo '<td>'.$tabTournois[$i]->getNombreTotalEquipes().'</td>';
					}
					echo'</tr>';
				}
				echo'</table>
				</form>';
			?>
		</div>

		<div class="cadre">   
			<h1>
				<p style="text-align: center;">Tournois à venir</p>
			</h1>
			<?php
				echo '<form action="Tournois.php" method="post">
				<table>
				<tr>
				<th>Nom</th>
				<th>Lieu</th>
				<th>Début</th>
				<th>Fin</th>
				<th>Durée</th>
				<th>Equipes restantes</th>
				</tr>';
				for($i=0;$i<sizeof($tabTournois);++$i)
				{
					echo'<tr>';
					if($tabTournois[$i]->aVenir())
					{
						$k=0;
						$nbe = $tabTournois[$i]->getNombreTotalEquipes();
						$id = $tabTournois[$i]->getIdTournoi();
						$tabEquipes = getEquipeTournoiWithIdTournoi($id);
						if(sizeof($tabEquipes)>0)
						{
							for($j=0;$j<sizeof($tabEquipes);++$j)
								if($tabEquipes[$j]->getEstInscrite())
									++$k;	
						}
						$nbPlaces = $tabTournois[$i]->getNombreTotalEquipes();
						echo '<td><button type=submit name="tournoi" value="'.$tabTournois[$i]->getIdTournoi().'" class="btn">'.$tabTournois[$i]->getNom().'</button></td>';
						echo '<td>'.$tabTournois[$i]->getLieu().'</td>';
						echo '<td>'.date("jS F, Y", strtotime($tabTournois[$i]->getDateDeb())).'</td>';
						echo '<td>'.date("jS F, Y", strtotime($tabTournois[$i]->getDateDeb(). '+'.$tabTournois[$i]->getDuree().' days')).'</td>';
						echo '<td>'.$tabTournois[$i]->getDuree().' jours</td>';
						echo '<td>'.($nbPlaces-$k).'/'.$nbPlaces.'</td>';
					}
					echo'</tr>';
				}
				echo'</table>
				</form>';
			?>
		</div>
	</body>
</html>