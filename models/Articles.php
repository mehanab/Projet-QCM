<?php 


class Articles extends Model
{
	public $db;
	public $id;
	public $titre;
	public $article;
	public $ajoute_le;
	public $id_admin;
	public $total;
	public $count_pages;

	public function __construct(){
		if(!$this->db){
			$this->db = self::getPDO();
		}
	}

	public function verifyTitre(): bool
	{
		if (!preg_match('#^([a-zA-Z0-9çéè]+([a-zA-Z\çéè\-_|\s|0-9]){5,255})*$#', $this->titre)) {
			return false;
		}
		return true;
	}

	public function verifyArticle(): bool
	{
		if (strlen($this->article) > 10 ) 
		{
			return true;
		}
		return false;
	}


	public function selectArticle(): ?Articles
	{
		try{

			$db=$this->db;
			$query= $db->prepare('SELECT * FROM articles WHERE id=:id');
			$query->execute([':id'=>$this->id]);
			$query->setFetchMode(PDO::FETCH_CLASS, Articles::class);
			$article=$query->fetch();
			if ($article === false) 
			{
				return null;
			}
		
			return $article;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
	}

	public function selectAllArticles(int $offset=null): ?array
	{
		$q='SELECT * FROM articles ORDER BY articles.ajoute_le DESC';

		if ($offset) 
		{
			$q.=' LIMIT '.$offset.' OFFSET 0';
		}

		try{

			$db=$this->db;
			$query= $db->prepare($q);
			$query->execute();
			$query->setFetchMode(PDO::FETCH_CLASS, Articles::class);
			$article=$query->fetchAll();
			if ($article === false) 
			{
				return null;
			}
		
			return $article;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			/*var_dump($erreur);*/
			return null;
		}
	}


	public function editArticle()
	{
		try{

			$db=$this->db;
			$query= $db->prepare('UPDATE articles SET titre=:titre, article=:article WHERE id=:id');
			$query->execute([
				':id'=>(int)$this->id,
				':titre'=>$this->titre,
				':article'=>$this->article
			]);

			$req=$query->rowCount();
			
			return $req;

		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}

	}

	public function insertArticle(): ?int
	{
		try
		{
			$db=$this->db;
			$query= $db->prepare('INSERT INTO articles (titre, article, ajoute_le, id_admin) VALUES (:titre, :article, :ajoute_le, :id_admin)');

			$query->execute([
				':titre'=>$this->titre,
				':article'=>$this->article,
				':ajoute_le'=>$this->ajoute_le,
				':id_admin'=>$this->id_admin
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


	public function deleteArticle()
	{
		try{

			$db=$this->db;
			$query= $db->prepare('DELETE FROM articles WHERE id=:id');
			$query->execute([
				':id'=>$this->id
			]);
			$req=$query->rowCount();
			
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