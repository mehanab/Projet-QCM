<?php 


Class EleveController extends Controller {



	public function eleve()
	{
		$this->render('eleveView');
	}

	public function monCompte():void 
	{
		if (isset($_SESSION['eleve']) && $_SESSION['eleve']['statut']== 'eleve') 
		{
			$adresse= new Adresse();
			$adresse->setId((int)$_SESSION['eleve']['id_adresse']);
			$adresse=$adresse->getAllAdresses('id')[0];
			
			$this->set(['adresse'=>$adresse]);
			$this->render('eleveMonCompte');
			die();
		}

		header('Location: /logout');
		exit();
	}


	public function confirmer_password():void 
	{
		if (isset($_SESSION['eleve']) && $_SESSION['eleve']['statut']== 'eleve') 
		{
			if (isset($_POST['password']) && !empty($_POST['password'])) 
			{
				
				if (password_verify($_POST['password'] , $_SESSION['eleve']['password'])) 
				{
					$this->render('eleveChangePassword');
					die();
				}

				$this->set(['erreur'=>'Mot de passe incorrect !']);
				$this->render('eleveMonCompte');
				die();
				
			}

			$this->render('eleveMonCompte');
			die();
		}

		header('Location: /logout');
		exit();
	}


	public function changer_password(): void 
	{
		if (isset($_SESSION['eleve']) && $_SESSION['eleve']['statut']== 'eleve') 
		{
			if (isset($_POST['password']) && isset($_POST['confPassword']) && !empty($_POST['password']) && !empty($_POST['confPassword'])) 
			{
				if ($_POST['password'] === $_POST['confPassword']) 
				{
					$personne= new Personne();
					$personne->id=(int)$_SESSION['eleve']['id'];
					$personne->nom=$_SESSION['eleve']['nom'];
					$personne->prenom=$_SESSION['eleve']['prenom'];
					$personne->sexe=$_SESSION['eleve']['sexe'];
					$personne->pseudo=$_SESSION['eleve']['pseudo'];
					$personne->mail=$_SESSION['eleve']['mail'];
					$personne->date_de_naissance=strtotime($_SESSION['eleve']['date_de_naissance']);
					$personne->password= trim($_POST['password']);

					if ($personne->verifyPassword()) 
					{
						$modif=$personne->alterPersonne();
						if ($modif) 
						{
							$_SESSION['eleve']['password']=password_hash($personne->password, PASSWORD_DEFAULT);
							$this->set(['succes'=>'Le mot de passe à été modifié avec succès']);
							$this->monCompte();
							die();
							
						}

						$this->set(['erreur'=>'Une erreur s\'est produite lors de la modifiation !']);
						$this->render('eleveChangePassword');
						die();
						
					}
					
					$this->set(['erreur'=>'Le mot de passe doit être composé de 8 à 15 caractère: au moins une lettre majuscule, une minuscule, un chiffre, et un des caractère suivant:  $ @ % * + - _ !']);
					$this->render('eleveChangePassword');
					die();
					
				}
				
				$this->set(['erreur'=>'Les deux mots de passe ne sont pas identiques']);
				$this->render('eleveChangePassword');
				die();
			}

			$this->monCompte();
			die();

		}

		header('Location: /logout');
		exit();
	}


	private function qcm_eleve(): array
	{
		if (isset($_SESSION['eleve'])) 
		{
			$themesArrayObject=[];
			$tableau_themes;
			$eleve= new Eleve(); 
			$eleve->id_personne= $_SESSION['eleve']['id_personne'];
			$mes_qcm=$eleve->get_qcm_eleve();
			if ($mes_qcm && !empty($mes_qcm)) 
			{
				foreach ($mes_qcm as $qcm) 
				{
					$theme= new Theme();
					$theme->id=$qcm->id_theme;
					$thme=$theme->theme_exist();
					if ($thme) 
					{
						$qcm->theme=$thme->libelle;
					}
					
					$personne=new personne();
					$personne->id=$eleve->id_personne;
					$note=$personne->get_note((int)$qcm->id);
					$qcm->note_eleve=$note;
					$tableau_themes[]=$qcm->theme;
				}

				$tab_themes=array_unique($tableau_themes);

				foreach ($mes_qcm as $qcm) 
				{
					foreach ($tab_themes as $theme) 
					{
						if ($qcm->theme== $theme) 
						{
							$themes[$theme][]=$qcm;
						}
					}
				}

				$themesArrayObject=new ArrayObject($themes);
				$themesArrayObject->ksort();
			}

			$qcm_eleve['mes_qcm']=$mes_qcm;
			$qcm_eleve['themesArrayObject']=$themesArrayObject;
			return $qcm_eleve;
			/*$this->set(['mes_qcm'=>$mes_qcm, 'themes'=>$themesArrayObject]);
			$this->render('eleveQcm');
			die();*/
		}
	}

	public function mes_qcm(): void
	{
		
		$qcm=$this->qcm_eleve();
		$mes_qcm=$qcm['mes_qcm'];
		$themesArrayObject=$qcm['themesArrayObject'];
	
		$this->set(['mes_qcm'=>$mes_qcm, 'themes'=>$themesArrayObject]);
		$this->render('eleveQcm');
		die();

	}

	public function qcm(string $id_qcm, string $validated=null): void 
	{
		if (isset($_SESSION['eleve']) && $id_qcm) 
		{
			$tableau_themes;
			$eleve= new Eleve(); 
			$eleve->id_personne= $_SESSION['eleve']['id_personne'];
			$qcm=$eleve->get_qcm_eleve((int)$id_qcm);
			if ($qcm && !empty($qcm)) 
			{
					$qcm=$qcm[0];
					$theme= new Theme();
					$theme->id=$qcm->id_theme;
					$thme=$theme->theme_exist();
					if ($thme) 
					{
						$qcm->theme=$thme->libelle;
					}
					$personne=new personne();
					$personne->id=$eleve->id_personne;
					$note=$personne->get_note((int)$qcm->id);
					$qcm->note_eleve=$note;
					$qcm->minute=intval((($qcm->duree_test/60) - intval($qcm->duree_test/60))*60);
					$qcm->heure=intval(((intval($qcm->duree_test/60)/24)-intval(intval($qcm->duree_test/60)/24))*24);
					$qcm->jour=intval(intval($qcm->duree_test/60)/24);

					if (isset($validated) && $validated=='validated') 
					{
						$this->set(['succes'=>'Vous avez obtenu la note de : '.$qcm->note_eleve->note."/".$qcm->echelle_not]);
					}

					$this->set(['qcm'=> $qcm]);
					$this->render('eleveRenduQcm');
					die();
				
			}
			$this->set(['erreur'=>' QCM introuvable']);
			$this->mes_qcm();
			die();
		}
		$this->set(['erreur'=>' QCM introuvable']);
		$this->mes_qcm();
		die();

	}



	public function qcm_questions(string $id_qcm): void 
	{
		if (isset($_SESSION['eleve']) && $id_qcm) 
		{
			$tableau_themes;
			$eleve= new Eleve(); 
			$eleve->id_personne= $_SESSION['eleve']['id_personne'];
			$qcm=$eleve->get_qcm_eleve((int)$id_qcm);
			if ($qcm && !empty($qcm)) 
			{
					$qcm=$qcm[0];
					$theme= new Theme();
					$theme->id=$qcm->id_theme;
					$thme=$theme->theme_exist();
					if ($thme) 
					{
						$qcm->theme=$thme->libelle;
					}
					$personne=new personne();
					$personne->id=$eleve->id_personne;
					$note=$personne->get_note((int)$qcm->id);
					$qcm->note_eleve=$note;
					$qcm->minute=intval((($qcm->duree_test/60) - intval($qcm->duree_test/60))*60);
					$qcm->heure=intval(((intval($qcm->duree_test/60)/24)-intval(intval($qcm->duree_test/60)/24))*24);
					$qcm->jour=intval(intval($qcm->duree_test/60)/24);
					if ($qcm->jour > 0) 
					{
						$qcm->heure+= ((int)($qcm->jour)*24);
					}
					if (($qcm->minute == 0) || ($qcm->minute==null) ) 
					{
						$qcm->heure=(int)$qcm->heure-1;
						$qcm->minute+=60;
					}
			
					$qcm->select_all_questions();
					if ($qcm->questions && !empty($qcm->questions)) 
					{
						foreach ($qcm->questions as $question) 
						{
							$question->select_all_responses();
						}
						
					}
					$eleve->note_qcm=0.0;
					$note=$eleve->insert_note($qcm->id);
					
					if ($note) 
					{
						$this->set(['qcm'=> $qcm]);
						$this->render('eleveQuestionsQcm');
						die();
					}

				$this->set(['erreur'=>' Une erreur imprévue s\'est produite !']);
				$this->mes_qcm();
				die();
					
			}
			$this->set(['erreur'=>' QCM introuvable']);
			$this->mes_qcm();
			die();
		}
		$this->set(['erreur'=>' QCM introuvable']);
		$this->mes_qcm();
		die();

	}


	public function validationQcm(): void 
	{
		
		if (isset($_POST['qcm']) && isset($_POST['question']) && isset($_SESSION['eleve'])) 
		{	
			$eleve= new Eleve(); 
			$eleve->id_personne= $_SESSION['eleve']['id_personne'];
			$qcm=$eleve->get_qcm_eleve((int)$_POST['qcm']);

			if ($qcm && !empty($qcm)) 
			{
					$qcm=$qcm[0];
					$theme= new Theme();
					$theme->id=$qcm->id_theme;
					$thme=$theme->theme_exist();
					if ($thme) 
					{
						$qcm->theme=$thme->libelle;
					}
					$personne=new personne();
					$personne->id=$eleve->id_personne;
					$note=$personne->get_note((int)$qcm->id);
					$qcm->note_eleve=$note;

					$qcm->select_all_questions();
					if ($qcm->questions && !empty($qcm->questions)) 
					{
						foreach ($qcm->questions as $question) 
						{
							$question->select_all_responses();
						}
						
					}

					$rep_eleve=[];
					$calcul_note=0;
					$reponse_valide=(int)($qcm->notation_vrai);
					$reponse_invalide=(int)($qcm->notation_faux);
					$bareme=(int)($qcm->echelle_not);
					$nb_questions=0;

					if (isset($_POST['reponses'])) 
					{
						if (!empty($qcm->questions) && !empty($_POST['reponses'])) 
						{
							$nb_questions=count($qcm->questions);

							foreach ($qcm->questions as $question) 
							{
								
								foreach ($_POST['reponses'] as $id_quest => $tab_reponses) 
								{
									if ($question->id== $id_quest) 
									{
										if (!empty($question->reponses) && !empty($tab_reponses)) 
										{
											foreach ($question->reponses as $reponse) 
											{
												foreach ($tab_reponses as $id_rep => $rep) 
												{
													
													if ($reponse->id == $id_rep) 
													{	
														$rep_eleve[$id_quest][]=$id_rep;
														$tab_valeur[]=$reponse->valeur;
													}
												}
											}

											if (in_array('faux', $tab_valeur)) 
											{
												$calcul_note+=$reponse_invalide;

												if ($calcul_note < 0) 
												{
													$calcul_note=0;
												}
														
											}else{

												$calcul_note+=$reponse_valide;
											}

											$tab_valeur=[];
										}
									}
								}
									
							}

							$calcul_note= ($bareme * $calcul_note)/($nb_questions * $reponse_valide);
						}
					}
		
				if (!empty($rep_eleve)) 
				{
					foreach ($rep_eleve as $id_question => $tab_rep) 
					{
						$qcm_question=$qcm->qcm_question((int)$id_question);
						if ($qcm_question) 
						{
							foreach ($tab_rep as $reponse_eleve) 
							{
								$reponse=new Reponse();
								$reponse->id=(int)$reponse_eleve;
								$reponse->insert_reponse_eleve((int)($qcm_question['id']));
							}	
						}
					}
				}	

				$eleve->note_qcm=round($calcul_note, 2);
				$eleve->update_note((int)$qcm->id);
				/*$this->set(['succes'=>'Vous avez obtenu la note de : '.$calcul_note."/".$bareme]);*/
				/*$this->qcm((int)$qcm->id);*/
				header('Location: /eleve/qcm/'.$qcm->id.'/validated');
				die();

			}
			$this->set(['erreur'=>'Une erreur imprévue s\'est produite']);
			$this->mes_qcm();
			die();
			
		}
	
		$this->mes_qcm();
		die();
	}


	public function review(string $id_qcm):void 
	{
		if (isset($_SESSION['eleve']) && $id_qcm) 
		{
			$tableau_themes;
			$eleve= new Eleve(); 
			$eleve->id_personne= $_SESSION['eleve']['id_personne'];
			$qcm=$eleve->get_qcm_eleve((int)$id_qcm);

			if ($qcm && !empty($qcm)) 
			{
				$qcm=$qcm[0];
				$theme= new Theme();
				$theme->id=$qcm->id_theme;
				$thme=$theme->theme_exist();
				if ($thme) 
				{
					$qcm->theme=$thme->libelle;
				}
				$personne=new personne();
				$personne->id=$eleve->id_personne;
				$note=$personne->get_note((int)$qcm->id);
				$qcm->note_eleve=$note;
				$qcm->select_all_questions();
					if ($qcm->questions && !empty($qcm->questions)) 
					{
						foreach ($qcm->questions as $question) 
						{
							$question->select_reponses_eleve((int)($qcm->id));
							$question->select_all_responses();
						}
						
					}
				$this->set(['qcm'=> $qcm]);
				$this->render('eleveQuestionsQcmReview');
				die();

			}

			$this->set(['erreur'=>' QCM introuvable']);
			$this->mes_qcm();
			die();
		}

		$this->mes_qcm();
		die();

	}


	public function notes(): void 
	{
		$qcm_eleve=$this->qcm_eleve();
		$mes_qcm=$qcm_eleve['themesArrayObject'];
		$this->set(['themes'=>$mes_qcm]);
		$this->render('eleveNotes');
		die();
	}

	public function ma_classe():void 
	{
		if (isset($_SESSION['eleve']['id_classe'])) 
		{
			$cls= new Classes();
			$cls->setId($_SESSION['eleve']['id_classe']);
			$classe= $cls->classeExist();

			if ($classe) 
			{
				$niveau= new Niveaux();
				$classe->niveau=$niveau->getNiveaux((int)$classe->id_niveau);
				$classe->getProfesseursClasse();

				$this->set(['classe'=>$classe]);
				$this->render('eleveMaClasse');
				die();	
			}

			$this->set(['erreur'=>'Une erreur est survenue !']);
			$this->render('eleveMaClasse');
			die();
		}

		$this->eleve();
	
	}

	public function contact(): void 
	{
		if (isset($_SESSION['eleve']['id_classe'])) 
		{
			$admin=[];
			$personne=new Personne();
			$cls= new Classes();
			$cls->setId($_SESSION['eleve']['id_classe']);
			$classe= $cls->classeExist();
			if ($classe) 
			{
				$classe->getProfesseursClasse();
			}

			if (!empty($classe->professeurs)) 
			{
				foreach ($classe->professeurs as $professeur) 
				{
					$prof=$personne->isPersonne($professeur->id);
					if ($prof) 
					{
						$professeur->mail=$prof->mail;
					}
				}
			}

			$prof=new Professeur();
			$professeurs=$prof->selectProfesseurs();

			foreach ($professeurs as $professeur) 
			{
				if ($professeur->statut== 'admin') 
				{
					$admin[]=$professeur;
				}
			}
			
			$this->set(['admin'=>$admin, 'classe'=>$classe]);
			$this->render('eleveContact');
			die();
		}
		$this->eleve();
	}





	
}