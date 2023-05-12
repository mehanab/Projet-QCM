<?php 
$titre='Ma classe';
?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		  		<li class="breadcrumb-item"><a href="/projetQCM/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    	<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Ma classe</li>
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
					
						<a href="/projetQCM/eleve/mes_qcm" class="list-group-item list-group-item-action pl-5" >Mes QCM</a>
						<a href="/projetQCM/eleve/notes" class="list-group-item list-group-item-action pl-5">Notes</a>
						<a href="/projetQCM/eleve/ma_classe" class="list-group-item list-group-item-action pl-5">Ma classe</a>
						<a href="/projetQCM/eleve/contact" class="list-group-item list-group-item-action pl-5">Contact</a>
						<a href="/projetQCM/logout" class="list-group-item list-group-item-action pl-5" id="">Se déconnecter</a>				
					</nav>
				</div>
				
			</section>

			<div class="col-md-9">
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
				<div class="d-flex justify-content-between">
					<div class="card col-sm-12" style="min-height: 20rem;">
						<div class="card-header bg-white">
							<h3 class="card-title">Ma classe</h3>
						</div>	
						<div class="card-body text-center">
						<?php if(isset($classe)): ?>
						
							<p><strong>Classe : </strong><strong class="text-primary"><?=$classe->libelle ?></strong></p>
							<p><strong>Niveau : </strong><strong class="text-primary"><?=$classe->niveau->libelle ?></strong></p>
							<div class="">
								<p><strong>Professeurs : </strong></p>
								
								<ul class="pl-5">
									<?php if(!empty($classe->professeurs)): ?>
										<?php foreach($classe->professeurs as $professeur): ?>
											<li class="list-group-item border-white"><strong class="text-primary"><?= $professeur->nom.' '.$professeur->prenom ?></strong></li>
										<?php endforeach ?>
									<?php else: ?>
										<p>Votre classe n'a pas encore de professeurs. </p>
									<?php endif ?>
								</ul>
							</div>
						
						<?php else: ?>
							<p>Vous n'êtes inscrit dans aucune classe pour le moment.</p>
						<?php endif ?>
						</div>
						
					</div>
				</div>				
			</div>
			
		</div>
		
		
	</div>
</div>






