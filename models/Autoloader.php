<?php
class Autoloader
{

	static function autoload($Class_name){

		require $Class_name.'.php';
	}

	static function register(){
		spl_autoload_register(array('Autoloader', 'autoload' ));
	}
}