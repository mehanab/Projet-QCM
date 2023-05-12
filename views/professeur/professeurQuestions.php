<?php 

$titre='Toutes les questions'; 
?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    	<li class="breadcrumb-item"><a href="/professeur/questions">Choisir un thème</a></li>
		    	<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Toutes les questions</li>
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
						<h2><strong>Les questions</strong></h2>
					</div>		
				</div>
				
				
				<div class="row d-flex justify-content-between">

				<form action="/professeur/create_qcm_validation" method="post" class="col-lg-12 needs-validation" novalidate>

					<div class="row d-flex justify-content-between">
						<div class="card p-4 col-lg-12 my-3" id="enregistrement_suite">
						
							<div class="card-header bg-white">
								<h3>Thème : <i>"<?= isset($theme)? $theme->libelle: ''; ?>"</i></h3>
							</div>

							<?php if(isset($questions) && !empty($questions)): ?>
							
							<div  class="card-body" id="questionReponse">
								<?php $pages= null; $num=1; ?>
								<?php foreach ($questions as $question): ?>
									
									<div class="bg-light p-3 pl-3">
										
										<p class=" pl-3"><strong><?=$num; ?> - <?= htmlentities($question->question); ?></strong></p>
										  	
									</div>

									<div  class="collapse" id="divRep<?= $question->id; ?>">
										<div class="ml-5 bg-light px-5 py-3 ">
											<?php if(!empty($question->reponses)): ?> 
										
												<?php foreach($question->reponses as $reponse): ?>
													<?php 
													$valeur='<i class="fas fa-check text-success"></i>';
													if ($reponse->valeur=='faux') 
													{
														$valeur='<i class="fas fa-times text-danger"></i>';
													}
													?>
												<div>		
													<ol>
														<li><?= htmlentities($reponse->reponse); ?> <strong><?= $valeur ?></strong></li>
													</ol>
										
												</div>
												
												<?php endforeach ?>	
											<?php endif ?>
										</div>
									</div>
									<div class="pb-3 clearfix myCollapsible">
										<a class="float-right pr-5" data-toggle="collapse" href="" role="button" aria-expanded="false" aria-controls="divRep<?= $question->id ?>" >Voir les réponses</a>
									</div>
									<?php $pages= $question->count_pages; $num++; ?>
								<?php endforeach ?> 
								<?php if($pages && $pages > 1): ?>
								<a href="#" data-theme="<?= $theme->id ?? '' ?>" class="2" id="more_questions">Afficher plus</a>
								<?php endif ?>				
							</div>
							<?php endif ?>


						</div>
					</div>
					
					<a href="javascript:history.go(-1)" class="btn btn-primary">Page précédente </a>
					
				</form>
				</div>
			</div>

			</section>

			
			
		</div>
	</div>
</div>
<script src="/js/professeur/questions.js?v=<?= time() ?>"></script>
	
