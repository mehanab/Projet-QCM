
$(document).ready(function() {

// nav
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

	// Ajout QCM professeur
	$('#inputTheme').toggle();
	$('#ajoutTheme').click(function(){
		$('#inputTheme').toggle();
		return false;

	})

	$('#enregistrement_suite').toggle();
	$('#retour_enregistrement').toggle();
	$('#suite_enregistrement').click(function(){
		$('#enregistrement_suite').toggle();
		$('#enregistrement').toggle();
		$('#retour_enregistrement').toggle();

	})

	$('#retour_enregistrement').click(function(){
		$('#enregistrement_suite').toggle();
		$('#enregistrement').toggle();
		$('#retour_enregistrement').toggle();

	})



	// Questions et réponses: 

	$('.cursorRep').css('cursor', 'pointer')
	$('.cursorQuest').css('cursor', 'pointer')
	$('.cursorQuestPost').css('cursor', 'pointer')
	$('.fa-times-circle').css('cursor', 'pointer')
	$('.fa-times').css('cursor', 'pointer')
	$('.fa-times').hide()
	$('.fa-plus-square').addClass('text-secondary')

// Style supression question
	$('body').on('mouseenter', '.p-3 > label', function(){

		$(this).find('.fa-times').show()
		$('.fa-times').css('color: red;')

	}).on('mouseleave', '.p-3 > label', function(){
		$('.fa-times').hide() 
	})

// Style des boutons supression Options de questions:
$('body').on('mouseenter', '.fa-times-circle', function(){
		
		$(this).addClass('text-danger')

	}).on('mouseleave', '.fa-times-circle', function(){
	
		$(this).toggleClass('text-danger', false)
	})

// Style des boutons d'ajout des Options et questions:
$('body').on('mouseenter', '.fa-plus-square.text-secondary', function(){
		
		$(this).toggleClass('text-secondary', false)

	}).on('mouseleave', '.fa-plus-square', function(){
		
		$(this).toggleClass('text-secondary', true)

	})



/*var id=1;*/
	$('.cursorQuest').click(function(){
		var id=$('.cursorQuest').siblings('.reponses').length
		divQuestion=$('div > #questionReponse > :first-child').clone()
		
		if (divQuestion.length <= 1) {
			
			divQuestion ='<div class="form-group row bg-light p-3" id="">'+
					'<label class="col-sm-4 col-form-label"><span><i class="fas fa-times" style="color: red;">'+
					'</i><em> </em><strong> Question 1 : </strong></span></label>'+
					'<input type="text" name="questions[]" class="col-sm-8 form-control" placeholder="" value="" required>'+
					'<div class="invalid-feedback">'+
					'Le champs ne doit pas être vide !'+
					'</div>';
		}

		divReponse=$('.reponses :first-child').html()	

		if (divReponse==undefined) {
			divReponse='<div class="form-group row ">'+
											
			'<label class="col-sm-4 col-form-label"><span class="mr-1"><i class="fas fa-times-circle">'+
			' Option 1 : </i> </span></label>'+
			'<input type="text" name="reponses[0][]" class="col-sm-8 form-control" placeholder="" value="" required>'+
			'<div class="invalid-feedback">'+
			 'Le champs ne doit pas être vide !'+
			'</div></div>'+
			'<div class="form-group row ml-sm-1 d-flex justify-content-end">'+
			'<div class="form-check form-check-inline">'+
			'<input type="checkbox" name="valReponses[0][0]" value="vrai" class="form-check-input">'+
			'<label for="homme" class="form-check-label ">Bonne proposition</label>'+
			'</div></div>';
			idPost=0;
		}

		$('.cursorQuest').before(divQuestion)
		$('.cursorQuest').before('<div class="mb-5 ml-5 bg-light reponses px-5 py-3"><div>'
				+divReponse+
			'</div><span class="cursorRep" style="cursor: pointer;" onclick="rep('+id+
			');" id="'+id+'"><i class="fas fa-plus-square"></i></span></div>')

		$('#questionReponse > div:last > div > div:first > input').attr('name', 'reponses['+
			id+'][]')
		$('#questionReponse > div:last > div > div:last > div > input').attr('name', 'valReponses['+
			id+'][0]')
		$('#questionReponse > div:last > div > div:last > div > input').removeAttr('checked')
		id++;
		/*$('#questionReponse > .form-group > label').last().text('Question '+id+ ' :');*/
		$('#questionReponse > .form-group > label').last().find('strong').text(' Question '+id+ ' :');
		$('.fa-times').hide()
	
	})


/*var idPost=$('.cursorQuestPost').attr('id');*/


	$('.cursorQuestPost').click(function()
	{
		idPost=$('.cursorQuestPost').siblings('.reponses').length
		divQuestion=$('div > #questionReponse > div:first-child').clone()
		
		if (divQuestion.length <= 0) {
			divQuestion ='<div class="form-group row bg-light p-3" id="">'+
					'<label class="col-sm-4 col-form-label"><span><i class="fas fa-times" style="color: red;">'+
					'</i><em> </em><strong> Question 1 : </strong></span></label>'+
					'<input type="text" name="questions[]" class="col-sm-8 form-control" placeholder="" value="" required>'+
					'<div class="invalid-feedback">'+
					'Le champs ne doit pas être vide !'+
					'</div>';
		}

		divReponse=$('.reponses :first-child').html()

		if (divReponse==undefined) {
			divReponse='<div class="form-group row ">'+
											
			'<label class="col-sm-4 col-form-label"><span class="mr-1"><i class="fas fa-times-circle">'+
			' Option 1 : </i> </span></label>'+
			'<input type="text" name="reponses[0][]" class="col-sm-8 form-control" placeholder="" value="" required>'+
			'<div class="invalid-feedback">'+
			 'Le champs ne doit pas être vide !'+
			'</div></div>'+
			'<div class="form-group row ml-sm-1 d-flex justify-content-end">'+
			'<div class="form-check form-check-inline">'+
			'<input type="checkbox" name="valReponses[0][0]" value="vrai" class="form-check-input">'+
			'<label for="homme" class="form-check-label ">Bonne proposition</label>'+
			'</div></div>';
			idPost=0;
		}	


		$('.cursorQuestPost').before(divQuestion)
		$('.cursorQuestPost').before('<div class="mb-5 ml-5 bg-light reponses px-5 py-3"><div>'
				+divReponse+
			'</div><span class="cursorRep" style="cursor: pointer;" onclick="rep('+idPost+
			');" id="'+idPost+'"><i class="fas fa-plus-square"></i></span></div>')

		$('#questionReponse > div:last > div > div:first > input').attr('name', 'reponses['+
			idPost+'][]')
		$('#questionReponse > div:last > div > div:first > input').attr("value", '')
		$('.p-3:last > input').attr("value", '')
		$('#questionReponse > div:last > div > div:last > div > input').attr('name', 'valReponses['+
			idPost+'][0]')
		$('#questionReponse > div:last > div > div:last > div > input').removeAttr('checked')

		idPost++;

		$('#questionReponse > .form-group > label').last().find('strong').text(' Question '+idPost+ ' :');
		$('.fa-times').hide()
	
	})

// Suppression des Options des Questions QCM:
	$('body').on('click', '.fa-times-circle' ,function() {

		var id= $(this).parent().parent().parent().parent().siblings('span').attr('id');
		
		$(this).parent().parent().parent().parent().remove()
		$('body').find('#'+id).siblings('div').each(function(ind){
			var t= ind+1;
			$(this).find('.form-group > label').find('i').text(' Option '+t)
			$(this).find('.form-check-inline > input[type="checkbox"]').attr('name', 'valReponses['+id+']['+ind+']')
		})
	});

// suppression des Questions dans le QCM et mise en page: 
	$('body').on('click', '.fa-times' ,function() {

		$(this).parent().parent().parent().next('.reponses').remove()
		$(this).parent().parent().parent().remove()

		$('body').find( ".p-3" ).each(function(i) {
				var t= i+1;
			$(this).find("label > span > strong").text('Question '+t)
		
		});

		$('body').find( ".reponses" ).each(function(i) {
				
			$(this).find(".cursorRep").attr('onclick', 'rep('+i+')');
			$(this).find(".cursorRep").attr('id', i);

		});

		$('body').find( ".reponses" ).each(function(i) {

			$(this).find('div').each(function(index){
				$(this).find("input[type='text']").attr('name', 'reponses['+i+'][]');	
			})

			$(this).find('div.form-check-inline').each(function(m){
				$(this).find('input').attr('name', 'valReponses['+i+']['+m+']')
			})

		});

	});

 
	(function(){
	  'use strict';
	  window.addEventListener('load', function() {
	    // Fetch all the forms we want to apply custom Bootstrap validation styles to
	    var forms = document.getElementsByClassName('needs-validation');
	    // Loop over them and prevent submission
	    var validation = Array.prototype.filter.call(forms, function(form) {
	      form.addEventListener('submit', function(event) {
	        if (form.checkValidity() === false) {
	          event.preventDefault();
	          event.stopPropagation();
	        }
	        form.classList.add('was-validated');
	      }, false);
	    });
	  }, false);
	})(jQuery);


});

function rep(id){
	
		html=$('.reponses div:first-child').html()	

		if (html==undefined) {
			html='<div class="form-group row ">'+
											
			'<label class="col-sm-4 col-form-label"><span class="mr-1"><i class="fas fa-times-circle">'+
			' Option 1 : </i> </span></label>'+
			'<input type="text" name="reponses[0][]" class="col-sm-8 form-control" placeholder="" value="" required>'+
			'<div class="invalid-feedback">'+
			 'Le champs ne doit pas être vide !'+
			'</div></div>'+
			'<div class="form-group row ml-sm-1 d-flex justify-content-end">'+
			'<div class="form-check form-check-inline">'+
			'<input type="checkbox" name="valReponses[0][0]" value="vrai" class="form-check-input">'+
			'<label for="homme" class="form-check-label ">Bonne proposition</label>'+
			'</div></div>';
		}

		var valRep=$('#'+id).siblings().length
	
		$('#'+id).before('<div class="'+valRep+'">'+html+'</div>')
		$('#'+id).prevAll().find('input:first').attr('name', 'reponses['+
			id+'][]')
			
	$('#'+id).prevAll('.'+valRep).first().find(".fa-times-circle").text(' Option '+ (valRep+1))
	$('#'+id).prevAll('.'+valRep).first().find("input.col-sm-8").attr("value", "")
	
	$('#'+id).prevAll('.'+valRep).last().find("input.form-check-input").removeAttr('checked')

	$('body').find('#'+id).siblings('div').each(function(ind){	
		$(this).find('.form-check-inline > input[type="checkbox"]').attr('name', 'valReponses['+id+']['+ind+']')
	})
	
}



