
$(document).ready(function() {

// réponses questions: 
	
	
	$('body').on('click', '.myCollapsible > a', function(){
		var text=$(this).text()
		if (text=='Voir les réponses') {
			text='Masquer';
		}else{
			text='Voir les réponses';
		}
		$(this).text(text)
		$(this).parent().prev('.collapse').toggle(400)
	})

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

// Plus de questions

	$('#more_questions').click(function(){
		var id_theme= $(this).attr('data-theme');
		var page= $(this).attr('class');
		$(this).attr('class', parseInt(page)+1);

		requete=$.ajax({ 
			type: 'GET',
			url: '/projetQCM/professeur/more_questions/'+id_theme+ '/'+page,
			dataType: 'json'
		})
		
		requete.done(function(response, textStatus, jqXHR){
			
				
				if ('questions' in response) 
				{
					var questions= response['questions'];
		
					for (var i = 0; i <= questions.length - 1; i++) {
						var question=questions[i];
						if (parseInt(page) == question['count_pages']) 
						{
							$('#more_questions').hide()
						}
						
						$('#more_questions').before('<div class="form-check bg-light p-3 pl-5">'+			
						'<input type="checkbox" class="form-check-input" name="questions[]" value="'+question['id']+
							'" id="'+question['id']+'">'+
							'<label class="form-check-label pl-3" for="'+question['id']+'">'+
							'<strong>'+question['question']+'</strong></label></div>'		
							)

						if (question['reponses'] != null && question['reponses'].length > 0) 
						{
							var reponses=question['reponses'];	
							$('#more_questions').before('<div class="collapse" id="'+question['id']+'">'+
							'<div class="ml-5 bg-light px-5 py-3 "><div><ol>'
							)
							for (var j = 0; j <= reponses.length -1; j++) {
								reponse=reponses[j]
								var valeur= reponse['valeur'];
								var icon= '<i class="fas fa-times text-danger"></i>';
								if (valeur== 'vrai' ) 
								{
									icon='<i class="fas fa-check text-success"></i>';
								}
								$('#questionReponse').find('ol').last().append('<li>'+reponse['reponse']+' '+icon+'</li>')
							}

							$('#more_questions').before('<div class="pb-3 clearfix myCollapsible">'+
										'<a class="float-right pr-5" data-toggle="collapse" '+
										'href="" role="button" aria-expanded="false" '+
										' aria-controls="divRep'+question['id']+'" >'+
										'Voir les réponses</a></div>')
							
						}
					}
				}
		});
	
		return false;
	})



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








