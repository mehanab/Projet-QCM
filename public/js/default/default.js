$(document).ready(function() {
	
	$('body').on('click','li.dropdown > .dropdown-toggle', function (e) {
	  
	  $(this).removeClass('.nav-link text-dark')
	  $('.dropdown-menu').toggleClass('show', '')
	 
	})

	




})