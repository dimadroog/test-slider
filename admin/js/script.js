jQuery(document).ready( function($) {

	jQuery('input#add_new_slide').click(function(e) {

		var image_frame = get_image_frame();
		image_frame.open();

		image_frame.on('close',function() {
			var selection = image_frame.state().get('selection').first();
			if (selection) {
				var	section_id = jQuery('#slides > div').length;
				var data = {
				    section_id: section_id,
				    img_id: selection.toJSON().id,
				    action: 'test_slider_add_new_slide',
				};

				jQuery.get(ajaxurl, data, function(response) {
				    if(response.success === true) {
				    	var html = response.data.html_response;
				    	console.log(html);
				    	jQuery('#slides').append(html);
				    }
				});
			} else {
				return;
			}
		});

	});

});  //document ready

function get_image_frame(){ 
	// Define image_frame as wp.media object
	var image_frame = wp.media({
		title: 'Select Media',
		multiple : false,
		library : {
			type : 'image',
		}
	});
	return image_frame;
}

jQuery(document).on('click', '.remove-slide', function () { //event when target element generated after dom load 
    if (confirm("Этот слайд будет удален навсегда!")) {
        
        var slide_id = jQuery(this).attr('data-id');
        console.log(slide_id);
		var data = {
		    slide_id: slide_id,
		    action: 'test_slider_remove_slide',
		};
		jQuery.get(ajaxurl, data, function(response) {
		    if(response.success === true) {
		    	var slide = jQuery('.fields-section').eq(slide_id);
    	        slide.fadeOut(300, function(){ //fade out and remove element
		    		slide.remove();
		        });
		    }
		});	        
    } else {
        return;
    }
});

jQuery(document).on('click', '.slide-image', function () { //event when target element generated after dom load 
	var section = jQuery(this).closest('.fields-section');
	var old_image = jQuery(section).find('img');
	
	var image_frame = get_image_frame();
    image_frame.open();

	image_frame.on('close',function() {
		var selection = image_frame.state().get('selection').first();
		if (selection) {
			var data = {
			    img_id: selection.toJSON().id,
			    action: 'test_slider_change_slide_img',
			};
			jQuery.get(ajaxurl, data, function(response) {
			    if(response.success === true) {
			    	var img = response.data.img;
					old_image.attr({
						'src': jQuery(img).attr('src'),
						'width': jQuery(img).attr('width'),
						'height': jQuery(img).attr('height'),
					});
					jQuery(section).find('.hidden-img').val(selection.toJSON().id);
			    }
			});
		} else {
			return;
		}
	});
});