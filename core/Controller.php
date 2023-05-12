<?php 

Class Controller 
{

	
	public $tab=array();
	public $layout= 'default';

	public function set(array $data): void 
	{
		$this->tab = array_merge($this->tab, $data);
	}


	public function render(string $filename): void 
	{
		extract($this->tab);
		$class = substr(get_class($this),0,-10);
		ob_start();
		require ROOT.'views/'.strtolower($class.'/'.$filename.'.php');
		$content= ob_get_clean();
		
		if ($this->layout == false) {
			echo $content;
		}else{
			require ROOT.'views/layout/'.$this->layout.'.php';
		}
		
	}


	public function createPersonne(): ?Personne
	{
		if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['sexe']) && isset($_POST['date_de_naissance']) && isset($_POST['passwordConf']) && isset($_POST['mail']) && isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['numero_voie']) && isset($_POST['type_voie']) && isset($_POST['nom_voie']) && isset($_POST['complement_adresse']) && isset($_POST['ville']) && isset($_POST['code_postal'])) 
		{

			if (!empty($_POST['nom']) && !empty($_POST['prenom'])  && !empty($_POST['sexe']) && !empty($_POST['date_de_naissance']) && !empty($_POST['mail']) && !empty($_POST['pseudo']) && !empty($_POST['numero_voie']) && !empty($_POST['type_voie']) && !empty($_POST['nom_voie']) && !empty($_POST['ville']) && !empty($_POST['code_postal'])) 
			{

				$personne = new Personne(trim($_POST['prenom']), trim($_POST['nom']), trim($_POST['sexe']), strtotime($_POST['date_de_naissance']), trim($_POST['passwordConf']));

				$personne->completerPersonne(trim($_POST['mail']), trim($_POST['password']), trim($_POST['pseudo']), ['numero_voie'=>(int)(trim($_POST['numero_voie'])), 'type_voie'=>trim($_POST['type_voie']), 'nom_voie'=>trim($_POST['nom_voie']), 'complement_adresse'=>trim($_POST['complement_adresse']), 'ville'=>trim($_POST['ville']), 'code_postal'=>(int)($_POST['code_postal'])]);

				return $personne;

			}

			$this->set(['erreur' =>'Tous les champs doivent être remplit']);
			return null;
			die();

		}

		return null;
		die();
	}


	public function registerPersonne(Personne $personne, string $typePersonne)
	{
		$adresse= new Adresse($personne->adresse['numero_voie'], $personne->adresse['type_voie'], $personne->adresse['nom_voie'], $personne->adresse['complement_adresse'], $personne->adresse['ville'], $personne->adresse['code_postal']);

				$id_adresse=$adresse->getAdresseId();
				if (!$id_adresse) {
					$this->set(['erreur' =>'Erreur lors de l\'enregistrement de l\'adresse']);
					return false;
					die();
				}
				$personne->setIdAdresse($id_adresse);
				$personne->setCreeLe(date('Y-m-d H:i:s'));
				$personne->setDateDeNaissance(date('Y-m-d',$personne->getDateDeNaissance()));
				$idPersonne=$personne->insertPersonne();
				
				if (!$idPersonne) {
					$this->set(['erreur' =>'Erreur lors de l\'enregistrement']);
					return false;
					die();
				}

				$typePersonne= new $typePersonne($personne);
				$typePersonne->id_personne= $idPersonne;
				return $typePersonne;
	}



	public function verifyClasseExist(int $id_classe):?bool
	{			

			$classe= new Classes();
			$classe->setId($id_classe);

			if (!$classe->classeExist())
			{
				$this->set(['erreur' =>'La classe n\'existe pas']);
				return false;						
			}
	
			return true;
	}



	public function verifyPersonneExist(Personne $personne, string $typePersonne, int $classeId=null): ?bool
	{
		$personneExist=$personne->personneExist();
				
		if ($personneExist) {

				// Une ou des personnes portant le même nom, prenom et date de naissance sont déjà enregistrées dans la base de donnée. 
						
				// On crée un tableau d'Objet eleve/professeur avec les personnes de la BD.

				$arrayPersonneExist;
				foreach ($personneExist as $value) 
				{
					$arrayPersonneExist[]=new $typePersonne($value);
				}
	
				// On crée un Objet eleve/professeur avec la personne que veut ajouter l'admin.			
				$personneToAdd= new $typePersonne($personne);
							
				if ($typePersonne=='eleve' && $classeId) {
				// L'objet et un élève: 

					foreach ($arrayPersonneExist as $value) 
					{			
						$value->id_classe= $classeId;
					}
							
					$personneToAdd->id_classe= $classeId;
				}

					$_SESSION['personneExist']=(array)$arrayPersonneExist;
					$_SESSION['other']=(array)$personneToAdd;
					$this->set(['personneExist'=>$arrayPersonneExist, 'other'=>$personneToAdd]);
					return true;
		}
		return false;

	}
	
// verifivation des données envoyées sauf les mots de passes : 
	public function verifyData(Personne $personne, int $param=null) :?Personne
	{

				
				if (!$personne->verifyName()) {
						$this->set(['erreur' =>'Le nom ou le prenom est trop court ou contient des caractères non-autorisés']);
						return null;
						die();
					
				}

				if (!$personne->verifySexe()) {
						$this->set(['erreur' =>'Le sexe est invalide !']);
						return null;
						die();
					
				}

				if (!$personne->verifyBirthDay()) {
					$this->set(['erreur' =>'La date de naissance n\'est pas valide']);
						return null;
						die();
				}

				if(!$personne->verifyMail())
				{
						$this->set(['erreur' =>'L\'adresse mail doit être une adresse valide']);
						return null;
						die();

				}

				if (!$param) {

					if(!$personne->verifyPseudo())
					{
						$this->set(['erreur' =>'Le pseudo doit commencer par une lettre et doit contenir de 5 à 15 lettres et chiffres uniquement']);
						return null;
						die();

					}

					if (!$personne->verifyPseudoExist()) {
					$this->set(['erreur' =>'Ce pseudo est déjà utilisé, choisissez un autre !']);
						return null;
						die();
					}
					
				}

				if (!$personne->verifyAdresse()) {
					$this->set(['erreur' =>'L\'adresse n\'est pas valide']);
					return null;
					die();
				}

			return $personne;
			
	}

	public function verifyPasswords(Personne $personne): bool
	{

		if ($personne->getPassword() !== $personne->getMotDePasse()) {
			$this->set(['erreur' =>'Les deux mot de passe ne sont pas identiques']);
			return false;
			die();
		}

		if(!$personne->verifyPassword())
		{
			$this->set(['erreur' =>'Le mot de passe doit contenir :
						- de 8 à 15 caractères
						- au moins une lettre minuscule
						- au moins une lettre majuscule
						- au moins un chiffre
						- au moins un de ces caractères spéciaux: $ @ % * + - _ !']);
			return false;
			die();

		}
		return true;
	}


	public function verifyUser(string $typePersonne)
	{

		$type= $typePersonne;
		$classeId=null;
		if ($type=='eleve') {

			if (isset($_POST['id_classe']) && !empty($_POST['id_classe'])) 
			{
				$classeId=(int)($_POST['id_classe']);
				$idVerified=$this->verifyClasseExist($classeId);

				if (!$idVerified) {
					return false;
					die();
				}

			}else{

				$this->set(['erreur' =>'Tous les champs doivent être remplit']);
				return false;
			}
		}

		$personne= $this->createPersonne();
		if (!$personne) {
			return false;
			die();
		}

		$personne= $this->verifyData($personne);

		if (!$personne) {
			return false;
			die();
		}

		
		if (!empty($_POST['password']) && !empty($_POST['passwordConf'])) {

			$personne->setMotDePasse(trim($_POST['passwordConf']));
			$personne->setPassword(trim($_POST['password']));

			$verifyPassword= $this->verifyPasswords($personne);
			
			if (!$verifyPassword) {
				return false;
				die();
			}

		}else{

			$this->set(['erreur' =>'Tous les champs doivent être remplit']);
			return false;
			die();
		}

		if ($this->verifyPersonneExist($personne, $type, $classeId)) {
			return false;
			die();
		}

		$typePersonne= $this->registerPersonne($personne, $type);
				
		if (!$typePersonne) {
			return false;
			die();
		}

		if ($type=='eleve') {
		// L'objet renvoyé par registerPersonne est donc un élève: 
	
			$typePersonne->id_classe= $classeId;
		}

		return $typePersonne;
	}



}