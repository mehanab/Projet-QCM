<?php 
$titre='Commencer le test';
$date=date('Y-m-d');

?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    	<li class="breadcrumb-item"><a href="/eleve/mes_qcm">Mes QCM</a></li>
		    	<li class="breadcrumb-item"><a href="/eleve/qcm/<?= $qcm->id ?? '' ?>"><?= htmlentities($qcm->libelle) ?? '' ?></a></li>
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
					
						<a href="/eleve/mes_qcm" class="list-group-item list-group-item-action pl-5" >Mes QCM</a>
						<a href="/eleve/notes" class="list-group-item list-group-item-action pl-5">Notes</a>
						<a href="/eleve/ma_classe" class="list-group-item list-group-item-action pl-5">Ma classe</a>
						<a href="/eleve/contact" class="list-group-item list-group-item-action pl-5">Contact</a>
						<a href="/logout" class="list-group-item list-group-item-action pl-5" id="">Se déconnecter</a>	
								
					</nav>
				</div>
				
			</section>

			<section class="col-md-9">
				<div class="card text-center d-flex row bg-danger">
					<div class="card-body bg-danger text-white">
						<h2><strong>Thème: <?= htmlentities($qcm->theme)?? ''; ?></strong></h2>
					</div>
				</div>
			

				<div class="row d-flex justify-content-between">
					<div class="card col-lg-8 my-3"style="min-height: 20rem;">
						<?php if(isset($qcm)): ?>

							<div class="my-3 mx-3 card-header bg-white mb-5">
								<h3>QCM : <?= htmlentities($qcm->libelle); ?></h3>
							</div>

							<form action="/eleve/validationQcm" method="post" id="form">

								<input type="checkbox" name="qcm" aria-label="identiant qcm" class="col-sm-8 form-control"  value='<?= $qcm->id ?>'checked hidden>

								<?php $i=1; ?>
								<?php foreach($qcm->questions as $question): ?>
									<h5 class="text-info">Question <?= $i; ?> :</h5>
									<div class="form-group bg-light p-3 mb-0" id="">
										<label class="col-form-label" for="question<?= $question->id ?>"><i class="fas fa-hand-point-right text-info"></i><strong class="py-2 pl-4"><?= htmlentities($question->question); ?>  </strong></label>
										<input type="text" name="question[<?= $question->id ?>]" class="col-sm-8 form-control"  value='<?= $question->id ?>' id="question<?= $question->id ?>" hidden>
								    	
									</div>

									<div class="mb-5 ml-5 reponses bg-light px-5 py-3">
										<?php foreach($question->reponses as $reponse): ?>		
											<div class="form-check row p-2 pl-4">
												<input type="checkbox" name="reponses[<?= $question->id ?>][<?= $reponse->id ?>]" class="form-check-input" value="<?= $reponse->id ?>" id="reponse<?= $reponse->id ?>">		
												<label class="form-check-label" for="reponse<?= $reponse->id ?>"><strong><?= htmlentities($reponse->reponse) ?></strong></label>
											
											</div>

										<?php endforeach ?>
													
									</div>
								<?php $i++; ?>
								<?php endforeach ?>
								<div class="text-center">
									<button type="submit" class="btn btn-primary my-3">Soumettre</button>
								</div>
							</form>
							
							
						<?php else:  ?>
							<div class="alert alert-danger text-center">
								<p>Une erreur s'est produite</p>
							</div>
						<?php endif ?>
					</div>
					<div class="col-lg-4 my-3 d-flex align-self-start">
						<?php if(isset($qcm)): ?>
							
						<div class="card col-sm-12" id="chrono">
							<div class="card-header bg-white text-center">
								<h4 class="card-title">Temps restant</h4> 
							</div>

							<div class="card-body text-center">
								<div class="bg-info text-white py-3">
									<h4 class="card-title" id="temps"><span id="heure"><?= ($qcm->heure <10)? '0'.$qcm->heure: $qcm->heure; ?></span>:<span id="minute"><?= ($qcm->minute < 10)? '0'.($qcm->minute) : ($qcm->minute) ?></span>:<span id="seconde">00</span></h4>
								</div>

							</div>
						</div>
						<?php endif ?>
						
					</div>
				</div>
					
			</section>
			
		</div>
		
		
	</div>
</div>
<script src="/js/eleve/questionsQcm.js?v=<?= time() ?>"></script>





