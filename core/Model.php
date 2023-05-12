<?php 


Class Model {

	public static $pdo;




// version PDO en cas où le serveur n'est pas connecté :
	public static function getPDO(): ?PDO 
	{

		try{

			if (!self::$pdo) {
			self::$pdo = new PDO("mysql:dbname=qcm;host=localhost", 'mehana', 'realmadrid', [
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