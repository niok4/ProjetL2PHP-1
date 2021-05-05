<?php
	include_once('reqTournoi.php');
	include_once('../module/MatchT.php');

	function insertMatchT(int $idTournoi,string $date, string $horaire)
    {
        include('DataBaseLogin.inc.php');

        if(!estTournoi($idTournoi))
			trigger_error("ERREUR : Identifiant de tournoi invalide.");
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}

        $idMatchT = chooseIntegerIdSequential("MatchT", "idMatchT");

        $requete = "INSERT INTO MatchT VALUES($idMatchT,$idTournoi,'$date','$horaire');";

        $res = $connexion->query($requete);
		if(!$res)
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
		
		$connexion->close();
		
		//unset($_POST);

		return true;
		
		exit();

    }

    function estMatchT(string $id)
	{
		include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}
		
		$requete = "SELECT idMatchT FROM MatchT WHERE idMatchT = \"$id\";";
		
		$res = $connexion->query($requete);
		if(!$res)
		{
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
			$connexion->close();
			
			return false;
		}
		
		$objTemp = $res->fetch_object();
		$idMatchT = strval($objTemp->idMatchT);
		
		$connexion->close();
		
		if(empty($idMatchT))
			return false;
		
		return true;
	}
	
	function getMatchT(string $id)
	{
		include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}
		
		$requete = "SELECT * FROM MatchT WHERE idMatchT = \"$id\";";
		
		$res = $connexion->query($requete);
		if(!$res)
		{
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
			$connexion->close();
			
			return NULL;
		}
		
		$objTemp = $res->fetch_object();
		$idMatchT = strval($objTemp->idMatchT);
		$idTournoi = strval($objTemp->idTournoi);
		$date = strval($objTemp->date);
		$horaire = strval($objTemp->horaire);
		
		$connexion->close();
		
		if(empty($idMatchT))
			return NULL;
		
		return new MatchT($idMatchT, $idTournoi, $date, $horaire);
	}

	function getAllMatchT(int $idTournoi)
	{
		include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}
		
		$requete = "SELECT * FROM MatchT WHERE idTournoi = \"$idTournoi\";";
		
		$res = $connexion->query($requete);
		if(!$res)
		{
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
			$connexion->close();
			
			return NULL;
		}
		
		$nbMatchs = $res->num_rows;
		
		$connexion->close();
		
		$tabMatchT = array();
		
		if($nbMatchs == 0)
			return $tabMatchT;
		
		while($obj = $res->fetch_object())
		{
			array_push($tabMatchT, getMatchT($obj->idMatchT));
		}
		
		return $tabMatchT;
	}

	//fonction qui récupère tous les Matchs d'un tournoi en fonction de l'idT
	//fonction qui récupère tous les matchs d'un tour en fonction de l'idT et du tour
?>