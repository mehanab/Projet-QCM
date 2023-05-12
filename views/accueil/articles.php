<?php $titre= "Articles"; ?>
<nav aria-label="breadcrumb">
      <ol class="breadcrumb" style="margin-bottom: 0px; ">
      	<li class="breadcrumb-item"><a href="/">Accueil</a></li>
        <li class="breadcrumb-item active" aria-current="articles">Articles</li>
      </ol>
</nav>
<main role="main">

      <section class="jumbotron text-center">
	        <div class="container">
		          <h1 class="jumbotron-heading">Historique des articles</h1>
		          <p class="lead text-muted">Retrouvez ici tous les articles mis en ligne par nos administrateurs en commençant par les plus récents.</p>
		          <p>
		            <a href="/" class="btn btn-primary my-2">&laquo; Retour à la page d'accueil</a>
		          </p>
	        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
          	<?php if(isset($articles) && !empty($articles)): ?>
          		<?php foreach($articles as $article): ?>
		            <div class="col-md-4">
		              <div class="card mb-4 box-shadow">
			                <div class="card-body">
			                	<div class="card-header bg-white">
			                		<h3><?= $article->titre ?></h3>
			                	</div>
			                  	<p class="card-text pt-3"><?= substr($article->article, 0, 150) ?></p>
				                <div class="d-flex justify-content-between align-items-center">
					                    <div>
					                      <a href="/accueil/article/<?= $article->id ?>" class="btn btn-sm btn-outline-secondary">Lire</a>
					                    </div>
					                    <small class="text-muted">Ajouté le <?= date('d/m/Y à H:i', strtotime($article->ajoute_le)) ?></small>
				                </div>
			                </div>
		              </div>
		            </div>
		         <?php endforeach ?>
		    <?php else: ?>
		    	<div class="text-center">
		    		<p>Cette rubrique est vide pour l'instant.</p>
		    	</div>
        	<?php endif ?>
          </div>
        </div>
      </div>

</main>
<hr>
<div class="text-muted">
      <div class="container py-5">
        <p class="float-right">
          <a href="#">Haut de la page</a>
        </p>
      </div>
</div>
