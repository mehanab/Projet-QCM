<?php 

class ErreurController extends controller {

	
	public function erreur404()
	{
		$this->render('erreur');
	}

	public function forbidAccess()
	{
		$this->render('forbidAccess');
	}
	
}