<?php 
function test_slider_styles() {  
    wp_register_style( 'test_slider_bootstrap_grid', plugins_url( '/css/bootstrap-only-grid.min.css', __FILE__ ));   
	wp_enqueue_style( 'test_slider_bootstrap_grid' ); 
    wp_register_style( 'test_slider_lightslider_style', plugins_url( '/css/lightslider.min.css', __FILE__ ));   
	wp_enqueue_style( 'test_slider_lightslider_style' ); 
    wp_register_style( 'test_slider_style', plugins_url( '/css/style.css', __FILE__ ));   
	wp_enqueue_style( 'test_slider_style' ); 
}
add_action( 'wp_enqueue_styles', 'test_slider_styles' );
do_action( 'wp_enqueue_styles' );


function test_slider_scripts() {  
    wp_register_script( 'test_slider_lightslider_script', plugins_url( '/js/lightslider.min.js', __FILE__ ), array( 'jquery' )); 
	wp_enqueue_script( 'test_slider_lightslider_script' );  
    wp_register_script( 'test_slider_script', plugins_url( '/js/script.js', __FILE__ ), array( 'jquery' )); 
	wp_enqueue_script( 'test_slider_script' );  
}
add_action( 'wp_enqueue_scripts', 'test_slider_scripts' );
do_action( 'wp_enqueue_scripts' );