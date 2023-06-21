<?php $titre= 'Espace administrateur'; ?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Enregistrer un professeur</li>
		  </ol>
	</nav>

	<div class="container-fluid">

		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 my " style="padding: 0 10px 0 0">
				<header class="card-header d-flex justify-content-center text-white bg-dark">
					<h4>Géstion des données</h4>
				</header>
				<nav class="list-group list-group-flush bg-dark">
					<a href="/admin" class="list-group-item list-group-item-action">Mon espace</a>
					<a href="/admin/adminEleve" class="list-group-item list-group-item-action">Enregistrer un élève</a>
					<a href="/admin/listQcm" class="list-group-item list-group-item-action">Lister les QCM</a>
					<a href="/admin/getNiveaux" class="list-group-item list-group-item-action">Lister les classes</a>
					<a href="/admin/articles" class="list-group-item list-group-item-action">Mes articles</a>	

				</nav>
			</section>

			<article class="d-flex flex-column col-lg-9 card bg-dark text-white py-5 ml-lg-2">
				<?php if(isset($personneExist) && isset($other)): ?>
					<header class="alert alert-danger d-flex align-self-center card-header">
					<?php if (count($personneExist) > 1): ?>
						<h3>Attention : des personnes similaires sont déjà enregistrées. S'agit-il de l'une de ces personnes ?</h3>
					<?php else: ?>
						<h3>Attention : une personne similaire est déjà enregistré. S'agit il de cette personne ?</h3>
					<?php endif ?>
					</header>

					<form action="/admin/addPersonneExist" method="post" class="col-lg-8 d-flex flex-column align-self-center card-body">

						<?php foreach($personneExist as $personneExist): ?>

						<div class="form-check">

						    <input class="form-check-input" type="radio" name="id_personne" id="users" value="<?= $personneExist->id_personne; ?>"> 
							<label class="form-check-label" for="users">
								    Prenom:   <strong><?= $personneExist->getPrenom(); ?></strong></br>
								    Nom:   <strong><?= $personneExist->getNom(); ?></strong></br>
								    Sexe:   <strong><?= $personneExist->getSexe(); ?></strong></br>
								    Date de naissance:   <strong><?= date("d/m/Y", strtotime($personneExist->getDateDeNaissance())); ?></strong></br>
								    Mail:   <strong><?= $personneExist->getMail(); ?></strong></br>
								    Pseudo:   <strong><?= $personneExist->getPseudo(); ?></strong></br>
								    Ajouté le:   <strong><?= date("d/m/Y à H:i:s",strtotime($personneExist->getCreeLe())); ?></strong></br>
							</label>
							
						</div></br>
						<?php endforeach ?>
						
						<button type="submit" class="btn btn-primary">Valider</button>
						<a href="/admin/addPersonneOther" class="btn btn-primary mt-3">Non, c'est une autre personne </a>
						
					</form>


				<?php else: ?>

						<header class="card-header">
							<h3 class="d-flex justify-content-center my-4">Insérez les coordonnées du professeur </h3>
						</header>
					
						<?php if (isset($erreur)): ?>
							<div class="alert alert-danger d-flex align-self-center">
								<?= $erreur ?>
							</div>
						<?php endif ?>
						<?php if (isset($succes)): ?>
							<div class="alert alert-success d-flex align-self-center">
								<?= $succes ?>
							</div>
						<?php endif ?>
						
						
						<form action="adminAddProfesseur" method="post" class="col-lg-8 d-flex flex-column align-self-center card-body formulaire needs-validation" novalidate>
							
							<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="prenom">Prenom</label>
							<input id="prenom" type="text" name="prenom" class="col-sm-10 form-control" value="<?= $_POST['prenom']?? ''?>" placeholder="Exemple: jean " required>
							<div class="invalid-feedback">
				        		Entrez un prenom valide qui contient au minimum trois lettres!
				    		</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="nom">Nom</label>
							<input id="nom" type="text" name="nom" class="col-sm-10 form-control" value="<?= $_POST['nom']?? ''?>" placeholder="Exemple: Leroy" required>
							<div class="invalid-feedback">
				        		Entrez un nom valide qui contient au minimum trois lettres!
				    		</div>
						</div>
						<div class="form-group row ml-sm-1">
								<div class="form-check form-check-inline">
									<input type="radio" id="homme" name="sexe" value="homme" class="form-check-input" required>
									<label for="homme" class="form-check-label ">Homme</label>
								</div>
								<div class="form-check form-check-inline">
									<input type="radio" id="femme" name="sexe" value="femme" class="form-check-input" required>	
									<label for="femme" class="form-check-label">Femme</label>
									<div class="invalid-feedback ml-4">
								        Selectionnez le sexe de l'élève !
								 	</div>
								</div>	
						</div>
					
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="dirthday">Date de naissance</label>
							<input id="birthday" type="date" name="date_de_naissance" class="col-sm-8 form-control" value="<?= $_POST['date_de_naissance']?? ''?>" placeholder="Date de naissance au fomrat : jour/mois/année" min="1920-01-01" max="2020-01-01" required>
							<div class="invalid-feedback">
				        		Entrez une date valide au format: jours/mois/année
				    		</div>
							
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="mail">Email</label>
							<input id="mail" type="mail" name="mail" class="col-sm-10 form-control" value="<?= $_POST['mail']?? ''?>"  placeholder="Exemple: jeanleroy@exemple.fr" required>
							<div class="invalid-feedback">
				        		Entrez un email valide !
				    		</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="pseudo">Pseudo</label>
							<input id="pseudo" type="text" name="pseudo" class="col-sm-10 form-control" value="<?= $_POST['pseudo']?? ''?>" placeholder="Pseudo du professeur" required>
							<div class="invalid-feedback">
				        		Entrez un Pseudo valide avec uniquement des lettres et des chiffres!
				    		</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="motDePasse">Mot de passe</label>
							<input id="motDePasse" type="password" name="password" class="col-sm-8 form-control" placeholder="Renseigner le mot de passe" value="<?= $_POST['password']?? ''?>" required>
							<small class="form-text text-muted">Le mot de passe doit être composé de 8 à 15 caractère: au moins une lettre majuscule, une minuscule, un chiffre, et un des caractère suivant:  $ @ % * + - _ !</small>
							<div class="invalid-feedback">
				        		Entrez un mot de passe valide !
				    		</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="confMotDePasse">Confirmation mot de passe</label>
							<input id="confMotDePasse" type="password" name="passwordConf" class="col-sm-8 form-control" placeholder="Confirmez le mot de passe" value="<?= $_POST['passwordConf']?? ''?>" required>
							<div class="invalid-feedback">
				        		Les deux mots de passe ne sont pas identiques!
				    		</div>
						</div>

						
						<h3> <span> Adresse du professeur</span> </h3>


						<div class="form-row">
							<div class="form-group col-md-3">
						    	<label for="inputVoie">Numero de voie</label>
							    <input type="number" name="numero_voie" class="form-control" min="1" max="10000" value="<?= $_POST['numero_voie']?? ''?>" id="inputVoie" placeholder="Exemple: 10 " required>
							    <div class="invalid-feedback">
				        				Entrez un numero de voie valide !
				    			</div>    
						    </div>
						    <div class="form-group col-md-3">
							      <label for="inputType">Type de voie</label>
							      <select id="inputType" class="form-control" name="type_voie">
								        <option selected>Rue</option>
								        <option>Boulevard</option>
								        <option>Avenue</option>
								        <option>Route</option>
								        <option>Chemin</option>
								        <option>Impasse</option>
							      </select>
						    </div>
						    <div class="form-group col-md-6">
							      	<label for="inputNomVoie">Nom de voie</label>
							      	<input type="text" class="form-control" id="inputNomVoie" name="nom_voie" placeholder="Exemple : Boulevard du docteur Bertrand" value="<?= $_POST['nom_voie']?? ''?>" required>
							      	 <div class="invalid-feedback">
				        				Entrez un nom de voie valide sans accent et sans caractères spéciaux !
				    				</div> 
						    </div>
						    <div class="form-group col-md-12">
							      	<label for="inputComplement">Complément de l'adresse</label>
							      	<input type="text" class="form-control" id="inputComplement" name="complement_adresse" placeholder="Exemple : Batiment 3" value="<?= $_POST['complement_adresse']?? ''?>">
						    </div>
						     <div class="form-group col-md-6">
							      	<label for="inputVille">Ville</label>
							      	<input type="text" class="form-control" id="inputVille" name="ville" placeholder="Exemple: Paris" value="<?= $_POST['ville']?? ''?>" required>
							      	<div class="invalid-feedback">
				        				Entrez un nom de ville valide !
				    				</div> 
						    </div>
						     <div class="form-group col-md-6">
							      	<label for="inputCode">Code postal</label>
							      	<input type="number" class="form-control" id="inputCode" name="code_postal" placeholder="Exemple: 75000" min="0" max="99999" value="<?= $_POST['code_postal']?? ''?>" required>
							      	<div class="invalid-feedback">
				        				Entrez un code postal valide en chiffre !
				    				</div> 
						    </div>	   
						</div>
					
						<button type="submit" class="btn btn-primary">Ajouter</button>
						
					</form>
					
					<?php endif ?>

			</article>
		</div>
	</div>
</div>
<script src="/js/admin/adminProfesseurView.js?v=<?= time() ?>"></script>
