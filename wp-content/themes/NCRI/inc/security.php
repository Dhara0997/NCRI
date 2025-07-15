<?php
	
	remove_action('wp_head', 'wp_generator');
	function ncri_remove_version() {
	return '';
	}
	add_filter('the_generator', 'ncri_remove_version');