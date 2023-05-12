<?php
Class ProfesseurController extends Controller {



	public function professeur()
	{
		$this->render('professeurView');
	}


	public function monCompte():void 
	{
		if (isset($_SESSION['professeur']) && $_SESSION['professeur']['statut']== 'professeur') 
		{
			$adresse= new Adresse();
			$adresse->setId((int)$_SESSION['professeur']['id_adresse']);
			$adresse=$adresse->getAllAdresses('id')[0];
			
			$this->set(['adresse'=>$adresse]);
			$this->render('professeurMonCompte');
			die();
		}

		header('Location: /projetQCM/logout');
		exit();
	}
	

	public function confirmer_password():void 
	{
		if (isset($_SESSION['professeur']) && $_SESSION['professeur']['statut']== 'professeur') 
		{
			if (isset($_POST['password']) && !empty($_POST['password'])) 
			{
				
				if (password_verify($_POST['password'] , $_SESSION['professeur']['password'])) 
				{
					$this->render('professeurChangePassword');
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
		if (isset($_SESSION['professeur']) && $_SESSION['professeur']['statut']== 'professeur') 
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
						$this->render('professeurChangePassword');
						die();
						
					}
					
					$this->set(['erreur'=>'Le mot de passe doit être composé de 8 à 15 caractère: au moins une lettre majuscule, une minuscule, un chiffre, et un des caractère suivant:  $ @ % * + - _ !']);
					$this->render('professeurChangePassword');
					die();
					
				}
				
				$this->set(['erreur'=>'Les deux mots de passe ne sont pas identiques']);
				$this->render('professeurChangePassword');
				die();
			}

			$this->monCompte();
			die();

		}

		header('Location: /projetQCM/logout');
		exit();
	}


	public function liste_qcm(): void 
	{
		if (isset($_GET['p'])) 
		{
			$params= explode('=', $_GET['p']);
			$select=isset($params[1])? $params[1]: null;
		}
		
		$qcm= new Qcm();
		$mes_qcm=$qcm->select_all_qcm();
		$mes_qcm_publie=$qcm->select_qcm_publie();
		if (isset($select) && $select=='publies') 
		{
			$mes_qcm=$mes_qcm_publie;
	
		}elseif (isset($select) && $select=='non_publies') {

			$tab=[];

			if(!empty($mes_qcm_publie))
			{
				foreach ($mes_qcm_publie as $qcm_pub) 
				{
					$tab[]=$qcm_pub->id;
				}
			}

			if(!empty($mes_qcm))
			{
				foreach ($mes_qcm as $qcm) 
				{

					if (!in_array($qcm->id, $tab)) {
						$tab_qcm[]=$qcm;
					}
				}
			}
			
			$mes_qcm=$tab_qcm ?? [];

		}elseif (isset($select) && $select=='tous'){

			$mes_qcm=$mes_qcm;

		}else{
			if (isset($select)) 
			{
				$classe=new Classes();
				$classe->setId((int)$select);
				if ($classe->classeExist()) 
				{
					$professeurs_de_classe=$classe->getProfesseursClasse();
					foreach ($professeurs_de_classe as $personne) 
					{
						if ($personne->id == $_SESSION['user_id']) 
						{
							$mes_qcm=$qcm->select_qcm_publie($classe->getId());
						}
					}

				}
				
			}
		}	
		
		$professeur= new professeur();
		$professeur->id_personne=(int)($_SESSION['user_id'])?? 0;
		$mes_classes=$professeur->selectClassesProfesseur();
		$this->set(['mes_qcm'=>$mes_qcm, 'mes_classes'=>$mes_classes, 'mes_qcm_publie'=>$mes_qcm_publie, 'select'=>$select]);
		$this->render('professeurListeQcm');
	}



// Afficher les détails d'un QCM : 
	public function get_more($id): void
	{
		if (isset($id)) 
		{
			$qcm_detail=null;
			$qcm= new Qcm();
			$mes_qcm=$qcm->select_all_qcm();

			foreach ($mes_qcm as $qcm) 
			{
				if ($qcm->id == (int)($id)) 
				{
					$questions=$qcm->select_all_questions();
					if ($questions) 
					{
						foreach ($qcm->questions as $question) 
						{
							$reponses=$question->select_all_responses();
							
						}
					}
					$qcm_detail['qcm']=$qcm;
				}
			}
			
		}
		
		echo json_encode($qcm_detail);

	}



	public function new_qcm(string $libelle=null): void 
	{
		$thme=new Theme();
		$themes=$thme->select_all_themes();
		if (!$themes) 
		{
			$themes=null;
		}

		if ($libelle) 
		{
			
			$thme->libelle=(string)$libelle;
			$theme=$thme->theme_exist($libelle);
			if ($theme) 
			{
				
				$this->set(['themes'=>$themes, 'theme'=>$theme]);
				$this->render('professeurSelectionNewQcm');
				die();
				
			}

			$this->set(['erreur'=>'Theme introuvable !']);
			$this->selection();
			die();		
		}


		$this->set(['themes'=>$themes]);
		$this->render('professeurNewQcm');
		
	}




	private function verification_qcm(string $qcm_cree_le= null): ?Qcm
	{
		if (isset($_SESSION['user_id'])) 
		{

			if ((isset($_POST['id_theme']) || isset($_POST['libelle_theme'])) && isset($_POST['libelle']) && isset($_POST['date_limite']) && isset($_POST['questions']) && isset($_POST['reponses']) && isset($_POST['valReponses'])) 
			{

				if ((!empty($_POST['id_theme']) || !empty($_POST['libelle_theme'])) && !empty($_POST['libelle']) && !empty($_POST['date_limite']) && !empty($_POST['questions']) && !empty($_POST['reponses']) && !empty($_POST['valReponses'])) 
				{
				
					$qcm=new Qcm();
					$qcm->cree_le= $qcm_cree_le;
					$qcm->id_professeur=(int)($_SESSION['user_id']);
					$theme = new Theme();
					$id_theme=null;
					$tab_quest=null;

					if (isset($_POST['id_theme']) && !empty($_POST['id_theme'])) 
					{

						$theme->id=(int)($_POST['id_theme']);
						$themeExist=$theme->theme_exist();
						if (!$themeExist) 
						{
							$this->set(['erreur' => 'Le theme selectionné est introuvable !']);
							return null;
							die();	
						}

						$id_theme=(int)$themeExist->id;
					}
		
					
					$qcm->id_theme=$id_theme;
					$qcm->libelle=trim($_POST['libelle']);
					$verif_qcm_lib= $qcm->verify_qcm_libelle();
					
					if (!$verif_qcm_lib) 
					{
						$this->set(['erreur' => 'Le libelle du QCM est trop court ou contient des caractères invalides !']);
						return null;
						die();
						
					}

					if ($qcm->cree_le == null) 
					{
						$qcm->cree_le=date('Y-m-d H:i');
					}
					
					$qcm->date_limite=trim($_POST['date_limite']);
					$date_jour=date('Y-m-d');
					
					if (($qcm->date_limite < $date_jour) || (!$qcm->verify_date($qcm->date_limite))) 
					{
						
						$this->set(['erreur' => 'La date limite est invalide ou elle est inférieure à la date du jours !']);
						return null;
						die();
							
					}

					if (isset($_POST['echelle_not']) && !empty($_POST['echelle_not'])) 
					{
						$ech_not=(int)($_POST['echelle_not']);
						if ($ech_not > 0) {
							$qcm->echelle_not=$ech_not;

						}else{
							$this->set(['erreur' => 'L\'échelle de notation doit être supérieur à zéro !']);
							return null;
							die();
						}
					}

					if (isset($_POST['notation_vrai']) && !empty($_POST['notation_vrai'])) 
					{
						$not_vrai=(int)($_POST['notation_vrai']);
						if ($not_vrai > 0) 
						{
							$qcm->notation_vrai=$not_vrai;

						}else{
							$this->set(['erreur' => 'Le barème de réponse valide doit être supérieur à zéro !']);
							return null;
							die();
						}
					}

					if (isset($_POST['notation_faux']) && !empty($_POST['notation_faux'])) 
					{
						$not_faux=(int)($_POST['notation_faux']);
						if ($not_faux < 0) 
						{
							$qcm->notation_faux=$not_faux;

						}else{
							$this->set(['erreur' => 'Le barème de réponse invalide doit être inférieure à zéro !']);
							return null;
							die();
						}
					}

					if (isset($_POST['jour']) || isset($_POST['heure'])|| isset($_POST['minute'])) 
					{
						if (!empty($_POST['jour']) || !empty($_POST['heure'])|| !empty($_POST['minute'])) 
						{
							$qcm->jour=(int)($_POST['jour'])?? 0;
							$qcm->heure=(int)($_POST['heure'])?? 0;
							$qcm->minute=(int)($_POST['minute'])?? 15;
							$duree_t=(($qcm->jour*24)*60)+($qcm->heure*60)+$qcm->minute;

							$date_duree= date("Y-m-d" , mktime(date("H")+$qcm->heure, date("i")+$qcm->minute, 0, date("m"), date("d")+$qcm->jour, date("Y")));

							if ($date_duree > $qcm->date_limite) 
							{
								$this->set(['erreur' => 'La durée du test est supérieure à la date limite du QCM !']);
								return null;
								die();
								
							}
							$qcm->duree_test=$duree_t;
							
						}
					}

					foreach ($_POST['questions'] as $cle => $question) {

						if (empty($question) && isset($_POST['reponses'][$cle])) {
							foreach ($_POST['reponses'][$cle] as $key => $reponse) {
								if (!empty($reponse)) {
									$this->set(['erreur' => 'Veuillez remplire toutes les questions !']);
									return null;
									die();
									
								}
							}
						}

						if (!empty($question)) 
						{
							$q=new Question();
							if ((strlen($question) >= 4) && (strlen($question) < 500)) 
							{
								$q->question=trim($question);

							}else{
								
								$this->set(['erreur' => 'Une ou plusieurs questions sont trop courtes ou dépassent la limite des caractères autorisée !']);
								return null;
								die();
							}
							

							if (isset($_POST['reponses'][$cle])) 
							{
								foreach ($_POST['reponses'][$cle] as $key => $rep) 
								{
									if (!empty($rep)) 
									{
										$re=new Reponse();
										if ((strlen($rep) > 0) && (strlen($rep) < 500)) 
										{
											$re->reponse=trim($rep);

										}else{

											$this->set(['erreur' => 'Une ou plusieurs réponses sont trop courtes ou dépassent la limite des caractères autorisée !']);
											return null;
											die();
										}
										
										$re->valeur=isset($_POST['valReponses'][$cle][$key])? 'vrai': 'faux';
										$q->reponses[]=$re;
														
									}
											
								}


								if (!empty($q->reponses)) 
								{
									$les_valeurs=null;
									foreach ($q->reponses as $reponse) 
									{
										$les_valeurs[]=$reponse->valeur;
										
									}

									if (!in_array('vrai', $les_valeurs)) 
									{
										$this->set(['erreur' => 'Veuillez sélectionner au moins une proposition valide pour chaque questions !']);
										return null;
										die();	
									}

									$q->id_professeur= (int)($_SESSION['user_id']);
									$q->id_theme= (int)$id_theme;
									$tab_quest[]=$q;
													
								}else{

									$this->set(['erreur' => 'Veuillez ajouter des réponses à toutes les questions !']);
									return null;
									die();

								}

							}

						}

					}
				
					if ($qcm->id_theme=== NULL) 
					{

						if (isset($_POST['libelle_theme']) && !empty($_POST['libelle_theme'])) 
						{
							$thme=new Theme();
							$themes=$thme->select_all_themes();
							if ($themes && !empty($themes)) 
							{
								foreach ($themes as $theme) 
								{
									if ($theme->libelle == $_POST['libelle_theme']) 
									{
										$this->set(['erreur' => 'Ce thème existe déja, veillez le sélectionner dans le liste !']);
										return null;
										die();
										
									}
								}
							}

							$theme->libelle=trim($_POST['libelle_theme']);
							$verifTheme=$theme->verify_theme_libelle();
						
							if (!$verifTheme) 
							{
								$this->set(['erreur' => 'Le libelle du thème est trop court ou contient des caractères invalides !']);
								return null;
								die();
							}

							$id_th=$theme->insert_theme();
							if (!$id_th) 
							{
								$this->set(['erreur' => 'Une erreur s\'est produite lors de l\'enregistrement du libellé !']);
								return null;
								die();
								
							}

							$qcm->id_theme=$id_th;
							foreach ($tab_quest as $question) 
							{
								$question->id_theme=(int)($id_th);
								
							}
							
						}else{

							$this->set(['erreur' => 'Veuillez choisir un theme !']);
							return null;
							die();

						}

					}

					$qcm->questions=$tab_quest;
					return $qcm;


				}

				$this->set(['erreur' => 'Veuillez remplir tous les champs !']);
				return null;
				die();
						
			}

			$this->set(['erreur' => 'Veuillez remplir tous les champs !']);
			return null;
			die();
			
			
		}

		$this->set(['erreur' => 'Impossible d\'enregistrer le QCM ! veuillez vous reconnecter puis réessayez !']);
		return null;
		die();	

	}


	public function create_qcm()
	{
				
		$qcm=$this->verification_qcm();

		if (!$qcm) 
		{
			$this->new_qcm();
			die();
						
		}

		$id_qcm=$qcm->insert_qcm();
					
		if ($id_qcm) 
		{
			foreach ($qcm->questions as $question) 
			{
				$id_question=$question->insert_question();
				if ($id_question) 
				{
					$question->id=$id_question;
					$id_qcm_question=$question->insert_qcm_question($id_qcm);

						if ($id_qcm_question) 
						{
							foreach ($question->reponses as $rep) 
							{
								
								$id_reponse=$rep->insert_reponse();
								if ($id_reponse) 
								{
									$rep->id=$id_reponse;
									$rep->insert_question_reponse((int)$id_question);
													
								}else{

									$this->set(['erreur' => 'Une erreur s\'est produite lors de l\'insertion des réponses !']);
									$this->new_qcm();
									die();
								}

							}
									
						}else{

							$this->set(['erreur' => 'Une erreur s\'est produite lors de l\'insertion des questions !']);
							$this->new_qcm();
							die();
						}
									
				}else{
							
					$this->set(['erreur' => 'Une erreur s\'est produite lors de l\'insertion des questions !']);
					$this->new_qcm();
					die();
				}	
							
			}

			$_POST=[];
			$this->set(['succes' => 'Le QCM à été enregistré avec succès !']);
			$this->new_qcm();
			die();
						
		}

		$this->set(['erreur' => 'Une erreur s\'est produite lors de l\'enregistrement du QCM !']);
		$this->new_qcm();
		die();

	}


	public function selection(): void
	{
		$theme=new Theme();
		$themes=$theme->select_all_themes();
		$this->set(['themes'=>$themes]);
		$this->render('professeurSelectTheme');
	}


	private function find_qcm(int $id_qcm): ?Qcm
	{
		$qcm_vide= new Qcm();
		$qcm_vide->id=$id_qcm;
		$qcm=$qcm_vide->select_qcm();
	
		if ($qcm) 
		{
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
			return $qcm;
			die();
		}
			
		return null;

	}


	public function alter_qcm(string $id) :void
	{
		if (isset($id)) 
		{
			$thme=new Theme();
			$themes=$thme->select_all_themes();
			if (!$themes) 
			{
				$themes=null;
			}

			$qcm=$this->find_qcm((int)($id));
			if ($qcm) 
			{
				
				$_SESSION['id_qcm']=$qcm->id;
				$this->set(['qcm'=>$qcm, 'themes'=>$themes]);
				$this->render('professeurAlterQcm');
				die();
				
			}
		}

		$this->liste_qcm();
	}



	public function edit_qcm(): void
	{
		if (isset($_SESSION['id_qcm'])) 
		{
			$qcm_basic=$this->find_qcm((int)($_SESSION['id_qcm']));
			$qcm=$this->verification_qcm($qcm_basic->cree_le);
			if (!$qcm) 
			{
				$this->alter_qcm($_SESSION['id_qcm']);
				die();
						
			}

			if (!$qcm_basic) 
			{	
				$this->liste_qcm();	
			}

			// transmettre les ID:
			$qcm->id=(int)$qcm_basic->id;
			//mis-à-jour du QCM
			$qcm->edit_qcm();
			if(!empty($qcm->questions))
			{
				foreach ($qcm->questions as $cle => $q) 
				{
					if(!empty($qcm_basic->questions))
					{
						foreach ($qcm_basic->questions as $key => $q_basic) 
						{
							if ($q_basic->question==$q->question) 
							{
								$valeur_reponses= true;

								if(count($q->reponses) == count($q_basic->reponses))
								{
									foreach ($q->reponses as $c => $rep) 
									{

										if (isset($q_basic->reponses[$c])) 
										{
											$rep1=$rep->reponse;
											$valRep1=$rep->valeur;
											$rep2=$q_basic->reponses[$c]->reponse;
											$valRep2=$q_basic->reponses[$c]->valeur;
											
											if ($rep1 != $rep2 || $valRep1 != $valRep2 ) 
											{
												$valeur_reponses=false;
											}

										}else{

											$valeur_reponses=false;
										}
										
									}

								}else{

									$valeur_reponses=false;
								}

								if ($valeur_reponses==true) 
								{
									$q->id=(int)$q_basic->id;
									if ($q->id_professeur!= $_SESSION['user_id']) 
									{
										$q->id_theme=(int)$q_basic->id_theme;
									}

									$edit=$q->edit_question();

								}
							}	
						}
					}

					if ($q->id==null) 
					{
						$lastid= $q->insert_question();
						
						if ($lastid) 
						{
							$q->id=$lastid;
							foreach ($q->reponses as $reponse) 
							{
								$id_reponse=$reponse->insert_reponse();
								if ($id_reponse) 
								{
									$reponse->id=$id_reponse;
									$reponse->insert_question_reponse((int)$q->id);
														
								}else{

									$this->set(['erreur' => 'Une erreur s\'est produite lors de la modification des questions !']);
									$this->alter_qcm($_SESSION['id_qcm']);
									die();
	
								}
							}

						}else{

							$this->set(['erreur' => 'Une erreur s\'est produite lors de la modification des questions !']);
							$this->alter_qcm($_SESSION['id_qcm']);
							die();
						}
						
					}
				}

				$delete=$qcm->delete_qcm_question();

				foreach ($qcm->questions as $question)
				{
					$id=$question->insert_qcm_question($qcm->id);
					if ($id==null) 
					{
						$this->set(['erreur' => 'Une erreur s\'est produite lors de la modification des questions !']);
						$this->alter_qcm($_SESSION['id_qcm']);
						die();
					}

				}

				$this->set(['succes' => 'Le QCM à été modifié avec succès !']);
				$this->alter_qcm($_SESSION['id_qcm']);
				unset($_SESSION['id_qcm']);
				die();		

			}
			
		}
		$this->liste_qcm();	
	}


	public function deleteQcm(): void
	{

		if (isset($_POST['id_qcm'])) 
		{
			$qcm= new Qcm();
			$qcm->id=(int)$_POST['id_qcm'];
			$delete=$qcm->delete_qcm();

			if ($delete) 
			{
				$this->set(['succes'=>'Le QCM à été supprimé avec succès !']);
				$this->liste_qcm();
				die();
			}

			$this->set(['erreur'=>'Le QCM est introuvable !']);
			$this->liste_qcm();
			die();
			

		}else{
			$this->liste_qcm();
		}
	}



	public function publication():void
	{
		if (isset($_POST['id_qcm'])) 
		{
			$qcm=new Qcm();
			$qcm->id=(int)$_POST['id_qcm'];

			if ($qcm->qcmExist()) 
			{
				$qcm= $qcm->qcmExist();
				if ($qcm->date_limite < date('Y-m-d')) 
				{
					$this->set(['erreur'=>'La date limite du QCM est inférieure à la date du jour. Veuillez modifiez la date limite puis réessayez !']);
					$this->liste_qcm();
					die();	
				}
				
				$qcm->delete_qcm_classe();

				if (isset($_POST['id_classe'])) 
				{
				
					foreach ($_POST['id_classe'] as $id_classe) 
					{

						$classe= new Classes();
						$classe->setId((int)$id_classe);

						if ($classe->classeExist()) 
						{
								$lastId=$qcm->qcm_classe($classe->getId());
								if ($lastId) 
								{
									$countInsert[]=$lastId;
								}
						}else{

							$this->set(['erreur'=>'La classe est introuvable !']);
							$this->liste_qcm();
							die();

						}
					}

					if (count($countInsert) == count($_POST['id_classe']))
					{
						
						$this->set(['succes'=>'Le QCM à été publié avec succès !']);
						unset($_POST['id_qcm']);
						$_POST['id_qcm']=null;
						$_POST['id_classe']=null;
						$this->liste_qcm();
						die();

					}else{

						$this->set(['erreur'=>'Une erreur imprévue s\'est produite !']);
						$this->liste_qcm();
						die();

					}
					
				}else{

					$this->set(['erreur'=>'Le QCM n\'est plus publié  !']);
					$this->liste_qcm();
					die();

				}
				
			}else{
					
				$this->set(['erreur'=>'Le QCM est introuvable !']);
				$this->liste_qcm();
				die();
			}
			
		}

		$this->liste_qcm();
		die();
	}



	public function classe_qcm(string $id_qcm, string $id_classe): void
	{
		$qcm= new Qcm();
		$qcm->id= (int)$id_qcm; 
		$checked=$qcm->select_classe_qcm((int)$id_classe);
		if ($checked) 
		{
			$checked['qcm']=$checked;
		}
		
		echo json_encode($checked);
	}


// Création QCM par sélection: 
	public function create_qcm_selection():void
	{
		if (isset($_SESSION['user_id'])) 
		{
			if (isset($_POST['id_theme']) && isset($_POST['libelle']) && isset($_POST['date_limite'])) 
			{

				if (!empty($_POST['id_theme']) && !empty($_POST['libelle']) && !empty($_POST['date_limite'])) 
				{
				
					$qcm=new Qcm();
					$qcm->id_professeur=(int)($_SESSION['user_id']);
					$theme = new Theme();
					$theme->id=(int)($_POST['id_theme']);
					$themeExist=$theme->theme_exist();
					if (!$themeExist) 
					{
						$this->set(['erreur' => 'Le theme selectionné est introuvable !']);
						$this->selection();
						die();	
					}

					$qcm->id_theme=(int)$themeExist->id;
					$qcm->theme=$themeExist->libelle;
					$qcm->libelle=trim($_POST['libelle']);
					$verif_qcm_lib= $qcm->verify_qcm_libelle();
					
					if (!$verif_qcm_lib) 
					{
						$this->set(['erreur' => 'Le libelle du QCM est trop court ou contient des caractères invalides !']);
						$this->new_qcm($themeExist->libelle);
						die();
						
					}

					$qcm->cree_le=date('Y-m-d H:i');
					$qcm->date_limite=trim($_POST['date_limite']);

					if (($qcm->date_limite < $qcm->cree_le) || (!$qcm->verify_date($qcm->date_limite))) 
					{
						$this->set(['erreur' => 'La date limite est invalide ou elle est inférieure à la date du jours !']);
						$this->new_qcm($themeExist->libelle);
						die();
							
					}

					if (isset($_POST['echelle_not']) && !empty($_POST['echelle_not'])) 
					{
						$ech_not=(int)($_POST['echelle_not']);
						if ($ech_not > 0) {
							$qcm->echelle_not=$ech_not;

						}else{

							$this->set(['erreur' => 'L\'échelle de notation doit être supérieur à zéro !']);
							$this->new_qcm($themeExist->libelle);
							die();
						}
					}

					if (isset($_POST['notation_vrai']) && !empty($_POST['notation_vrai'])) 
					{
						$not_vrai=(int)($_POST['notation_vrai']);
						if ($not_vrai > 0) 
						{
							$qcm->notation_vrai=$not_vrai;

						}else{
							$this->set(['erreur' => 'Le barème de réponse valide doit être supérieur à zéro !']);
							$this->new_qcm($themeExist->libelle);
							die();
						}
					}

					if (isset($_POST['notation_faux']) && !empty($_POST['notation_faux'])) 
					{
						$not_faux=(int)($_POST['notation_faux']);
						if ($not_faux < 0) 
						{
							$qcm->notation_faux=$not_faux;

						}else{
							$this->set(['erreur' => 'Le barème de réponse invalide doit être inférieure à zéro !']);
							$this->new_qcm($themeExist->libelle);
							die();
						}
					}

					if (isset($_POST['jour']) || isset($_POST['heure'])|| isset($_POST['minute'])) 
					{
						if (!empty($_POST['jour']) || !empty($_POST['heure'])|| !empty($_POST['minute'])) 
						{
							$qcm->jour=(int)($_POST['jour'])?? 0;
							$qcm->heure=(int)($_POST['heure'])?? 0;
							$qcm->minute=(int)($_POST['minute'])?? 15;
							$duree_t=($qcm->jour*24*60)+($qcm->heure*60)+$qcm->minute;

							$date_duree= date("Y-m-d" , mktime(date("H")+$qcm->heure, date("i")+$qcm->minute, 0, date("m"), date("d")+$qcm->jour, date("Y")));

							if ($date_duree > $qcm->date_limite) 
							{
								$this->set(['erreur' => 'La durée du test est supérieure à la date limite du QCM !']);
								$this->new_qcm($themeExist->libelle);
								die();
								
							}

							$qcm->duree_test=$duree_t;
							$_SESSION['qcm_select']=(array)$qcm;

							$question= new Question();
							$question->id_theme=(int)($qcm->id_theme);
							$questions=$question->select_all_questions($question->id_theme);
							if ($questions && !empty($questions)) 
							{
								foreach ($questions as $question) 
								{
									$question->select_all_responses();
								}
							}
							$this->set(['questions'=>$questions]);
							$this->render('professeurSelectionNewQcm_suite');
							die();
							
						}
					}
				}

				$this->set(['erreur' => 'Veuillez remplir tous les champs !']);
				$this->selection();
				die();
			}	


			$this->set(['erreur' => 'Veuillez remplir tous les champs !']);
			$this->selection();
			die();
		}

		$this->set(['erreur' => 'Impossible d\'enregistrer le QCM ! veuillez vous reconnecter puis réessayez !']);
		$this->selection();
		die();	
	}



	public function more_questions(string $id_theme, string $page)
	{
		if ($id_theme && $page) 
		{
			$to_json=[];
			$thme=new Theme();
			$thme->id=(int)$id_theme;
			$theme=$thme->theme_exist();
			if ($theme) 
			{
				$question= new Question();
				$question->id_theme=(int)($theme->id);
				$questions=$question->select_all_questions($question->id_theme, (int)$page);
				if ($questions && !empty($questions)) 
				{
					foreach ($questions as $question) 
					{
						$question->select_all_responses();
					}
					$to_json['questions']=$questions;
					echo json_encode($to_json);
				}
				
			}	
			
		}

	}

	public function create_qcm_validation():void
	{
		if (isset($_SESSION['qcm_select'])) 
		{
			if (isset($_POST['questions'])) 
			{

				if (!empty($_SESSION['qcm_select']) && !empty($_POST['questions'])) 
				{
					$qcm= new Qcm();
					$qcm->id_theme=(int)$_SESSION['qcm_select']['id_theme'];
					$qcm->libelle=$_SESSION['qcm_select']['libelle'];
					$qcm->echelle_not=(int)$_SESSION['qcm_select']['echelle_not'];
					$qcm->notation_vrai=(int)$_SESSION['qcm_select']['notation_vrai'];
					$qcm->notation_faux=(int)$_SESSION['qcm_select']['notation_faux'];
					$qcm->duree_test=(int)$_SESSION['qcm_select']['duree_test'];
					$qcm->cree_le=$_SESSION['qcm_select']['cree_le'];
					$qcm->date_limite=$_SESSION['qcm_select']['date_limite'];
					$qcm->id_professeur=(int)$_SESSION['qcm_select']['id_professeur'];

					$id_qcm=$qcm->insert_qcm();
						
					if ($id_qcm) 
					{
						foreach ($_POST['questions'] as $id_quest) 
						{
							$question=new Question();
							$question->id=(int)($id_quest);
							if ($question->questionExist()) 
							{
								$question->insert_qcm_question($id_qcm);
							}
						/*	$nouv_question= $question->questionExist();
							if ($nouv_question) 
							{
								$nouv_question->id=(int)($id_quest);
								$rep=$nouv_question->select_all_responses();
								$nouv_question->id_professeur= (int)$_SESSION['user_id'];

								if (!empty($nouv_question->reponses)) 
								{
									$nouv_question->id=null;
									$lastId=$nouv_question->insert_question();
									$nouv_question->id=(int)$lastId;
									$nouv_question->insert_qcm_question((int)$id_qcm);

									foreach($nouv_question->reponses as $reponse) 
									{
										$reponse->id=null;
										$lastIdRepo=$reponse->insert_reponse((int)$nouv_question->id);
										$reponse->id=(int)($lastIdRepo);
										$reponse->insert_question_reponse((int)$nouv_question->id);
									}
								}
								

							}*/
							
						}

						$this->set(['succes' => 'Le QCM à été enregistré avec succès! ']);
						$this->new_qcm($_SESSION['qcm_select']['theme']);
						unset($_SESSION['qcm_select']);
						die();
						
					}

					$this->set(['erreur' => 'Une erreur s\'est produite lors de l\'enregistrement du QCM !']);
					$this->new_qcm($_SESSION['qcm_select']['theme']);
					die();
		
				}

				$this->set(['erreur' => 'Vueillez choisir des questions !']);
				$this->new_qcm($_SESSION['qcm_select']['theme']);
				die();
					
			}

			$this->set(['erreur' => 'Vueillez choisir des questions !']);
			$this->new_qcm($_SESSION['qcm_select']['theme']);
			die();
			
		}
		$this->set(['erreur' => 'Une erreur imprévue s\'esrt produite !']);
		$this->selection();
		die();

		
	}


	public function questions(string $libelle=null):void 
	{
		$theme=new Theme();
		$themes=$theme->select_all_themes();

		if ($libelle) 
		{
			$thme=new Theme();
			$thme->libelle=(string)$libelle;
			$theme=$thme->theme_exist($libelle);

			if ($theme) 
			{
				$question= new Question();
				$question->id_theme=(int)($theme->id);
				$questions=$question->select_all_questions($question->id_theme);
				if ($questions && !empty($questions)) 
				{
					foreach ($questions as $question) 
					{
						$question->select_all_responses();
					}
				}
			
				
				$this->set(['theme'=>$theme, 'questions'=>$questions]);
				$this->render('professeurQuestions');
				die();
				
			}

			$this->set(['erreur'=>'Theme introuvable !']);
			$this->questions();
			die();		
		}

		
		$this->set(['themes'=>$themes]);
		$this->render('professeurSelThemeQuestions');
	}


	public function mes_questions(): void 
	{
		$p=isset($_POST['page'])?(int)$_POST['page']:null;

		if (isset($_SESSION['user_id'])) 
		{
			$professeur=new professeur();
			$professeur->id_personne=(int)$_SESSION['user_id'];
			if ($p) 
			{
				$questions=$professeur->select_questions_professeur($p);
			}else{
				$questions=$professeur->select_questions_professeur();
			}
			
			
			if ($questions && !empty($questions)) 
			{
				foreach ($questions as $question) 
				{
					$question->est_partagee();
					$question->select_all_responses();
				}
			}

			if (isset($_POST['page'])) 
			{
				$to_json['questions']=$questions;
				echo json_encode($to_json);
				die();
			}
			
			$this->set(['questions'=>$questions]);
			$this->render('professeurMesQuestions');
			die();
				
			
		}
			
		$this->set(['erreur'=>'Impossible de trouver les questions, reconnectez-vous puis réessayez !']);
		$this->professeur();
		die();		
				
	}


	public function deleteQuestion(): void
	{

		if (isset($_POST['id_question'])) 
		{
			$question= new Question();
			$question->id=(int)$_POST['id_question'];
			$question->select_all_responses();

			if (!empty($question->reponses)) 
			{
				foreach ($question->reponses as $reponse) 
				{
					$del_rep=$reponse->delete_reponse();
					if (!$del_rep) 
					{
						$this->set(['erreur'=>'Erreur lors de la suppression des données !']);
						$this->mes_questions();
						die();
					}
				}
			}
			
			$delete=$question->delete_question();

			if ($delete) 
			{

				$this->set(['succes'=>'La question à été supprimée avec succès !']);
				$this->mes_questions();
				die();
			}

			$this->set(['erreur'=>'La question est introuvable !']);
			$this->mes_questions();
			die();
			

		}else{

			$this->mes_questions();
		}
	}



	public function edit_question(string $id_question):void 
	{
		if (isset($id_question) && isset($_SESSION['user_id'])) 
		{
			$id_professeur=(int)($_SESSION['user_id']);
			$question= new Question();
			$question->id=(int)($id_question);
			$q=$question->question_professeur_exist((int)$id_professeur);

			if ($q) 
			{
				$q->select_all_responses();
				$this->set(['question'=>$q]);
				$this->render('professeurEditQuestion');
				die();
			}
			$this->set(['erreur'=>'Impossible de trouver la question !']);
			$this->mes_questions();
			
		}
	}


	public function valid_edit_question(): void
	{
		if(isset($_SESSION['user_id']))
		{ 
		if (isset($_POST['question']) && isset($_POST['reponses']) && isset($_POST['valReponses']) ) 
		{
			if (!empty($_POST['question']) && !empty($_POST['reponses']) && !empty($_POST['valReponses'])) 
			{

				foreach ($_POST['question'] as $key => $question) 
				{

					if (!empty($question) && (strlen($question) > 5) && (strlen($question) < 500)) 
					{
						$q= new Question();
						$q->id=(int)$key;
						$quest=$q->question_professeur_exist((int)$_SESSION['user_id']);
						if ($quest) 
						{
							$edit=true;

							if ($quest->question != $question) 
							{
								$quest->question=$question;
								$edit=$quest->edit_question();
							}
							

							if ($edit) 
							{
								$quest->select_all_responses();
								if (!empty($quest->reponses)) 
								{
									foreach ($quest->reponses as $reponse) 
									{
										$reponse->delete_reponse();
									}
								}
								
								foreach ($_POST['reponses'] as $cle => $reponse) 
								{
									if (!empty($reponse) && (strlen($reponse) > 0) && (strlen($reponse) < 500)) 
									{
										$rep= new Reponse();
										$rep->reponse=trim($reponse);
										$rep->valeur=(isset($_POST['valReponses'][$cle]))? 'vrai': 'faux';
										$lastid_rep=$rep->insert_reponse();
										if ($lastid_rep) 
										{
											$rep->id=(int)$lastid_rep;
											$lastid=$rep->insert_question_reponse((int)($quest->id));

										}else{

										$this->set(['erreur'=>'Une erreur est survenue lors de la modification des réponses !']);
										$this->mes_questions();
										die();

										}
										
									}else{

									$this->set(['erreur'=>'Les reponses sont trop courtes ou dépassent la limite des caractères autorisée !']);
									$this->render('professeurEditQuestion');
									die();

									}
								}

								$this->set(['succes'=>'La question à été modifiée avec succès!']);
								$this->mes_questions();
								die();
										
							}
							
							$this->set(['erreur'=>'Une erreur est survenue lors de la modification de la question !']);
							$this->mes_questions();
							die();
							
						}
						$this->set(['erreur'=>'Impossible de trouver la question !']);
						$this->mes_questions();
						die();
						
					}

					$this->set(['erreur'=>'La question est trop courte ou dépasse la limite des caractères autorisée !']);
					$this->render('professeurEditQuestion');
					die();
					
				}
				
			}
			$this->set(['erreur'=>'Veuillez remplir tous les champs !']);
			$this->render('professeurEditQuestion');
			die();
			 
		}
		$this->set(['erreur'=>'Veuillez remplir tous les champs !']);
		$this->render('professeurEditQuestion');
		die();

		}

		$this->set(['erreur'=>'Veuillez vous reconnecter puis réessayez !']);
		$this->mes_questions();
		die();
	}


	public function mes_classes(): void
	{
		if (isset($_SESSION['user_id'])) 
		{
			$professeur= new Professeur();
			$professeur->id_personne=(int)$_SESSION['user_id'];
			$classes=$professeur->selectClassesProfesseur();
			if ($classes) 
			{
				foreach ($classes as $classe) 
				{
					$classe->getElevesClasse();
					$niveau=new Niveaux();
					$niv=$niveau->getNiveaux((int)$classe->id_niveau);
					if ($niv) 
					{
						$classe->niveau=$niv;
					}
				}
				
				$this->set(['classes'=>$classes]);
				$this->render('professeurClasses');
				die();
			}
			
			$this->render('professeurClasses');
			die();

		}
		$this->set(['erreur'=>'reconnectez-vous puis réessayez !']);
		$this->professeur();
		die();
		
	}


	public function resultats(): void 
	{
		$qcm= new Qcm();
		$mes_qcm=$qcm->select_all_qcm();
		if ($mes_qcm) 
		{
			foreach ($mes_qcm as $qcm) 
			{
				$qcm->get_classes_qcm();
				if ($qcm->classes) 
				{
					foreach ($qcm->classes as $classe) 
					{
						$classe->getElevesClasse();
						if ($classe->eleves) 
						{
							foreach ($classe->eleves as $personne) 
							{
								$personne->get_note((int)$qcm->id);
							}
						}
					}
				}
			}
		
		}
		$this->set(['mes_qcm'=>$mes_qcm]);
		$this->render('professeurResultats');
	}


			
						
			






}