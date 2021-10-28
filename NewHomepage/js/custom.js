(function ($) {
	"use strict";
	var swiper = new Swiper('.swiper-container.one', {

        autoplay: {
            delay: 1500,
        },
        speed: 1000,
        effect: 'coverflow',
		loop: true,
        centeredSlides: true,
		spaceBetween: 50,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 0,
            stretch: 100,
            depth: 120,
			modifier: 1,
            slideShadows: false,
        }
    });
	$('.venobox').venobox({
		spinner: 'wave',
	}); 



})(jQuery);
