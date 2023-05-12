$(document).ready(function() {

	$('#admin').show();
	$('#tableUsers').hide();
	$('#div').hide();

	var requete=null;
	var url=null;

	function ajax(){
		
		requete=$.ajax({ 
				type: 'GET',
				url: url,
				dataType: 'json'
			})
			
		requete.done(function(response, textStatus, jqXHR){
				
				$('#div').show()
				$('#admin').hide()
				$('#pageSuivante').hide()
				$('#pagePrecedente').hide()
				$('#tableUsers').show()
				$('#personne').empty()
				$('#classe').hide()
					
				
					if ("vide" in response) {
						$('#nbrPersonne').empty()
						$('#nbrPersonne').append('<p> Résultat : 0 personne trouvé </p>')

						$('#personne').append("<tr><td>"+ response['vide']+"</td>"+
					"<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>")

					}else if ("reponse" in response) {
						if ("pages" in response) {
							
							var nbPersonne=response['pages']['nbrPersonne'];
							var p= "personne trouvé";
							if (nbPersonne > 1) {
								p="personnes trouvés";
							}
							var pages= response['pages']['pages'];
							var pSuivante=parseInt($("#pageSuivante").attr("value"))
						
							if (pages > 1) {
									
								if (pSuivante > 2) {
									$('#pagePrecedente').show()
								}

								if ( pSuivante > pages) {
									$('#pageSuivante').hide()

								}else{

									$('#pageSuivante').show()
								}
							}
						}
						
						var response= response['reponse'];
						for (var i = 0; i < response.length; i++) {
						var sexe=response[i]['sexe'];
						if (sexe=='homme') {
							sexe='H'
						}else if (sexe=='femme') {
							sexe='F'
						}
						var d=new Date(response[i]['date_de_naissance']);
						var dateNaissance=d.getDate()+'/'+ (d.getMonth()+1) +'/'+ 
							d.getFullYear();

						var dCreation=new Date(response[i]['cree_le']);
						var dateCreation= dCreation.getDate()+'/'+ (dCreation.getMonth()+1) +'/'+ 
							dCreation.getFullYear()+ ' à '+ dCreation.getHours()+':'+ dCreation.getMinutes();
						var classe="";
						var setClass="";
						var isAdmin="";
						if ("statut" in response[i]) {
							if (response[i]["statut"]== "admin") {
								isAdmin="<span class='text-danger'> ("+response[i]["statut"]+")</span>"
								setClass= "class='table-warning'";
							}
						}

						if ("libelle" in response[i]) {
								$('#classe').show()
								classe = "<td>"+response[i]["libelle"]+"</td>"
							}
						$('#nbrPersonne').empty()
						$('#nbrPersonne').append('<p> Résultat : '+nbPersonne+' '+p+'</p>')
						$('#personne').append("<tr "+setClass+"><td>"+ response[i]['nom']+"</td><td>"
							+ response[i]['prenom']+isAdmin+"</td><td>"+ sexe +"</td><td>"+ dateNaissance+ "</td><td>"+ 
							response[i]['mail']+"</td>"+classe+"<td>"+response[i]['pseudo']+"</td><td>"+
							dateCreation +"</td><td>"+ response[i]['numero_voie']+' '+
							response[i]['type_voie']+' '+response[i]['nom_voie']+' '+
							response[i]['complement_adresse']+' '+response[i]['ville']+' '+
							response[i]['code_postal']+
							"<td>"+
							"<a class='btn btn-secondary' href='/projetQCM/admin/alterUser/"+response[i]['pseudo']+"'>Modif</a></td>"+
							"<td>"+
							"<a class='btn btn-secondary text-white' onclick='deleteUser(\""+response[i]['pseudo']+"\")'>Supp</a></td></tr>")
			
						
					}
				}	
			})
	}


	// lister les utilisateurs:
	$(".getUsers").click(function(){
		$('#titre').text('Liste de tous les utilisateurs')
		$('#valeur').val('');
		$("#pageSuivante").attr("value", 2)
		$("#pagePrecedente").attr("value", 1)
		url='/projetQCM/admin/listUsers';
		ajax();
	});

	// Lister les élèves:
	$(".getEleves").click(function(){
		
		$('#titre').text('Liste des élèves')
		$('#valeur').val('');
		$("#pageSuivante").attr("value", 2)
		$("#pagePrecedente").attr("value", 1)
		url='/projetQCM/admin/listEleves';
		ajax();
	});

	// Lister les professeurs
	$(".getProfesseurs").click(function(){
		
		$('#titre').text('Liste des professeurs')
		$('#valeur').val('');
		$("#pageSuivante").attr("value", 2)
		$("#pagePrecedente").attr("value", 1)
		url='/projetQCM/admin/listProfesseurs';
		ajax();
	});


	// rechercher un utilisateur :
	$("#serch").click(function(){
		$("#pageSuivante").attr("value", 2)
		$("#pagePrecedente").attr("value", 1)

		$( "#form" ).submit(function(event) {
	  		event.preventDefault();
	  	})

		var getfonction= fonctionUrl()
		var serch= $('#valeur').val();
		url='/projetQCM/admin/'+getfonction+'/'+serch;
		ajax();

	});

	// Click sur la page suivante
	$("#pageSuivante").click(function(){
		var serch= $('#valeur').val();
		var p=parseInt($('#pageSuivante').attr("value"));
		if (p < 2) {
			p=2
		}
		$('#pageSuivante').attr("value", p+1);
		$('#pagePrecedente').attr("value", p-1);
		if (serch== "") {
			serch=1
		}
		var getfonction= fonctionUrl();
		url='/projetQCM/admin/'+getfonction+'/'+serch+'/'+p;
		ajax();
	});


	// Click sur la page précédente
	$("#pagePrecedente").click(function(){
		var serch= $('#valeur').val();
		var p=parseInt($('#pagePrecedente').attr("value"));
		if (p< 1) {
			p=1
		}
		$('#pagePrecedente').attr("value", p-1);
		$('#pageSuivante').attr("value", p+1);
		if (serch== "") {
			serch=1
		}
		var getfonction= fonctionUrl();
		url='/projetQCM/admin/'+getfonction+'/'+serch+'/'+p;
		ajax();
	});


	$( "#liste" ).hide()

	$("#listerUsers").mouseover(function(){
	  $( "#liste" ).show()
	});


	$("#liste a").click(function(){
		$('#section1').toggleClass('col-md-3 my', false)
		$('#div').toggleClass()
		$('#div').toggleClass('mx-2')
		$('#section1').toggle('slide')
		$('#indice').toggle();
		
	})


	$("#indice").click(function(){
		$('#div').toggleClass('col-sm-9', true)
		$('#section1').toggleClass('col-md-3 my', true)
		$('#section1').toggle('slide')
		$('#indice').toggle();
	})



	$("#divActions").mouseleave(function() {
		$( "#liste" ).hide()	
	});


	$('#indice').toggle();

	$('.nav-tabs > li > a.nav-link').click(function(){
		$(this).toggleClass('.nav-link text-dark active', true)
		$(this).parent().prevAll().children().toggleClass('nav-link text-dark active', false)
		$(this).parent().prevAll().children().addClass('nav-link text-white')
		$(this).parent().nextAll().children().toggleClass('nav-link text-dark active', false)
		$(this).parent().nextAll().children().addClass('nav-link text-white')
	})

	$('#getUsers').click(function(){
		$('.getUsers').toggleClass('.nav-link text-dark active', true)
		$(this).toggleClass('active', false)
		$('.getUsers').parent().prevAll().children().toggleClass('nav-link text-dark active', false)
		$('.getUsers').parent().prevAll().children().addClass('nav-link text-white')
		$('.getUsers').parent().nextAll().children().toggleClass('nav-link text-dark active', false)
		$('.getUsers').parent().nextAll().children().addClass('nav-link text-white')
	})

	$('#getEleves').click(function(){
		$('.getEleves').toggleClass('.nav-link text-dark active', true)
		$(this).toggleClass('active', false)
		$('.getEleves').parent().prevAll().children().toggleClass('nav-link text-dark active', false)
		$('.getEleves').parent().prevAll().children().addClass('nav-link text-white')
		$('.getEleves').parent().nextAll().children().toggleClass('nav-link text-dark active', false)
		$('.getEleves').parent().nextAll().children().addClass('nav-link text-white')
	})

	$('#getProfesseurs').click(function(){
		$('.getProfesseurs').toggleClass('.nav-link text-dark active', true)
		$(this).toggleClass('active', false)
		$('.getProfesseurs').parent().prevAll().children().toggleClass('nav-link text-dark active', false)
		$('.getProfesseurs').parent().prevAll().children().addClass('nav-link text-white')
		$('.getProfesseurs').parent().nextAll().children().toggleClass('nav-link text-dark active', false)
		$('.getProfesseurs').parent().nextAll().children().addClass('nav-link text-white')
	})

})



	function deleteUser($pseudo)
	{
		$('#modalhref').attr('onclick', 'supprimer("'+$pseudo+'")')
	    $("#myModal").modal()
	}



	function supprimer($pseudo)
	{

		url='/projetQCM/admin/deleteUser/'+$pseudo;
		requete=$.ajax({ 
				type: 'GET',
				url: url,
				dataType: 'json'
			})
			
		requete.done(function(response, textStatus, jqXHR){
			if ('true' in response) {

				$("#myModalSucces").modal()
				
			}else {

				$("#myModalError").modal()
			}
			
			
		});

	}


	function listerUsers()
	{
		$('#titre').text('Liste de tous les utilisateurs')
		$('#valeur').val('');
		$("#pageSuivante").attr("value", 2)
		$("#pagePrecedente").attr("value", 1)
		url='/projetQCM/admin/listUsers';
		$('.getUsers').toggleClass('.nav-link text-dark active', true)
		$('#getUsers').toggleClass('active', false)
		$('.getUsers').parent().prevAll().children().toggleClass('nav-link text-dark active', false)
		$('.getUsers').parent().prevAll().children().addClass('nav-link text-white')
		$('.getUsers').parent().nextAll().children().toggleClass('nav-link text-dark active', false)
		$('.getUsers').parent().nextAll().children().addClass('nav-link text-white')
		ajax();

	}

	


	function fonctionUrl()
	{

		var titre=$('#titre').text()
		var fonction = 'listUsers';

		if (titre=='Liste des élèves') {
			fonction='listEleves';
		}else if (titre== 'Liste des professeurs') {
			fonction='listProfesseurs';
		}
		return fonction;

	}
