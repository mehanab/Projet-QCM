<?php

Class AdminController extends Controller {



	public function admin(): void
	{
		$this->render('adminView');		
	}


	public function adminProfesseur(): void
	{
		$this->render('adminProfesseurView');	
	}


	public function adminEleve(): void
	{	
		$classes= new Classes(); 
		$classes= $classes->getAllClasses();
		$this->set(['classes'=> $classes]);
		$this->render('adminEleveView');	
	}


	public function monCompte():void 
	{
		if (isset($_SESSION['professeur']) && $_SESSION['professeur']['statut']== 'admin') 
		{
			$adresse= new Adresse();
			$adresse->setId((int)$_SESSION['professeur']['id_adresse']);
			$adresse=$adresse->getAllAdresses('id')[0];
			
			$this->set(['adresse'=>$adresse]);
			$this->render('adminMonCompte');
			die();
		}

		header('Location: /projetQCM/logout');
		exit();
	}


	public function confirmer_password():void 
	{
		if (isset($_SESSION['professeur']) && $_SESSION['professeur']['statut']== 'admin') 
		{
			if (isset($_POST['password']) && !empty($_POST['password'])) 
			{
				
				if (password_verify($_POST['password'] , $_SESSION['professeur']['password'])) 
				{
					$this->render('adminChangePassword');
					die();
				}

				$this->set(['erreur'=>'Mot de passe incorrect !']);
				$this->monCompte();
				die();
				
			}

			$this->monCompte();
			die();
		}

		header('Location: /projetQCM/logout');
		exit();
	}
	

	public function changer_password(): void 
	{
		if (isset($_SESSION['professeur']) && $_SESSION['professeur']['statut']== 'admin') 
		{
			if (isset($_POST['password']) && isset($_POST['confPassword']) && !empty($_POST['password']) && !empty($_POST['confPassword'])) 
			{
				if ($_POST['password'] === $_POST['confPassword']) 
				{
					$personne= new Personne();
					$personne->id=(int)$_SESSION['professeur']['id'];
					$personne->nom=$_SESSION['professeur']['nom'];
					$personne->prenom=$_SESSION['professeur']['prenom'];
					$personne->sexe=$_SESSION['professeur']['sexe'];
					$personne->pseudo=$_SESSION['professeur']['pseudo'];
					$personne->mail=$_SESSION['professeur']['mail'];
					$personne->date_de_naissance=strtotime($_SESSION['professeur']['date_de_naissance']);
					$personne->password= trim($_POST['password']);
					if ($personne->verifyPassword()) 
					{
						$modif=$personne->alterPersonne();
						if ($modif) 
						{
							$_SESSION['professeur']['password']=password_hash($personne->password, PASSWORD_DEFAULT);
							$this->set(['succes'=>'Le mot de passe à été modifié avec succès']);
							$this->monCompte();
							die();
							
						}

						$this->set(['erreur'=>'Une erreur s\'est produite lors de la modifiation !']);
						$this->render('adminChangePassword');
						die();
						
					}
					
					$this->set(['erreur'=>'Le mot de passe doit être composé de 8 à 15 caractère: au moins une lettre majuscule, une minuscule, un chiffre, et un des caractère suivant:  $ @ % * + - _ !']);
					$this->render('adminChangePassword');
					die();
					
				}
				
				$this->set(['erreur'=>'Les deux mots de passe ne sont pas identiques']);
				$this->render('adminChangePassword');
				die();
			}

			$this->monCompte();
			die();

		}

		header('Location: /projetQCM/logout');
		exit();
	}


	public function adminAddProfesseur(): void
	{
		$professeur=$this->verifyUser('professeur');

		if ($professeur=== false) {
			$this->adminProfesseur();
			die();
		}

		//ajouter le professeur dans la base	
		$professeur=$professeur->insertProfesseur();
		if ($professeur) {
			$this->set(['succes'=>'Le professeur à été ajouté avec succès']);
			$this->adminProfesseur();
			die();
		}else{
			$this->set(['erreur'=>'Echec lors de l\'inscription']);
			$this->adminProfesseur();
			die();	
		}
				
	}


	public function adminAddEleve(): void
	{

		$eleve=$this->verifyUser('eleve');

		if ($eleve=== false) {
			$this->adminEleve();
			die();
		}
			
		//ajouter l'élève dans la base	
		$eleve=$eleve->insertEleve();
		if ($eleve) {
			$this->set(['succes'=>'L\'élève à été ajouté avec succès']);
			$this->adminEleve();
			die();
		}else{
			$this->set(['erreur'=>'Echec lors de l\'inscription']);
			$this->adminEleve();
			die();	
		}
				
	}

	public function addPersonneExist(){
		if (isset($_POST['id_personne']) && isset($_POST['id_classe'])) {
			// L'objet envoyé est un élève : 
				$eleve =new Eleve();

				$eleve->id_personne = (int)$_POST['id_personne'];
				$eleve->id_classe = (int)$_POST['id_classe'];

				$eleveExist=$eleve->isEleve();

				if ($eleveExist) 
				{
					//l'élève est une personne déjà inscrite comme élève: 
					$this->set(['erreur'=>'Enregistrement impossible car cette personne est déjà enregistré comme élève']);
					$this->adminEleve();				
					die();

				}else{
					
					// L'élève est une personne non enregistré comme élève
					$eleve=$eleve->insertEleve();
					if ($eleve) 
					{
						$this->set(['succes'=>'L\'élève à été ajouté avec succès']);
						$this->adminEleve();
						die();
					}

					$this->set(['erreur'=>'Echec lors de l\'inscription']);
					$this->adminEleve();
					die();	
				}
				
		} elseif (isset($_POST['id_personne'])) {

			//L'objet en session est un professeur :
				$professeur = new Professeur();

				$professeur->id_personne = (int)(int)$_POST['id_personne'];
				$professeurExist=$professeur->isProfesseur();

				if ($professeurExist) 
				{

					/*L'objet est une personne déjà inscrite comme professeur: */
					$this->set(['erreur'=>'Enregistrement impossible car cette personne est déjà enregistré comme professeur']);
					$this->adminProfesseur();				
					die();

				}else{

					// L'objet est une personne non enregistré comme élève
					$professeur=$professeur->insertProfesseur();
					if ($professeur) 
					{
						$this->set(['succes'=>'Le professeur à été ajouté avec succès']);
						$this->adminProfesseur();
						die();
					}

					$this->set(['erreur'=>'Echec lors de l\'inscription']);
					$this->adminProfesseur();
					die();	
				}
			
		}else{
	
				$this->admin();		
		}
	}



	public function addPersonneOther():void
	{
	
		$typePersonne= 'eleve';

		if (isset($_SESSION['other'])) {
			$personne = new Personne($_SESSION['other']['prenom'], $_SESSION['other']['nom'], $_SESSION['other']['sexe'], $_SESSION['other']['date_de_naissance'], $_SESSION['other']['password']);

			$personne->completerPersonne($_SESSION['other']['mail'], $_SESSION['other']['password'], $_SESSION['other']['pseudo'], $_SESSION['other']['adresse']);


			if (isset($_SESSION['other']['statut']) && $_SESSION['other']['statut']== 'professeur')
			{

				$typePersonne= 'professeur';
			}
	
			$typePersonne=$this->registerPersonne($personne, $typePersonne);
			
			if ($_SESSION['other']['statut']== 'eleve') {

				$typePersonne->id_classe=$_SESSION['other']['id_classe'];
				$typePersonne=$typePersonne->insertEleve();

				if ($typePersonne) 
				{
					$this->set(['succes'=>'L\'élève à été ajouté avec succès']);
				}else{
					$this->set(['erreur'=>'Echec lors de l\'inscription']);
				}

					
				$this->adminEleve();
				unset($_SESSION['other']);
				die();	

			} elseif ($_SESSION['other']['statut']== 'professeur') {

				$typePersonne=$typePersonne->insertProfesseur();

				if ($typePersonne) 
				{
					$this->set(['succes'=>'Le professeur à été ajouté avec succès']);
				}else{
					$this->set(['erreur'=>'Echec lors de l\'inscription']);
				}

				$this->adminProfesseur();
				unset($_SESSION['other']);
				die();	
				
			}else{

				if (isset($_SESSION['other']['statut']) && $_SESSION['other']['statut']== 'professeur') 
				{
					$this->adminProfesseur();
					unset($_SESSION['other']);
					die();	
				}

				$this->adminEleve();
				unset($_SESSION['other']);
				die();	

			}
			
		}

		$this->admin();

	}

	public function ask_queryCount(string $table, string $condition=null, array $parametre=null): array
	{
		$personne= new Personne();
		if ($condition && $parametre) {
			$pages=$personne->queryCount($table, $condition, $parametre);
		}else{
			$pages=$personne->queryCount($table);
		}
		return $pages;

	}


	private function list(string $parametre=null, string $p=null, int $code=null): array
	{
		
		$page=1;
		if (isset($p) && $p!=null) 
		{
			$page=(int)($p);
		}

		$params=[];
		$table= "personne";
		$condition= " WHERE nom LIKE :param OR prenom LIKE :param";
		$params[':param']= '%'.$parametre.'%';
		$jointure= " INNER JOIN adresse ON adresse.id = personne.id_adresse";
		
		if ($code == 2) 
		{

			$jointure.=" INNER JOIN eleve ON personne.id = eleve.id_personne INNER JOIN classe ON eleve.id_classe = classe.id";

		}elseif ($code == 3) {

			$jointure.=" INNER JOIN professeur ON personne.id = professeur.id_personne";
		}
		
		$personne= new Personne();
		
		if ($parametre != null AND $parametre != 1) {
			$jointure.= $condition;
			$pages=$this->ask_queryCount($table, $jointure, $params);
			$users=$personne->selectAll($page, $table, $jointure, $params);
			
		}else{
			
			$pages=$this->ask_queryCount($table, $jointure, $params);
			$users=$personne->selectAll($page, $table, $jointure, $params);
		}

		if ($pages) {
			$users['pages']=$pages;
		}
		return $users;

	}

	public function listEleves(string $parametre=null, string $p=null)
	{
		$users=$this->list($parametre, $p, 2);
		echo json_encode($users);

	}

	public function listProfesseurs(string $parametre=null, string $p=null)
	{
		$users=$this->list($parametre, $p, 3);
		echo json_encode($users);

	}

	public function listUsers(string $parametre=null, string $p=null)
	{
		$users=$this->list($parametre, $p);
		echo json_encode($users);
	}



	public function alterUser(string $pseudo): void
	{
		$classes= new Classes(); 
		$classes= $classes->getAllClasses();
		
		$personne= new Personne();
		$personne->setPseudo($pseudo);	
		$p=$personne->isPersonne();
			
		if (!$p) {
			$this->admin();
			exit();	
		}

		$_SESSION['pseudo']=$pseudo;
		$_SESSION['password']=$p->password;
		$_SESSION['id']=$p->id;
		$_SESSION['id_adresse']=$p->id_adresse;

		$adresse= new Adresse();
		$adresses=$adresse->getAllAdresses();
		foreach ($adresses as $adresse) {
			if ($p->id_adresse == $adresse->getId()) {
				$p->adresse=['numero_voie'=>$adresse->getNumeroVoie(), 'type_voie'=>$adresse->getTypeVoie(),'nom_voie'=>$adresse->getNomVoie(),'complement_adresse'=>$adresse->getComplementAdresse(), 'ville'=>$adresse->getVille(), 'code_postal'=>$adresse->getCodePostal()];
			}	
		}
		
		$eleve= new Eleve($p);
		$e=$eleve->isEleve();
		$isEleve="checked";
		$professeur= new Professeur($p);
		$prof= $professeur->isProfesseur();

		if ($prof && $prof->statut=='admin') {
				$isProfesseur="";
				$isAdmin="checked";

		}elseif($prof && $prof->statut=='professeur'){
				$isProfesseur="checked";
				$isAdmin="";
		}else{
				$isProfesseur="";
				$isAdmin="";
				if (!$prof) {
					$prof=$p;
				}		
		}

		if (!$e) {
			$isEleve="";
			$this->set(['personne'=>$prof, 'isEleve'=>$isEleve, 'isProfesseur'=>$isProfesseur, 'isAdmin'=>$isAdmin]);
			$this->render('adminAlterUser');
			exit();
		}
		
		$this->set(['classes'=> $classes, 'personne'=>$e, 'isEleve'=>$isEleve, 'isProfesseur'=>$isProfesseur, 'isAdmin'=>$isAdmin]);
		$this->render('adminAlterUser');
		/*echo json_encode($e);*/
	}




	public function validateAlterUser(): void
	{
		$p=new Personne();
		$classes= new Classes(); 
		$classes= $classes->getAllClasses();
		$classeId=null;
		$type=null;
		$isProfesseur='';
		$isAdmin='';
		$isEleve='';
		$isNoOne='';

			if (isset($_POST['statutEleve']) && $_POST['statutEleve']=='eleve' ) 
			{
				$isEleve='checked';
				$p=new Eleve($p);
				$p->id_classe=$_POST['id_classe'] ?? null;

			}else{
				
				$p=new Professeur($p);
				$classes=null;
			}

			if (isset($_POST['statut'])) 
			{
				
				if ($_POST['statut']=='admin') {
					$isAdmin='checked';
				}elseif($_POST['statut']=='professeur'){
					$isProfesseur='checked';

				}else{

					$isProfesseur='';
					$isAdmin='';
					$isNoOne='checked';
				}
			
			}

		if (isset($_SESSION['id']) && isset($_SESSION['id_adresse']) && isset($_SESSION['pseudo']) && isset($_SESSION['password'])) 
		{
	
				
			$personneCreated= $this->createPersonne();

			if ($personneCreated) 
			{
				$personneCreated->setId($_SESSION['id']);
				$personneCreated->setIdAdresse($_SESSION['id_adresse']);

				if ($personneCreated->pseudo == $_SESSION['pseudo']) {
					$personne= $this->verifyData($personneCreated, 1);
				}else{
					$personne= $this->verifyData($personneCreated);
				}
				
				if ($personne) 
				{

					if ($personne->mot_de_passe !== $_SESSION['password'] || $personne->password !== $_SESSION['password']) 
					{

						$pswd=$this->verifyPasswords($personne);

						if (!$pswd) {

							$this->set(['classes'=> $classes, 'personne'=>$p, 'isEleve'=>$isEleve, 'isProfesseur'=> $isProfesseur, 'isAdmin'=>$isAdmin, 'isNoOne'=>$isNoOne]);
							$this->render('adminAlterUser');
							die();	
						}

					}else{

						$personne->password=null;
						$personne->mot_de_passe=null;
					}

					$personne->alterPersonne();// alter personne
						
					$adresse= new Adresse((int)($personne->adresse['numero_voie']), $personne->adresse['type_voie'], $personne->adresse['nom_voie'], $personne->adresse['complement_adresse'], $personne->adresse['ville'], (int)($personne->adresse['code_postal']));
					$adresse->setId((int)($personne->id_adresse));
					$adresse->alterAdresse();

								if (isset($_POST['statutEleve']) && $_POST['statutEleve']=='eleve' ) 
								{

									$e=new Eleve($personne);

									if (isset($_POST['id_classe'])) 
									{

										$classe=$this->verifyClasseExist((int)($_POST['id_classe']));
										if ($classe) {

											$e->id_classe=(int)($_POST['id_classe']);
											$estEleve= $e->isEleve();

											if ($estEleve) {
												$e->alterEleve();
											}else{
												$e->insertEleve();
											}


												$p = new Professeur($personne);
												if (!empty($isAdmin)) {
													$p->statut='admin';
												}
												
												$estProfesseur= $p->isProfesseur();
												
												if ($isProfesseur != '' || $isAdmin != '') 
												{

													if ($estProfesseur) {
														$p->alterProfesseur();//alter professeur
													}else{

														$p->insertProfesseur();// ajouter professeur
													}
												

												}else{

													if ($estProfesseur) {
														$p->deleteProfesseur();// supprimer le professeur
													}
												
												}

												$this->set(['classes'=> $classes, 'personne'=>$p, 'isEleve'=>$isEleve, 'isProfesseur'=> $isProfesseur, 'isAdmin'=>$isAdmin, 'isNoOne'=>$isNoOne, 'succes'=>'L\'utilisateur a été modifié avec succes !']);
												$this->render('adminAlterUser');
												die();
												
		
										}else{

										$this->set(['classes'=> $classes, 'personne'=>$p, 'isEleve'=>$isEleve, 'isProfesseur'=> $isProfesseur, 'isAdmin'=>$isAdmin, 'isNoOne'=>$isNoOne ,'erreur'=>'Vueillez choisir une classe']);
										$this->render('adminAlterUser');
											die();	
										}

									}else{

									$this->set(['classes'=> $classes, 'personne'=>$p, 'isEleve'=>$isEleve, 'isProfesseur'=> $isProfesseur, 'isAdmin'=>$isAdmin, 'isNoOne'=>$isNoOne ,'erreur'=>'Vueillez choisir une classe']);
									$this->render('adminAlterUser');
										die();
									}


								}else{

									$p = new Professeur($personne);
									if (!empty($isAdmin)) {
										$p->statut='admin';
									}

									$e=new Eleve($personne);
									$estEleve=$e->isEleve(); 

									if ($estEleve) 
									{
										$e->deleteEleve();// supprimer l'eleve...
									}

									$estProfesseur=$p->isProfesseur();
									if ($estProfesseur) 
									{
										if ($isNoOne !='') {
											$p->deleteProfesseur();
										}else{
											$p->alterProfesseur();// alter professeur
										}
										
									}else{
										if ($isNoOne=='') 
										{
											$p->insertProfesseur();// inserer Professeur
										}	
									}

									$this->set(['classes'=> $classes, 'personne'=>$p, 'isEleve'=>$isEleve, 'isProfesseur'=> $isProfesseur, 'isAdmin'=>$isAdmin, 'isNoOne'=>$isNoOne, 'succes'=>'L\'utilisateur a été modifié avec succes !']);
									$this->render('adminAlterUser');
									die();
								}			
					/*}*/
				
				}else{

					$this->set(['classes'=> $classes, 'personne'=>$p, 'isEleve'=>$isEleve, 'isProfesseur'=> $isProfesseur, 'isAdmin'=>$isAdmin, 'isNoOne'=>$isNoOne]);
					$this->render('adminAlterUser');
					die();
					

				}

			}else{
				$this->set(['classes'=> $classes, 'personne'=>$p, 'isEleve'=>$isEleve, 'isProfesseur'=> $isProfesseur, 'isAdmin'=>$isAdmin, 'isNoOne'=>$isNoOne,'erreur'=>'Tous les champs doivent être remplit']);
				$this->render('adminAlterUser');
				die();
			}

		}else{
			$this->render('adminAlterUser');
			die();

		}	

	}


	public function deleteUser(string $pseudo): void
	{
		$a=[];
		$personne=new Personne();
		$personne->setPseudo($pseudo);
		$p=$personne->isPersonne();
		if ($p) {
			$rep=$p->deletePersonne();
			if ($rep==true) {
				$a['true']=true;
			}
		}
		echo json_encode($a);
	}


	public function getNiveaux(string $id_niveaux= null): void
	{
		$niveau= new Niveaux();
		$niveaux=$niveau->getNiveaux();
		if ($niveaux) {

			$classe = new Classes();
			foreach ($niveaux as $niveau) {
				
				$tab_niveaux[$niveau->id]=$classe->getAllClasses($niveau->id);
				$libelle[$niveau->id]=$niveau->libelle;

			}
			$this->set(['niveaux'=>$niveaux, 'tab_niveaux'=>$tab_niveaux, 'libelle'=>$libelle]);
			$this->render('adminClasses');
			die();
		}

		$this->set([/*'erreur'=>'oups, une erreur s\'est produite !'*/'niveaux'=>'', 'tab_niveaux'=>'', 'libelle'=>'']);
		$this->render('adminClasses');
	}

	public function addNiveau(): void
	{
		if (isset($_POST['libelle']) && !empty($_POST['libelle'])) {
			$niveau=new Niveaux();
			$niveau->libelle=trim($_POST['libelle']);
			if ($niveau->verifyLibelle()) 
			{
				$insert=$niveau->insertNiveau();
				if ($insert) {
					$_POST['libelle']=null;
					$this->set(['succesForms'=>'Le niveau à été ajouté avec succès']);
					$this->getNiveaux();
					die();
				}
				$this->set(['erreurForms'=>'Erreur lors de l\'insertion']);
				$this->getNiveaux();
				
			}
			$this->set(['erreurForms'=>'Le libellé est trop court ou contient des caractères invalides !']);
			$this->getNiveaux();
		}
		$this->set(['erreurForms'=>'Veuillez remplir le formulaire !']);
		$this->getNiveaux();

	}

	public function deleteNiveau(): void
	{
		if (isset($_POST['id']) && !empty($_POST['id'])) 
		{
			$niveau=new Niveaux();
			$niveau->id=(int)(trim($_POST['id']));
			
			$delete=$niveau->deleteNiveau();
				if ($delete) {
					$this->set(['succesForms'=>'Le niveau à été supprimé avec succès']);
					$this->getNiveaux();
					die();
				}
				$this->set(['erreurForms'=>'Erreur lors de la suppression']);
				$this->getNiveaux();
				
		}
		$this->set(['erreurForms'=>'Veuillez selectionner un niveau !']);
		$this->getNiveaux();

	}

	public function addClasse(string $id_niveau=null): void
	{
		if (isset($id_niveau) && (isset($_POST['nomClasse']) && !empty($_POST['nomClasse']))) 
		{
			$classe= new Classes($_POST['nomClasse'], (int)($id_niveau));
			$c=$classe->verifyLibelleClasse();
			if ($c) {
				$insert=$classe->insertClasse();
				if ($insert) {
					$_POST['nomClasse']=null;
					$this->set(['succesForms'=>'La classe à été ajouté avec succès', 'classIdNiveau'=>$id_niveau]);
					$this->getNiveaux();
					die();
					
				}
				$this->set(['erreurForms'=>'Erreur lors de l\'insertion', 'classIdNiveau'=>$id_niveau]);
				$this->getNiveaux();
				die();
			}
			$this->set(['erreurForms'=>'Le libellé est trop court ou contient des caractères invalides !', 'classIdNiveau'=>$id_niveau]);
			$this->getNiveaux();
			die();
		}

		$this->set(['erreurForms'=>'Le champs ne doit pas être vide', 'classIdNiveau'=>$id_niveau]);
		$this->getNiveaux();
			die();
	}


	public function alterClasse(string $id_niveau=null): void
	{

		if (isset($id_niveau) && isset($_POST['idClasseAlter']) && isset($_POST['niveauAlter'])) 
		{
			$classe= new Classes();
			$classe->setId((int)($_POST['idClasseAlter']));
			$classe->setIdNiveau((int)($_POST['niveauAlter']));

			if (isset($_POST['classeName']) && !empty($_POST['classeName']))
			{
				$classe->setLibelle($_POST['classeName']);
				$c=$classe->verifyLibelleClasse();
				if (!$c) 
				{
					$this->set(['erreurForms'=>'Le libellé est trop court ou contient des caractères invalides !', 'classIdNiveau'=>$id_niveau]);
					$this->getNiveaux();
					die();
					
				}
			}
			$c= $classe->classeExist();
			if ($c) 
			{
			
				$alter=$classe->alterClasse();
				if ($alter) 
				{
					$this->set(['succesForms'=>'La classe à été modifié avec succès', 'classIdNiveau'=>$id_niveau]);
					$this->getNiveaux();
					die();
					
				}

				$this->set(['erreurForms'=>'Erreur lors de la modification', 'classIdNiveau'=>$id_niveau]);
				$this->getNiveaux();
				die();
				
			}
			$this->set(['erreurForms'=>'La classe est introuvable !', 'classIdNiveau'=>$id_niveau]);
			$this->getNiveaux();
			die();
		}

		$this->set(['erreurForms'=>'Veillez selectionner la classe et le niveau', 'classIdNiveau'=>$id_niveau]);
		$this->getNiveaux();
			die();
	}



	public function deleteClasse(string $id_niveau): void
	{
		if (isset($id_niveau)) 
		{
			if (isset($_POST['classeId']) && !empty($_POST['classeId'])) 
			{
				$classe=new Classes();
				$classe->id=(int)($_POST['classeId']);
				$c=$classe->classeExist();
				if ($c) 
				{
					$delete=$c->deleteClasse();
					if ($delete) {
						$_POST['classeId']=null;
						$this->set(['succesForms'=>'Le classe à été supprimé avec succès', 'classIdNiveau'=>$id_niveau]);
						$this->getNiveaux();
						die();
					}
					$this->set(['erreurForms'=>'Erreur lors de la suppression', 'classIdNiveau'=>$id_niveau]);
					$this->getNiveaux();
					die();		
				}
				$this->set(['erreurForms'=>'La classe est introuvable !', 'classIdNiveau'=>$id_niveau]);
				$this->getNiveaux();
					
				}

		$this->set(['erreurForms'=>'Veuillez selectionner un niveau !', 'classIdNiveau'=>$id_niveau]);
		$this->getNiveaux();
			
		}

		$this->set(['erreurForms'=>'Une erreur est survenue !']);
		$this->getNiveaux();
		
	}


	public function getDetailsClasse(string $idClasse): void 
	{
		if (isset($idClasse)) 
		{
			$id=(int)($idClasse);
			$classe = new Classes();
			$classe->setId($id);
			$c=$classe->classeExist();
			if ($c) {

				$professeur=new Professeur();
				$allProfesseurs=$professeur->selectProfesseurs();

				if ($allProfesseurs) {

						$n=null;
						$niveau=new Niveaux();
						$niv=$niveau->getNiveaux($c->getIdNiveau());
						if ($niv) {
							$n=$niv;
						}
						$eleves=$c->getElevesClasse();
						$professeurs=$c->getProfesseursClasse();
						$this->set(['detailsClasse'=>$c, 'eleves'=>$eleves, 'professeurs'=>$professeurs, 'niv'=>$n, 'allProfesseurs'=>$allProfesseurs]);
						$this->render('adminClasses');
						die();		
				}
				$this->set(['erreur'=>'Une erreur imprévue est survenue !']);
				$this->getNiveaux();
				die();
			
			}

			$this->set(['erreur'=>'Impossible de trouver la classe!']);
			$this->getNiveaux();
			die();	
		}
		$this->set(['erreur'=>'Impossible de trouver la classe!']);
		$this->getNiveaux();
	}


	public function addProfClasse(string $idClasse): void 
	{
		if (isset($idClasse)) 
		{
			$id=(int)($idClasse);
			$classe = new Classes();
			$classe->setId($id);
			$c=$classe->classeExist();
			if ($c) {
				if (isset($_POST['professeurId'])) {
					$personne=new Personne();
					$pers=$personne->isPersonne((int)($_POST['professeurId']));
					
					if ($pers) 
					{
						$prof=new Professeur($pers);
						$p=$prof->isProfesseur();
						if ($p) 
						{
							$insert= $p->insertProfToClasse($c->getId());
							if ($insert) 
							{
								$this->set(['succesForms'=>'Le professeur a été ajouté avec succès à cette classe !']);
								$this->getDetailsClasse($idClasse);
								die();	
							}

							$this->set(['erreurForms'=>'Le professeur n\'a pas été ajouté! une erreur imprévue est survenue']);
							$this->getDetailsClasse($idClasse);
							die();
						}
						$this->set(['erreurForms'=>'Impossible de trouver le professeur!']);
						$this->getDetailsClasse($idClasse);
						die();
						
					}

					$this->set(['erreurForms'=>'Impossible de trouver le professeur!']);
					$this->getDetailsClasse($idClasse);
					die();
					
					
				}
				$this->set(['erreurForms'=>'Veuillez selectionnez un professeur!']);
				$this->getDetailsClasse($idClasse);
				die();
				
			}
			$this->set(['erreurForms'=>'Impossible de trouver la classe!']);
			$this->getDetailsClasse($idClasse);
			die();
				
		}
		$this->set(['erreur'=>'Impossible de trouver la classe!']);
		$this->getNiveaux();
	}


	public function listQcm(string $theme_libelle=null): void 
	{
		$all_qcm=[];
		$theme=new Theme();
		$qcm=new Qcm();

		if ($theme_libelle) 
		{
			$theme->libelle=trim($theme_libelle);
			$themeExist=$theme->theme_exist($theme->libelle);
			if ($themeExist) 
			{
				$all_qcm=$qcm->select_all_qcm((int)($themeExist->id));
				
				$this->set(['qcm'=>$all_qcm]);
				$this->render('adminQcm');
				die();
			}

			$this->set(['erreur'=>'Le thème est introuvable']);
			$this->listQcm();
			die();

			
		}else{

			$themes=$theme->select_all_themes("qcm");
			$this->set(['themes'=>$themes]);
			$this->render('adminSelectTheme');
		}
	}

	public function detail_qcm(string $id_qcm=null): void 
	{
		if ($id_qcm) 
		{
			$qcm=new Qcm(); 
			$qcm->id=(int)($id_qcm);
			$qcmExist=$qcm->qcmExist();
			if ($qcmExist) 
			{
				$qcm=$qcmExist;
				$theme= new Theme();
				$theme->id=(int)($qcm->id_theme);
				$thme= $theme->theme_exist();
				if ($thme) 
				{
					$qcm->theme=$thme->libelle;
				}

				$questions=$qcm->select_all_questions();
				if ($questions) 
				{
					foreach ($qcm->questions as $question) 
					{
						$reponses=$question->select_all_responses();
								
					}
				}
						
				$qcm->minute=(($qcm->duree_test/60) - intval($qcm->duree_test/60))*60;
				$qcm->heure=((intval($qcm->duree_test/60)/24)-intval(intval($qcm->duree_test/60)/24))*24;
				$qcm->jour=intval(intval($qcm->duree_test/60)/24);

				$this->set(['qcm'=>$qcm]);
				$this->render('adminDetailQcm');
				die();
				
			}

			$this->set(['erreur'=>'Le QCM est introuvable']);
			$this->listQcm();
			die();

		}

	$this->set(['erreur'=>'Le QCM est introuvable']);
	$this->listQcm();
	die();
		
	}

	public function deleteQcm():void
	{
		if (isset($_POST['id_qcm']) && !empty($_POST['id_qcm'])) 
		{
			foreach ($_POST['id_qcm'] as $id_qcm) 
			{
				$qcm= new Qcm();
				$qcm->id=(int)$id_qcm;
				$qcmExist=$qcm->qcmExist();
				if ($qcmExist) 
				{
					$theme= new Theme();
					$theme->id=(int)($qcmExist->id_theme);
					$thme= $theme->theme_exist();
					if ($thme) 
					{
						$qcmExist->theme=$thme->libelle;
					}

					$delete=$qcmExist->delete_qcm();
					if (!$delete) 
					{
						$this->set(['erreur'=>'Impossible de supprimer le QCM : Le QCM est introuvable']);
						if ($qcmExist->theme) 
						{
							$this->listQcm($qcmExist->theme);
							die();
						}
						$this->listQcm();
						die();
					}

				}

			}

			$this->set(['succes'=>'Le QCM à été supprimé avec succès !']);
			if ($qcmExist->theme) 
			{
				$this->listQcm($qcmExist->theme);
				die();
			}
			$this->listQcm();
			die();

		}else{

			$this->listQcm();
			die();
		}
	}



	public function articles(string $page=null): void 
	{
	
		if ((isset($_SESSION['statut']) && $_SESSION['statut'] == 'admin') && isset($_SESSION['user_id'])) 
		{
			$adm= new Professeur();
			$adm->id_personne = (int)($_SESSION['user_id']);
			$admin= $adm->isProfesseur();
			if ($admin && ($admin->statut == 'admin'))
			{
				$admin->id_personne =(int)($_SESSION['user_id']);
				$p=!empty($page)? (int)$page: 1;
				$articles=$admin->selectArticles($p);
				$this->set(['articles'=>$articles, 'page'=>$p]);
				$this->render('adminArticles');
				die();
				
			}

			header('Location: /projetQCM/logout');
			exit();
		}

		header('Location: /projetQCM/logout');
		exit();
	}



	public function detail_article(string $id_article): void 
	{
		if ((isset($_SESSION['statut']) && $_SESSION['statut'] == 'admin') && isset($_SESSION['user_id'])) 
		{
			if ($id_article) 
			{
				$article= new Articles();
				$article->id= (int)($id_article);
				$art= $article->selectArticle();
				if ($art) 
				{
					$this->set(["article"=>$art]);
					$this->render('adminDetailArticle');
					die();	
				}

				$this->set(["erreur"=>"Article introuvable"]);
				$this->articles();
				die();
				
			}

			$this->set(["erreur"=>"Article introuvable"]);
			$this->articles();
			die();
		}

		header('Location: /projetQCM/logout');
		exit();
	}


	public function nouvel_article(): void 
	{
		$this->render('adminNouvelArticle');
		die();

	}

	private function verification_article(): ?Articles
	{

			if (isset($_POST['titre']) && isset($_POST['article']) && !empty($_POST['titre']) && !empty($_POST['article']) ) 
			{
				$art= new Articles();
				$art->titre=trim($_POST['titre']);
				$art->article=trim($_POST['article']);
				$art->id_admin=(int)$_SESSION['user_id'];
				$art->ajoute_le=date('Y-m-d H:i:s');
				if ($art->verifyTitre()) 
				{
					if ($art->verifyArticle()) 
					{
						return $art; 
						die();
						
					}

					$this->set(['erreur'=>'L\'article est trop court. ']);
					return null;
					die();
					
				}

				$this->set(['erreur'=>'Le titre est trop court ou contient des caractères invalides. ']);
				return null;
				die();
				
			}

			$this->set(['erreur'=>'Tous les champs sont obligatoires. ']);
			return null;
			die();
	}


	public function ajouter_article(): void 
	{
		if ((isset($_SESSION['statut']) && $_SESSION['statut'] == 'admin') && isset($_SESSION['user_id'])) 
		{
			$article_verif=$this->verification_article();

			if ($article_verif) 
			{
				$lastId=$article_verif->insertArticle();
				if ($lastId) 
				{
					$this->set(['succes'=>'L\'article à été ajouté avec succès. ']);
					$this->articles();
					die();
					
				}

				$this->set(['erreur'=>'Une erreur est survenue lors de l\'enregistrement. ']);
				$this->nouvel_article();
				die();
				
			}
			$this->nouvel_article();
			die();
		}

		header('Location: /projetQCM/logout');
		exit();
	}


	public function editArticle(): void 
	{
		if ((isset($_SESSION['statut']) && $_SESSION['statut'] == 'admin') && isset($_SESSION['user_id'])) 
		{
			if (isset($_POST['id_article'])) 
			{
				$art= new Articles();
				$art->id=(int)$_POST['id_article'];
				$art_exist= $art->selectArticle(); 

				if ($art_exist && ((int)$art_exist->id_admin==(int)$_SESSION['user_id'])) 
				{
					$article_verif=$this->verification_article();

					if ($article_verif) 
					{
						$article_verif->id=(int)$art_exist->id;
						$article_verif->editArticle();
						
						$this->set(['succes'=>'L\'article à été modifié avec succès. ']);
						$this->detail_article($_POST['id_article']);
						die();
						
					}

					$this->detail_article($_POST['id_article']);
					die();
					
				}

				$this->set(['erreur'=>'L\'article est introuvable. ']);
				$this->articles();
				die();
				
			}

			$this->set(['erreur'=>'Une erreur est survenue lors de la modification. ']);
			$this->articles();
			die();
			
		}

		header('Location: /projetQCM/logout');
		exit();

	}
	

	public function deleteArticles(): void 
	{
		if ((isset($_SESSION['statut']) && $_SESSION['statut'] == 'admin') && isset($_SESSION['user_id'])) 
		{
			if (isset($_POST['articles']) && !empty($_POST['articles'])) 
			{
				
				foreach ($_POST['articles'] as $id_article) 
				{
					$art= new Articles();
					$art->id=(int)$id_article;
					$art_exist=$art->selectArticle();
					if (!$art_exist || ((int)$art_exist->id_admin != (int)$_SESSION['user_id']))
					{
						$this->set(['erreur'=>'Un ou plusieurs articles sont introuvables. ']);
						$this->articles();
						die();
					}

				}

				foreach ($_POST['articles'] as $id_article) 
				{
					$art= new Articles();
					$art->id=(int)$id_article;
					$art->deleteArticle();
				}

				if (count($_POST['articles']) > 1) 
				{
					$this->set(['succes'=>'Les articles ont été supprimés avec succès ']);
				}else{
					$this->set(['succes'=>'L\'articles à été supprimé avec succès ']);
				}

				$this->articles();
				die();

			}

			$this->articles();
			die();

		}

		header('Location: /projetQCM/logout');
		exit();

	}



		
		




	
	



	
}