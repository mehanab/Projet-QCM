<?php $titre='Liste des QCM'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item"><a href="/admin/listQcm">Choisir un thème</a></li>
	    <li class="breadcrumb-item active" aria-current="<?= $qcm[0]->theme?? 'Liste QCM'?>"><?=  $qcm[0]->theme ?? 'Liste QCM' ?></li>
		  </ol>
	</nav>

	<div class="container-fluid">

		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 my " style="padding: 0 10px 0 0">
				
					<header class="card-header text-white text-center bg-dark">
						<h4>Géstion des données</h4>
					</header>
					<nav class="list-group list-group-flush bg-dark">
						<a href="/admin" class="list-group-item list-group-item-action">Mon espace</a>
						<a href="/admin/adminProfesseur" class="list-group-item list-group-item-action">Enregistrer un professeur </a>
						<a href="/admin/adminEleve" class="list-group-item list-group-item-action">Enregistrer un élève </a>
						<a href="/admin/listQcm" class="list-group-item list-group-item-action">Lister les QCM</a>
						<a href="/admin/getNiveaux" class="list-group-item list-group-item-action">Lister les classes</a>
						<a href="/admin/articles" class="list-group-item list-group-item-action">Mes articles</a>	

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
						<?php if (isset($succes)): ?>
								<div class="alert alert-success col-lg-12 d-flex align-self-center mt-3">
									<?= $succes ?>
								</div>
						<?php endif ?>
						
							

						<?php if(isset($qcm) && (!empty($qcm))): ?>
						<div class="clearfix pb-3">
							<form class="float-left pl-5 text-info" action="" id="select_all">
								<input class="form-check-input me-1" type="checkbox" name="check_all" value="" aria-label="selectionner_tout">Sélectionner tout
							</form>
							<a href="#" class="float-right"><i class="fas fa-trash-alt pr-2"></i>Supprimer</a>
						</div>

						<form action="/admin/deleteQcm" method="post">
							<ul class="list-group">
								<?php foreach($qcm as $qcm): ?>
									<li class="list-group-item pl-5">
										<input class="form-check-input me-1" type="checkbox" name="id_qcm[]" value="<?= $qcm->id ?>" aria-label="libelle-qcm">
										<a href="/admin/detail_qcm/<?= $qcm->id ?>">QCM : <?= $qcm->libelle; ?></a>
									</li>		
								<?php endforeach ?>
							</ul>
							<div class="pt-3 text-center" id="btnSupp">
								<button type="submit" class="btn btn-primary">Supprimer</button>
							</div>
						</form>

						<?php else: ?>

						<div class=" card col-sm-12 text-center mt-4 p-5">
							<p>Ce thème est vide.</p>
						</div>
						<?php endif ?>					
					</div>	
				</div>

				<div class="mt-3">
					<a href="javascript:history.go(-1)"><i class="fas fa-angle-double-left"></i> Page précédente </a>	
				</div>				
			</section>	
		</div>
	</div>
</div>
<script src="/js/admin/adminQcm.js?v=<?= time() ?>"></script>

