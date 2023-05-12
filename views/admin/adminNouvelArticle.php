<?php $titre='Ajouter un article'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/projetQCM/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item"><a href="/projetQCM/admin/articles">Mes articles</a></li>
	    	<li class="breadcrumb-item active" aria-current="Ajouter un article">Ajouter un article</li>
		  </ol>
	</nav>

	<div class="container-fluid">

		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 my " style="padding: 0 10px 0 0">
				
					<header class="card-header text-white text-center bg-dark">
						<h4>Géstion des données</h4>
					</header>
					<nav class="list-group list-group-flush bg-dark">
						<a href="/projetQCM/admin" class="list-group-item list-group-item-action">Mon espace</a>
						<a href="/projetQCM/admin/adminProfesseur" class="list-group-item list-group-item-action">Enregistrer un professeur </a>
						<a href="/projetQCM/admin/adminEleve" class="list-group-item list-group-item-action">Enregistrer un élève </a>
						<a href="/projetQCM/admin/listQcm" class="list-group-item list-group-item-action">Lister les QCM</a>
						<a href="/projetQCM/admin/getNiveaux" class="list-group-item list-group-item-action">Lister les classes</a>
						<a href="/projetQCM/admin/articles" class="list-group-item list-group-item-action">Mes articles</a>	

					</nav>
			
				
			</section>

			<section class="col-md-9 my">
				
					
				<div class="card">
					<div class="card-header bg-dark text-white">
						<h2><strong>Ajouter un article</strong></h2>
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

						<form action="/projetQCM/admin/ajouter_article" method="post" id="modif">
							
							<div class="mb-3">
								  <label for="titre" class="form-label"><strong>Titre</strong></label>
								  <input type="text" class="form-control" id="titre" placeholder="titre de l'article" name="titre" value="<?= $_POST['titre']?? '' ?>">
							</div>
							<div class="mb-3">
								  <label for="contenu" class="form-label"><strong>Article</strong></label>
								  <textarea class="form-control" name="article" id="contenu" rows="6" placeholder="Texte ..."><?= $_POST['article']?? '' ?></textarea>
							</div>
							
							<div class="pt-3 text-center" id="btnSupp">
								<button type="submit" class="btn btn-primary">Ajouter</button>
							</div>
						</form>			
									
					</div>	
				</div>

				<div class="mt-3">
					<a href="javascript:history.go(-1)"><i class="fas fa-angle-double-left"></i> Page précédente </a>	
				</div>				
			</section>	
		</div>
	</div>
</div>

 
