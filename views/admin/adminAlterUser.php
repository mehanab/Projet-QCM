<?php $titre= 'Espace administrateur'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/projetQCM/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Modifier un utilisateur</li>
		  </ol>
	</nav>

	<div class="container-fluid">

		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 my " style="padding: 0 10px 0 0">
				<header class="card-header d-flex justify-content-center text-white bg-dark">
					<h4>Géstion des données</h4>
				</header>
				<nav class="list-group list-group-flush bg-dark">
					<a href="<?=WEBROOT?>admin" class="list-group-item list-group-item-action">Mon espace</a>
					<a href="/projetQCM/admin/adminProfesseur" class="list-group-item list-group-item-action">Enregistrer un professeur </a>
					<a href="/projetQCM/admin/adminEleve" class="list-group-item list-group-item-action">Enregistrer un élève </a>
					<a href="/projetQCM/admin/listQcm" class="list-group-item list-group-item-action">Lister les QCM</a>
					<a href="/projetQCM/admin/getNiveaux" class="list-group-item list-group-item-action">Lister les classes</a>
					<a href="/projetQCM/admin/articles" class="list-group-item list-group-item-action">Mes articles</a>	

				</nav>
			</section>

			<article class="d-flex flex-column col-lg-9 card bg-dark text-white py-5 ml-lg-2">
			<?php if(isset($personne)): ?> 

				<header class="card-header align-self-center">
				
					<h2>Modifier les coordonnées de " <?= htmlentities($_POST['nom']?? $personne->nom) .' '. htmlentities($_POST['prenom']?? $personne->prenom); ?> "</h2>
				</header>

					<?php if (isset($erreur)): ?>
							<div class="alert alert-danger col-lg-8 d-flex align-self-center">
								<?= $erreur ?>
							</div>
					<?php endif ?>
					<?php if (isset($succes)): ?>
							<div class="alert alert-success col-lg-8 d-flex align-self-center">
								<?= $succes ?>
							</div>
					<?php endif ?>

				
						
				<form action="/projetQCM/admin/validateAlterUser" method="post" class="col-lg-8 d-flex flex-column align-self-center card-body formulaire needs-validation" novalidate>
						
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="prenom">Prenom</label>
							<input id="prenom" type="text" name="prenom" class="col-sm-10 form-control" value="<?=htmlentities($_POST['prenom']?? $personne->prenom) ?>" placeholder="Exemple: jean " required>
							<div class="invalid-feedback">
				        		Entrez un prenom valide qui contient au minimum trois lettres!
				    		</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="nom">Nom</label>
							<input id="nom" type="text" name="nom" class="col-sm-10 form-control" value="<?= htmlentities($_POST['nom']?? $personne->nom) ?>" placeholder="Exemple: Leroy" required>
							<div class="invalid-feedback">
				        		Entrez un nom valide qui contient au minimum trois lettres!
				    		</div>
						</div>
						<div class="form-group row ml-sm-1">
							<?php 
							$homme="";
							$femme="";
							if (isset($personne) ){
								
								if ($personne->sexe== 'homme') {
									$homme='checked';
									
								}if ($personne->sexe== 'femme') {
									$femme='checked';
								} 		
							}
							if (isset($_POST['sexe'])) {
								if ($_POST['sexe']== 'homme') {
									$homme='checked';
									
								}if ($_POST['sexe']== 'femme') {
									$femme='checked';
								} 
								
							}
							?>
								<div class="form-check form-check-inline">
									<input type="radio" id="homme" name="sexe" value="homme" class="form-check-input" required <?= $homme ?>>
									<label for="homme" class="form-check-label ">Homme</label>
								</div>
								<div class="form-check form-check-inline">
									<input type="radio" id="femme" name="sexe" value="femme" class="form-check-input" required <?= $femme ?>>	
									<label for="femme" class="form-check-label">Femme</label>
									<div class="invalid-feedback ml-4">
								        Selectionnez le sexe de l'élève !
								 	</div>
								</div>	
						</div>
					
						<div class="form-group row">
							
							<label class="col-sm-4 col-form-label" for="dirthday">Date de naissance</label>
							<input id="birthday" type="date" name="date_de_naissance" class="col-sm-8 form-control" value="<?= htmlentities($_POST['date_de_naissance']?? date('Y-m-d', strtotime($personne->date_de_naissance))); ?>" min="1920-01-01" max="2020-01-01" required>
							<div class="invalid-feedback">
				        		Entrez une date valide au format: jours/mois/année
				    		</div>
							
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="mail">Email</label>
							<input id="mail" type="mail" name="mail" class="col-sm-10 form-control" value="<?= htmlentities($_POST['mail']?? $personne->mail); ?>"  placeholder="Exemple: jeanleroy@exemple.fr" required>
							<div class="invalid-feedback">
				        		Entrez un email valide !
				    		</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="pseudo">Pseudo</label>
							<input id="pseudo" type="text" name="pseudo" class="col-sm-10 form-control" value="<?= htmlentities($_POST['pseudo']?? $personne->pseudo); ?>" placeholder="Pseudo du professeur" required>
							<div class="invalid-feedback">
				        		Entrez un Pseudo valide avec uniquement des lettres et des chiffres!
				    		</div>
						</div>
						<div class="form-check">
							  <input class="form-check-input" type="checkbox" name="statutEleve" id="statutEleve" value="eleve" <?= $isEleve ?? ''; ?>>
							  <label class="form-check-label" for="statutEleve">
							    Elève
							  </label>
						</div>
						<div class="form-check">
							  <input class="form-check-input" type="radio" name="statut" value="professeur" id="statutProfesseur" <?= $isProfesseur ?? ''; ?>>
							  <label class="form-check-label" for="statutProfesseur">
							    Professeur
							  </label>
						</div>
						<div class="form-check">
							  <input class="form-check-input" type="radio" name="statut" id="statutAdmin" value="admin" <?= $isAdmin ?? ''; ?>>
							  <label class="form-check-label" for="statutAdmin">
							    Administrateur
							  </label>
						</div>
						<div class="form-check">
							  <input class="form-check-input" type="radio" name="statut" id="statutNoOne" value="noOne" <?= $isNoOne ?? ''; ?>>
							  <label class="form-check-label" for="statutNoOne">
							    Aucun
							  </label>
						</div>

					
						<div id="divPassword">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="motDePasse">Mot de passe</label>
							<input id="motDePasse" type="password" name="password" class="col-sm-8 form-control" value='<?=$_POST['password']??  $personne->password; ?>' placeholder="Renseigner le mot de passe">
							<small class="form-text text-muted">Le mot de passe doit être composé de 8 à 15 caractère: au moins une lettre majuscule, une minuscule, un chiffre, et un des caractère suivant:  $ @ % * + - _ !</small>
							<div class="invalid-feedback">
				        		Entrez un mot de passe valide !
				    		</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label" for="confMotDePasse">Confirmation mot de passe</label>
							<input id="confMotDePasse" type="password" name="passwordConf" class="col-sm-8 form-control" value='<?= $_POST['passwordConf']?? $personne->password; ?>' placeholder="Confirmez le mot de passe">
							<div class="invalid-feedback">
				        		Les deux mots de passe ne sont pas identiques!
				    		</div>
						</div>
						<button id="passwordDontChge" type="button" class="btn btn-primary mb-5">Je ne veux pas changer le mot de passe</button>
						</div>
					


						<button id="passwordChange" type="button" class="btn btn-primary col-sm my-5">Changer le mot de passe</button>

					<?php if(isset($classes)): ?>

						<div class="form-group row">
							      <label for="inputClasse" class="col-sm-4 control-label">Choisir la classe </label>
							      <select id="inputClasse" class="col-sm-8 form-control" name="id_classe"required>
							      		<option></option>
							      	
							      		<?php foreach ($classes as $classe): ?>
							      			<?php 
							      				$selected="";
												if (isset($personne) && $personne->id_classe == $classe->getId()) {
													$selected='selected';
												}elseif (isset($_POST['id_classe']) && $_POST['id_classe']== $classe->getId()) {
													$selected='selected';
												}
											?>
								        <option value="<?= $classe->getId(); ?>" <?= $selected?>><?= $classe->getLibelle(); ?></option>
								   		<?php endforeach ?>
								   
							      </select>
							      <div class="invalid-feedback">
				        				Choisissez une classe !
				    			  </div>
						</div>
					 <?php endif ?>

						
						<h3> <span> Adresse :</span> </h3>


						<div class="form-row">
							
							<div class="form-group col-md-3">
						    	<label for="inputVoie">Numero de voie</label>
							    <input type="number" name="numero_voie" class="form-control" min="1" max="10000" value="<?= htmlentities($_POST['numero_voie']?? $personne->adresse['numero_voie'])?>" id="inputVoie" placeholder="Exemple: 10 " required>
							    <div class="invalid-feedback">
				        				Entrez un numero de voie valide !
				    			</div>    
						    </div>
						    <div class="form-group col-md-3">
						    	<?php 
						    		 $tab=['Rue','Boulevard','Avenue', 'Route', 'Chemin', 'Impasse'];		 
						    	?>
							      <label for="inputType">Type de voie</label>
							      <select id="inputType" class="form-control" name="type_voie">
							      	<?php foreach($tab as $value): ?>
							      		<?php if(isset($personne) && $personne->adresse['type_voie']==$value){
							      			$select= 'selected';
							      		}elseif (isset($_POST['type_voie']) && $_POST['type_voie']==$value) {
							      			$select= 'selected';
							      		}else{
							      			$select='';
							      		}
							      		?>
								        <option <?= $select; ?>><?= $value; ?></option>
								        
								     <?php endforeach; ?>
							      </select>
						    </div>
						    <div class="form-group col-md-6">
							      	<label for="inputNomVoie">Nom de voie</label>
							      	<input type="text" class="form-control" id="inputNomVoie" name="nom_voie" placeholder="Exemple : Boulevard du docteur Bertrand" value="<?= htmlentities($_POST['nom_voie']?? $personne->adresse['nom_voie']); ?>" required>
							      	 <div class="invalid-feedback">
				        				Entrez un nom de voie valide sans accent et sans caractères spéciaux !
				    				</div> 
						    </div>
						    <div class="form-group col-md-12">
							      	<label for="inputComplement">Complément de l'adresse</label>
							      	<input type="text" class="form-control" id="inputComplement" name="complement_adresse" placeholder="Exemple : Batiment 3" value="<?= htmlentities($_POST['complement_adresse']?? $personne->adresse['complement_adresse']);?>">
							      	
						    </div>
						     <div class="form-group col-md-6">
							      	<label for="inputVille">Ville</label>
							      	<input type="text" class="form-control" id="inputVille" name="ville" placeholder="Exemple: Paris" value="<?= htmlentities($_POST['ville']?? $personne->adresse['ville']);?>" required>
							      	<div class="invalid-feedback">
				        				Entrez un nom de ville valide !
				    				</div> 
						    </div>
						     <div class="form-group col-md-6">
							      	<label for="inputCode">Code postal</label>
							      	<input type="number" class="form-control" id="inputCode" name="code_postal" placeholder="Exemple: 75000" min="0" max="99999" value="<?= htmlentities($_POST['code_postal']?? $personne->adresse['code_postal']);?>" required>
							      	<div class="invalid-feedback">
				        				Entrez un code postal valide en chiffre !
				    				</div> 
						    </div>	   
						</div>
					
						<button type="submit" class="btn btn-primary mb-3">Modifier</button>
						<a href="/projetQCM/admin" class="text-white"> << Revenir à mon espace</a>
						
					</form>

				<?php else: ?>

					<article  class="alert alert-danger d-flex justify-content-center mt-5">
						<p>Oups une erreur est survenue ! </p>
					</article>
					<nav class="d-flex justify-content-center mt-5">
						<button class="btn btn-primary"><a class="text-white" href="/projetQCM/admin">Revenir à mon espace</a></button>
					</nav>
				<?php endif; ?>


			</article>
		</div>
	</div>
</div>
<script src="/projetQCM/public/js/admin/adminAlterUser.js?v=<?= time() ?>"></script>
