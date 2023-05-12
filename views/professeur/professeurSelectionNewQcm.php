<?php 

$titre='Créer un nouveau QCM'; 
?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    	<li class="breadcrumb-item"><a href="/professeur/selection">Choisir un thème</a></li>
		    	<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Créer un nouveau QCM</li>
		  </ol>
	</nav>
	<div class="container-fluid">
		<div class="d-md-flex flex-row justify-content-between">

			<section class="col-md-3 " style="padding: 0 10px 0 0">
				<div class="card  d-flex align-self-start" >
					<header class="card-header text-white text-center bg-info">
						<h4>Mon espace</h4>
					</header>
					<nav class="list-group list-group-flush bg-info" id="navProf">
					
						<a href="/professeur/liste_qcm" class="list-group-item list-group-item-action pl-5" id="">Ma bibliothèque QCM</a>
						<a href="" class="list-group-item list-group-item-action pl-5" id="showQuestions">Ma bibliothèque Questions</a>
						<div class="list-group list-group-flush ml-4 text-left" id="choixTypeQuestions">
								<a href="/professeur/questions" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i> Toutes les questions</a>
								<a href="/professeur/mes_questions" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i> Mes questions</a>
						</div>
						<a class="list-group-item list-group-item-action pl-5" href="" id="createQcm">Créer un nouveau QCM</a>
						<div class="list-group list-group-flush ml-4 text-left" id="choixTypeQcm">
								<a href="/professeur/new_qcm" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i> Saisie manuelle</a>
								<a href="/professeur/selection" class="list-group-item list-group-item-action pl-5"><i class="fas fa-angle-double-right"></i>  Sélection de questions</a>
						</div>
						<a href="/professeur/mes_classes" class="list-group-item list-group-item-action pl-5">Mes classes</a>
						<a href="/professeur/resultats" class="list-group-item list-group-item-action pl-5" id="">Résultats</a>
													
					</nav>
				</div>
				
			</section>

			<section class="col-md-9">
				<?php if (isset($succes)): ?>
							
							<div class="alert alert-success text-center d-flex justify-content-center">
								<?= $succes ?>
							</div>
							<nav class="row mt-5 d-flex justify-content-around ">
								<a class="btn btn-info" href="/professeur/selection">Ajouter un autre QCM</a>
								<a class="btn btn-info " href="/professeur/liste_qcm">Retour à la liste des QCM</a>
								
							</nav>
				<?php else: ?>
					
				<div class="card text-center d-flex row bg-secondary">
					<div class="card-body bg-secondary text-white">
						<h2><strong>Créer un nouveau QCM</strong></h2>
					</div>		
				</div>
				
				
				<div class="row d-flex justify-content-between">

				<form action="/professeur/create_qcm_selection" method="post" class="col-lg-12 needs-validation" novalidate>

					<div class="row d-flex justify-content-between">
						<?php if (isset($erreur)): ?>
							<div class="alert alert-danger col-lg-8 d-flex align-self-center mt-3">
								<?= $erreur ?>
							</div>
						<?php endif ?>


						<div class="card p-4 col-lg-8 my-3" id="enregistrement">
						
							<div class="card-header bg-white">
								<h3>Enregistrement</h3>
							</div>

							<div  class="card-body">
							
								<div class="form-group row">
									<label for="select_theme" class="col-sm-4 control-label">Choisir une matière </label>
									<select id="select_theme" class="col-sm-8 form-control" name="id_theme" readonly>
										      		
									<?php if(isset($theme)): ?>
										   <option value="<?= $theme->id; ?>"><?= htmlentities($theme->libelle); ?></option>
								 	<?php endif ?>
									</select>

								</div>

								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="libelle">Titre du QCM</label>
									<input id="libelle" type="text" name="libelle" class="col-sm-8 form-control" placeholder="Entrez le libéllé de votre QCM" value="<?= $_POST['libelle']?? ''?>" required>
									<div class="invalid-feedback">
							        		Le libellé n'est pas valide' !
							    	</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label" for="date_limite">Date limite du QCM</label>
									<?php $date=date("Y-m-d"); ?>
									<input id="date_limite" type="date" name="date_limite" class="col-sm-8 form-control" value="<?= $_POST['date_limite']?? ''?>" min="<?= $date ?>" required>
									<div class="invalid-feedback">
							        		La date est invalide !
							    	</div>
								</div>
								
							</div>

								<button type="submit" class="btn btn-primary" id="suite_enregistrement">Etape suivante</button>

						</div>
					

						<div class="card col-lg-4 my-lg-3 bg-light">
							<div class="card-header bg-light text-center">
								<h4>Paramètres</h4>
							</div>
							<div class="form-group">
									<label class="col-form-label" for="echelle">Echelle de notation</label>
									<input id="echelle" type="number" name="echelle_not" class=" form-control" value="<?=$_POST['echelle_not']?? '20' ?>" min="0" max="500" required>
									<div class="invalid-feedback">
							        		L'échelle de notation ne doit pas être vide !
							    	</div>
							</div>
							<div class="form-group">
									<label class="col-form-label" for="notation_vrai">Barème de réponse valide</label>
									<input id="notation_vrai" type="number" name="notation_vrai" class=" form-control" value="<?=$_POST['notation_vrai']?? '1' ?>" min="0" max="500" required>
									<div class="invalid-feedback">
							        		Le barème de notation ne doit pas être vide !
							    	</div>
							</div>
							<div class="form-group">
									<label class="col-form-label" for="notation_faux">Barème de réponse invalide</label>
									<input id="notation_faux" type="number" name="notation_faux" class=" form-control" value="<?=$_POST['notation_faux']?? '0' ?>" min="-500" max="0" required>
									<div class="invalid-feedback">
							        		Le barème de notation ne doit pas être vide !
							    	</div>
							</div>
							<div class="form-group">
								<p>Durée du test</p>
								<div class="d-flex justify-content-start mt-1">
									<input id="jours" type="number" name="jour" class="col-5 form-control" value="<?=$_POST['jour']?? '0' ?>" min="0" max="365" required>
									<label class="col-5 col-form-label" for="jours">Jour</label>
								</div>
								<div class="d-flex justify-content-start mt-1">
									<input id="heure" type="number" name="heure" class="col-5 form-control" value="<?=$_POST['heure']?? '0' ?>" min="0" max="24" required>
									<label class="col-5 col-form-label" for="heure">Heure</label>
								</div>
								<div class="d-flex justify-content-start mt-1">
									<input id="minute" type="number" name="minute" class=" col-5 form-control" value="<?=$_POST['minute']?? '15' ?>" min="0" max="60" required>
									<label class="col-5 col-form-label" for="minute">minute</label>
								</div>
								<div class="invalid-feedback">
							        		Aucun champs ne doit être vide !
							    </div>
							</div>
							
							
						</div>

					</div>
					
				</form>
				</div>

			<?php endif ?>
			</section>
		</div>
	</div>
</div>
<script src="/js/professeur/newQcmSelection.js?v=<?= time() ?>"></script>
