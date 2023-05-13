<?php $titre='Changer mon mot de passe'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item"><a href="/admin/monCompte">Mon compte</a></li>
	    	<li class="breadcrumb-item active" aria-current="Changer mon mot de passe">Changer mon mot de passe</li>
		  </ol>
	</nav>
	<div class="p-4 text-center d-flex justify-content-center" style="min-height: 21rem;">
		<div class="card col-sm-5 p-5">
			
			<div class="card-header bg-white">
				<h2 class="card-title">Changer mon mot de passe</h2> 
			</div>
			
			
			<?php if(isset($erreur)): ?>
				<div class="alert alert-danger">
					<?= $erreur ?>
				</div>
			<?php endif ?>

			<div class="card-body">
				<form action="/admin/changer_password" method="post">
					
					<div class="form-group text-left">
						<label class="col-sm-12 col-form-label" for="password"><strong>Nouveau mot de passe</strong></label>
						<input type="password" name="password" class="form-control" placeholder="Votre mot de passe" id="password">
					</div>
					<small class="form-text text-muted">Le mot de passe doit être composé de 8 à 15 caractère: au moins une lettre majuscule, une minuscule, un chiffre, et un des caractère suivant:  $ @ % * + - _ !</small>
					<div class="form-group text-left">
						<label class="col-sm-12 col-form-label" for="confPassword"><strong>Confirmation du mot de passe</strong></label>
						<input type="password" name="confPassword" class="form-control" placeholder="Confirmation du mot de passe" id="confPassword">
					</div>
					<button type="submit" class="btn btn-primary col-sm-5">Modifier</button>
					
				</form>
			</div>
			
		</div>

	</div>
</div>