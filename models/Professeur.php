<?php 

Class Professeur extends Personne {


	public $id_personne;
	public $statut= 'professeur';
	private const PER_PAGE= 3;


	public function __construct(Personne $personne= null)
	{
		
		if ($personne !== null)
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

	public function isProfesseur(): ?Professeur
	{

		$db=self::getPDO();
		$query= $db->prepare('SELECT * FROM professeur WHERE id_personne=:id');
		$query->execute([':id'=>$this->id_personne]);
		$query->setFetchMode(PDO::FETCH_CLASS, Professeur::class, [$this]);
		$professeur=$query->fetch();
		if ($professeur === false) {
			return null;
		}
	
		return $professeur;
	}

	public function selectProfesseurs(): ?array
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('SELECT * FROM professeur INNER JOIN personne ON personne.id=professeur.id_personne');
			$query->execute();
			$query->setFetchMode(PDO::FETCH_CLASS, Professeur::class);
			$professeur=$query->fetchAll();
			if ($professeur === false) {
				return null;
			}
		
			return $professeur;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
	}


	public function insertProfesseur(): bool
	{
		$db=self::getPDO();
		$query= $db->prepare('INSERT INTO professeur (id_personne, statut) VALUES (:id_personne, :statut)');
		$query->execute([
			':id_personne'=>$this->id_personne,
			':statut'=>$this->statut
		]);
		$req=$query->rowCount();
		if ($req == 0) {
			return false;
		}
		return true;
	
	}


	public function alterProfesseur():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('UPDATE professeur SET statut=:statut WHERE id_personne=:id_personne');
			$query->execute([
			':statut'=>$this->statut,
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

	public function deleteProfesseur():bool
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('DELETE FROM professeur WHERE id_personne=:id_personne');
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

	public function insertProfToClasse(int $id_classe): bool
	{
		try {
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO classe_professeur (id_professeur, id_classe) VALUES (:id_professeur, :id_classe)');
			$query->execute([
				':id_professeur'=>$this->id_personne,
				':id_classe'=>$id_classe
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

	public function selectClassesProfesseur(): ?array
	{
		try{

			$db=self::getPDO();
			$query= $db->prepare('SELECT classe.* FROM classe INNER JOIN classe_professeur ON classe.id=classe_professeur.id_classe INNER JOIN professeur ON classe_professeur.id_professeur=professeur.id_personne WHERE professeur.id_personne = :id_professeur');
			$query->execute([
				':id_professeur'=>$this->id_personne
			]);
			$query->setFetchMode(PDO::FETCH_CLASS, Classes::class);
			$classes=$query->fetchAll();
			if ($classes === false) {
				return null;
			}
		
			return $classes;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
	}


	public function select_questions_professeur(int $page=null): ?array
	{
		$pages=null;
		$q='SELECT  question.* FROM question WHERE question.id_professeur=:id_professeur';
		$queryCount= "SELECT COUNT('question.id') as count FROM question WHERE question.id_professeur=:id_professeur"; 
		$params['id_professeur']=$this->id_personne;

	
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
		$p=$page??1;
		$offset= ($p-1) * self::PER_PAGE;
		$q.=' LIMIT '.self::PER_PAGE.' OFFSET '.$offset;
		
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
					$question->total=$count;
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

	public function selectArticles(int $page=null): ?array 
	{
		$pages=null;
		$q='SELECT articles.* FROM articles WHERE articles.id_admin=:id_admin';
		$queryCount= "SELECT COUNT('articles.id') as count FROM articles WHERE articles.id_admin=:id_admin"; 
		$params['id_admin']=$this->id_personne;

	
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

		$q.=' ORDER BY articles.ajoute_le DESC';
		$p=$page??1;
		$offset= ($p-1) * self::PER_PAGE;
		$q.=' LIMIT '.self::PER_PAGE.' OFFSET '.$offset;
		
		try
		{
			$db=self::getPDO();
			$query= $db->prepare($q);
			$query->execute($params);
			$query->setFetchMode(PDO::FETCH_CLASS, Articles::class);
			$articles=$query->fetchAll();
			if ($articles) 
			{
				foreach ($articles as $article) 
				{
					$article->total=$count;
					$article->count_pages=(int)$pages;
				}
				
			}

			return $articles;
	
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
			
		}

	}

	
}