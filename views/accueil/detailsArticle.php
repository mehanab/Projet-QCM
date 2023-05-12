<?php $titre= "Détails de l'article"; ?>
<nav aria-label="breadcrumb">
      <ol class="breadcrumb" style="margin-bottom: 0px; ">
        <li class="breadcrumb-item"><a href="/projetQCM/accueil">Accueil</a></li>
        <li class="breadcrumb-item"><a href="/projetQCM/accueil/articles">Articles</a></li>
        <li class="breadcrumb-item active" aria-current="détails de l'article"><?= $article->titre ?? 'Détails de l\'articles' ?></li>
      </ol>
</nav>
<article class="container mt-5">
	<?php if (isset($article)): ?>
      <div class="jumbotron" style="min-height: 20rem;">
	        <h1><?= $article->titre ?></h1>
	        <p class="lead"><?= $article->article ?></p>
	        <p class="text-muted float-right">Ajouté le <?= date('d/m/Y à H:i', strtotime($article->ajoute_le)) ?></p>
	        <a class="btn btn-primary" href="/projetQCM/accueil/articles" role="button">&laquo; Retour à la liste d'articles</a>
      </div>
     <?php else: ?>
     <div class="jumbotron text-center" style="min-height: 25rem;">
     	<p>Article introuvable</p>
     	<a class="btn btn-primary" href="../../components/navbar/" role="button">&laquo; Retour à la liste d'articles</a>
     </div>
     <?php endif ?>

</article>