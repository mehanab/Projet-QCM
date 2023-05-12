<?php $titre='Choisir un thème'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Choisir un thème</li>
		  </ol>
	</nav>

	<div class="container-fluid">

		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 my " style="padding: 0 10px 0 0">
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

			<section class="col-md-9 my">
				
					
				<div class="card text-center d-flex row bg-secondary">
					<div class="card-body bg-secondary text-white">
						<h2><strong>Choisir un thème</strong></h2>
					</div>		
				</div>
				
				
				<div class="row">
					<?php if (isset($erreur)): ?>
							<div class="alert alert-danger col-lg-12 d-flex align-self-center mt-3">
								<?= $erreur ?>
							</div>
					<?php endif ?>
					
						

					<?php if(isset($themes) && (!empty($themes))): ?>
						<?php foreach($themes as $theme): ?>

							<?php 
							$href='';
							$bg='disabled';
							if($theme->nombre_questions > 0)
							{
								$href="href='/projetQCM/professeur/questions/".$theme->libelle."'";
								$bg='';
							}
							?>
							<a <?= $href; ?> class="card-link border-light btn btn-outline-info <?= $bg ?> mt-2" style="margin-left: 10px;">

								<div class="card my-3 text-white border-info bg-info" style="max-width: 10rem; min-height: 15rem;">

									<div class="card-header text-center">
										<h4 class="card-title"><?= htmlentities($theme->libelle); ?></h4>
									</div>

									<div class="card-body">
										<p class="card-text">Nombre de questions: <strong>( <?= $theme->nombre_questions; ?> ) </strong></p>
									</div>
								</div>
							</a>
						<?php endforeach ?>
					<?php else: ?>

						<div class=" card col-sm-12 text-center mt-4 p-5">
							<p>Aucun thème n'a été rentré pour le moment</p>
						</div>
					<?php endif ?>

					
				</div>


			</section>	
		</div>
	</div>
</div>
<script src="/projetQCM/public/js/professeur/newQcm.js?v=<?= time() ?>"></script>
