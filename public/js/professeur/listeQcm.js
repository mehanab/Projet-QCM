$(document).ready(function() {

	$('#divMore').hide()
	$('.fa-edit').css('cursor', 'pointer')
	$('.fa-edit').addClass('text-dark')
	$('.fa-times').css('cursor', 'pointer')
	$('.fa-eye').addClass('text-dark')
	$('.fa-lock').addClass('text-dark')
	$('.fa-share-square').css('cursor', 'pointer')
	$('.fa-share-square').addClass('text-dark')

// Nav
	$('#choixTypeQcm').toggle()
	$('body').on('mouseenter', '#createQcm', function(){
		$('#choixTypeQcm').show()
		$('#choixTypeQuestions').hide()
		
	}).on('mouseleave', '#navProf', function(){
		$('#choixTypeQcm').hide()
	})

	$('#choixTypeQuestions').toggle()
	$('body').on('mouseenter', '#showQuestions', function(){
		$('#choixTypeQuestions').show()
		$('#choixTypeQcm').hide()
		
	}).on('mouseleave', '#navProf', function(){
		$('#choixTypeQuestions').hide()
	})

// Les tooltips
	$(function () {
  		$('[data-toggle="modal"]').tooltip()
	})
	
	$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
	})

//Css
	$('body').on('mouseenter', 'td > .fa-times', function(){
		$(this).attr('style', 'cursor: pointer; color: red;')
	}).on('mouseleave', 'td > .fa-times', function(){
		$(this).attr('style', 'cursor: pointer;')
	})

	$('body').on('mouseenter', 'td > a > .fa-edit', function(){
		$(this).attr('style', 'cursor: pointer;')
		$(this).toggleClass('text-dark').toggleClass('text-blue')
	}).on('mouseleave', 'td > a > .fa-edit', function(){
		$(this).attr('style', 'cursor: pointer;')
		$(this).toggleClass('text-blue').toggleClass('text-dark')
	})

	$('body').on('mouseenter', 'td > a > .fa-eye', function(){
		$(this).attr('style', 'cursor: pointer;')
		$(this).toggleClass('text-dark').toggleClass('text-blue')
	}).on('mouseleave', 'td > a > .fa-eye', function(){
		$(this).attr('style', 'cursor: pointer;')
		$(this).toggleClass('text-blue').toggleClass('text-dark')
	})

	$('i.publier').click(function(){
		$('tr').toggleClass('table-active', false)
		$(this).parent().parent().addClass('table-active')
		
	})


// Détails QCM :
	$('a.voir').click(function(){
		var element = document.getElementById("divMore");
		element.scrollIntoView();
		$('tr').toggleClass('table-active', false)
		$(this).parent().parent().addClass('table-active')
		var id=Math.trunc(parseInt($(this).attr('id')));
		var url='/projetQCM/professeur/get_more/'+id;

		requete=$.ajax({ 
			type: 'GET',
			url: url,
			dataType: 'json'
		})
		
		requete.done(function(response, textStatus, jqXHR){
			
				
				if ("qcm" in response) {
					$('#divMore').empty()
					$('#publication').hide();
					$('#divMore').show()
					var date=new Date(response['qcm']['date_limite']);
					var month=date.getMonth()+1
					var day=date.getDate()
					if (month < 10) {
						month='0'+(month);
					}
					if (day < 10) {
						day='0'+(day);
					}
					var date_limite= day+'/'+ month +'/'+ 
						date.getFullYear()

					var d=new Date(response['qcm']['cree_le']);
					var month=d.getMonth()+1
					var day=d.getDate()
					if (month < 10) {
						month='0'+(month);
					}
					if (day < 10) {
						day='0'+(day);
					}
					var minute=d.getMinutes();
					if (minute < 10) {

						minute='0'+(minute);
					}
					var cree_le= day+'/'+ month +'/'+ 
						d.getFullYear()+' à '+d.getHours()+':'+minute;

					var minutes=parseInt(response['qcm']['duree_test']) 
					var minute= parseInt(response['qcm']['duree_test']);
					var heure=0;
					var jour=0;
					if (minute > 60) {
						minute= Math.ceil(((minutes/60)- Math.trunc(minutes/60))*60)
						heure= Math.trunc(((Math.trunc(minutes/60)/24).toFixed(8) - Math.trunc(Math.trunc(minutes/60)/24))*24);
						jour= Math.trunc(Math.trunc(minutes/60)/24);
							/*alert((Math.trunc(minutes/60)/24).toFixed(8))*/
					}
					if (heure > 0) {heure= heure+ ' heures et ' }else{ heure= ''};
					if (jour > 0) {jour= jour+ ' jours et ' }else{ jour= ''};
					$('#divMore').append("<article><h3 class='card-header text-center text-dark mb-5'>Détails"+
						" </h3>"+"<p><strong class='text-secondary'>Matière: </strong><strong><i>" +
						response['qcm']['theme']+

					" </i></strong></p><p><strong class='text-secondary'>Titre: </strong><strong><i>'" +
						response['qcm']['libelle']+
					"' </i></strong></p><p><strong class='text-secondary'> Date limite: </strong><strong><i>"+date_limite+ 
					"</i></strong></p><p><strong class='text-secondary'> Durée du test: </strong><strong><i>" + jour+ heure +minute+' mn ' +  
					"</i></strong></p><p><strong class='text-secondary'> Echelle de notation: </strong><strong><i>" +response['qcm']['echelle_not']+
					"</i></strong></p><p><strong class='text-secondary'> Barème de bonne réponse: </strong><strong><i>" +response['qcm']['notation_vrai']+
					"</i></strong></p><p><strong class='text-secondary'> Barème de réponse invalide: </strong><strong><i>" +response['qcm']['notation_faux']+
					"</i></strong></p><p><strong class='text-secondary'> Crée le: </strong><strong><i>" +cree_le+
					"</i></strong></p></article><div id='det_question' class='mt-5'></div>"
					)
					$('body').find('#det_question').toggle()

					if ((response['qcm']['questions'] != null) && response['qcm']['questions'].length > 0) {

						var questions=response['qcm']['questions']
						$('#divMore').append("<nav><a class='det_question' href='#'>Voir les questions </a></nav>")
						$('#det_question').append("<h4 class='mb-5 card-header bg-light text-center'><strong>Les questions</strong></h4>")
						for (var i = 0; i <= questions.length - 1; i++) {
							$('#det_question').append('<p><strong>'+(i+1)+' - '+questions[i]['question']+
								'</strong></p><ul class="ul'+i+'">')
							var reponses= questions[i]['reponses']
							for (var j = 0; j <= reponses.length -1; j++) {
								var valeur= ' <span class="text-danger"><i class="fas fa-times"></i></span>'
								var la_class='text-danger'
								if (reponses[j]['valeur']== 'vrai') {
									valeur=' <span class="text-success"><i class="fas fa-check"></i></span>'
									la_class='text-success'
								}
								$('.ul'+i).append('<li>'+reponses[j]['reponse']+valeur+' </li>')
							}
							$('#det_question').append('</ul>')
						}
						
						
					}			
				}
		})	
		
		return false;
	})

// Affichage des détails des QCM: 
	$('body').on('click', '.det_question', function(){
		$('#det_question').toggle()
		$('.det_question').text('Masquer')
		$('.det_question').toggleClass('moins')
		$('.det_question').toggleClass('det_question', false)
		return false
	})
	$('body').on('click', '.moins', function(){
		$('#det_question').toggle()
		$('a.moins').text('Voir les questions')
		$('.moins').toggleClass('det_question')
		$('.moins').toggleClass('moins', false)
		return false
	})

// Suppression Qcm

$(function(){
	$('[data-target="#deleteQcm"]').click(function(){
		var id=$(this).attr('id');
		$('.modal-footer').find('form > div > input').attr('value', id);

	})
})



// Publication QCM

$('#publication').hide();

$(function(){
	$('.fa-share-square').click(function(){
	
		var element = document.getElementById("publication");
		element.scrollIntoView();
		
		var id_qcm=$(this).attr('id');
		var name=$(this).attr('data-name');
		$('#form-group').find('input').attr('value', id_qcm);
		$('#form-group').find('label').empty()
		$('#form-group').find('label').append('QCM à publier : <strong>'+ name+'</strong>');

		$('#publication > form > .form-check').each(function()
		{
			$(this).find('input').attr('checked', false)

		})


		$('#publication > form > .form-check').each(function()
		{
			
			var idClasse = $(this).find('input').attr('value')

			var url= '/projetQCM/professeur/classe_qcm/'+id_qcm+'/'+idClasse

			requete=$.ajax({ 

				type: 'POST',
				url: url,
				dataType: 'json',				
			})

			requete.done(function(response, textStatus, jqXHR)
			{
				if (response) {
					
					if ('qcm' in response) 
					{
					
						if ('id_classe' in response['qcm'] ) 
						{
							
							if (response['qcm']['id_classe']== idClasse) 
							{
								$('#publication > form > .form-check').each(function()
								{
									id_classe = $(this).find('input').attr('value')
									
									if (response['qcm']['id_classe']== id_classe) 
									{
										$(this).find('input').attr('checked', 'checked')
									}
									
								})

								
							}

						}

						
					}

				}
							
			})
			
		})

		$('#divMore').hide();
		$('#publication').show();
			
	})
	

})








})