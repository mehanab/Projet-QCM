<?php 


/**
 * 
 */
class Theme extends Model
{
	public $id;
	public $libelle;



	public function select_all_themes(string $qcm=null)
	{
		$q='SELECT theme.*, count(question.id_theme) AS nombre_questions FROM theme LEFT JOIN question ON theme.id= question.id_theme GROUP BY theme.id;';

		if ($qcm && $qcm="qcm") 
		{
			$q='SELECT theme.*, count(qcm.id_theme) AS nombre_qcm FROM theme LEFT JOIN qcm ON theme.id= qcm.id_theme GROUP BY theme.id;';
		}

		try{

			$db=self::getPDO();

			$query= $db->prepare($q);
			$query->execute();
			$query->setFetchMode(PDO::FETCH_CLASS, Theme::class);
			$themes=$query->fetchAll();
			if (!$themes) {
				return false;
			}
		
			return $themes;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
			
		}
	}



	public function theme_exist(string $libelle=null)
	{
		$q='SELECT * FROM theme WHERE id=:id';
		$params=[':id'=>$this->id];
		if ($libelle) 
		{
			$q='SELECT * FROM theme WHERE libelle = :libelle';
			$params=[':libelle'=>$this->libelle];
		}
		try{

			$db=self::getPDO();
			$query= $db->prepare($q);
			$query->execute($params);
			$query->setFetchMode(PDO::FETCH_CLASS, Theme::class);
			$theme=$query->fetch();
			if (!$theme) {
				return false;
			}
		
			return $theme;
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return false;
			
		}
	}

	public function verify_theme_libelle():bool
	{
		if (!preg_match('#^([a-zA-Z0-9çéè]+([a-zA-Z\çéè\-_|\s|0-9]){5,255})*$#', $this->libelle)) {
			return false;
		}
		return true;
	}

	public function insert_theme():?int
	{
		try
		{
			$db=self::getPDO();
			$query= $db->prepare('INSERT INTO theme (libelle) VALUES (:libelle)');
			$query->execute([
				':libelle'=>$this->libelle, 
			]);
			$theme=$query->rowCount();
				
			if ($theme > 0) 
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




}