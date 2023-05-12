$(document).ready(function() {
	
	$('#modif').toggle()
	
	$('body').on('click', '.clearfix > a', function(){
		$('#article').toggle()
		$('#modif').toggle()
		return false
	})



})