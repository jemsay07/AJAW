(function($){
	$(document).ready(function(){
		$('ul.navbar-nav li.dropdown').hover(function(){
			$(this).find('.dropdown-menu').stop(true, true).fadeIn(500);
			$(this).find('.dropdown-menu').toggleClass('show');
		},function(){
			$(this).find('.dropdown-menu').stop(true, true).fadeOut(500);
			$(this).find('.dropdown-menu').toggleClass('show');
		});

	});
	
})(jQuery);