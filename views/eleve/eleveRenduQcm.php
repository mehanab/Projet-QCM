<?php 
$titre= $qcm->libelle ?? 'QCM';
$date=date('Y-m-d');
?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/projetQCM/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    	<li class="breadcrumb-item"><a href="/projetQCM/eleve/mes_qcm">Mes QCM</a></li>
		   		<li class="breadcrumb-item active" aria-current="<?= $titre; ?>"><?= $titre ?></li>
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
						<h2><strong>Thème: <?= htmlentities($qcm->theme)?? ''; ?></strong></h2>
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
					<?php if(isset($qcm)): ?>
						<div class="my-3 mx-3">
							<h3>QCM : <?= htmlentities($qcm->libelle); ?></h3>
						</div>
						<div class="text-center">
							<p>Tentatives autorisées: <strong>1</strong></p>
							<?php if($qcm->date_limite < $date): ?>
								<p>Ce test a été fermé le :<strong> <?= date('d/m/Y à 23:59', strtotime($qcm->date_limite)); ?></strong></p>
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


						</div>
						<?php if($qcm->note_eleve): ?>
						<div class="d-flex justify-content-center mt-2">
							<table class="table col-sm-11">
								<thead class="thead-light border-secondary">
									<tr>
										<th scope="col">Etat</th>
										<th scope="col" class="text-center">Note</th>
										<th scope="col" class="text-center"> Action</th>
									</tr>
									
								</thead>
								<tbody>
									<tr>
										<td scope="col" class="d-flex flex-column">Terminé <span class="card-subtitle text-muted mt-1">Remis le : <?= date('d/m/Y à H:i', strtotime($qcm->note_eleve->remis_le));?></span></td>
										<td class="text-center"><strong><?= $qcm->note_eleve->note; ?>/<?= $qcm->echelle_not; ?></strong></td>
										<td scope="col" class="text-center"><a href="/projetQCM/eleve/review/<?= $qcm->id; ?>" class="text-danger">Relecture</a></td>
									</tr>
								</tbody>
								
							</table>
						</div>

						<?php elseif($qcm->date_limite >= $date): ?>
						<div class="d-flex justify-content-center mt-2">
							<table class="table col-sm-11">
								<thead class="thead-light border-secondary">
									<tr>
										<th scope="col">Etat</th>
										<th scope="col" class="text-center"> Action</th>
									</tr>
									
								</thead>
								<tbody>
									<tr>
										<td scope="col">Non terminé</td>
										<td scope="col" class="text-center"><a href="/projetQCM/eleve/qcm_questions/<?= $qcm->id; ?>" class="text-danger">Commencer le test</a></td>
									</tr>
								</tbody>
								
							</table>
						</div>

						<?php else: ?>
						<div class="d-flex justify-content-center mt-2">
							<table class="table col-sm-11">
								<thead class="thead-light border-secondary">
									<tr>
										<th scope="col">Etat</th>
										<th scope="col" class="text-center">Note</th>
									</tr>
									
								</thead>
								<tbody>
									<tr>
										<td scope="col" class="d-flex flex-column">Terminé <span class="card-subtitle text-muted mt-1">Remis le : Non-remis</span></td>
										<td class="text-center"><strong>0/<?= $qcm->echelle_not; ?></strong></td>
									</tr>
								</tbody>
								
							</table>
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
<script src="/projetQCM/public/js/eleve/renduQcm.js?v=<?= time() ?>"></script>





