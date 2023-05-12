<?php 


/**
 * 
 */
class Adresse extends Model
{
	private $id;
	private $numero_voie;
	private $type_voie;
	private $nom_voie;
	private $complement_adresse;
	private $ville;
	private $code_postal;
	
	public function __construct(int $numero_voie=null, string $type_voie=null, string $nom_voie=null, string $complement_adresse=null, string $ville=null, int $code_postal=null)
	{
		if ($numero_voie && $type_voie && $nom_voie && $ville && $code_postal) {
			
		
			$this->numero_voie= $numero_voie;
			$this->type_voie= $type_voie;
			$this->nom_voie= $nom_voie;

			if (!empty($complement_adresse)) {
				$this->complement_adresse= $complement_adresse;
			}
			
			$this->ville= $ville;
			$this->code_postal= $code_postal;
		}	
	}


// Methodes Get: 
	public function getId(): ?int
	{
		return $this->id;
	}
	public function getNumeroVoie(): int
	{
		return $this->numero_voie;
	}
	public function getTypeVoie(): string
	{
		return $this->type_voie ;
	}
	public function getNomVoie(): string
	{
		return $this->nom_voie ;
	}
	public function getComplementAdresse(): ?string
	{
		return $this->complement_adresse;
	}
	public function getVille(): string
	{
		return $this->ville;
	}
	public function getCodePostal(): int
	{
		return $this->code_postal;
	}

// Methodes Set: 
	public function setId(int $id): void
	{
		$this->id=$id;
	}
	public function setNumeroVoie(int $numero_voie): void
	{
		$this->numero_voie=$numero_voie;
	}
	public function setTypeVoie(string $type_voie): void
	{
		$this->type_voie= $type_voie ;
	}
	public function setNomVoie(string $nom_voie): void
	{
		$this->nom_voie= $nom_voie ;
	}
	public function setComplementAdresse(string $complement_adresse): void
	{
		$this->complement_adresse = $complement_adresse;
	}
	public function setVille(string $ville): void
	{
		$this->ville = $ville ;
	}
	public function setCodePostal(int $code_postal): void
	{
		$this->code_postal= $code_postal ;
	}


	public function adresseExist(): ?int
	{
		$db=self::getPDO();
		if ($this->complement_adresse!==null) {
			$query= $db->prepare('SELECT * FROM adresse WHERE numero_voie=:numero_voie AND type_voie=:type_voie AND nom_voie=:nom_voie AND complement_adresse=:complement_adresse AND ville=:ville AND code_postal=:code_postal');
			$query->execute([
			':numero_voie'=>$this->numero_voie, 
			':type_voie'=>$this->type_voie, 
			':nom_voie'=>$this->nom_voie,
			':complement_adresse'=>$this->complement_adresse,
			':ville'=>$this->ville, 
			':code_postal'=>$this->code_postal
			]);

		}else{

			$query= $db->prepare('SELECT * FROM adresse WHERE numero_voie=:numero_voie AND type_voie=:type_voie AND nom_voie=:nom_voie AND ville=:ville AND code_postal=:code_postal');
			$query->execute([
			':numero_voie'=>$this->numero_voie, 
			':type_voie'=>$this->type_voie, 
			':nom_voie'=>$this->nom_voie,
			':ville'=>$this->ville, 
			':code_postal'=>$this->code_postal
			]);

		}
		
		$query->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
		$adresse=$query->fetch();
		if ($adresse) {
			return (int)$adresse->id;
		}
		return null;

	}

	public function insertAdresse(): ?int 
	{
		$db=self::getPDO();
		$query= $db->prepare('INSERT INTO adresse (numero_voie, type_voie, nom_voie, complement_adresse, ville, code_postal) VALUES (:numero_voie, :type_voie, :nom_voie, :complement_adresse, :ville, :code_postal)');
		$query->execute([
			':numero_voie'=>$this->getNumeroVoie(), 
			':type_voie'=>$this->getTypeVoie(), 
			':nom_voie'=>$this->getNomVoie(),
			':complement_adresse'=>$this->getComplementAdresse(), 
			':ville'=>$this->getVille(), 
			':code_postal'=>$this->getCodePostal()
		]);
		$adresse=$query->rowCount();

		if ($adresse > 0) {
			$lastId=$db->lastInsertId();
			return $lastId;
		}

		return null;

	}

	public function getAdresseId(): ?int
	{
		$id_adresse= $this->adresseExist();
		if (!$id_adresse) {
			$id_adresse=$this->insertAdresse();
		}
		return $id_adresse;

	}

	public function getAllAdresses(string $id=null):?array
	{
		$q='SELECT * FROM adresse';
		$param=[];

		if ($id && $id="id") 
		{
			$q='SELECT * FROM adresse WHERE id=:id';
			$param=[':id'=> $this->getId()];	
		}

		try
		{
			$db=self::getPDO();
			
			$query= $db->prepare($q);
			$query->execute($param);
			$query->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
			$adresses=$query->fetchAll();
			return $adresses;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
	}


	public function alterAdresse():bool
	{
		$q='UPDATE adresse SET numero_voie=:numero_voie, type_voie=:type_voie, nom_voie=:nom_voie, complement_adresse= :complement_adresse, ville=:ville, code_postal=:code_postal WHERE id=:id';

		$params=[
			':numero_voie'=>$this->numero_voie, 
			':type_voie'=>$this->type_voie, 
			':nom_voie'=>$this->nom_voie, 
			':complement_adresse'=>$this->complement_adresse, 
			':ville'=>$this->ville, 
			':code_postal'=>$this->code_postal,
			':id'=>$this->id
		    ];

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










}