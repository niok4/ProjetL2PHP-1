<?php
    function lineCount(string $table)
    {
        include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
        
        if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}
		
		$res = $connexion->query("SELECT * FROM $table;");
		
		if(!$res)
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
		
		$row = $res->fetch_assoc();
		
		$connexion->close();
		
		return $res->num_rows;
    }

    function creerTournoi(string $nom, date $dateDeb, int $duree, string $lieu)
    {
        include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}

        $idT = lineCount("Tournoi") + 1;

        $requete = "INSERT INTO Tournoi VALUES($idT, '$nom', '$dateDeb', $duree, 1, '$lieu');";

        $res = $connexion->query($requete);
		if(!$res)
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
		
		$connexion->close();
		
		unset($_POST);
		
		header('Location: ../php/creer_tournois.php');
		exit();
    }