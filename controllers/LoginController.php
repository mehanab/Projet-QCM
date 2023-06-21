<?php 


Class LoginController extends Controller 
{

	public function login()
	{	
		$this->render('loginView');		
	}


	public function user(): void
	{
		
		if (isset($_POST['pseudo']) && isset($_POST['password'])) 
		{

			if (!empty($_POST['pseudo']) && !empty($_POST['password'])) 
			{		

				if (isset($_POST['eleve'])) 
				{

					$eleve=$this->getEleve($_POST['pseudo'], $_POST['password']);

					if (!$eleve) 
					{
						$this->set(['user'=>'eleve']);
						$this->login();
						exit();
					}
				
					session_start();
					$_SESSION['eleve']=(array)$eleve;
					$_SESSION['user_id']= $eleve->id_personne;
					$_SESSION['statut']=$eleve->statut;	
					
					header('Location: /eleve');
					exit();

				}elseif (isset($_POST['professeur'])|| isset($_POST['admin'])) {

					if (isset($_POST['professeur'])) 
					{
						$professeur=$this->getProfesseur($_POST['pseudo'], $_POST['password']);
						if (!$professeur) {
							$this->set(['user'=>'professeur']);
							$this->login();
							exit();
						}
						
					}else{
						
						if (file_exists(dirname(__DIR__).'/install.php')) 
						{
							require dirname(__DIR__).'/install.php';
						}

						$professeur=$this->getAdministrateur($_POST['pseudo'], $_POST['password']);
						if (!$professeur) {
							$this->set(['user'=>'professeur']);
							$this->login();
							exit();
						}
					}
					
					session_start();
					$_SESSION['professeur']=(array)$professeur;
					$_SESSION['user_id']= $professeur->id_personne;
					$_SESSION['statut']=$professeur->statut;
					if ($professeur->statut=== 'professeur') {
						header('Location: /professeur');
						exit();
					} elseif ($professeur->statut=== 'admin'){
						header('Location: /admin');
						exit();
					}		
				}
				
			}else{

				$this->set(['erreur'=>'Veuillez remplir les champs']);			
				$this->render('loginView');
			}
		}else{
			$this->render('loginView');
		}
	}



	private function getPersonne(string $pseudo, string $password): ?Personne
	{
		if ((strlen($pseudo) < 5) || (strlen($password) < 8)) 
		{	
			return null;
		}

		$personne = new Personne();
		$personne->setPseudo($pseudo);
		$personne->setMotDePasse($password);
		return $personne;		
	}

	


	private function getEleve(string $pseudo, string $password): ?Eleve 
	{

		$personne=$this->getPersonne($pseudo, $password);

		if ($personne=== null) 
		{
			$this->set(['erreur'=>'Pseudo ou mot de passe trop court']);
			return null;
		}

		$personne=$personne->personneLogin();

		if($personne===null){
			$this->set(['erreur'=>'Pseudo ou mot de passe erroné']);
			return null;
		}

		$eleve= new Eleve($personne);
		$eleve=$eleve->isEleve($personne);

		if ($eleve === null) {
			$this->set(['erreur'=>'identifiants erronés, Vous êtes peut-être professeur ?']);
			return null;
		}
		return $eleve;
	}




	private function getProfesseur(string $pseudo, string $password): ?Professeur 
	{

		$personne=$this->getPersonne($pseudo, $password);
		if ($personne=== null) {
			$this->set(['erreur'=>'Pseudo ou mot de passe trop court']);
			return null;
		}

		$personne=$personne->personneLogin();
		if($personne===null){
			$this->set(['erreur'=>'Pseudo ou mot de passe erroné']);
			return null;
		}

		$professeur= new Professeur($personne);
		$professeur=$professeur->isProfesseur($personne);
		if ($professeur === null || $professeur->statut != 'professeur') {
			$this->set(['erreur'=>'identifiants erronés, Vous êtes peut-être élève ?']);
			return null;
		}
		return $professeur;
	}



	private function getAdministrateur(string $pseudo, string $password): ?Professeur {

		$personne=$this->getPersonne($pseudo, $password);
		if ($personne=== null) {
			$this->set(['erreur'=>'Pseudo ou mot de passe trop court']);
			return null;
		}

		$personne=$personne->personneLogin();
		if($personne===null){
			$this->set(['erreur'=>'Pseudo ou mot de passe erroné']);
			return null;
		}

		$prof = new Professeur($personne);
		$admin = $prof->isProfesseur($personne);
		if ($admin === null || $admin->statut != 'admin') {
			$this->set(['erreur'=>'identifiants erronés, Vous êtes peut-être élève ?']);
			return null;
		}
		return $admin;
	}


	public function passCompte(): void 
	{
		$this->render('loginLost');

	}

	public function generatePassword(int $size):string 
	{
		$password='';
		$characters=[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "-","+", "!","*","$", "@", "%","_"];

		for($i=0; $i<$size; $i++)
	    {
	        $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
	    }
		
    	return $password;
	}



	public function reinitialisation(): void
	{
		if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['pseudo'])) 
		{
			if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['pseudo']))
			{
				$perso=new Personne();
				$perso->setPseudo(trim($_POST['pseudo']));
				$perso->setMail(trim($_POST['mail']));
				$perso->setNom(trim($_POST['nom']));
				$perso->setPrenom(trim($_POST['prenom']));
				
				$personne=$this->getPersonne($perso->getPseudo(), "passwordLost");
				if ($personne=== null) {
					$this->set(['erreur'=>'Le pseudo est trop court']);
					$this->passCompte();
					die();
				}

				$pseudo=$perso->verifyPseudo();
				if (!$pseudo) 
				{
					$this->set(['erreur'=>'Le pseudo est invalide']);
					$this->passCompte();
					die();	
				}

				$nomPrenom=$perso->verifyName();
				if(!$nomPrenom){
					$this->set(['erreur'=>'Le nom ou le prenom est incorrect!']);
					$this->passCompte();
					die();
				}

				$mail=$perso->verifyMail();
				if(!$mail){
					$this->set(['erreur'=>'Le mail est invalide !']);
					$this->passCompte();
					die();
				}

				$personne=$perso->isPersonne();
				if($personne===null){
					$this->set(['erreur'=>'Utilisateur introuvable !']);
					$this->passCompte();
					die();
				}

				if (strtolower($personne->getNom())===strtolower($perso->getNom()) && strtolower($personne->getPrenom())===strtolower($perso->getPrenom()) && strtolower($personne->getMail())===strtolower($perso->getMail())) 
				{

					$size=rand(8, 20);
					$password= $this->generatePassword($size);
					$personne->setPassword($password);
					$pass=$personne->verifyPassword();
					while ($pass==false) 
					{
						$size=rand(8, 20);
						$password= $this->generatePassword($size);
						$personne->setPassword($password);
						$pass=$personne->verifyPassword();	
					}

					$personne->setDateDeNaissance(strtotime($personne->getDateDeNaissance()));
					$update=$personne->alterPersonne();
					
					if($update)
					{
						// envoyer le mail;
						$mail= $personne->getMail();
						$text= 'Votre nouveau mot de passe pour accéder à votre espace personnel du site "Le QCM" est : <br/>'.$personne->getPassword().'<br/>'.
						 "\r\n" .'Veuillez changer votre mot de passe dès votre connexion.';
						$headers = 'From: webmaster@leqcm.com' . "\r\n" .
					     'Reply-To: webmaster@leqcm.com' . "\r\n" .
					     'X-Mailer: PHP/' . phpversion();
					    $headers .="Content-Transfer-Encoding: 8bit \n";
						$headers .="Content-type: text/html; charset=utf-8 \n";

	
						$rep=mail($mail, 'Réinitialisation de mot de passe', $text, $headers);
						if ($rep) 
						{
								$this->set(['succes'=>'Un mail comportant votre nouveau mot de passe vous a été envoyé à votre adresse mail !']);
								$this->passCompte();
								die();
						}
						
						$this->set(['erreur'=>'Une erreur imprévue est survenue!']);
						$this->passCompte();
						die();

					}
							
					$this->set(['erreur'=>'Une erreur imprévue est survenue!']);
					$this->passCompte();
					die();
				}
				
				$this->set(['erreur'=>'Utilisateur introuvable !']);
				$this->passCompte();
				die();

			}
			$this->set(['erreur'=>'Tous les champs sont obligatoire.']);
			$this->passCompte();
			die();
	
		}
		$this->passCompte();
	}

}