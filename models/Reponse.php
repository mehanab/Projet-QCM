<?php 

class Reponse extends Model
{
	public $id;
	public $reponse;
	public $valeur;


	public function __construct(string $reponse=null, string $valeur=null)
	{
		if ($reponse && $valeur) 
		{
			$this->reponse=$reponse;
			$this->valeur= $valeur;
		}

	}
	


	public function insert_reponse():?int
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO reponse (reponse) VALUES (:reponse)');

			$query->execute([
				':reponse'=>$this->reponse
			]);

			$reponse=$query->rowCount();
				
			if ($reponse > 0) 
			{
				$lastId=$db->lastInsertId();
				return (int)$lastId;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
			
	}

	public function insert_question_reponse(int $id_question):?int
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO question_reponse (id_question, id_reponse, valeur) VALUES (:id_question, :id_reponse, :valeur)');

			$query->execute([
				':id_question'=>(int)($id_question),
				':id_reponse'=>$this->id,
				':valeur'=>$this->valeur
			]);

			$question=$query->rowCount();
				
			if ($question >= 0) 
			{
				$lastId=$db->lastInsertId();

				return (int)$lastId;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
			
	}

	public function insert_reponse_eleve(int $id_qcm_question): ?int
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO reponse_eleve (id_reponse, id_qcm_question,  id_eleve) VALUES (:id_reponse, :id_qcm_question,  :id_eleve)');

			$query->execute([
				':id_qcm_question'=>(int)($id_qcm_question),
				':id_reponse'=>$this->id,
				':id_eleve'=>(int)$_SESSION['eleve']['id_personne']
			]);

			$rep=$query->rowCount();
				
			if ($rep >= 0) 
			{
				$lastId=$db->lastInsertId();

				return (int)$lastId;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}

	}

	public function delete_reponse():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM reponse WHERE id=:id_reponse');
			$query->execute([
				':id_reponse'=>$this->id
			]);
			$req=$query->rowCount();
		
			return $req;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}

	}


	

}