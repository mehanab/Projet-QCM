<?php $titre= 'Espace administrateur'; ?>
<div style="min-height: 35rem;">
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" class="bg-light" style="margin-bottom: 0px; background-color: #FAFCFC; ">
		    <li class="breadcrumb-item active" aria-current="<?= $titre?? 'Mon espace '?>">Mon espace</li>
		  </ol>
	</nav>
	<div class="container-fluid">

		<div class="d-md-flex flex-row justify-content-between" id="divShow">
			
			<section class="col-md-3 my " style="padding: 0 10px 0 0" id="section1">
					
						<header class="card-header text-white text-center bg-dark">
							<h4>Géstion des données</h4>
						</header>
						<nav class="list-group list-group-flush bg-dark" id="divActions">
							<a href="/admin/adminProfesseur" class="list-group-item list-group-item-action" id="addProf">Enregistrer un professeur</a>
							<a href="/admin/adminEleve" class="list-group-item list-group-item-action">Enregistrer un élève</a>
							<a href="#" class="list-group-item list-group-item-action" id="listerUsers">Lister les utilisateurs</a>
							<div class="list-group list-group-flush ml-3" id="liste">
										<a href="#" class="list-group-item list-group-item-action getUsers" id="getUsers">Tous les utilisateurs</a>
										<a href="#" class="list-group-item list-group-item-action getEleves" id="getEleves">Les élèves</a>
										<a href="#" class="list-group-item list-group-item-action getProfesseurs" id="getProfesseurs">Les professeurs</a>
							</div>
							<a href="/admin/listQcm" class="list-group-item list-group-item-action">Lister les QCM</a>
							<a href="/admin/getNiveaux" class="list-group-item list-group-item-action">Lister les classes</a>
							<a href="/admin/articles" class="list-group-item list-group-item-action">Mes articles</a>						

						</nav>	
				</section>

			<section style="margin-left: 2px; width: 10px; height: 1px; border:1px solid #069; border-color:transparent transparent transparent black; border-width:20px;" id="indice"></section>


			<section class="mx-2" id="div">

				<article  id="tableUsers" class="card bg-dark text-white text-center">

					<header class="card-header text-white">
						<h2 id="titre">Liste de tous les utilisateurs</h2>
							<nav>	
								<ul class="nav nav-tabs card-header-tabs pt-3">
							        <li class="nav-item">
							        	<a class="nav-link text-dark active getUsers" href="#">Tous les utilisateurs</a>
							        </li>
							     	<li class="nav-item">
							        	<a class="nav-link text-white getEleves" href="#">Les élèves</a>
							        </li>
							      	<li class="nav-item">
							        	<a class="nav-link text-white getProfesseurs" href="#">Les professeurs</a>
							      	</li>
							    </ul>
							</nav>
					</header>

					<div class="card text-white bg-dark mt-4">
						<form action="<?=WEBROOT; ?>admin/serch" class="my-3 row mx-2" id="form">
							<div class="form-group col-sm-10">
								<input type="text" name="valeur" id="valeur" class="form-control" placeholder="Recherche une personne par nom ou prénom" value="">	
							</div>
							<div class="form-group col-sm-2">
								<button class="btn btn-primary" id="serch">Rechercher</button>
							</div>
							
						</form>
						<div id="nbrPersonne">
							
						</div>
						
					</div>

					<div class="card-body d-flex justify-content-center ">

						<div class="table-responsive-xl overflow-auto">
							<table class="table table-striped table-light table-bordered table-hover">
								<thead class="thead-dark">
									<tr id="headTable">
										<th>Nom</th>
										<th>Prenom</th>
										<th>Sexe</th>
										<th>Date de naissance</th>
										<th>Mail</th>
										<th id="classe">Classe</th>
										<th>Pseudo</th>
										<th>Date de création</th>
										<th>Adresse</th>
										<th colspan="2">Action</th>
									</tr>
								</thead>
								<tbody id="personne">
									
								</tbody>
								
							</table>
							
							
						</div>

					</div>

				</article>	
				<nav class="row d-flex justify-content-around my-5" id="btns">

						<button id="pagePrecedente" type="button" class="btn btn-primary" value="2"><< Pages précédente</button>
						<button id="pageSuivante" type="button" class="btn btn-primary" value="2">Page suivante >></button>	
				</nav>
			</section>

			<article id="admin" class="col-9 text-center">
					<div class="d-flex flex-column">
						<header>
							<h2 >Espace Administrateur</h2>
						</header>
						<div>
							<p>Cet espace est réservé à l'administrateur</p>
						</div >
					</div>
			</article>
			
			<div class="modal fade" id="myModalSucces" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
				      <div class="modal-content">
				      	<div class="modal-header">
				        	<h4 class="modal-title col-md-3 ml-auto" style="color: green!important;">Succès</h4>
				          	<button type="button" class="close getUsers text-dark" data-dismiss="modal">X</button>    
				        </div>
				        <div class="modal-body text-dark">
				          <p style="color: black!important; ">L'utilisateur à été supprimé avec succes !</p>   
				        </div>
				        <div class="modal-footer">
				          <button type="button" class="btn btn-success getUsers text-white" data-dismiss="modal">Fermer</button>
				       </div> 	
				      </div>   
				    </div>
					
			</div>

			<div class="modal fade" id="myModalError" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
				      <div class="modal-content">
				      	<div class="modal-header">
				        	<h4 class="modal-title col-md-3 ml-auto">Erreur</h4>
				          	<button type="button" class="close" data-dismiss="modal">X</button>    
				        </div>
				        <div class="modal-body">
				          <p>L'utilisateur n'a pas pu être supprimé !</p>   
				        </div>
				        <div class="modal-footer">
				          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
				       </div> 	
				      </div>   
				    </div>
					
			</div>

			<div class="modal fade" id="myModal" role="dialog">
				    <div class="modal-dialog modal-dialog-centered">
				    
				      <!-- Modal content-->
				      <div class="modal-content">
				        <div class="modal-header">
				        	<h4 class="modal-title col-md-3 ml-auto">Confirmation</h4>
				          <button type="button" class="close" data-dismiss="modal">X</button>
				          
				        </div>
				        <div class="modal-body">
				          <p>La suppression de cet utilisateur entrainera la suppression de toutes les données le concernant !</p>
				          <p><span>Etes vous sûr de vouloir supprimer cet utilisateur ?</span></p>
				        </div>
				        <div class="modal-footer">
				        		<a id='modalhref' onclick="" class="btn btn-danger text-white col-md-4" data-dismiss="modal">Oui</a>
				         		<button type="button" class="btn btn-secondary col-md-4 ml-auto" data-dismiss="modal">Non</button>
				        	
				        </div>
				      
				      </div>
				      
				    </div>
			</div>
			
		</div>

	</div>
</div>

<script src="/js/admin/adminView.js?v=<?= time() ?>"></script>
