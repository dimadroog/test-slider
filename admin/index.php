<?php
function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=settings_test_slider">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );


function test_slider_admin_enqueue_scripts( $page ) {
	if( $page == 'settings_page_settings_test_slider' ) {
		wp_enqueue_media(); //wp media for call select image modal
		wp_enqueue_script( 'test_slider_admin_script', plugins_url( 'js/script.js' , __FILE__ ), array('jquery'), '0.1' );
		wp_enqueue_style( 'test_slider_admin_style', plugins_url('css/style.css', __FILE__) );
	}
}
add_action( 'admin_enqueue_scripts', 'test_slider_admin_enqueue_scripts' );


function register_test_slider_settings_page() {
	add_submenu_page( 'options-general.php', 'Test Slider', 'Test Slider', 'manage_options', 'settings_test_slider', 'test_slider_settings_page_callback' );
}
add_action( 'admin_menu', 'register_test_slider_settings_page' );



function test_slider_settings(){
	// params: $option_group, $option_name, $sanitize_callback
	register_setting( 'test_slider_option_group', 'test_slider_setting', 'test_slider_sanitize_callback' );
}
add_action('admin_init', 'test_slider_settings');


function test_slider_settings_page_callback() {
?>
	<div class="wrap">
		<h1><?php echo __('Test Slider', 'test_slider'); ?></h1>
		<form action="options.php" method="POST">
			<div id="slides">
				<?php 
				if (get_option('test_slider_setting')) {
					foreach (get_option('test_slider_setting') as $key => $value){
						echo test_slider_create_slide($key, $value);
					} 
				}
				settings_fields( 'test_slider_option_group' );     // скрытые защитные поля
				?>	
			</div>
			<input type='button' class="button" value="<?php echo __('Add new slide', 'test_slider'); ?>" id="add_new_slide"/>
			<input type="submit" class="button button-primary" value="<?php echo __('Save changes', 'test_slider'); ?>">
		</form>
	</div>
	<?php
}

// generate fields when add new slide or show already created slides
function test_slider_create_slide($key, $value) {
	$result = '';
	$result .= '<div id="test_slider_section_'.$key.'" class="fields-section">	';
	$result .= '<div class="fields-section-col">';
	$result .= '<label>'.__('Title', 'test_slider').'</label>';
	$result .= '<input type="text" class="regular-text" name="test_slider_setting['.$key.'][title]" value="'.$value['title'].'">';
	$result .= '<label>'.__('Customer', 'test_slider').'</label>';
	$result .= '<input type="text" class="regular-text" name="test_slider_setting['.$key.'][customer]" value="'.$value['customer'].'">';
	$result .= '<label>'.__('Tasks', 'test_slider').'</label>';
	$result .= '<textarea class="regular-text" name="test_slider_setting['.$key.'][tasks]">'.$value['tasks'].'</textarea>';
	$result .= '<label>'.__('Done', 'test_slider').'</label>';
	$result .= '<textarea class="regular-text" name="test_slider_setting['.$key.'][done]">'.$value['done'].'</textarea>';
	$result .= '<input type="hidden" class="hidden-img" name="test_slider_setting['.$key.'][img]" value="'.$value['img'].'">';
	$result .= '</div>';
	$result .= '<div class="fields-section-col">';
	$result .= '<label>'.__('Img', 'test_slider').'</label>';
	$result .=  wp_get_attachment_image( $value['img'], 'thumbnail', false, array( 'class' => 'slide-image' ) );
	$result .= '</div>';
	$result .= '<button type="button" data-id="'.$key.'" class="notice-dismiss remove-slide"></button>'; 
	$result .= '</div>'; 
	return $result;
}

// clear data before save
function test_slider_sanitize_callback( $options ){ 
	foreach( $options as $key => $value ){
		$options[$key]['title'] = strip_tags($options[$key]['title']);
		$options[$key]['customer'] = strip_tags($options[$key]['customer']);
		$options[$key]['tasks'] = strip_tags($options[$key]['tasks']);
		$options[$key]['done'] = strip_tags($options[$key]['done']);
		$options[$key]['img'] = intval($options[$key]['img']);
	}
	// die(var_dump($options));
	return $options;
}

// ajax callback function
function test_slider_add_new_slide() {
	$section_id = $_GET['section_id'];
	$img_id = $_GET['img_id'];
    if(isset($section_id) && isset($img_id)){
		// params: $id, $title, $callback, $page
		add_settings_section('test_slider_section_'.$section_id); 

		// params: $id, $title, $callback, $page, $section, $args
		add_settings_field('title', __('Title', 'test_slider'));
		add_settings_field('customer', __('Customer', 'test_slider'));
		add_settings_field('tasks', __('Tasks', 'test_slider'));
		add_settings_field('done', __('Done', 'test_slider'));
		add_settings_field('img', __('Img', 'test_slider'));

		$html_response = test_slider_create_slide($section_id, array('img' => $img_id));

		$data = array(
			'html_response' => $html_response,
		);
	    wp_send_json_success($data);
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_test_slider_add_new_slide', 'test_slider_add_new_slide');

// ajax callback function
function test_slider_remove_slide() {
	$slide_id = $_GET['slide_id'];
    if(isset($slide_id)){
    	$array = get_option('test_slider_setting');
    	unset($array[$slide_id]);
    	update_option('test_slider_setting', $array);
		$data = array(
			'slide_id' => $slide_id,
		);
	    wp_send_json_success( $data );
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_test_slider_remove_slide', 'test_slider_remove_slide');

// ajax callback function
function test_slider_change_slide_img() {
	$img_id = $_GET['img_id'];
    if(isset($img_id)){
    	$img = wp_get_attachment_image($img_id, 'thumbnail', false, array( 'class' => 'slide-image'));
		$data = array(
			'img' => $img,
		);
	    wp_send_json_success( $data );
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_test_slider_change_slide_img', 'test_slider_change_slide_img');