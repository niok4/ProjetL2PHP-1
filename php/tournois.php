<?php
include('../module/Tournoi.php');
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$tabTournoi = array();

$tabLieu = array();
$tabNom = array();
$tabDate = array(); 
$tabDuree = array();
$tabNbEquipes = array();
$i=0;

$getNom = $bdd->query("SELECT nom FROM Tournoi");
$getLieu = $bdd->query("SELECT lieu FROM Tournoi");
$getDate = $bdd->query("SELECT dateDeb FROM Tournoi WHERE month(dateDeb)");
$getDuree = $bdd->query("SELECT duree FROM Tournoi");
$getNbEquipes = $bdd->query("SELECT nombreTotalEquipes FROM Tournoi");

while($test=$getLieu->fetch()){
    
    $tabLieu[$i] = $test['lieu'];
    $test2 = $getDate->fetch();
    $tabDate[$i] = $test2['dateDeb'];
    $test3 = $getNom->fetch();
    $tabNom[$i] = $test3['nom'];
    $test4 = $getDuree->fetch();
    $tabDuree[$i] = $test4['duree'];
    $test5 = $getNbEquipes->fetch();
    $tabNbEquipes[$i] = $test5['nombreTotalEquipes'];
    
    ++$i;

}

$getLieu->closeCursor();
$getDate->closeCursor();
$getNom->closeCursor();
$getDuree->closeCursor();
$getNbEquipes->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href=".././css/styleTournois.css" />
    <title> Liste des Tournois </title>
</head>
<body>
    <div>
        <a href="../index.php">
            <img src="../img/home.png">
        </a>
    </div>
    <style>
        body div img {
            width:50px;
            border:5px groove white;
            padding:5px;
        }
    </style>

    <div class="cadre">   
    <h1>
        <p style="text-align: center;">Tournois passés</p>
    </h1>
    <?php
    $taille = sizeof($tabLieu);
    /*
    Sur la page Html
    Pour les tournois passés remplacer durée par date de fin.
    Pour les tournois en cours et à venir, laisser durée.
    Rajouter un lien cliquable vers le tournoi relantant des informations.
    Rajouter le vainqueur pour les tournois passés ?
    Rajouter Lien vers description de équipes du tournoi, puis composition de chaque équipe ?
    Rajouter lien vers l'arbre associé des tournois en cours et terminés
    */

    echo '<table>
        <tr>
            <th>Nom</th>
            <th>Lieu</th>
            <th>Date début</th>
            <th>Durée</th>
            <th>Nombre d'."'".'équipes</th>
        </tr>';
        for($i=0;$i<$taille;++$i){
            echo'<tr>';
            echo '<td>'.$tabNom[$i].'</td>';
            echo '<td>'.$tabLieu[$i].'</td>';
            echo '<td>'.$tabDate[$i].'</td>';
            echo '<td>'.$tabDuree[$i].'</td>';
            echo '<td>'.$tabNbEquipes[$i].'</td>';
            echo'</tr>';
        }

        echo'</table>';
    ?>
</div>
<div class="cadre">   
    <h1>
        <p style="text-align: center;">Tournois en cours</p>
    </h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Lieu</th>
            <th>Date début</th>
            <th>Durée</th>
            <th>Nombre d'équipes</th>

        </tr>
        <tr>
            <td>empty</td>
            <td>empty</td>
            <td>empty</td>
            <td>empty</td>
            <td>empty</td>
        </tr>
    </table>
</div>

<div class="cadre">   
    <h1>
        <p style="text-align: center;">Tournois à venir</p>
    </h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Lieu</th>
            <th>Date début</th>
            <th>Durée</th>
            <th>Nombre d'équipes</th>

        </tr>
        <tr>
            <td>empty</td>
            <td>empty</td>
            <td>empty</td>
            <td>empty</td>
            <td>empty</td>
        </tr>
    </table>
</div>


</body>
</html>