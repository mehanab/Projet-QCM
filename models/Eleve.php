<?php 

Class Eleve extends Personne {


	public $id_personne;
	public $statut= 'eleve';
	public $id_classe;
	public $note_qcm;



	public function __construct(Personne $personne=null)
	{
		if ($personne !=null) 
		{
			parent::__construct($personne->prenom, $personne->nom, $personne->sexe, $personne->date_de_naissance, $personne->mot_de_passe);
			$this->mail=$personne->mail;
			$this->pseudo=$personne->pseudo;
			$this->id_personne=$personne->id;
			$this->id = $personne->id;
			$this->cree_le=$personne->cree_le;
			$this->password=$personne->password;
			$this->id_adresse=$personne->id_adresse;
			$this->adresse=$personne->adresse;			
		}
	}

	public function setIdEleve($id): void
	{
		$this->id_personne=$id;
	}

	public function getIdEleve(): int
	{
		return $this->id_personne;
	}



	public function isEleve(): ?Eleve
	{

		$db=self::getPDO();
		$query= $db->prepare('SELECT * FROM eleve WHERE id_personne=:id');
		$query->execute([':id'=>$this->id_personne]);
		$query->setFetchMode(PDO::FETCH_CLASS, Eleve::class, [$this]);
		$eleve=$query->fetch();
		if ($eleve === false) {
			return null;
		}
	
		return $eleve;
	}

	public function insertEleve(): bool
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO eleve (id_personne, statut, id_classe) VALUES (:id_personne, :statut, :id_classe)');
			$query->execute([
				':id_personne'=>$this->id_personne,
				':statut'=>$this->statut,
				':id_classe'=>$this->id_classe
			]);
			$eleve= $query->rowCount();
			if ($eleve == 0) 
			{
				return false;
			}
				
			return true;

		}catch(Exception $e){

			$erreur=$e->getMessage();
			return false;
			
		}
	
	}

	public function alterEleve():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('UPDATE eleve SET statut=:statut, id_classe=:id_classe WHERE id_personne=:id_personne');
			$query->execute([
			':statut'=>$this->statut,
			':id_classe'=>(int)($this->id_classe),
			':id_personne'=>$this->id_personne
			]);
			$req=$query->rowCount();
			if ($req == 0) {
				return false;
			}
			return true;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
	}


	public function deleteEleve():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM eleve WHERE id_personne=:id_personne');
			$query->execute([
			':id_personne'=>$this->id_personne
			]);
			$req=$query->rowCount();
			if ($req == 0) {
				return false;
			}
			return true;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
	}


	public function get_qcm_eleve(int $id_qcm=null): ?array
	{
		$q='SELECT qcm.* FROM qcm INNER JOIN classe_qcm ON qcm.id= classe_qcm.id_qcm INNER JOIN classe ON classe.id= classe_qcm.id_classe WHERE classe.id= :id_classe';

		$params=[':id_classe'=>(int)($_SESSION['eleve']['id_classe'])];

		if ($id_qcm) 
		{
			$q.=' AND qcm.id= :id_qcm';
			$params['id_qcm']=$id_qcm;
		}

		$q.=' ORDER BY qcm.cree_le DESC';

		try
		{
			$db=self::getPDO();
			$query= $db->prepare($q);

			$query->execute($params);
			$query->setFetchMode(PDO::FETCH_CLASS, Qcm::class);
		
			$qcm=$query->fetchAll();
			if ($qcm) 
			{
				return $qcm;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}

	}

	public function insert_note(int $id_qcm):bool
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO note_eleve (id_eleve, id_qcm, note) VALUES (:id_personne, :id_qcm, :note_qcm)');
			$query->execute([
				':id_personne'=>$this->id_personne,
				':id_qcm'=>$id_qcm,
				':note_qcm'=>$this->note_qcm
			]);
			$note= $query->rowCount();
			if ($note == 0) 
			{
				return false;
			}
				
			return true;

		}catch(Exception $e){

			$erreur=$e->getMessage();
			return false;
			
		}
	}


	public function update_note(int $id_qcm):bool 
	{
		try{
			$db=self::getPDO();
			$query= $db->prepare('UPDATE note_eleve SET note=:note_qcm WHERE id_eleve=:id_eleve AND id_qcm=:id_qcm');
			$query->execute([
				':id_eleve'=>$this->id_personne,
				':id_qcm'=>$id_qcm,
				':note_qcm'=>$this->note_qcm
			]);
			$note= $query->rowCount();
			if ($note == 0) 
			{
				return false;
			}
				
			return true;

		}catch(Exception $e){

			$erreur=$e->getMessage();
			return null;
			
		}
	}

}