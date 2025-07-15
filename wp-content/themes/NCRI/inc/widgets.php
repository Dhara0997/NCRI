<?php
	
	function ncri_widgets_init() {
		register_sidebar( array (
		'name' => __( 'Sidebar Widget Area', 'ncri' ),
		'id' => 'primary-widget-area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		) );
	}
	add_action( 'widgets_init', 'ncri_widgets_init' );