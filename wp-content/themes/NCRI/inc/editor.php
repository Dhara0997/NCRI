<?php
	
	function wpdocs_theme_add_editor_styles() {
	    //add_editor_style( 'css/style.css' );
	}
	add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );