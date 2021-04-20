<?php
    function assertGest(int $idG){
        include('../BDD/DataBaseLogin.inc.php');
        $connexion = new mysqli($server, $user, $passwd, $db);
        $requete_InsG = "INSERT INTO Gestionnaire (idGestionnaire) VALUES ($idG) ";
        $resG = $connexion->query($requete_InsG);
	    if(!$resG)
		    die('Echec lors de l\'exécution de la requête requete_InsG: ('.$connexion->errno.') '.$connexion->error);
        header('Location: ../php/AffectGest.php');
    }
?>