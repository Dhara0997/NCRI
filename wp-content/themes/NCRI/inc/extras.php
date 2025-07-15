<?php

// Move Yoast to bottom of edit screen	
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

// Register Option Pages
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

// Register Footer Menu
function register_my_menu() {
  register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'register_my_menu' );