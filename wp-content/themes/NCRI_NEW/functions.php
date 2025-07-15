<?php
// Enqueue theme stylesheet
function ncri_new_enqueue_styles() {
    wp_enqueue_style('ncri-new-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'ncri_new_enqueue_styles');
