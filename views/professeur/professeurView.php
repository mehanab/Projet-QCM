<?php
$titre = 'Espace professeur';
if (!isset($_SESSION['user_id']) || $_SESSION['statut']!= 'professeur' && $_SESSION['statut']!= 'admin') {
	header('Location: /login');
	exit();
}

?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Mon espace</li>
		  </ol>
	</nav>

	<div class="container-fluid">
		<div class="d-md-flex flex-row justify-content-between">
			<section class="col-md-3" style="padding: 0 10px 0 0">
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

			<div class="col-md-9">
				<div class="jumbotron">
				  <h1 class="display-4">Bonjour, <?= $_SESSION['professeur']['nom'] ?? ''; ?>!</h1>
				  <p class="lead">Cette application est dédiée à la création de QCM. Créer vos QCM rapidement, manuellement ou en choisissant des questions déjà créer par d'autres professeurs.</p>
				  <hr class="my-4">
				  <p>Vous disposez également entre professeur d'une base de questions commune que vous enrichissez à chaque nouveau QCM crée.</p>
				  <p class="lead">
				    <a class="btn btn-primary btn-lg" href="/professeur/new_qcm" role="button">C'est parti</a>
				  </p>
				</div>
				
			</div>
			
		</div>
		
		
	</div>
</div>
<script src="/js/professeur/professeurView.js?v=<?= time() ?>"></script>


