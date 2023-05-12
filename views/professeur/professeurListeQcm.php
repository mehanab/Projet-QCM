<?php $titre='Ma bibliothèque QCM'; ?>
<div>
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    	<li class="breadcrumb-item"><a href="/<?= $_SESSION['statut']?? null; ?>">Mon espace</a></li>
		   		<li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Ma bibliothèque QCM</li>
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
				<div class="card text-center d-flex row bg-secondary">
					<div class="card-body bg-secondary text-white">
						<h2><strong>Ma bibliothèque QCM</strong></h2>
					</div>
				</div>
				<?php if (isset($succes)): ?>
					
					<div class="alert alert-success text-center mt-3 d-flex justify-content-center">
						<?= $succes ?>
					</div>

				<?php endif ?>
				<?php if (isset($erreur)): ?>
							
					<div class="alert alert-danger text-center mt-3 d-flex justify-content-center">
						<?= $erreur ?>
					</div>

				<?php endif ?>
				<div class="row d-flex justify-content-between">
				
					<div class="card col-lg-8 my-3">

							<div class="card-header bg-white">
								<h3 class="card-title">Mes QCM</h3>
							</div>
							<div class="card-body bg-white">
							<form class="form-inline bg-light py-4" action="/professeur/liste_qcm" method="GET">
								<label class="form-group-label col-sm-4"><strong><i>Afficher par :</i></strong></label>
								<?php 
							    		$tous='';
							    		$publies='';
							    		$non_publies='';
								    	if (isset($select)) {
								    		
								    		switch ($select) {
								    			case 'non_publies':
								    				$non_publies='selected';
								    				break;
								    			case 'publies':
								    				$publies='selected';
								    				break;
								    			default:
								    				$tous='';
								    				break;
								    		}
								    	}
							    ?>
							    <select class="form-control mr-sm-2 col-sm-6 bg-white" name="select">
							    
							    	<option value="tous" <?= $tous ?>>Tous les QCM</option>
							    	<option value="publies" <?= $publies ?>>QCM publiés</option>
							    	<option value="non_publies" <?= $non_publies ?>>QCM non publiés</option>
							    	<?php if(isset($mes_classes)): ?>
							    		<?php foreach($mes_classes as $classe): ?>
							    			<?php 
							    			if (isset($select) && $select == $classe->id) {
							    				$s='selected';
							    			}else{
							    				$s='';
							    			}
							    			?>
							    			<option value="<?= $classe->id ?>" <?= $s ?>><?= htmlentities($classe->libelle); ?></option>
							    		<?php endforeach ?>
							    	<?php endif ?>
							    	
							    </select>
							    <button type="submit" class="btn btn-primary col-sm-1" aria-label="chercher"><i class="fas fa-search"></i></button>
						    </form>

						    <table class="table table-bordered table-hover table-responsive-sm">
								  <thead class="thead-dark">
									    <tr>
									    	  
										      <th scope="col" class="text-center">Titre</th>
										      <th scope="col" class="text-center">Date limite</th>
										      <th scope="col" class="text-center">Etat</th>
										      <th scope="col" colspan="4" class="text-center">Actions</th>
									    </tr>
								  </thead>
								  <tbody>	
								    <?php if(isset($mes_qcm)): ?>
								    	<?php $i= 1; ?>
											<?php foreach($mes_qcm as $qcm): ?>
											<tr>
												<td scope="row"><a class="voir card-link" href="#" id="<?= $qcm->id; ?>.217654"><?= htmlentities($qcm->libelle); ?></a></td>
												<td><?= htmlentities(date('d/m/Y',strtotime($qcm->date_limite))); ?></td>

												<td class="text-center">
													<?php 	
													$etat='<span  class="text-success">Non publié</span>';
													if (isset($mes_qcm_publie)) 
													{
														foreach ($mes_qcm_publie as $qcm_publie) 
														{
															if ($qcm_publie->id == $qcm->id) 
															{
																 $etat= '<span class="text-danger">Publié</span>';
															}
														}
													}
													?>		
													<?= $etat; ?>
												</td>
												<td col="2"><i class="fas fa-share-square publier" data-toggle="tooltip" data-placement="bottom" title="Publier" id="<?= $qcm->id; ?>" data-name="<?= $qcm->libelle; ?>"></i></td>
												<td><a class="voir" href="#" id="<?= $qcm->id; ?>.654"><i class="far fa-eye" data-toggle="tooltip" data-placement="bottom" title="Voir plus"></i></a></td>
												<td class="text-center">
													<?php

													$href= "href=".WEBROOT."professeur/alter_qcm/".$qcm->id;

													$modif='<a '.$href.'><i class="far fa-edit"  data-toggle="tooltip" data-placement="bottom" title="Modifier"></i></a>';
													$date= date('Y-m-d');
													if ( $etat== '<span class="text-danger">Publié</span>' && $qcm->date_limite >= $date) 
													{
														$modif='<i class="fas fa-lock"></i>';
													}
													echo $modif;
													 ?>
												</td>
												<td><i class="fas fa-times" id="<?=$qcm->id; ?>" data-placement="bottom" title="Supprimer" aria-pressed="false" autocomplete="off" data-toggle="modal" data-target="#deleteQcm"></i></td>
											</tr>
											<?php $i++; ?>
											<?php endforeach ?>

									<?php endif ?>	
								  </tbody>
								</table>
								<p>Nombre total de QCM : <?= is_array($mes_qcm) ? count($mes_qcm): '0';?></p>
							
								
							</div>

					</div>
					<div class="card p-4 col-lg-4 my-3" id="divMore">
	
					</div>

					<div class="modal fade" id="deleteQcm" role="dialog">
					    <div class="modal-dialog modal-dialog-centered">
					    
					      <!-- Modal content-->
						      <div class="modal-content">
							        <div class="modal-header">
							        		<h4 class="modal-title col-md-3 ml-auto">Confirmation</h4>
							          		<button type="button" class="close" data-dismiss="modal">X</button>
							          
							        </div>
							        <div class="modal-body">
								          <p>La suppression de ce QCM sera définitive !</p>
								          <p><span>Etes vous sûr de vouloir supprimer ce QCM ?</span></p>

							        </div>
							        <div class="modal-footer">
							        	<form action="/professeur/deleteQcm" method="POST" class="col-md-12 ml-auto">

								          	<div>
								          		<input type="text" name="id_qcm" value="" aria-label="Qcm à supprimer" hidden>
								          	</div>
								          	<div class="d-flex justify-content-between">
									          	<button type="submit" class="btn btn-danger text-white col-md-4" >Oui</button>
								         		<button type="button" class="btn btn-secondary col-md-4 ml-auto" data-dismiss="modal">Non</button>
							         		</div>
								          
								        </form>	
								        	
							        </div>
						      </div>
					      
					    </div>
					</div>

					<div  class="card p-4 col-lg-4 my-3" id="publication">
						<div class="card-header bg-white text-center">
							<h3 class="card-title">Mes classes</h3>
						</div>
						
						<form action="/professeur/publication" method="post" class="mt-5">
							<?php if(isset($mes_classes)): ?>

									<div class="form-group" id="form-group">
										<label>QCM à publier : </label>
										<input type="text" name="id_qcm" value="" class="form-check-input" hidden>
									</div>
								<?php if(!empty($mes_classes)): ?>
								<?php foreach($mes_classes as $classe): ?>
									
									<div class="form-check">
										<input type="checkbox" name="id_classe[]" value="<?= $classe->id; ?>" class="form-check-input">
										<label class="form-check-label "><strong><?= $classe->libelle; ?></strong></label>
									</div>
									
								<?php endforeach ?>
								<?php else: ?>
									<div>
										<p>Vous n'êtes inscrit à aucune classe pour le moment .</p>
									</div>

								<?php endif ?>
								<?php if(!empty($mes_classes)): ?>
								<div class="text-center mt-5">
									<button type="submit" class="btn btn-primary col-md-8">Valider</button>
								</div>
								<?php endif ?>
							<?php endif ?>
						</form>

						
					</div>		
				</div>		
		
			</section>
			
		</div>
		
		
	</div>

</div>
	<script src="/js/professeur/listeQcm.js?v=<?= time() ?>"></script>