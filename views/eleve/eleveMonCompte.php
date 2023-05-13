<?php $titre='Mon compte'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
	    	<li class="breadcrumb-item active" aria-current="Mon compte">Mon compte</li>
		  </ol>
	</nav>

	<div class="container-fluid" style="min-height: 30rem;">

		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-12">
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

				<div class="pt-4">
					<h3>Mon compte</h3>
				</div>
				
					
				<div class="media pt-4">
					<span class="align-self-start mt-2" src="..." aria-label="icon-user"><i class="far fa-user fa-6x p-4 bg-white"></i></span>
					<div class="media-body pt-0">
						<?php if(isset($_SESSION['eleve'])): ?>
							<ul>
								<li class="nav-link">Nom : <strong><?= $_SESSION['eleve']['nom'] ?></strong></li>
								<li class="nav-link">Prenom : <strong><?= $_SESSION['eleve']['prenom'] ?></strong></li>
								<li class="nav-link">Sexe : <strong><?= $_SESSION['eleve']['sexe'] ?></strong></li>
								<li class="nav-link">Date de naissance : <strong><?= date('d-m-Y', strtotime($_SESSION['eleve']['date_de_naissance'])); ?></strong></li>
								<li class="nav-link">Email : <strong><?= $_SESSION['eleve']['mail']; ?></strong></li>
								<li class="nav-link">Pseudo : <strong><?= $_SESSION['eleve']['pseudo']; ?></strong></li>
								<li class="nav-link">Adresse : <strong><?= isset($adresse)? $adresse->getNumeroVoie().' '.$adresse->getTypeVoie().' '.$adresse->getNomVoie().' '.$adresse->getComplementAdresse().' '.$adresse->getVille().' '.$adresse->getCodePostal() : '' ?></strong></li>
								<li class="nav-link d-md-flex flex-row"><p>Mot de passe : <strong>*********</strong></p> <p><a class="btn btn-outline-primary border-primary ml-5" type="button" data-bs-toggle="modal" data-bs-target="#myModal" id="showModal">Modifier</a></p></li>
							</ul>

						<?php endif ?>

						<div class="mt-3 ml-5">
							<a href="javascript:history.go(-1)"><i class="fas fa-angle-double-left"></i> Page précédente </a>	
						</div>	
						
					</div>
					
					
				</div>
		

				<div class="modal fade" id="myModal"  tabindex="-1" aria-labelledby="confimation identité" aria-hidden="true" role="dialog">
					<div class="modal-dialog">
					    <div class="modal-content">
						      <div class="modal-header">
							        <h5 class="modal-title">Confirmation utilisateur</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
						      </div>
						      <div class="modal-body">
							        <form action="/eleve/confirmer_password" method="Post">
								          <div class="mb-3">
									            <label for="recipient-name" class="col-form-label">Entrez votre mot de passe</label>
									            <input type="password" class="form-control" id="recipient-name" name="password">
								          </div>
								          <button type="submit" class="btn btn-primary">Confirmer</button>
								   
							        </form>
						      </div>
						      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						      </div>
					    </div>
					 </div>
				  
				</div>
								
			</section>	
		</div>
	</div>
</div>
<script src="/js/eleve/eleveMonCompte.js?v=<?= time() ?>"></script>
 
