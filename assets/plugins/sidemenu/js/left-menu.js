(function($) {
    "use strict";
	
	// ______________Active Class
	$(".app-sidebar a").each(function() {
		var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) {
			$(this).addClass("active");
			$(this).parent().addClass("active"); // add active to li of the current link
			$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().prev().click(); // click the item to make it drop
		}
	});
	
	$(".app-sidebar").mCustomScrollbar({
		theme:"minimal",
		autoHideScrollbar: true
	});
	
	$(".right-sidebar").mCustomScrollbar({
		theme:"minimal",
		autoHideScrollbar: true
	});
	
	$(".sidebar-right").mCustomScrollbar({
		theme:"minimal",
		autoHideScrollbar: true
	});
	
})(jQuery);