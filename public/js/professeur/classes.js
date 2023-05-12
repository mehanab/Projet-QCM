$(document).ready(function() {
	
	$('#myList a').on('click', function (e) {
	  e.preventDefault()
	  $(this).toggleClass('show', false)
	  $(this).toggleClass('active', false)

	  $(this).siblings().toggleClass('show', false)
	  $(this).siblings().toggleClass('active', false)
	  $('#nav-tabContent').children().toggleClass('show', false)
	  $('#nav-tabContent').children().toggleClass('active', false)
	  $(this).tab('show')
	  window.scrollBy(0, 1000)

	})


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


})