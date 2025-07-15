<?php
	
	function ncri_setup()
	{
	    register_nav_menus(array(
	        'main-menu' => __('Main Menu', 'ncri')
	    ));
	}
	add_action('after_setup_theme', 'ncri_setup');