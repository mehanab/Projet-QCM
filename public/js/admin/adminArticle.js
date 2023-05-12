$(document).ready(function() {
	$('li.list-group-item > input').toggle()
	$('#btnSupp').toggle()
	$('#select_all').toggle()
	$('body').on('click', '.clearfix > a.supp', function(){
		$('li.list-group-item > input').toggle()
		$('#btnSupp').toggle()
		$('#select_all').toggle()
		return false
	})


	$( "#select_all > input[type=checkbox]" ).change(function() {
		  var $input = $( this );
		  if ($(this).is(":checked")) 
		  {
			  	$('li.list-group-item > input').each(function(e){
		
			  		$(this).prop("checked", 'checked')
				})

		  }else{

		  		$('li.list-group-item > input').each(function(){
		  			$(this).prop("checked", '')
				})

		  }
	}).change();


})