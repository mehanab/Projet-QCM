<?php 
$_SESSION['role']= $_SESSION['role'] ?? 'eleve';
?>

<div class="p-4 text-center d-flex justify-content-center" style="min-height: 21rem;">
	<div class="card col-sm-5 p-5">
		
		<div class="card-header bg-white">
			
			<h2 class="card-title">Mot de passe oublié </h2>
			<h6 class="card-subtitle text-muted">Votre nouveau mot de passe vous sera envoyé par mail à l'adresse comuniqué lors de votre inscription.</h6>
			
		</div>
		<?php if(isset($succes)): ?>
			<div class="alert alert-success">
				<?= $succes ?>
			</div>
		<?php endif ?>
		
		<?php if(isset($erreur)): ?>
			<div class="alert alert-danger">
				<?= $erreur ?>
			</div>
		<?php endif ?>
		<div class="card-body">
			<form action="/login/reinitialisation" method="post">
				
				<div class="form-group text-left">
					<label class="col-sm-5 col-form-label" for="nom"><strong>Nom</strong></label>
					<input type="text" name="nom" class="form-control" placeholder="Votre nom" id="nom">
				</div>
				<div class="form-group text-left">
					<label class="col-sm-5 col-form-label" for="prenom"><strong>Prenom</strong></label>
					<input type="text" name="prenom" class="form-control" placeholder="Votre prenom" id="prenom">
				</div>
				<div class="form-group text-left">
					<label class="col-sm-5 col-form-label" for="mail"><strong>Mail</strong></label>
					<input type="mail" name="mail" class="form-control" placeholder="Votre adresse email" id="mail" aria-descibedby="emailHelp">
					<div class="form-text text-muted" id="emailHelp">Adresse email : votre adresse de courriel personnelle, adresse communiquée lors de votre inscription, utilisée pour la communication des identifiants de connexion (pseudo et mot de passe).</div>
				</div>
				<div class="form-group text-left">
					<label class="col-sm-5 col-form-label" for="pseudo"><strong>Pseudo</strong></label>
					<input type="text" name="pseudo" class="form-control" placeholder="Votre pseudo" id="pseudo">
				</div>
				<button type="submit" class="btn btn-primary">Réinitialiser</button>
				
			</form>
		</div>
		<div class="card-footer bg-white">
			<p><a href="/login/login"> Revenir à la page de connexion</a></p>
		</div>
		
	</div>

</div>