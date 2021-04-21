<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href=".././css/syleIndex.css" />
    <!--<script type="text/javascript" src="PageDacc.js"></script>-->

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
        <p> sa </p>
        <button >
    </body>
</html>

<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM Tournoi ');

while ($donnees = $reponse->fetch())
{
	echo htmlspecialchars($donnees['nom']) . ' :, ' . htmlspecialchars($donnees['lieu']) . '<br />';
}

$reponse->closeCursor();

?>