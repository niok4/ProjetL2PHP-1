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

        $requete = "INSERT INTO MatchT VALUES($idMt,$idT,'$date', '$horaire');";

        $res = $connexion->query($requete);
        if(!$res)
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
        
		$connexion->close();

        return true;
    }	

	function IsAlreadyProgrammed(int $idT){
		include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}
		$requete = "SELECT * FROM MatchT WHERE idMatchT = \"$idT\";";

		$res = $connexion->query($requete);
		
		if(!$res)
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);

		
		if(mysqli_num_rows($res) >0){
			return true;
		}
		else{
			return false;
		}

		$connexion->close();
	}

	function getMatchT(string $id){
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
			$date = strval($objTemp->date);
			$horaire = strval($objTemp->horaire);
			$idTournoi = strval($objTemp->idTournoi);
			
			$connexion->close();
			
			if(empty($idMatchT))
				return NULL;
			
			return new MatchT($idMatchT, $date, $horaire, $idTournoi);
		}
	}

	function getAllMatchTwithIdT(string $idT)
	{
		include('DataBaseLogin.inc.php');
		
		$connexion = new mysqli($server, $user, $passwd, $db);
	
		if($connexion->connect_error)
		{
			echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
		}
		
		$requete = "SELECT *
		FROM MatchT
		WHERE idTournoi = $idT;";
		
		$res = $connexion->query($requete);
		if(!$res)
		{
			die('Echec lors de l\'exécution de la requête: ('.$connexion->errno.') '.$connexion->error);
			$connexion->close();
			
			return NULL;
		}
		
		$nbMatchT = $res->num_rows;
		
		$connexion->close();
		
		$tabMatchT = array();
		
		if($nbMatchT == 0)
			return $tabMatchT;
		
		while($obj = $res->fetch_object())
		{
			array_push($tabMatchT, getMatchT($obj->idMatchT));
		}
		
		return $tabMatchT;
	}
    
