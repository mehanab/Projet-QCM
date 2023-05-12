<?php $titre='Détail QCM';?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/projetQCM/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item"><a href="/projetQCM/admin/listQcm">Choisir un thème</a></li>
		    <li class="breadcrumb-item"><a href="/projetQCM/admin/listQcm/<?= htmlentities($qcm->theme) ?? '';  ?>"><?= htmlentities($qcm->theme)?? 'QCM' ?></a></li>
	   		<li class="breadcrumb-item active" aria-current="Détail qcm"><?= htmlentities($qcm->libelle) ?? 'Détail QCM' ?></li>
		  </ol>
	</nav>

	<div class="container-fluid">

		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 my " style="padding: 0 10px 0 0">
				
					<header class="card-header text-white text-center bg-dark">
						<h4>Géstion des données</h4>
					</header>
					<nav class="list-group list-group-flush bg-dark">
						<a href="/projetQCM/admin" class="list-group-item list-group-item-action">Mon espace</a>
						<a href="/projetQCM/admin/adminProfesseur" class="list-group-item list-group-item-action">Enregistrer un professeur </a>
						<a href="/projetQCM/admin/adminEleve" class="list-group-item list-group-item-action">Enregistrer un élève </a>
						<a href="/projetQCM/admin/listQcm" class="list-group-item list-group-item-action">Lister les QCM</a>
						<a href="/projetQCM/admin/getNiveaux" class="list-group-item list-group-item-action">Lister les classes</a>
						<a href="/projetQCM/admin/articles" class="list-group-item list-group-item-action">Mes articles</a>	

					</nav>
			
				
			</section>

			<section class="col-md-9 my">
				
					
				<div class="card">
					<div class="card-header bg-dark text-white">
						<h2><strong>Liste des QCM</strong></h2>
					</div>	

					<div class="card-body">
						<?php if (isset($erreur)): ?>
								<div class="alert alert-danger col-lg-12 d-flex align-self-center mt-3">
									<?= $erreur ?>
								</div>
						<?php endif ?>
						
							

						<?php if(isset($qcm) && (!empty($qcm))): ?>
							<div class="pb-5">
								<h3>QCM : <?= htmlentities($qcm->libelle) ?></h3>
							</div>

							<div class="text-center">
									<?php $date=date('Y-m-d'); ?>
									<p>Tentatives autorisées: <strong>1</strong></p>
									<?php if($qcm->date_limite < $date): ?>
									<p>Ce test à été fermé le :<strong> <?= date('d/m/Y à 23:59', strtotime($qcm->date_limite)); ?></strong></p>
									<?php else: ?>
										<p>Date limite du QCM :<strong> <?= date('d/m/Y à 23:59', strtotime($qcm->date_limite)); ?> </strong></p>
									<?php endif ?>
									<?php  
										$jour= ($qcm->jour >1)? ' jours': ' jour';
										$heure= ($qcm->heure >1)? ' heures': ' heure';
										$minute= ($qcm->minute >1)? ' minutes': ' minute';	 
									?>

									<p>Durée du test :<strong> <?= ($qcm->jour > 0)? $qcm->jour.$jour : ''; ?> <?= ($qcm->jour > 0 )? ' , ': '' ?><?= ($qcm->heure > 0)? $qcm->heure.$heure : ''; ?><?= ($qcm->heure > 0 )? ' et ': '' ?><?= ($qcm->minute > 0)? $qcm->minute.$minute : ''; ?></strong></p>
									<p>Barème de notation : <strong>/<?= htmlentities($qcm->echelle_not); ?></strong></p>
									<p>Notation pour réponse correcte : <strong><?= htmlentities($qcm->notation_vrai); ?></strong></p>
									<p>Notation pour réponse incorrecte : <strong><?= htmlentities($qcm->notation_faux); ?></strong></p>


									<div class="mt-5 text-left">
											<?php $i=1; ?>
											<?php if(!empty($qcm->questions)): ?>
											<?php foreach($qcm->questions as $question): ?>
												<h5 class="text-info">Question <?= $i; ?> :</h5>
												<div class="form-group bg-light p-3 mb-0" id="">
													<label class="col-form-label" for="question<?= $question->id ?>"><i class="fas fa-hand-point-right text-info"></i><strong class="py-2 pl-4"><?= htmlentities($question->question); ?>  </strong></label>
													<input type="text" name="question[<?= $question->id ?>]" class="col-sm-8 form-control"  value='<?= $question->id ?>' id="question<?= $question->id ?>" hidden>
											    	
												</div>

												<div class="ml-5 reponses bg-light px-5 py-3">
													<?php if(!empty($question->reponses)): ?>
													<?php foreach($question->reponses as $reponse): ?>
														<?php 

															$check='';
															$icon='';
															$iconFalse='';
												
															if ($reponse->valeur=='vrai') 
															{	
																$icon='<i class="fas fa-check text-success"></i>';
																$check='checked';
																$iconFalse='';
															}
														?>		
														<div class="form-check row p-2 pl-4">
														
															<input type="checkbox" name="reponses[<?= $question->id ?>][<?= $reponse->id ?>]" class="form-check-input me-1" value="<?= $reponse->id ?>" id="reponse<?= $reponse->id ?>" disabled <?= $check ?>>	
															 <label class="form-check-label" for="reponse<?= $reponse->id ?>"><strong><?= htmlentities($reponse->reponse) ?></strong> <?= $icon ?? '' ?><?= $iconFalse ?? '' ?></label>
														
														</div>
														
														<?php if ($reponse->valeur == 'vrai'): ?>		
																<?php $bn_Rep= $reponse->reponse; ?>
														<?php endif ?>
											
													<?php endforeach ?>
													<?php endif ?>										
												</div>

												<div class="bg-secondary mb-5 mt-1 pl-5 pt-2 text-white" style="min-height: 6rem;">		
													<div>
														<p>La reponse valide est : <strong><?= $bn_Rep?? 'Aucune'; ?></strong></p>	
													</div>
												</div>

											<?php $i++; ?>
											<?php endforeach ?>
											<?php endif ?>
										
									</div>
							</div>

						<?php else: ?>

							<div class=" card col-sm-12 text-center mt-4 p-5">
								<p>Qcm introuvable</p>
							</div>
						<?php endif ?>

					</div>	
				</div>

				<div class="mt-3">
					
					<?php if(isset($qcm) && isset($qcm->theme) ): ?>
						<a href="/projetQCM/admin/listQcm/<?= htmlentities($qcm->theme) ?? '';  ?>"><i class="fas fa-angle-double-left"></i> Page précédente </a>	
					<?php endif ?>
				</div>		
			</section>	
		</div>
	</div>
</div>
<script src="/projetQCM/public/js/admin/adminQcm.js?v=<?= time() ?>"></script>

