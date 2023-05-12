<?php 


/**
 * 
 */
class Qcm extends Model
{
	public $id;
	public $id_theme;
	public $libelle;
	public $echelle_not=20;
	public $notation_vrai=1;
	public $notation_faux=0;
	public $duree_test=15;
	public $cree_le;
	public $date_limite;
	public $id_professeur;

	public $questions;
	public $theme;
	public $jour;
	public $heure;
	public $minute;
	public $classes;
	public $note_eleve;





	public function verify_qcm_libelle():bool
	{
		if (!preg_match('#^([a-zA-Z0-9éàè]+([a-zA-Zéèà\-\_\'|\s|0-9]){0,255})*$#', $this->libelle)) {
			return false;
		}
		return true;
	}


	public function insert_qcm():?int
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO qcm (id_theme, libelle, echelle_not, notation_vrai, notation_faux, duree_test, cree_le, date_limite, id_professeur) VALUES (:id_theme, :libelle, :echelle_not, :notation_vrai, :notation_faux, :duree_test, :cree_le, :date_limite, :id_professeur)');

			$query->execute([

				':id_theme'=>$this->id_theme,
				':libelle'=>$this->libelle,
				':echelle_not'=>$this->echelle_not,
				':notation_vrai'=>$this->notation_vrai,
				':notation_faux'=>$this->notation_faux,
				':duree_test'=>$this->duree_test,
				':cree_le'=>$this->cree_le,
				':date_limite'=>$this->date_limite,
				':id_professeur'=>$this->id_professeur
			]);

			$qcm=$query->rowCount();
				
			if ($qcm > 0) 
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

	public function select_all_qcm(int $id_theme=null):?array
	{
		$q='SELECT qcm.*, theme.libelle as theme FROM qcm INNER JOIN theme ON theme.id=qcm.id_theme WHERE id_professeur= :id_professeur ORDER BY qcm.cree_le DESC';
		$params=[':id_professeur'=>(int)($_SESSION['user_id'])]; 

		if ($id_theme) 
		{
			$q='SELECT qcm.*, theme.libelle as theme FROM qcm INNER JOIN theme ON theme.id=qcm.id_theme WHERE qcm.id_theme= :id_theme ORDER BY qcm.cree_le DESC';
			$params=[':id_theme'=>(int)($id_theme)]; 
		}
		
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

	public function select_qcm():?Qcm
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('SELECT qcm.*, theme.libelle as theme FROM qcm INNER JOIN theme ON theme.id=qcm.id_theme WHERE id_professeur= :id_professeur AND qcm.id= :id');

			$query->execute([
				':id_professeur'=>(int)($_SESSION['user_id']),
				':id'=>$this->id
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Qcm::class);
			$qcm=$query->fetch();

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

	public function qcmExist():?Qcm
	{
		try{

			$db=self::getPDO();

			$query= $db->prepare('SELECT * FROM qcm WHERE id=:id');
			$query->execute([
				':id'=>$this->id
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Qcm::class);
			$qcm=$query->fetch();
			if (!$qcm) {
				return null;
			}
		
			return $qcm;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}
	}

	public function get_classes_qcm(): ?array
	{
		$q='SELECT classe.* FROM classe INNER JOIN classe_qcm ON classe.id= classe_qcm.id_classe  INNER JOIN qcm ON qcm.id= classe_qcm.id_qcm WHERE qcm.id=:id_qcm ORDER BY classe.libelle';

		$params=[':id_qcm'=>$this->id];

		
		try
		{
			$db=self::getPDO();
			$query= $db->prepare($q);
			$query->execute($params);
			$query->setFetchMode(PDO::FETCH_CLASS, Classes::class);
			$classes=$query->fetchAll();

			if ($classes) 
			{
				$this->classes=$classes;
				return $classes;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}
	}

	public function select_qcm_publie(int $id_classe=null): ?array
	{
		$q='SELECT qcm.* FROM qcm INNER JOIN classe_qcm ON qcm.id= classe_qcm.id_qcm INNER JOIN classe ON classe.id= classe_qcm.id_classe WHERE qcm.id_professeur= :id_professeur';

		$params=[':id_professeur'=>(int)($_SESSION['user_id'])];

		if ($id_classe) 
		{
			$q.=' AND classe.id = :id_classe';
			$params['id_classe']=(int)($id_classe)	;	
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

	public function select_all_questions():?array
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('SELECT question.* FROM question INNER JOIN qcm_question ON question.id= qcm_question.id_question INNER JOIN qcm ON qcm.id= qcm_question.id_qcm  WHERE qcm.id= :id_qcm');

			$query->execute([
				':id_qcm'=>$this->id
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Question::class);
			$questions=$query->fetchAll();
			if ($questions) 
			{
				$this->questions=$questions;
				return $questions;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}
		
	}

	public function delete_qcm():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM qcm WHERE id=:id_qcm');
			$query->execute([
				':id_qcm'=>$this->id
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

	public function delete_qcm_question():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM qcm_question WHERE id_qcm=:id_qcm');
			$query->execute([
				':id_qcm'=>$this->id
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


	public function edit_qcm(): bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('UPDATE qcm SET id_theme=:id_theme, libelle=:libelle, echelle_not=:echelle_not, notation_vrai=:notation_vrai, notation_faux=:notation_faux, duree_test=:duree_test, cree_le=:cree_le, date_limite=:date_limite WHERE id=:id');
			$query->execute([
				':id_theme'=>$this->id_theme,
				':libelle'=>$this->libelle,
				':echelle_not'=>$this->echelle_not,
				':notation_vrai'=>$this->notation_vrai,
				':notation_faux'=>$this->notation_faux,
				':duree_test'=>$this->duree_test,
				':cree_le'=>$this->cree_le,
				':date_limite'=>$this->date_limite,
				':id'=>$this->id
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


	public function qcm_classe(int $id_classe): bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO classe_qcm (id_classe, id_qcm) VALUES (:id_classe, :id_qcm)');

			$query->execute([
				':id_qcm'=>$this->id,
				':id_classe'=>(int)($id_classe)
			]);

			return true;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
		}
	}

	public function delete_qcm_classe()
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM classe_qcm WHERE id_qcm=:id_qcm');
			$query->execute([
				':id_qcm'=>$this->id
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


	public function select_classe_qcm(int $id_classe)
	{

		try{

			$db=self::getPDO();

			$query= $db->prepare('SELECT * FROM classe_qcm WHERE id_qcm=:id_qcm AND id_classe=:id_classe');
			$query->execute([
				':id_qcm'=>$this->id,
				':id_classe'=>(int)$id_classe
			]);
			
			$qcm=$query->fetch();
			if (!$qcm) {
				return null;
			}
		
			return $qcm;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}

	}


	public function qcm_question(int $id_question): ?array
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('SELECT * FROM qcm_question WHERE  id_question=:id_question AND id_qcm= :id_qcm');

			$query->execute([
				':id_question'=>(int)($id_question),
				':id_qcm'=>$this->id
			]);
			$qcm_question=$query->fetch();
				
			if ($qcm_question) 
			{
				return $qcm_question;
			}

			return null;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
	}



}