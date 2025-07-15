<?php

add_theme_support( 'align-wide' );

	
add_action('acf/init', 'my_register_blocks');
function my_register_blocks() {

    if( function_exists('acf_register_block') ) {
	    
/*
        acf_register_block(array(
            'name'              => 'custom_block',
            'title'             => __('Custom Block'),
            'description'       => __('A custom block.'),
            'render_template'   => 'parts/blocks/custom_block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'custom', 'block' ),
        ));
*/
        acf_register_block(array(
            'name'              => 'team_members',
            'title'             => __('Team Members'),
            'description'       => __('A custom block to display Team Members.'),
            'render_template'   => 'parts/blocks/team_members.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'preview',
            'keywords'          => array( 'team', 'block' ),
        ));
        acf_register_block(array(
            'name'              => 'media_link',
            'title'             => __('Media Link Block'),
            'description'       => __('A custom block to display a link to media such as a weblink or document.'),
            'render_template'   => 'parts/blocks/media_link.php',
            'category'          => 'layout',
            'icon'              => 'admin-links',
            'mode'              => 'preview',
            'keywords'          => array( 'custom', 'block' ),
        ));
        acf_register_block(array(
            'name'              => 'upcoming_webinars',
            'title'             => __('Upcoming Webinars'),
            'description'       => __('A custom block to display upcoming Webinars.'),
            'render_template'   => 'parts/blocks/upcoming_webinars.php',
            'category'          => 'layout',
            'icon'              => 'admin-links',
            'mode'              => 'preview',
            'keywords'          => array( 'webinars', 'upcoming' ),
        ));
        acf_register_block(array(
            'name'              => 'past_webinars',
            'title'             => __('Past Webinars'),
            'description'       => __('A custom block to display past Webinars.'),
            'render_template'   => 'parts/blocks/past_webinars.php',
            'category'          => 'layout',
            'icon'              => 'admin-links',
            'mode'              => 'preview',
            'keywords'          => array( 'webinars', 'past' ),
        ));
        acf_register_block(array(
            'name'              => 'accordion',
            'title'             => __('Accordion Block'),
            'description'       => __('An accordion block'),
            'render_template'   => 'parts/blocks/accordion.php',
            'category'          => 'custom-blocks',
            'icon'              => 'editor-insertmore',
            'mode'              => 'preview',
            'keywords'          => array( 'accordion', 'block' ),
        ));
    }
}