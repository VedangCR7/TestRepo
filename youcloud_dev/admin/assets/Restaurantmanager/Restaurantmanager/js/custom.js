(function ($) {
	"use strict";
	
	//Menu On Hover Dropdown
	$('.primary-navigation').on('mouseenter mouseleave', '.nav-item', function (e) {
		if ($(window).width() > 750) {
			var _d = $(e.target).closest('.nav-item'); _d.addClass('show');
			setTimeout(function () {
				_d[_d.is(':hover') ? 'addClass' : 'removeClass']('show');
			}, 1);
		}
	});


	// Sticky Navigation
	$(function () {
		var header = $(".start-style");
		$(window).scroll(function () {
			var scroll = $(window).scrollTop();
			if (scroll >= 10) {
				header.removeClass('start-style').addClass("scroll-on");
			} else {
				header.removeClass("scroll-on").addClass('start-style');
			}
		});
	});

	$('.nav-carousel').owlCarousel({
		loop:true,
		margin: 20,
		responsiveClass:true,
		mouseDrag: false,
		touchDrag: false,
		responsive:{
			0:{
				margin: 0,
				items:3,		
				mouseDrag: true,
				touchDrag: true,
			},
			600:{
				items:5,
			},
			1000:{
				items:7,
			}
		}
	});

	$('body').scrollspy({
		target: '.menu-navigation .nav-carousel',
		offset: 95
	})

	
	$('.nav-carousel a.item').on('click', function(event) {
		var $anchor = $(this);
		var headerH = '150';
		$('html,body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top - headerH + "px"
		}, 1200, 'easeInOutExpo');
		event.preventDefault();
	});



})(jQuery);
