
$(document).ready(function() {
// css
   
	$('.fa-times-circle').css('cursor', 'pointer')
	$('.fa-plus-square').css('cursor', 'pointer')



	$('body').on('mouseenter', 'span > .fa-times-circle', function(){
		$(this).attr('style', 'cursor: pointer; color: red;')
  		$('[data-toggle="tooltip"]').tooltip()

	}).on('mouseleave', 'span > .fa-times-circle', function(){
		$(this).attr('style', 'cursor: pointer;')
	})

	$('body').on('mouseenter', 'span > .fa-plus-square', function(){
		$(this).attr('style', 'cursor: pointer; color: blue;')
  		$('[data-toggle="tooltip"]').tooltip()

	}).on('mouseleave', 'span > .fa-plus-square', function(){
		$(this).attr('style', 'cursor: pointer;')
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



// suppression des input reponses

	$('body').on('click', '[data-target="#deleteQuestion"]', function(){
		var id=$(this).attr('id');
		$('.modal-footer').find('form > div > input').attr('value', id);
	})


	$('body').on('click', '.fa-times-circle' ,function() {

		var id= $(this).parent().parent().parent().parent().siblings('span').attr('id');
		
		$(this).parent().parent().parent().parent().remove()

		$('body').find('#'+id).siblings('div').each(function(ind){
			var t= ind+1;

			$(this).find('.form-group > label').find('#option').text(' Option '+t)
			$(this).find('.form-check-inline > input[type="checkbox"]').attr('name', 'valReponses['+(ind++)+']')
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

function rep(id){
	
		html=$('.reponses div:first-child').html()	

		if (html==undefined) {
			html='<div class="form-group row ">'+
											
			'<label class="col-sm-4 col-form-label"><span class="mr-1"><i class="fas fa-times-circle">'+
			'  </i></span><strong id="option">Option 1 : </strong></label>'+
			'<input type="text" name="reponses[]" class="col-sm-8 form-control" placeholder="" value="" required>'+
			'<div class="invalid-feedback">'+
			 'Le champs ne doit pas être vide !'+
			'</div></div>'+
			'<div class="form-group row ml-sm-1 d-flex justify-content-end">'+
			'<div class="form-check form-check-inline">'+
			'<input type="checkbox" name="valReponses[]" value="vrai" class="form-check-input">'+
			'<label for="homme" class="form-check-label ">Bonne proposition</label>'+
			'</div></div>';
		}

		var valRep=$('#'+id).siblings().length
	
		$('#'+id).before('<div class="'+valRep+'">'+html+'</div>')
		$('#'+id).prevAll().find('input:first').attr('name', 'reponses[]')
			
	$('#'+id).prevAll('.'+valRep).first().find("#option").text(' Option '+ (valRep+1))
	$('#'+id).prevAll('.'+valRep).first().find("input.col-sm-8").attr("value", "")

	$('#'+id).prevAll('.'+valRep).last().find("input.form-check-input").removeAttr('checked')

	$('body').find('#'+id).siblings('div').each(function(ind){	
		$(this).find('.form-check-inline > input[type="checkbox"]').attr('name', 'valReponses['+ind+']')
	})
	
}










