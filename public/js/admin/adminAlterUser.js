$(document).ready(function() {

	$('#divPassword').hide()
	$('#passwordChange').show();

	$("#passwordChange").click(function() {
	  $( "#divPassword" ).show()
	  $(this).hide()
	  $( "#motDePasse" ).attr('required',"")
	   $( "#confMotDePasse" ).attr('required',"")
	});

	$("#passwordDontChge").click(function() {
	  $( "#divPassword" ).hide()
	  $( "#motDePasse" ).attr('required', false)
	  $( "#confMotDePasse" ).attr('required', false)
	  $('#passwordChange').show()
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

	var password = document.getElementById("motDePasse"),
	 confirm_password = document.getElementById("confMotDePasse");

	function validatePassword(){
	  if(password.value != confirm_password.value) {
	    confirm_password.setCustomValidity("Les mots de passe ne sont pas identiques");
	  } else {
	    confirm_password.setCustomValidity('');
	  }
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;


})

