<?php $titre= "Accueil"; ?>
 <main role="main">
      <img class="img-fluid" src="/img/accueil/background-L.jpg" width="1300" style="height: 420px;">
      <div class="jumbotron bg-white">
          <div class="container">
              <h1 class="display-3">Bienvenue</h1>
              <p class="text-justify">Le QCM est une application gratuite de QCM interactifs qui utilise, en autre, une base de questions commune à tous les professeurs. Vous pouvez simplement créer et enregistrer vos QCM, ou les partager avec vos classes, en quelques cliques.  Les étudiants peuvent y répondre aux QCM (questions à choix multiples avec des sélections simples ou multiples) et consulter leurs notes instantanément.</p>
              <p><a class="btn btn-primary btn-lg" href="accueil/apropos" role="button">Continuer à lire &raquo;</a></p>
          </div>
      </div>

      <div class="container">
        
        <div class="row">
          <?php if(isset($articles) && !empty($articles)): ?>
              <?php foreach($articles as $article): ?>
                  <div class="col-md-4">  
                      <h2><?= $article->titre ?></h2>
                      <?php if(strlen($article->article) > 150): ?>

                          <p class="afficher"><?= substr($article->article, 0, 150) ?><span class="masquer"><?= substr($article->article, 150) ?></span></p>
                          <small class="text-muted">Ajouté le <?= date('d/m/Y à H:i', strtotime($article->ajoute_le)) ?></small>
                          <p class="pt-4"><a class="btn btn-secondary btnClick" href="" role="button">Voir les détails &raquo;</a></p>
                          
                      <?php else: ?>

                          <p><?= $article->article ?></p>
                          <small class="text-muted">Ajouté le <?= date('d/m/Y à H:i', strtotime($article->ajoute_le)) ?></small>
                    
                      <?php endif ?>
                  </div>
              <?php endforeach ?>
          <?php else: ?>
              <div>
                
              </div>
          <?php endif ?>
        </div>

        <hr>

      </div> 

</main>

<div class="container">
  <p>&copy; Le QCM 2020-2021</p>
</div>
<script src="/js/default/defaultArticle.js?v=<?= time() ?>"></script>