<?php $titre='Détails de l\'articles'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item"><a href="/admin/articles">Mes articles</a></li>
	    	<li class="breadcrumb-item active" aria-current="<?= $article->titre?? 'détails de \'article' ?>"><?= $article->titre?? 'détails de \'article' ?></li>
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
						<h2><strong>Détails de l'article</strong></h2>
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
						
							

						<?php if(isset($article) && (!empty($article))): ?>
					
						<div class="clearfix pb-3">
							
							<a href="#" class="float-right"><i class="far fa-edit pr-2"></i>Modifier</a>
							
						</div>
						<div id="article">
							<div class="card-subtitle">
								<h3><?= $article->titre; ?></h3>
							</div>
							<div>
								<p><?= $article->article ?></p>
							</div>
							
						</div>

						<form action="/admin/editArticle" method="post" id="modif">
							<input type="text" name="id_article" value="<?= $article->id ?>" hidden> 
							<div class="mb-3">
								  <label for="titre" class="form-label"><strong>Titre</strong></label>
								  <input type="text" class="form-control" id="titre" placeholder="titre de l'article" name="titre" value="<?= $article->titre??'' ?>">
							</div>
							<div class="mb-3">
								  <label for="contenu" class="form-label"><strong>Article</strong></label>
								  <textarea class="form-control" name="article" id="contenu" rows="6"><?= $article->article; ?></textarea>
							</div>
							
							<div class="pt-3 text-center" id="btnSupp">
								<button type="submit" class="btn btn-primary">Modifier</button>
							</div>
						</form>

							

						<?php else: ?>

						<div class=" card col-sm-12 text-center mt-4 p-5">
							<p>Article introuvable.</p>
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
<script src="/js/admin/adminDetailArticle.js?v=<?= time() ?>"></script>
 
