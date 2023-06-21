<?php 


Class Model {
	public static $db_created;
	public static $pdo;

// version PDO en cas où le serveur n'est pas connecté :
	public static function getPDO(): ?PDO 
	{

		try{
			
			if(self::$db_created != true)
			{
				try {
					$dbco = new PDO("mysql:host=localhost", 'root', '');
					$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$lines_exec = $dbco->exec('CREATE DATABASE IF NOT EXISTS qcm');
					if ($lines_exec > 0) {
						// $dbco = new PDO("mysql:dbname=qcm;host=localhost", 'root', '');
						// $db_create = "CREATE TABLE articles ( id INT NOT NULL AUTO_INCREMENT , titre VARCHAR(255) NOT NULL , article TEXT NOT NULL , ajoute_le TIMESTAMP NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
						// $dbco->exec($db_create);
						self::$db_created = true;
					}
					else
					{
						self::$db_created = true;
					}
				} catch (Exception $e) {
					$erreur=$e->getMessage();
					//return null;
				}
			}

			if (!self::$pdo) {
			self::$pdo = new PDO("mysql:dbname=qcm;host=localhost", 'root', '', [
    		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			]);
			}
		 
			return self::$pdo;

			
		}catch(Exception $e){
			$erreur=$e->getMessage();
			return null;
		}
		
	}


// Version PDO original sans gestion d'erreur serveur: 
/*	public static function getPDO(): PDO 
	{
		if (!self::$pdo) {
			self::$pdo = new PDO("mysql:dbname=qcm;host=localhost", 'mehana', 'realmadrid', [
    		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			]);
		}
		 
		return self::$pdo;
	}*/

	public function verify_date(string $date)
	{
		$date=strtotime($date);
		$d=checkdate(date('m', $date), date('d', $date), date('Y', $date));
		if ($d) 
		{
			return true;
		}
		return false;
	}

   
}