
<?php 
$titre='Mes notes';

?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/projetQCM/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		   		<li class="breadcrumb-item active" aria-current="<?= $titre; ?>">Mes notes</li>
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
				<div class="card text-center d-flex row bg-danger">
					<div class="card-body bg-danger text-white">
						<h2><strong>Mes notes</strong></h2>
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

				
				<div class="card my-3"style="min-height: 20rem;">
					<?php if(isset($themes)): ?>
					
						<?php if(!empty($themes)): ?>
							<?php $i=0; ?>
							<?php foreach($themes as $theme=> $mes_qcm): ?>
								
							<div class="card-header bg-white">
								<h3 class="card-title"><i class="fas fa-folder text-primary"></i><a data-toggle="collapse" href="#collapse-<?= $i; ?>" role="button" aria-expanded="false" aria-controls="collapse-<?= $theme; ?>"> <?= $theme; ?></a></h3>
							</div>
							<div class="card-body collapse" id="collapse-<?= $i?>">
								<?php if(!empty($mes_qcm)): ?>
									<table class="table">
										<thead class="bg-light">
											<tr>
												<th>Titre</th>
												<th>Note</th>
												<th>Date limite</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach ($mes_qcm as $qcm): ?>
											<tr>
												<td><a href="/projetQCM/eleve/qcm/<?= $qcm->id; ?>" class="card-link"> QCM : <?= $qcm->libelle ?></a></td>
												<td><strong><?= $qcm->note_eleve->note?? '-'?>/<?= $qcm->echelle_not; ?></strong></td>
												<td><?= date('d/m/Y à 23:59', strtotime($qcm->date_limite)); ?></td>
												
											</tr>

										<?php endforeach ?>
										</tbody>
									</table>
								
								<?php endif ?>
							</div>
							<?php $i++; ?>
							<?php endforeach ?>

						<?php else: ?>
							<div class="text-center pt-5">
								<p>Vous n'avez aucune note pour le moment.</p>
							</div>
						<?php endif ?>
					<?php else:  ?>
						<div class="alert alert-danger text-center">
							<p>Une erreur s'est produite</p>
						</div>
					<?php endif ?>
				</div>	
				
			</div>
			
		</div>
		
		
	</div>
</div>
<script src="/projetQCM/public/js/eleve/eleveQcm.js?v=<?= time() ?>"></script>





