<?php
	include_once('Entite.php');
	
	class MatchT extends Entite
	{
		protected $m_idMatchT;
		protected $m_date;
		protected $m_horaire;
		protected $m_idTournois;
		
		//Constructeur
		public function __construct(int $id, string $date, string $horaire,int $idT)
		{
			$this->m_idMatchT = $id;
			$this->m_date = $date;
			$this->m_horaire = $horaire;
			$this->m_idTournois = $idT;
		}
		
		//ACESSEURS EN LECTURE
		public function afficher()
		{
			echo "Match n°".$this->m_idMatchT;
			echo "<br ./>";
		}
		
		public function getIdMatchT()
		{
			return $this->m_idMatchT;
		}
		
		public function getdateMatchT()
		{
			return $this->m_date;
		}

		public function gethoraire()
		{
			return $this->m_horaire;
		}

		public function getIdTournoi()
		{
			return $this->m_idTournois;
		}
		//ACCESSEURS EN ECRITURE
		public function setId(int $id)
		{
			$this->m_idMatchT = $id;
		}

		public function setDate(string $date)
		{
			$this->$m_date = $date;
		}

		public function setHoraire(string $horaire)
		{
			$this->m_horaire = $horaire;
		}
		
		public function toString()
		{
			return strval($this->m_idMatchT);
		}
		
		public function toHTML()
		{
			return "<p>".strval($this->m_idMatchT)."</p>";
		}
	}
?>
