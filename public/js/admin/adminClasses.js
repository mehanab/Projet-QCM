$(document).ready(function() {

	// Ajout /supp des niveaux par l'admin
	$('#formAjoutNiv').toggle()
	$('#formSuppNiv').toggle()
	$('#ajoutNiv').click(function(){
		$('#formAjoutNiv').toggle()
	})
	$('#suppNiv').click(function(){
		$('#formSuppNiv').toggle()
	})

	// Ajout/modifier /supp des classes par l'admin
	/*$('.suppClasse').attr('data-toggle', 'modal');*/
	$('.formAjoutClasse').toggle()
	$('.formModifClasse').toggle()
	$('.formSuppClasse').toggle()

	$('div.tab-pane > div > button:first-child').click(function(){
		var id=$(this).parent().parent().attr('id')
		$('#'+id +'> .formAjoutClasse').toggle()
	})

	$('div.tab-pane > div > button.modifClasse').click(function(){
		var id=$(this).parent().parent().attr('id')
		$('#'+id +'> .formModifClasse').toggle()
	})

	$('div.tab-pane > div > button:last-child').click(function(){
		var id=$(this).parent().parent().attr('id')
		$('#'+id +'> .formSuppClasse').toggle()
		$('#deleteClasse').on('hidden.bs.modal', function (e) {
			$('#'+id +'> div > button:last-child').attr('data-toggle', 'button');
	  		$('#'+id +'> div > button:last-child').attr('data-target', '');	
	  		$('#'+id +'> div > button:last-child').trigger('click')
	  		$('#'+id +'> .formSuppClasse').toggle()
		})
	})

	// La liste des professeur de chaque classe: 
	$('.profListe').toggle();
	$('#profListe').click(function(){
		$('.profListe').toggle();
		return false;
	})

	// La liste des élèves de chaque classe: 
	$('.eleveListe').toggle();
	$('#eleveListe').click(function(){
		$('.eleveListe').toggle();
		return false;
	})

	// Ajouter un professeur à une classe: 
	$('#formAddProf').toggle();
	$('#showAddProf').click(function(){
		$('#formAddProf').toggle();
		return false;
	})






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

})