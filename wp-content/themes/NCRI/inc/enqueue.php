<?php
	
	add_action('wp_enqueue_scripts', 'ncri_styles');
	function ncri_styles()
	{
		
		wp_enqueue_style('bootstrap', get_template_directory_uri().'/css/bootstrap.min.css', false, '4.3.11', 'all' );
        
        wp_enqueue_style('slick', get_template_directory_uri().'/css/slick.css', false, '1.8.1', 'all' );
			
        wp_enqueue_style('slick-theme', get_template_directory_uri().'/css/slick-theme.css', false, '1.8.1', 'all' );
		
		wp_enqueue_style('fancybox', get_template_directory_uri().'/css/jquery.fancybox.min.css', false, '3.3.5', 'all' );
			
	    wp_enqueue_style('stylesheet', get_template_directory_uri().'/css/style.css', false, time(), 'all' );
	    
	    wp_enqueue_style('blocks', get_template_directory_uri().'/css/blocks.css', false, time(), 'all' );
	}
	
	add_action('wp_enqueue_scripts', 'ncri_load_scripts');
	function ncri_load_scripts()
	{
		wp_enqueue_script( 'jquery' );
		
		wp_enqueue_script('line', get_template_directory_uri().'/js/jquery.line.js', false, '1.0', true);

		wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', false, '4.3.11', true);
	    
	    wp_enqueue_script('menu', get_template_directory_uri().'/js/menu.js', false, '1.0.0', true);
		
		wp_enqueue_script('slick', get_template_directory_uri().'/js/slick.min.js', false, '1.8.1', true);
		
		wp_enqueue_script('fancybox', get_template_directory_uri().'/js/jquery.fancybox.min.js', false, '3.3.5', true);
		
		//wp_enqueue_script('scroll-magic', get_template_directory_uri().'/js/ScrollMagic.min.js', false, '2.0.7', true);
		//wp_enqueue_script('scroll-magic-indicators', get_template_directory_uri().'/js/debug.addIndicators.min.js', false, '2.0.7', true);
		
		wp_enqueue_script('scrollTrigger', get_template_directory_uri().'/js/scrollTrigger.js', false, '1.0', true);
		
		wp_enqueue_script('smoothscroll', get_template_directory_uri().'/js/jquery.smoothscroll.min.js', false, '1.0', true);
		
	    wp_enqueue_script('script', get_template_directory_uri().'/js/script.js', false, time(), true);
	
	 }
	 
	add_action('enqueue_block_editor_assets', 'ncri_blocks_styles');
	function ncri_blocks_styles() 
	{
		wp_enqueue_style('admin-block', get_template_directory_uri().'/css/blocks.css', false, time());
		
		wp_enqueue_style('bootstrap-grid', get_template_directory_uri().'/css/bootstrap-grid.min.css', false, '4.3.1', 'all' );
	}