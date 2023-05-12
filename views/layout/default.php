<?php
$espace=$_SESSION['statut']?? null;
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $titre ?? 'Mon site' ?></title>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d61ff5f27a.js" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg navbar-dark text-white bg-dark">
		  <a class="navbar-brand btn-lg" href="/"><img src="/img/accueil/logo.png" width="80"></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse d-lg-flex justify-content-between" id="navbarNav">
			    <ul class="navbar-nav">
				      <li class="nav-item active">
				        <a class="nav-link btn btn-lg ml-1" href='/accueil'>Accueil<span class="sr-only">(current)</span></a>
				      </li>
				      <li class="nav-item active">
				        <a class="nav-link btn btn-lg ml-1" href="/accueil/articles">Articles</a>
				      </li>
				      <li class="nav-item active">
				        <a class="nav-link btn btn-lg ml-1" href="/accueil/apropos">A propos</a>
				      </li>
				      <li class="nav-item active">
				        <a class="nav-link btn btn-lg ml-1" href="/accueil/aide">Aide</a>
				      </li>
			    </ul>
			    
		  		<ul class="navbar-nav mr-3">
		  			
	  				<?php if(isset($_SESSION['user_id'])): ?>
	  				<li class="dropdown active">
	  					<a class="nav-link btn btn-md btn-secondary ml-1 dropdown-toggle" id="menuDec" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"><i class="fas fa-cog fa-2x" aria-label="choix action"></i></a>
	  					<ul class="dropdown-menu mr-lg-5" aria-labelledby="menuDec" style="min-width: 7rem;">
	  						<li><a class="dropdown-item pl-lg-3 pr-lg-2" href="/logout"><i class="fas fa-sign-out-alt pr-2"></i> Quitter</a></li>
							<li><a class="dropdown-item pl-lg-3 pr-lg-2" href="/<?= $espace ? $espace.'/monCompte' : 'logout' ?>"><i class="fas fa-user-cog pr-2"></i> Mon compte</a></li>	
						</ul>
	  				</li>
	  				<?php else: ?>
	  				<li class="dropdown pr-lg-4">
	  					<a class="btn btn-md btn-outline-secondary ml-1 dropdown-toggle col-sm-12" id="menuConnex" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"><i class="fas fa-user pr-2"></i> <span class="pr-2">Se connecter</span></a>
	  					<ul class="dropdown-menu" aria-labelledby="menuConnex">
	  						<li><p class="dropdown-item text-center">Vous êtes :</p></li>
	  						<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="/professeur"><i class="fas fa-user pr-2 text-info"></i>Professeur</a></li>
							<li><a class="dropdown-item" href="/eleve"><i class="fas fa-user pr-2 text-danger"></i>Eleve</a></li>
							<li><a class="dropdown-item" href="/admin"><i class="fas fa-user pr-2 text-secondary"></i>Administrateur</a></li>
						</ul>

	  				</li>
	  				<?php endif ?>

	  				<?php if ($espace) : ?>
		  			<li class="nav-item active">
		  				<a class="nav-link btn btn-md btn-secondary ml-1" href="/<?= $espace ?>" aria-label="mon espace" id="espace"><i class="fas fa-user-circle fa-2x"></i></a>
		  			</li>
		  			<?php endif ?>	
		  		</ul>		 
		  </div>
		    
	</nav>

						



	 <?= $content ; ?>


	<footer class="bg-dark mt-5 py-5 text-center">
		<p class="text-white align-self-end ">Le QCM - <i>Tous droits réservés-2021</i></p>
		
	</footer>

	<script src="/js/default/default.js?v=<?php echo time(); ?>" type="text/javascript"></script>


	</body>
</html>