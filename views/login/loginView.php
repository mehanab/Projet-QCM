<?php 
$_SESSION['role']= $_SESSION['role'] ?? 'eleve';
?>

<div class="p-4 text-center d-flex justify-content-center" style="min-height: 21rem;">
	<div class="card col-sm-5 p-5">
		
		<div class="card-header bg-white">
			<?php if($_SESSION['role']=='eleve'): ?>
			<?php $title= 'Espace élève'; ?>
			<h2 class="card-title"><?= $title ?></h2>
			<p class="card-text text-muted">Vous êtes professeur ? <a href="/professeur"> cliquez ici</a></p>
			<?php elseif($_SESSION['role']=='professeur') : ?>
			<?php $title= 'Espace professeur'; ?>
			<h2 class="card-title"><?= $title ?></h2>
			<p class="card-text text-muted">Vous êtes élève ? <a href="/eleve"> cliquez ici</a></p>
			<?php elseif($_SESSION['role']=='admin') : ?>
			<?php $title= 'Espace Administrateur'; ?>
			<h2 class="card-title"><?= $title ?></h2>
			<p class="card-text text-muted">Vous êtes élève ? <a href="/eleve"> cliquez ici</a></p>
			<?php endif ?>
		</div>
		
		
		<?php if(isset($erreur)): ?>
			<div class="alert alert-danger">
				<?= $erreur ?>
			</div>
		<?php endif ?>
		<div class="card-body">
			<form action="/login/user" method="post">
				<input type="text" name="<?= $_SESSION['role'] ?>" hidden>
				<div class="form-group text-left">
					<label class="col-sm-5 col-form-label" for="pseudo"><strong>Pseudo</strong></label>
					<input type="text" name="pseudo" class="form-control" placeholder="Votre pseudo" id="pseudo">
				</div>
				<div class="form-group text-left">
					<label class="col-sm-5 col-form-label" for="password"><strong>Mot de passe</strong></label>
					<input type="password" name="password" class="form-control" placeholder="Votre mot de passe" id="password">
				</div>
				<button type="submit" class="btn btn-primary">Connexion</button>
				
			</form>
		</div>
		<div class="card-footer bg-white">
			<p>Mot de passe oublié ? <a href="login/passCompte"> cliquez ici</a></p>
		</div>
		
	</div>

</div>