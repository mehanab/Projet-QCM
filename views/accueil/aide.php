<?php $titre= "Aide"; ?>
<div>
	<nav aria-label="breadcrumb">
	      <ol class="breadcrumb" style="margin-bottom: 0px; ">
	      	<li class="breadcrumb-item"><a href="/">Accueil</a></li>
	        <li class="breadcrumb-item active" aria-current="articles">Aide</li>
	      </ol>
	</nav>
	<main role="main">

	      <section class="jumbotron text-center">
		        <div class="container">
			          <h1 class="jumbotron-heading">Comprendre notre site</h1>
			          <p class="lead text-muted">Facile, rapide et efficace.</p>
			          <p>
			            <a href="/" class="btn btn-primary my-2">&laquo; Retour à la page d'accueil</a>
			          </p>
		        </div>
	      </section>

	      <div class="album py-5 bg-light">
	        <div class="container-fluid">
	        	<div class="row mb-5 col-lg-12 row">
	        		<div class="pl-5 text-justify col-lg-8">
	        			<h3 class="text-muted">Mon espace personnel </h3>
	        			<p>Vous avez reçu vous identifiants de connexion par mail pour créer des QCM et évaluer vos classes ? connectez-vous à votre <a href="/professeur"> espace professeur ici</a>.  Vous êtes élève et vous souhaitez répondre aux évaluations de vos professeurs en ligne ? vous êtes au bon endroit. Connectez vous à <a href="/eleve">votre espace élève.</a></p>

	        			<h3 class="text-muted">Mot de passe oublié </h3>
	        			<p>Vous avez oublié votre mot de passe ou vous souhaitez le changer ? dans l'espace de connexion cliquez sur "mot de passe oublié" et replissez les informations nécessaires. Un nouveau mot de passe sera géneré automatiquement et vous sera envoyé à votre boite mail. </p>

	        			<h3 class="text-muted">Créer votre quiz</h3>
	        			<p>Dans votre espace professeur, rubrique "créer un nouveau QCM", choisissez une des deux options proposées : séléction dans la banque de questions ou saisie manuelle de questions. N'oubliez pas de parametrer votre quiz, dont la durée peut être limitée. </p>

	        			<h3 class="text-muted">Partage de QCM</h3>
	        			<p>Votre QCM est crée à l'instant où vous le valider mais il reste invisible pour vos élèves tant que vous ne l'avez pas partagé. Le partage des QCM au niveau d'une ou plusieures classes se fait en un clique. Dans la rubrique mes QCM, cliquez sur l'icon de partage qui apparaît devant chacun de vos tests puis selectionnez les classes que vous voulez évaluer. A chaque nouvelle question créee dans un test, celle-ci est ajoutée à la banques de questions, commune à tous les professeurs.</p>

	        			<h3 class="text-muted">Consulter les resultats de votre classe</h3>
	        			<p>Dans votre rubrique "résultat", consulter les notes obtenues par vos élèves dans chacune de vos classes avec les prénom, nom, adresse et email de chaque  personne évalué. </p>

	        			<h3 class="text-muted">Les QCM de ma classes</h3>
	        			<p>L'application permet une gestion souple des QCM dans l'espace élève en les regroupant par thème. Une notification appraît dans chaque thème indiquant le nombre de QCM auquelles vous n'avez pas encore répondu.</p>

	        			<h3 class="text-muted">En ligne ?</h3>
	        			<p>Gérez vos stocks de questions et vos questionnaires dans "Le QCM".Enregistez vos tests et pouvez ensuite décider, de le modifier, supprimer, ou, au dernier moment, de mettre en ligne. </p>

	        			<h3 class="text-muted">Contact</h3>
	        			<p>Que vous soyez élève ou professeur, vous pouvez contacter notre webmaster à tous moment. Les coordonnées de contact sont dans la rubrique "contact". </p>

		        	</div>
		        	<aside class="col-lg-4 ">
			        	<div class="d-flex flex-column col-lg-8 float-right">
			        		<nav class="float-right">
			        			<ul class="list-group list-group-flush">
			        				<li class="list-group-item bg-light"><a href="/accueil/articles">Articles</a></li>
			        				<li class="list-group-item bg-light"><a href="/accueil/apropos">A propos</a></li>
			        				<li class="list-group-item bg-light"><a href="/accueil/aide">Aide</a></li>
			        			</ul>
			        		</nav>
			        		<nav class="float-right mt-5">
			        			<h5 class="text-muted">Derniers articles </h5>
				        		<?php if (isset($articles) && !empty($articles)): ?>
				        			<?php foreach($articles as $article): ?>
				        				<div class="mt-4">
				        				<a href="/accueil/article/<?= $article->id ?>" class="text-muted">
				        					<strong class="center-block"><?= $article->titre ?> <br> </strong>
				        					<span class="card-body"><?= substr($article->article, 0, 100) ?>...</span><br><span class="text-primary">(lire la suite)</span></a>
				        				</div>
				        			<?php endforeach ?>
			        			<?php endif ?>
			        		</nav>
			        	</div>

		        	</aside>
		        	
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
</div>

