<?php 

Class Niveaux extends Model {

	public $id;
	public $libelle;




	public function getNiveaux(int $id=null){
		$q='SELECT * FROM niveau_classe';
		$params=[];
		if (isset($id)) {
			$q='SELECT * FROM niveau_classe WHERE id=:id';
			$params[':id']=$id;
		}
		
		$db=self::getPDO();
		$query= $db->prepare($q);
		$query->execute($params);
		$query->setFetchMode(PDO::FETCH_CLASS, Niveaux::class);
		if (isset($id)) {
			$niveaux=$query->fetch();
		}else{
			$niveaux=$query->fetchAll();
		}
		
		if ($niveaux === false) {
			return null;
		}
	
		return $niveaux;

	}

	public function verifyLibelle(): bool
	{
		
		if (!preg_match('#^([a-zA-Z0-9]+([a-zA-Z|\s|0-9-_/]){2,50})*$#', $this->libelle))
		{
			return false;
		}
		return true;
	}

	public function insertNiveau(): ?int
	{
		try {

			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO niveau_classe (libelle) VALUES (:libelle)');
			$query->execute([
				':libelle'=>$this->libelle
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

	public function deleteNiveau(): ?int
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM niveau_classe WHERE id=:id');
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