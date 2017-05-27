<?php

/*
Plugin Name: Multiform
Plugin URI: https://hirelandry.com/creating-custom-front-end-registration-and-login-forms
Description: Provides a step by step form with progressbar
Version: 1.0
Author: Djouonang Landry
Author URI: https://www.hirelandry.com

*/

		include dirname( __FILE__ ) .'/form.php';



	function wpb_adding_scripts() {

	wp_register_script('my_amazing_script', plugins_url('/js/plugin.js', __FILE__), array(), '1.0.0', true );
	wp_register_script('my_amazing_scrip', plugins_url('/js/checkbox.js', __FILE__), array(), '1.0.0', true );
    
	wp_enqueue_script('my_amazing_scrip');
	wp_enqueue_script('my_amazing_script');
	wp_enqueue_script('jquery-effects-core');

	}

	 
	add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' ); 
	

	
?>