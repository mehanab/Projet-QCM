<?php 

$titre='Mes classes'; 
?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    	<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Mes classes</li>
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
						<h2><strong>Mes classes</strong></h2>
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

				
				<div class="row" id="myList">
					<?php if(isset($classes) && !empty($classes)): ?>
						<?php foreach ($classes as $classe): ?>
						<?php 
							$href='';
							$bg='disabled';
							if(count($classe->eleves) > 0)
							{
								$href="href='#list".$classe->id."'";
								$bg='';
							}
						?>
						
						<a <?= $href; ?> class="card-link border-light btn btn-outline-info mt-2 <?= $bg; ?> " style="margin-left: 10px;" id="list-eleves<?= $classe->id ?>" data-toggle="list" role="tab" aria-controls="liste_eleves_classe<?= $classe->id ?>">

							<div class="card my-3 text-white border-info bg-info" style="max-width: 10rem; min-height: 15rem;">

								<div class="card-header text-center">
									<h4 class="card-title"><?= htmlentities($classe->libelle); ?></h4>
									<p>(<?= htmlentities($classe->niveau->libelle); ?>)</p>
								
								</div>

								<div class="card-body">
							
									<p class="card-text">Nombre d'élèves : <strong>( <?= count($classe->eleves );?> )</strong></p>
								</div>
							</div>
						</a>
						<?php endforeach ?> 

					<?php else: ?>
						<div class="col-sm-12 text-center my-5">
							<p>Vous n'avez aucune classe pour le moment !</p>
						</div>

					<?php endif ?>

				</div>
				<div class="mt-5">
					<div class="tab-content" id="nav-tabContent">
						<?php if(isset($classes) && !empty($classes)): ?>
							<?php foreach($classes as $classe): ?>
								<?php if(!empty(count($classe->eleves))): ?>
									 <div class="tab-pane fade" id="list<?=$classe->id; ?>" role="tabpanel" aria-labelledby="list-eleves<?=$classe->id; ?>">
									 	<table class="table text-white table-responsive">
									 		<thead class="bg-secondary">
									 			<tr>
									 				<td><strong>Nom</strong></td>
									 				<td>Prenom</td>
									 				<td>Sexe</td>
									 				<td>Mail</td>
									 				<td>Date de naissance</td>
									 			</tr>
									 		</thead>
									 		<tbody class="bg-white text-dark">
									 		<?php foreach($classe->eleves as $eleve): ?>
									 			<tr>
									 				<td><strong><?= $eleve->nom; ?></strong></td>
									 				<td><strong><?= $eleve->prenom; ?></strong></td>
									 				<td><?= $eleve->sexe; ?></td>
									 				<td><?= $eleve->mail; ?></td>
									 				<td><?= date('d/m/Y',strtotime($eleve->date_de_naissance)); ?></td>
									 			</tr>
									 		<?php endforeach ?>
									 		</tbody>
									 	</table>

									 </div>

								<?php endif ?>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
				<a href="javascript:history.go(-1)" class="btn btn-primary mt-5">Page précédente </a>

			</div>

			</section>

			
			
		</div>
	</div>
</div>
<script src="/js/professeur/classes.js?v=<?= time() ?>"></script>
	
