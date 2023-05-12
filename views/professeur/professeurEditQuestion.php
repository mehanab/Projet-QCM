<?php 

$titre='Modifier une question'; 
?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    	<li class="breadcrumb-item"><a href="/professeur/mes_questions">Mes questions</a></li>
		    	<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Modifier une question</li>
		  </ol>
	</nav>
	<div class="container-fluid">
		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 " style="padding: 0 10px 0 0">
				<div class="card  d-flex align-self-start" >
					<header class="card-header text-white text-center bg-info">
						<h4>Mon espace</h4>
					</header>
					<nav class="list-group list-group-flush bg-info" id="navProf">
					
						<a href="/professeur/liste_qcm" class="list-group-item list-group-item-action pl-5" id="">Ma bibliothèque QCM</a>
						<a href="" class="list-group-item list-group-item-action pl-5" id="showQuestions">Ma bibliothèque Questions</a>
						<div class="list-group list-group-flush ml-4 text-left" id="choixTypeQuestions">
								<a href="/professeur/questions" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i> Toutes les questions</a>
								<a href="/professeur/mes_questions" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i> Mes questions</a>
						</div>
						<a class="list-group-item list-group-item-action pl-5" href="" id="createQcm">Créer un nouveau QCM</a>
						<div class="list-group list-group-flush ml-4 text-left" id="choixTypeQcm">
								<a href="/professeur/new_qcm" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i> Saisie manuelle</a>
								<a href="/professeur/selection" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i>  Sélection de questions</a>
						</div>
						<a href="/professeur/mes_classes" class="list-group-item list-group-item-action pl-5">Mes classes</a>
						<a href="/professeur/resultats" class="list-group-item list-group-item-action pl-5" id="">Résultats</a>
													
					</nav>
				</div>
				
			</section>

			<section class="col-md-9">
			
					
				<div class="card text-center d-flex row bg-secondary">
					<div class="card-body bg-secondary text-white">
						<h2><strong>Modifier une question</strong></h2>
					</div>		
				</div>

				<?php if (isset($succes)): ?>
					
					<div class="alert alert-success text-center mt-3 d-flex justify-content-center">
						<?= $succes ?>
					</div>

				<?php endif ?>
				<?php if (isset($erreur)): ?>
							
					<div class="alert alert-danger text-center mt-3 d-flex justify-content-center">
						<?= $erreur ?>
					</div>

				<?php endif ?>
				
				
				<div class="row d-flex justify-content-between">

				<div class="col-lg-12">

					<div class="row d-flex justify-content-between">
						<div class="card p-4 col-lg-12 my-3" id="enregistrement_suite">
						
							<div class="card-header bg-white">
								<h3>Ma question : </h3>
							</div>

							<?php if((isset($question) && !empty($question)) || isset($_POST['question'])): ?>
							<?php $cle_question= null; ?>
<!-- /projetQCM/professeur/valid_edit_question -->
							<form action="/professeur/valid_edit_question" method="post" class="col-lg-12 needs-validation" novalidate>

								<div  class="card-body" id="questionReponse">
										
										<div class="form-group bg-light p-3 pl-3 row">
											<?php if(isset($_POST['question'])):  ?>
												<?php foreach($_POST['question'] as $key => $question): ?>
												<?php $cle_question=$key; ?>
											<label class="col-sm-4 col-form-label"> <strong> Question : </strong></label>
											<input type="text" name="question[<?= $key?>]" class="col-sm-8 form-control" value="<?= htmlentities($question); ?>" required>
											<div class="invalid-feedback">
									        		Le champs ne doit pas être vide !
									    	</div>
									    		<?php endforeach ?>
											<?php else: ?>

											<label class="col-sm-4 col-form-label"> <strong> Question : </strong></label>
											<input type="text" name="question[<?= $question->id; ?>]" class="col-sm-8 form-control" value="<?= htmlentities($question->question); ?>" required>
											<div class="invalid-feedback">
									        		Le champs ne doit pas être vide !
									    	</div>
									    	<?php endif ?>
											  	
										</div>
										
										<div class="mb-5 ml-5 bg-light reponses px-5 py-3 ">
											<?php if(!empty($question->reponses) || isset($_POST['reponses'])): ?> 
												<?php if(isset($_POST['reponses'])): ?>
													<?php foreach($_POST['reponses'] as $cle => $reponse): ?>
														<div>		
															<div class="form-group row ">
																		
																<label class="col-sm-4 col-form-label"><span class="mr-1"><i class="fas fa-times-circle"> </i></span><strong id="option">Option <?= $cle+1; ?>  : </strong></label>
																<input type="text" name="reponses[]" class="col-sm-8 form-control" value="<?= htmlentities($reponse); ?>" required>
																<div class="invalid-feedback">
																    Le champs ne doit pas être vide !
																</div>	
															</div>
															<div class="form-group row ml-sm-1 d-flex justify-content-end">
																<div class="form-check form-check-inline">
																		<input type="checkbox" name="valReponses[<?= $cle; ?>]" value="vrai" class="form-check-input" <?= isset($_POST['valReponses'][$cle]) ? 'checked' : '' ?>>
																		<label class="form-check-label ">Bonne proposition</label>
																</div>
															</div>
														</div>
													


													<?php endforeach ?>	

												<?php else: ?>	
										
													<?php foreach($question->reponses as $cle => $reponse): ?>
											
														<div>		
															<div class="form-group row ">
																		
																<label class="col-sm-4 col-form-label"><span class="mr-1"><i class="fas fa-times-circle"> </i></span><strong id="option">Option <?= $cle+1; ?>  : </strong></label>
																<input type="text" name="reponses[]" class="col-sm-8 form-control" value="<?= htmlentities($reponse->reponse); ?>" required>
																<div class="invalid-feedback">
																    Le champs ne doit pas être vide !
																</div>	
															</div>
															<div class="form-group row ml-sm-1 d-flex justify-content-end">
																<div class="form-check form-check-inline">
																		<input type="checkbox" name="valReponses[<?= $cle; ?>]" value="vrai" class="form-check-input" <?= (isset($reponse->valeur) && $reponse->valeur== 'vrai' ) ? 'checked' : '' ?>>
																		<label class="form-check-label ">Bonne proposition</label>
																</div>
															</div>
														</div>
													
													<?php endforeach ?>	
												<?php endif ?>
											<?php endif ?>
											<span class="cursorRep" title="Ajouter une réponse" onclick="rep(<?= $cle_question ?? $question->id ?>)" id="<?= $cle_question ?? $question->id ?>"><i class="fas fa-plus-square" data-toggle="tooltip" data-placement="bottom" title="Ajouter une réponse"></i></span>
										</div>
												
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary">Modifier</button>
								</div>
							</form>

							<?php endif ?>
							
						</div>
					</div>
					
					<a href="javascript:history.go(-1)" class="btn btn-primary">Page précédente </a>


				</div>
				</div>

			</section>

			
		</div>
	</div>
</div>
<script src="/js/professeur/editQuestion.js?v=<?= time() ?>"></script>
	
