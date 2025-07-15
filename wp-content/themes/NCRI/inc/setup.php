<?php
	
	load_theme_textdomain( 'ncri' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	wp_delete_comment( 1 );
	wp_delete_post( 1, TRUE );
	wp_delete_post( 2, TRUE );