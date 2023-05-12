<?php 

class Question extends Model
{
	public $id;
	public $id_professeur;
	public $id_theme;
	public $question;

	public $reponses;
	public $total;
	public $count_pages;
	public $est_partagee;
	public $reponses_eleve;
	private const PER_PAGE= 3;



	public function questionExist():?Question
	{
		try{

			$db=self::getPDO();

			$query= $db->prepare('SELECT * FROM question WHERE id=:id');
			$query->execute([
				':id'=>$this->id
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Question::class);
			$question=$query->fetch();
			if (!$question) 
			{
				return null;
			}
		
			return $question;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}
	}

	public function question_professeur_exist(int $id_professeur):?Question
	{
		try{

			$db=self::getPDO();

			$query= $db->prepare('SELECT * FROM question WHERE id=:id AND id_professeur=:id_professeur');
			$query->execute([
				':id'=>$this->id,
				':id_professeur'=>$id_professeur
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Question::class);
			$question=$query->fetch();
			if (!$question) 
			{
				return null;
			}
		
			return $question;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}
	}

	public function select_all_questions(int $id_theme=null, int $page=null): ?array
	{
		$pages=null;
		$q='SELECT  question.* FROM question ';
		$queryCount= "SELECT COUNT('question.id') as count FROM question"; 
		$params=[];

		if ($id_theme) 
		{
			$q.=' WHERE question.id_theme= :id_theme';
			$queryCount.=' WHERE question.id_theme= :id_theme';
			$params['id_theme']=$this->id_theme;
		}

	
		try{

			$db=self::getPDO();
			$query= $db->prepare($queryCount);
			$query->execute($params);
			$count=(int)$query->fetch()['count'];
			$pages=ceil($count / self::PER_PAGE);
			if ($page > $pages) 
			{
				$page= $pages;
			}

		}catch(Exception $e){
			$erreur=$e->getMessage();
		}
			
		$q.=' ORDER BY question.id DESC';
		if ($id_theme) 
		{
			$p=$page??1;
			$offset= ($p-1) * self::PER_PAGE;
			$q.=' LIMIT '.self::PER_PAGE.' OFFSET '.$offset;
		}
		
		try
		{
			$db=self::getPDO();
			$query= $db->prepare($q);
			$query->execute($params);
			$query->setFetchMode(PDO::FETCH_CLASS, Question::class);
			$questions=$query->fetchAll();
			if ($questions) 
			{
				foreach ($questions as $question) 
				{
					$question->count_pages=$pages;
				}
				
				return $questions;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}

	}




	public function insert_question():?int
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO question (id_professeur, id_theme, question) VALUES (:id_professeur, :id_theme, :question)');

			$query->execute([
				':id_professeur'=>$this->id_professeur,
				':id_theme'=>$this->id_theme,
				':question'=>$this->question
			]);

			$question=$query->rowCount();
				
			if ($question > 0) 
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

	public function est_partagee(): bool
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('SELECT COUNT(qcm_question.id) as count FROM qcm_question WHERE qcm_question.id_question= :id_question');

			$query->execute([
				':id_question'=>$this->id
			]);
		
			$count=$query->fetch()['count'];
			if ($count > 0) 
			{
				$this->est_partagee=true;
				return true;
			}
			$this->est_partagee=false;
			return false;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
		
			
		}

	}

	public function edit_question(): bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('UPDATE question SET id_theme=:id_theme, question=:question WHERE id=:id');
			$query->execute([
				':id'=>(int)$this->id,
				':id_theme'=>(int)$this->id_theme,
				':question'=>$this->question
			]);
			$req=$query->rowCount();
			
			return $req;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
	}

	public function insert_qcm_question($id_qcm):?int
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO qcm_question (id_question, id_qcm) VALUES (:id_question, :id_qcm)');

			$query->execute([
				':id_question'=>$this->id,
				':id_qcm'=>(int)($id_qcm)
			]);

			$question=$query->rowCount();
				
			if ($question > 0) 
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


	public function select_all_responses():?array
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('SELECT reponse.*, question_reponse.valeur FROM reponse INNER JOIN question_reponse ON reponse.id= question_reponse.id_reponse INNER JOIN question ON question.id= question_reponse.id_question WHERE question.id= :id_question');

			$query->execute([
				':id_question'=>(int)$this->id
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Reponse::class);
			$reponses=$query->fetchAll();
			if ($reponses) 
			{
				$this->reponses=$reponses;
				return $reponses;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}
		
	}

	public function select_reponses_eleve(int $id_qcm): ?array 
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('SELECT reponse_eleve.* FROM reponse_eleve INNER JOIN qcm_question ON qcm_question.id = reponse_eleve.id_qcm_question WHERE qcm_question.id_question= :id_question AND qcm_question.id_qcm= :id_qcm AND reponse_eleve.id_eleve= :id_eleve');

			$query->execute([
				':id_qcm'=>(int)($id_qcm),
				':id_question'=>$this->id,
				':id_eleve'=>(int)$_SESSION['eleve']['id_personne']
			]);

			$reponses=$query->fetchAll();
			if ($reponses) 
			{
				$this->reponses_eleve=$reponses;
				return $reponses;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
	}

	public function delete_question():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM question WHERE id=:id_question');
			$query->execute([
				':id_question'=>$this->id
			]);
			$req=$query->rowCount();
			return $req;
			if ($req == 0) 
			{
				return false;
			}
			return true;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}

	}
		




}