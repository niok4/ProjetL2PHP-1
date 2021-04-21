<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href=".././css/syleIndex.css" />
    <!--<script type="text/javascript" src="PageDacc.js"></script>-->

    <style>
    form
    {
        text-align:center;
    }
    </style>

    <body>
        <div class="topnav">
            <a href="../index.php">Information</a>
            <a href="tournois.php">Liste des Tournois</a>
            <a href="creer_tournois.php">Creer un tournoi</a>
            <div class="topnav-right">
              <a href="Login.php">Login</a>
            </div>
        </div>         
        <hr>

        <h2 style="text-align:center">Inserez les donnez pour créer un Tournoi (gestionnaire seulement)</h2> 
        
        
        <form action="creer_tournois.php" method="post">
        <p>
        <label for="nom">Nom</label> : <input type="text" name="nom" id="nom" /><br />
        <label for="dateDeb">date de début</label> :  <input type="date" name="dateDeb" id="dateDeb" /><br />
        <label for="duree">duree</label> :  <input type="number" name="duree" id="duree" /><br />
        <label for="lieu">Lieu</label> :  <input type="text" name="lieu" id="lieu" /><br />

        <button type="submit"  name="envoiValeurs" value="Envoyer">Creer</button>
	    </p>
    </form>

<?php
// Connexion à la base de données
if(isset($_POST) && isset($_POST['envoiValeurs']))
{   
    include('../BDD/reqCreerTournoi.php');
    
    creerTournoi(strval($_POST['nom']),$_POST['dateDeb'], $_POST['duree'], strval($_POST['lieu']));
}

$_POST = array();


/*
// Récupération des données
$reponse = $bdd->query('SELECT nom, dateDeb, duree, lieu FROM Tournoi ORDER BY idTournoi DESC LIMIT 0, 10');

// Affichage de chaque turnoi (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $reponse->fetch())
{
	echo '<p><strong>' . htmlspecialchars($donnees['nom']) . '</strong> : ' . htmlspecialchars($donnees['dateDeb']) . '</p>';
}

$reponse->closeCursor();

// Redirection du visiteur vers la page du minichat
header('Location: tournois.php');*/

?>



    </body>
</html>


