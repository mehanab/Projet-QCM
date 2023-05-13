<?php $titre= 'Espace administrateur'; 
?>

<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		    <li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Lister les classes</li>
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
					<a href="/admin/adminProfesseur" class="list-group-item list-group-item-action">Enregistrer un professeur </a>
					<a href="/admin/adminEleve" class="list-group-item list-group-item-action">Enregistrer un élève </a>
					<a href="/admin/listQcm" class="list-group-item list-group-item-action">Lister les QCM</a>
					<a href="/admin/getNiveaux" class="list-group-item list-group-item-action">Lister les classes</a>
					<a href="/admin/articles" class="list-group-item list-group-item-action">Mes articles</a>	

				</nav>
			</section>


			<section class="d-flex flex-column col-sm-9">
			<?php if(isset($erreur)): ?>
				<div class="alert alert-danger col-lg-8 d-flex align-self-center">
					<?= $erreur ?>
				</div>
			<?php else: ?>

				<div class="card">

						<div class="card-header bg-dark">
							<h2 class="card-title text-center text-white">Géstion des classes</h2>	
						</div>

	  					<div class="card-body bg-light">
	  						 
	  					<?php if(isset($niveaux) && isset($tab_niveaux)): ?>
	  						<?php if(isset($erreurForms)): ?>
								<div class="alert alert-danger d-flex align-self-center">
									<?= $erreurForms ?>
								</div>
							<?php endif ?>
							<?php if(isset($succesForms)): ?>
								<div class="alert alert-success d-flex align-self-center">
									<?= $succesForms ?>
								</div>
							<?php endif ?>
	  						<div class="row">
		  						 <div class="col-sm-4">	
		  						 	<nav>	 
		  						 	<?php if(!empty($niveaux) && !empty($tab_niveaux)): ?>	
			  						 	<ul class="list-group" id='myList' role='tablist'>
			  						 		<?php foreach($niveaux as $niveau): ?>
			  						 			<li class="list-group-item d-flex justify-content-between align-items-center">
											    	<a data-toggle="list" href='#niveau<?=$niveau->id; ?>' role="tab" class="card-link"><?= $niveau->libelle; ?></a>
											    	<?php $count= count($tab_niveaux[$niveau->id]);?>
											    	<span class="badge badge-primary badge-pill"><?= $count; ?> classe<?= ($count > 1)? 's':'';  ?> </span>
											  	</li>
											  		<!-- /admin/getNiveaux/<?= $niveau->id;?> -->
			  						 		<?php endforeach; ?>
										</ul>
									<?php else: ?>
										<p>La liste est vide</p>
									<?php endif ?>
									</nav>

									<button class="btn btn-info my-3 col-lg-12" id="ajoutNiv" data-toggle="button" aria-pressed="false" autocomplete="off">Ajouter un niveau</button>

									<form action="/admin/addNiveau" method="post" id="formAjoutNiv" class="needs-validation">
											<div class="form-group">
												<label class="col-form-label" for="libelle">Libellé </label>
												<input id="libelle" type="text" name="libelle" class="form-control" value="<?= $_POST['libelle']?? ''?>" placeholder="Exemple: niveau x" required>
												<div class="invalid-feedback">
									        		Entrez un libelé valide qui contient au minimum trois lettres!
									    		</div>
											</div>
											<button type="submit" class="btn btn-primary">Ajouter</button>
									</form>

									<?php if(!empty($niveaux) && !empty($tab_niveaux)): ?>
									<button class="btn btn-info my-3 col-lg-12" id="suppNiv" data-toggle="button" aria-pressed="false" autocomplete="off">Supprimer un niveau</button>

									<form action="/admin/deleteNiveau" method="post" id="formSuppNiv" class="needs-validation">
											<div class="form-group">
												<label for="niv" class="control-label">Choisir un niveau </label>
												<select id="niv" class="form-control" name="id" required>
												      
												    <?php foreach ($niveaux as $niveau): ?>
													    <option value="<?= $niveau->id; ?>"><?= $niveau->libelle; ?></option>
													 <?php endforeach ?>
											    </select>
											</div>
											<button type="submit" class="btn btn-primary">Supprimer</button>
									</form>
									<?php endif ?>

								</div>

								<div class="col-sm-8">
									<div class="tab-content">
										<?php if(!empty($tab_niveaux)): ?>
										<?php foreach($tab_niveaux as $id_niveau=>$tab_niveau): ?>
										  <div class="tab-pane <?=(isset($classIdNiveau) && $classIdNiveau== $id_niveau)? 'active': ''; ?>" id="niveau<?= $id_niveau;?>" role="tabpanel">
										  	<h3 class="card-subtitle mb-2 text-muted d-flex justify-content-center"><i><strong>Les classes de <?= $libelle[$id_niveau]?? 'chaque niveau' ;?></strong></i></h3>
										  	<ul class="nav d-flex flex-column my-3">
										  	<?php foreach($tab_niveau as $classe): ?>
										  		<li class="nav-item"><strong><a href="/admin/getDetailsClasse/<?= $classe->id ?>" class='nav-link'><?= $classe->libelle; ?></a></strong></li>
										  	<?php endforeach ?> 
										  	</ul>

										  	<div class="row d-flex justify-content-around">
										  		<button class="ajoutClasse btn btn-info my-3 col-lg-3" data-toggle="button" aria-pressed="false" autocomplete="off">Ajouter une classe</button>
										  	<?php if(!empty($tab_niveau)): ?>
										  		<button class="modifClasse btn btn-info my-3 col-lg-3" data-toggle="button" aria-pressed="false" autocomplete="off">Modifier une classe</button>
										  		<button class="suppClasse btn btn-info my-3 col-lg-3"aria-pressed="false" autocomplete="off" data-toggle="modal" data-target="#deleteClasse">Supprimer une classe</button>
										  	<?php endif ?>
										  	</div>

										
										  	<form action="/admin/addClasse/<?= $id_niveau ?>" method="post" class="formAjoutClasse needs-validation">
										  		<div class="form-group">
													<label class="col-form-label" for="nomClasse">Libellé</label>
													<input id="nomClasse" type="text" name="nomClasse" class="form-control" value="<?= $_POST['nomClasse']?? ''?>" placeholder="Exemple: classe x" required>
													<div class="invalid-feedback">
										        		Entrez un libellé valide qui contient au minimum trois lettres!
										    		</div>
												</div>

										  		<button type="submit" class="btn btn-primary">Ajouter</button>
										 	 </form> 

										 	 <?php if(!empty($tab_niveau)): ?>

										 	 <form action="/admin/alterClasse/<?= $id_niveau ?>" method="post" class="formModifClasse needs-validation">
										 	 <div class="row">
										 	 	
												<div class="col">
													<label for="libelleAlter" class="col-form-label">Choisir une classe </label>
													<select id="libelleAlter" class="form-control" name="idClasseAlter" required>
												   
										  			<?php foreach($tab_niveau as $classe): ?>
										  				<option value="<?= $classe->id ?>"><?= $classe->libelle; ?></option>
										  			<?php endforeach ?> 
											   		</select>
												</div>

										 	 	<div class="col">
													<label for="niveauAlter" class="col-form-label">Changer le niveau </label>
													<select id="niveauAlter" class="form-control" name="niveauAlter" required>
												   
										  			<?php foreach ($niveaux as $niveau): ?>
										  				<?php 
										  				$selected='';
										  				if($id_niveau == $niveau->id)
										  				{
										  					$selected='selected';
										  				}
												    	?>
													    <option value="<?= $niveau->id; ?>" <?= $selected;?>><?= $niveau->libelle; ?></option>
													 <?php endforeach ?>
											   		</select>
												</div>
											</div>
												<div class="form-group">
													<label class="col-form-label" for="nomClasseAlter">Nouveau libellé</label>
													<input id="nomClasseAlter" type="text" name="classeName" class="form-control" value="<?= $_POST['classeName']?? ''?>" placeholder="Exemple: classe x">
												</div>
											
												<button class="btn btn-primary my-3">Modifier</button>
										 	 </form> 

										
										 	 <form action="/admin/deleteClasse/<?= $id_niveau ?>" method="post" class="formSuppClasse needs-validation" id='<?= $id_niveau ?>'>
										 	 	<div class="form-group">
													<label for="classe<?= $id_niveau ?>" class="control-label">Choisir une classe </label>
													<select id="classe<?= $id_niveau ?>" class="form-control" name="classeId" required>
												      
												    <?php foreach($tab_niveau as $classe): ?>
										  				<option value='<?= $classe->id ?>'><?= $classe->libelle; ?></option>
										  			<?php endforeach ?> 
											   		</select>
												</div>	
												<button type="submit" class="btn btn-primary button" >Supprimer</button> 
										 	 </form> 
										 	 <?php endif ?> 	
										  </div>
										  
										<?php endforeach ?>
										<?php endif ?>
										 
									</div>

									<div class="modal fade" id="deleteClasse" tabindex="-1" role="dialog" aria-hidden="true">
										 <div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title col-md-3 ml-auto text-danger" id="modalAlerte">Alerte </h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														 <span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														La suppression d'une classe entraine la supression de toutes les données associées à celle-ci !
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">J'ai compris</button>
													</div>
												</div>
										 </div>
									</div>
								</div>

							</div>

						<?php elseif (isset($detailsClasse) && isset($eleves) && isset($professeurs) && isset($allProfesseurs)): ?>

							<?php if(isset($erreurForms)): ?>
								<div class="alert alert-danger d-flex align-self-center">
									<?= $erreurForms ?>
								</div>
							<?php endif ?>
							<?php if(isset($succesForms)): ?>
								<div class="alert alert-success d-flex align-self-center">
									<?= $succesForms ?>
								</div>
							<?php endif ?>


							<div class="table-responsive-xl overflow-auto">
								<table class="table table-bordered table-hover bg-white">
									<thead class="thead-secondary text-center">
										<tr>
											<th colspan="2">Détails de la classe</th>
										
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>Libellé</th>
											<td><?= $detailsClasse->getLibelle(); ?></td>
										</tr>
										<tr>
											<th>Niveau</th>
											<td><?= $niv->libelle ?? ''; ?></td>
										</tr>
										<tr>
											<th>Les élèves</th>
											<td>
												<a <?= count($eleves) >0 ? 'href="#" id="eleveListe" class="card-link"': '' ?>><?= count($eleves); ?> élève<?= count($eleves) > 1 ? 's': '' ?> </a>
												<ul class="eleveListe nav flex-column mt-3">
												<?php foreach($eleves as $eleve): ?>
														<li class="nav-item"><?= $eleve->nom. ' '.$eleve->prenom; ?></li>
												<?php endforeach ?>
												</ul>

											</td>
										</tr>
										<tr>
											<th>Les professeurs</th>
											<td>
												<a <?= count($professeurs) >0 ? 'href="#" id="profListe" class="card-link"': ''  ?>><?= count($professeurs); ?> professeur<?= count($professeurs) > 1 ? 's': '' ?> </a>
												<ul class="nav flex-column mt-3 profListe">
													<?php foreach($professeurs as $professeur): ?>
														<li class="nav-item"><?= $professeur->nom. ' '.$professeur->prenom; ?></li>
													<?php endforeach ?>
												</ul>

											</td>
										</tr>
										
									</tbody>						
								</table>
								<nav>
									<a class="btn btn-primary text-white" id="showAddProf">Ajouter un professeur à cette classe</a>
								</nav>
								<form action="/admin/addProfClasse/<?= $detailsClasse->getId(); ?>" method="post" class="needs-validation my-4" id='formAddProf'>
										<div class="form-group">
											<label for="professeurCls" class="control-label">Choisir un professeur </label>
											<select id="professeurCls" class="form-control" name="professeurId" required>
												      
											<?php foreach($allProfesseurs as $professeur): ?>
												<?php if($professeur->statut== "admin")
												{
													continue;
												} 
												?>
										  		<option value='<?= $professeur->id ?>'><?= $professeur->nom .' '. $professeur->prenom; ?></option>
										 	<?php endforeach ?> 
											</select>
										</div>	
										<button type="submit" class="btn btn-primary button" >Ajouter</button> 
								 </form> 
							</div>

	  					<?php endif?>
	   						
	   					</div>
	   			</div>

			<?php endif ?>
			</section>
		</div>
	</div>
</div>
<script src="/js/admin/adminClasses.js?v=<?= time() ?>"></script>
