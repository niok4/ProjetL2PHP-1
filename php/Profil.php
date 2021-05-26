<?php
	include_once('../BDD/reqGestionnaire.php');
	include_once('../BDD/reqEquipe.php');
	include_once('../BDD/reqEquipeTournoi.php');
	
	session_start();
	
	if(!isset($_SESSION['login']))
	{
		trigger_error("Vous n'êtes pas authentifié.");
		header('Location: Login.php');
		exit();
	}
	
	if(!verifLoginMdp(strval($_SESSION['login']), strval($_SESSION['motDePasse'])))
	{
		trigger_error("Mauvais login/mot de passe.");
		header('Location: Login.php');
		exit();
	}
	
	$ut = getUtilisateurWithEmail($_SESSION['login']);
	$estAdministrateur = ($ut->getRole() === "Administrateur");
	$estGestionnaire = estGestionnaire($ut->getIdUtilisateur());
	$estJoueur = estJoueur($ut->getIdUtilisateur());
	if(!$estAdministrateur && !$estGestionnaire && !$estJoueur)
		$estUtilisateur = true ;
	$id = $ut->getIdUtilisateur();

	if(isset($_POST['envoiValeurs']) && strval($_POST['idT'])!=null)
	{   
		$_SESSION['idT'] = strval($_POST['idT']) ;
		
		
	}
	$_POST = array();

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../css/styleProfil.css" />
		<script type="text/javascript" src="../js/RegisterJS.js"></script>
		<title>Mon profil</title>

		<style>
			body .bandeau-haut img {
				width:70px;
				padding:5px 0 0 5px;
				margin:5px 0 0 5px;
				float:left;
			}
		</style>
	</head>	
	<body id="body">
		<div class="bandeau-haut">
			<a href="../index.php">
				<img src="../img/prev.png">
				<h3>RETOUR</h3>
			</a>
		</div>

		<div id="container-main">
			<?php
			$nom = $ut->getNom() ;
			$prenom = $ut->getPrenom() ;
			$role = $ut->getRole() ;

			echo '<p style="text-align:center;font-size:25px">'.$nom.' '.$prenom;
			echo'<hr>';
			
			echo'
			<table style="margin:auto">
				<tr>
				<th style="text-align:center">Adresse électronique</th><th>'.$ut->getEmail().'</th>
				</tr>
				<tr>
				<th style="text-align:center">Mot de passe</th><th>************</th>
				</tr>
				<tr>
				<th style="text-align:center">IDENTIFIANT</th><th>'.$id.'</th>
				</tr>';

			if($estGestionnaire)
				echo  '<tr><th style="text-align:center">Role</th><th>Gestionnaire</th></tr>';
			elseif($estJoueur)
			{
				$joueur = getJoueur($id);
				$equipe = getEquipe($joueur->getIdJoueur()) ;
				echo  '<tr><th style="text-align:center>('.$equipe->getNomEquipe().')</th></tr>';
				if($joueur->getCapitaine())
					echo  '<tr><th style="text-align:center>Role</th><th>Capitaine ('.$equipe->getNomEquipe().')</th></tr>';
				else
					echo  '<tr><th style="text-align:center>Equipe</th><th>'.$equipe->getNomEquipe().'</th></tr>';
			}
			else
			{
				echo'<tr><th style="text-align:center>Role</th><th>'.$ut->getRole().'</th></tr>';
			}
			echo'</table>';
			?>
		</div>



			<?php
			
				if($estAdministrateur)
				{
					$tabTournois = getAllTournoiByDate();
					echo '<div id="tab">
					<table style="border:2px solid black; margin-top:100px">
						<tr>
							</th></tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Lieu</th>
							<th>Début</th>
							<th>Fin</th>
							<th>Durée</th>
							<th>Equipes</th>
							<th>Gestionnaire</th>
							<th>Statut</th>
						</tr>';

					for($i=0;$i<sizeof($tabTournois);++$i)
					{
						$idG = $tabTournois[$i]->getIdGestionnaire();
						$gest = getGestionnaire($idG) ;
						echo'
						<tr>
						<td>'.$tabTournois[$i]->getIdTournoi().'</td>	
						<td>'.$tabTournois[$i]->getNom().'</td>
						<td>'.$tabTournois[$i]->getLieu().'</td>
						<td>'.date("d/m/Y", strtotime($tabTournois[$i]->getDateDeb())).'</td>
						<td>'.date("d/m/Y", strtotime($tabTournois[$i]->getDateDeb(). '+'.$tabTournois[$i]->getDuree().' days')).'</td>
						<td>'.$tabTournois[$i]->getDuree().' jours</td>
						<td>'.$tabTournois[$i]->getNombreTotalEquipes().'</td>
						<td>'.$gest->getNom().' '.$gest->getPrenom().' (ID '.$idG.')</td>';
						if($tabTournois[$i]->termine())
							echo '<td>Terminé</td>';
						elseif($tabTournois[$i]->enCours())
							echo '<td>En Cours</td>';
						else
							echo '<td>A venir</td>';
						echo'</tr>';
					}
					echo'</table>';
				}
				if($estGestionnaire)
				{
					$gest = getGestionnaire($id);
					$tabTournois = getAllTournoiWithIdGestionnaireByDate($gest->getIdGestionnaire());
						
					if(sizeof($tabTournois)>0)
					{
						echo '<div id="tab2">';
						echo '<table>
						<tr>
						</th></tr>
						<th>ID</th>
						<th>Nom</th>
						<th>Lieu</th>
						<th>Début</th>
						<th>Fin</th>
						<th>Durée</th>
						<th>Equipes</th>
						<th>Statut</th>
						</tr>';
						
						for($i=0;$i<sizeof($tabTournois);++$i)
						{
							$idG = $tabTournois[$i]->getIdGestionnaire();
							$gest = getGestionnaire($idG) ;
							echo'<tr>';
							?>
							<?php
								echo '
								<td>'.$tabTournois[$i]->getIdTournoi().'</td>
								<td>'.$tabTournois[$i]->getNom().'</td>
								<td>'.$tabTournois[$i]->getLieu().'</td>
								<td>'.date("d/m/Y", strtotime($tabTournois[$i]->getDateDeb())).'</td>
								<td>'.date("d/m/Y", strtotime($tabTournois[$i]->getDateDeb(). '+'.$tabTournois[$i]->getDuree().' days')).'</td>
								<td>'.$tabTournois[$i]->getDuree().' jours</td>
								<td>'.$tabTournois[$i]->getNombreTotalEquipes().'</td>';
								if($tabTournois[$i]->termine())
									echo '<td>Terminé</td>';
								elseif($tabTournois[$i]->enCours())
									echo '<td>En Cours</td>';
								else
									echo '<td>A venir</td>';
								echo '</tr>';
						}
						echo'</table>';
						echo'</div>';
					}
					else
					{
						echo '<div id="tab">';
						echo "AUCUN TOURNOI";
						echo'</div>';
					}
				}
				
				?>
						
			</div>
	</body>
</html>