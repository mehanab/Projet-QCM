<?php 
session_start();
require '../models/Autoloader.php';
Autoloader::register();
date_default_timezone_set ('Europe/Paris');


define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));

require ROOT.'core/Controller.php';
require ROOT.'core/Model.php';


// définir le paramètre GET s'il n'est pas défini 

if (!isset($_GET['p'])) 
{
	$_GET['p']= '';
}else{
	$_GET['p'] = str_replace('public/', '', $_GET['p']);
}

// Exploser le parametre GET pour définir le controller et l'action à appeler 
$params= explode('/', $_GET['p']);
$controller= strtolower($params[0])??'accueil';
$action = !empty($params[1])? $params[1]: strtolower($params[0]);


if ($controller == '') 
{
	$controller = 'accueil';
}

if ((($action=='')&& ($controller=='accueil')) || (($action =='accueil') && ($controller=='accueil'))) 
{
	$action = 'index';
}


// Controle d'acces 
if ($controller == 'admin' || $controller == 'eleve' || $controller=='professeur') 
{

	if (isset($_SESSION['statut']) && $_SESSION['statut']!= $controller) 
	{

			$controller='erreur';
			$action='forbidAccess';

	}elseif (!isset($_SESSION['statut'])) {


			if ($controller == 'professeur') 
			{

				$_SESSION['role']='professeur';

			}elseif($controller == 'admin'){ 

				$_SESSION['role']='admin';

			}else{

				$_SESSION['role']='eleve';
			}

		$controller='login';
		$action='login';
	}


} elseif ($controller == 'login') {

	if (isset($_SESSION['statut']) && $_SESSION['statut']== 'professeur') {
		$controller= 'professeur';
		$action='professeur';
	}elseif(isset($_SESSION['statut']) && $_SESSION['statut']== 'admin'){
		$controller= 'admin';
		$action='admin';
	}elseif (isset($_SESSION['statut']) && $_SESSION['statut']== 'eleve') {
		$controller= 'eleve';
		$action= 'eleve';
	}

}


//Inclure le fichie correspondant au controller 
if (file_exists('../controllers/'.$controller.'Controller.php')) {
	require '../controllers/'.$controller.'Controller.php';


}else{
	
	$controller='Erreur';
	$action='erreur404';
	require_once '../controllers/'.$controller.'Controller.php';

}

$controller= $controller.'Controller';
$controller = new $controller();


if (method_exists($controller, $action)) {
	
	unset($params[0]);
	unset($params[1]);

	call_user_func_array(array($controller, $action), $params);
	//$controller->$action();

}else{

	
	$controller='ErreurController';
	$action='erreur404';
	require_once '../controllers/'.$controller.'.php';
	$controller= new $controller();
	$controller->$action();

}


