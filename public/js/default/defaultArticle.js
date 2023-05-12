$(document).ready(function() {

	$('p > span.masquer').toggle();
	$('.afficher').append('<span>...</span>');
	
	$('body').on('click','.btnClick', function (e) {
	  $(this).parent().siblings('p.afficher').find('span').toggle()
	  var text =$(this).text()
	  $(this).text(text =='Voir les détails »' ? 'Voir moins »' : 'Voir les détails »')
	  return false 
	})




})