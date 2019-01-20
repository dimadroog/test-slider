jQuery(document).ready(function() {
	var slider = jQuery('#test-slider').lightSlider({
		item: 1,
		loop: true,
		slideMove: 1,
		slideMargin: 150,
		controls: false,
		pager: false,
		auto:true,
		speed: 600,
		pause: 3000,
		pauseOnHover: true,
	});  
	jQuery('#goToPrevSlide').on('click', function () {
	    slider.goToPrevSlide();
	});
	jQuery('#goToNextSlide').on('click', function () {
	    slider.goToNextSlide();
	});
});  

