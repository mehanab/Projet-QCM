<?php $titre='Choisir un thème'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Choisir un thème</li>
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
				
					
				<div class="card text-center d-flex row bg-secondary">
					<div class="card-body bg-dark text-white">
						<h2><strong>Choisir un thème</strong></h2>
					</div>		
				</div>
				
				
				<div class="row">
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
					
						

					<?php if(isset($themes) && (!empty($themes))): ?>
						<?php foreach($themes as $theme): ?>

							<?php 
							$href='';
							$bg='disabled';
							if($theme->nombre_qcm > 0)
							{
								$href="href='/admin/listQcm/".$theme->libelle."'";
								$bg='';
							}
							?>
							<a <?= $href; ?> class="card-link border-light btn btn-outline-info <?= $bg ?> mt-2" style="margin-left: 10px;">

								<div class="card my-3 text-white border-info bg-info" style="max-width: 10rem; min-height: 15rem;">

									<div class="card-header text-center">
										<h4 class="card-title"><?= htmlentities($theme->libelle); ?></h4>
									</div>

									<div class="card-body">
										<p class="card-text">Nombre de QCM : <strong>( <?= $theme->nombre_qcm; ?> ) </strong></p>
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

