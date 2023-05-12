<?php 


Class Classes extends Model {

	public $id;
	public $libelle;
	public $id_niveau;
	public $niveau;
	public $eleves;
	public $professeurs;


	public function __construct(string $libelle=null, int $id_niveau=null)
	{
		if ($libelle && $id_niveau) {
			$this->libelle=$libelle;
			$this->id_niveau=$id_niveau;
		}
	}



	public function setId(int $id): void
	{
		$this->id=$id;
	}
	public function setLibelle(string $libelle): void
	{
		$this->libelle=$libelle;
	}

	public function setIdNiveau(int $id_niveau): void
	{
		$this->id_niveau=$id_niveau;
	}

	public function getId(): int
	{
		return $this->id;
	}
	public function getLibelle(): string
	{
		return $this->libelle;
	}

	public function getIdNiveau(): int
	{
		return $this->id_niveau;
	}


	public function getAllClasses(int $id_niveau=null): ?array
	{
		$q='SELECT * FROM classe';
		$param=[];
		if (isset($id_niveau)) {
			$q.=' WHERE id_niveau = :id_niveau';
			$param[':id_niveau']=$id_niveau;
		}
		try {

			$db=self::getPDO();

			$query= $db->prepare($q);
			$query->execute($param);
			$query->setFetchMode(PDO::FETCH_CLASS, Classes::class);
			$classes=$query->fetchAll();
			if ($classes === false) {
				return null;
			}
		
			return $classes;

		}catch(Exception $e){
			$erreur=$e->getMessage();
		}
	}

	public function classeExist()
	{
		try{

			$db=self::getPDO();

			$query= $db->prepare('SELECT * FROM classe WHERE id=:id');
			$query->execute([
				':id'=>$this->getId()
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Classes::class);
			$classe=$query->fetch();
			if (!$classe) {
				return false;
			}
		
			return $classe;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
			
		}

	}

	public function getElevesClasse(): ?array
	{
		try {
			
			$db=self::getPDO();

			$query= $db->prepare('SELECT id, nom, prenom, sexe, date_de_naissance, mail FROM personne INNER JOIN eleve ON personne.id=eleve.id_personne WHERE eleve.id_classe=:id ORDER BY personne.nom');
			$query->execute([
				':id'=>$this->getId()
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Personne::class);
			$eleves=$query->fetchAll();
			
			$this->eleves=$eleves;
			return $eleves;
		}catch(Exception $e){
			$erreur=$e->getMessage();
		}

	}


	public function getProfesseursClasse(): ?array
	{
		try {
			$db=self::getPDO();

			$query= $db->prepare('SELECT personne.id, nom, prenom FROM personne INNER JOIN professeur ON personne.id =professeur.id_personne INNER JOIN classe_professeur ON professeur.id_personne= classe_professeur.id_professeur WHERE classe_professeur.id_classe=:id');
			$query->execute([
				':id'=>$this->getId()
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Personne::class);
			$professeurs=$query->fetchAll();
			
			$this->professeurs=$professeurs;
			return $professeurs;
		}catch(Exception $e){
			$erreur=$e->getMessage();
		}

	}

	public function verifyLibelleClasse(): bool
	{
		
		if (!preg_match('#^([a-zA-Z0-9]+([a-zA-Z|\s|0-9-_/]){2,50})*$#', $this->libelle))
		{
			return false;
		}
		return true;
	}

	public function insertClasse(): ?int
	{
		try {

			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO classe (libelle, id_niveau) VALUES (:libelle, :id_niveau)');
			$query->execute([
				':libelle'=>$this->libelle,
				':id_niveau'=>$this->id_niveau
			]);
			$niveau=$query->rowCount();
				
			if ($niveau > 0) 
			{
				return true;
			}
			return false;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
		
	}

	public function alterClasse():bool
	{
		if ($this->libelle) {
			$q= 'UPDATE classe SET libelle=:libelle, id_niveau=:id_niveau WHERE id=:id';
			$params= [
			':libelle'=>$this->libelle,
			':id_niveau'=>(int)($this->id_niveau),
			':id'=>$this->id
			];
		}else{

			$q= 'UPDATE classe SET id_niveau=:id_niveau WHERE id=:id';
			$params= [
			':id_niveau'=>(int)($this->id_niveau),
			':id'=>$this->id
			];
		}

		try{

			$db=self::getPDO();
			$query= $db->prepare($q);
			$query->execute($params);
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


	public function deleteClasse(): ?int
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM classe WHERE id=:id');
			$query->execute([
			':id'=>$this->id
			]);
			$req=$query->rowCount();
			if ($req > 0) {
				return true;
			}
			return false;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
		
	}


}