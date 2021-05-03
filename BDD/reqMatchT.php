<?php
    include_once('../module/MatchT.php');
    include_once('reqTournoi.php');
    include_once('reqGeneralBDD.php');
    function inserMatchT(int $idT,string $date,string $horaire){
		
        include('DataBaseLogin.inc.php');
        $connexion = new mysqli($server, $user, $passwd, $db);
        if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}

        $idMt = chooseIntegerIdSequential("MatchT","idMatchT");
        $requete = "INSERT INTO MatchT VALUES($idMt, $idT,$date, $horaire);";

        $res = $connexion->query($requete);
        if(!$res)
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
        
		$connection->close();

        return true;
    }	
    
    function getMatchTwithId(string $id)
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
		$idMatcT = strval($objTemp->idMatcT);
		$idTournoi = strval($objTemp->idTournoi);
		$date = strval($objTemp->date);
		$horaire = strval($objTemp->duree);
		
		$connexion->close();
		
		if(empty($idMatcT))
			return NULL;
		
		return new MatchT($idMatcT, $date, $horaire, $idTournoi);
	}
	function getMatchTwithDateAndHoraire(string $date,string $horaire)
	{
		include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}
		
		$requete = "SELECT * FROM MatchT WHERE date = \"$date\" AND horaire = \"$horaire\";";
		
		$res = $connexion->query($requete);
		if(!$res)
		{
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
			$connexion->close();
			
			return NULL;
		}
		
		$objTemp = $res->fetch_object();
		$idMatcT = strval($objTemp->idMatcT);
		$idTournoi = strval($objTemp->idTournoi);
		$date = strval($objTemp->date);
		$horaire = strval($objTemp->duree);
		
		$connexion->close();
		
		if(empty($idMatcT))
			return NULL;
		
		return new MatchT($idMatcT, $date, $horaire, $idTournoi);
	}
?>