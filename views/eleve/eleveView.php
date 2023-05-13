<?php 
if (!isset($_SESSION['user_id']) || $_SESSION['statut']!= 'eleve'  && $_SESSION['statut']!= 'admin') {
	header('Location: /login');
	exit();
}
$titre='Espace Eleve';
?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Mon espace</li>
		  </ol>
	</nav>

	<div class="container-fluid">
		<div class="d-md-flex flex-row justify-content-between">
			<section class="col-md-3" style="padding: 0 10px 0 0">
				<div class="card  d-flex align-self-start" >
					<header class="card-header text-white text-center bg-danger">
						<h4>Mon espace</h4>
					</header>
					<nav class="list-group list-group-flush bg-danger" id="navProf">
					
						<a href="/eleve/mes_qcm" class="list-group-item list-group-item-action pl-5" >Mes QCM</a>
						<a href="/eleve/notes" class="list-group-item list-group-item-action pl-5">Notes</a>
						<a href="/eleve/ma_classe" class="list-group-item list-group-item-action pl-5">Ma classe</a>
						<a href="/eleve/contact" class="list-group-item list-group-item-action pl-5">Contact</a>
						<a href="/logout" class="list-group-item list-group-item-action pl-5" id="">Se déconnecter</a>				
					</nav>
				</div>
				
			</section>

			<div class="col-md-9">
				<div class="jumbotron">
				  <h1 class="display-4">Bonjour, <?= $_SESSION['eleve']['nom'] ?? ''; ?> !</h1>
				  <p class="lead">Cette application est dédiée aux QCM. Consultez et répondez rapidement à tous les QCM concernants votre classe. A chaque nouveau QCM ajouté par votre professeur, une notification apparaît dans la rubrique "Mes QCM".</p>
				  <hr class="my-4">
				  <p>Vous pouvez également consulter toutes vos notes, les détails de chaque QCM, ainsi que le relecture des QCM que vous avez déjà fait.</p>
				  <p class="lead">
				    <a class="btn btn-danger btn-lg" href="/eleve/mes_qcm" role="button">Voir mes QCM</a>
				  </p>
				</div>
				
			</div>
			
		</div>
		
		
	</div>
</div>






