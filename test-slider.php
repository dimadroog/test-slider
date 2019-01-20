<?php /*
	Plugin Name: Test Slider
	Description: A test slider. Calls with shortcode [test_slider] in theme or any post
	* Text Domain: test_slider
	* Domain Path: /lang
   */

	add_action( 'plugins_loaded', function(){
		load_plugin_textdomain( 'test_slider', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
	} );

	function test_slider_shortcode_function($atts) {
		ob_start (); 
		include plugin_dir_path( __FILE__ ) . '/front/functions.php';
		include_once(plugin_dir_path( __FILE__ ) . 'front/index.php');
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	add_shortcode('test_slider', 'test_slider_shortcode_function');



	// admin settings
	include plugin_dir_path( __FILE__ ) . '/admin/index.php';
	
 ?>