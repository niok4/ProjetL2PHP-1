<?php
	include_once('./BDD/reqUtilisateur.php');
	
	session_start();
	
	$ut = NULL;
	$estConnecte = false;
	$estAdministrateur = false;
	
	if(isset($_SESSION['login']))
	{
		if(verifLoginMdp(strval($_SESSION['login']), strval($_SESSION['motDePasse'])))
		{
			$ut = getUtilisateurWithEmail($_SESSION['login']);
			$estConnecte = true;
			$estAdministrateur = ($ut->getRole() === "Administrateur");
		}
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<link rel="stylesheet" type="text/css" href="./css/syleIndex.css" />
		<script type="text/javascript" src="./js/Menu.js"></script>
		<title>Accueil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
	        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
	        crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
	        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
	        crossorigin="anonymous"></script>
	    <link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="bandeau-haut">	
			<h3 style="font-size:50px;margin:auto;">TOURNOIS SPORTIFS</h3>
			<div class="topnav-right">
				<?php
					$register = "<a href=\"php/Register.php\" style=\"text-decoration: none\">Inscription</a>";
					$co = "<a href=\"php/Login.php\" style=\"text-decoration: none\">Connexion</a>";
					$deco = "<a href=\"php/Logout.php\" style=\"text-decoration: none\">Déconnexion</a>";

					$total1 = "<a href=\"php/Register.php\" style=\"text-decoration: none\">Inscription</a>
					<a href=\"php/Login.php\" style=\"text-decoration: none\">Connexion</a>";

					$total2 = "<a href=\"php/Profil.php\" style=\"text-decoration: none\">Mon Compte</a>
					<a href=\"php/Logout.php\" style=\"text-decoration: none\">Déconnexion</a>";	
					echo (($estConnecte) ? $total2 : $total1);
				?>
			</div>
			
			<div class="unBeauMenu">
				<div class="iconeMenu" onclick="changerIcone(this)">
					<div class="barre1"></div>
					</br>
					<div class="barre2"></div>
					</br>
					<div class="barre3"></div>
				</div>

				<div class="corpsMenu">
					<ul class="listeItemsMenus">

						<li class="itemMenu"><a class="lien" href="php/Tournois.php">Liste des Tournois</a></li>
						<li class="itemMenu"><a class="lien" href="php/CreerTournoi.php">Création de tournois</a></li>
						<li class="itemMenu"><a class="lien" href="#">À Propos</a></li>
						<li class="itemMenu"><a class="lien" href="#">Contact</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container-main">

		<div id="carouselExemple" class="carousel slide" data-ride="carousel" data-interval="5000">

	        <ol class="carousel-indicators">
	            <li data-target="#carouselExemple" data-slide-to="0" class="active"></li>
	            <li data-target="#carouselExemple" data-slide-to="1"></li>
	            <li data-target="#carouselExemple" data-slide-to="2"></li>
	            <li data-target="#carouselExemple" data-slide-to="3"></li>
	            <li data-target="#carouselExemple" data-slide-to="4"></li>
	        </ol>


	        <div class="carousel-inner">

	            <div class="carousel-item active">
	                <img src="img/back3.jpg">
	            </div>

	            <div class="carousel-item">
	                <img src="img/basket.jpg">
	            </div>

	            <div class="carousel-item">
	                <img src="img/volley.jpg">
	            </div>

	            <div class="carousel-item">
	                <img src="img/tennis.jpg">
	            </div>

	            <div class="carousel-item">
	                <img src="img/foot.jpg">
	            </div>

	        </div>

	        <a href="#carouselExemple" class="carousel-control-prev" role="button" data-slide="prev">
	            <span class="carousel-control-prev-icon" aria-hidden="ture"></span>
	            <span class="sr-only">Previous</span>
	        </a>
	        <a href="#carouselExemple" class="carousel-control-next" role="button" data-slide="next">
	            <span class="carousel-control-next-icon" aria-hidden="true"></span>
	            <span class="sr-only">Next</span>
	        </a>

    	</div>


	    <script>
	        $('.carousel').carousel({pause: "null"})
	    </script>


    <div class="cadre">
		<h1>Bienvenue</h1>
		<?php
			$propIns = "<p>
				- Pas de compte ? Inscrivez-vous dès maintenant -
			</p>";
				
			if(!$estConnecte)
				echo $propIns;
		?>
	</div>
	</div>
	</body>
</html>
