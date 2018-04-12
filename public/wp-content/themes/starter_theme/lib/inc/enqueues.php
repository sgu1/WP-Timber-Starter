<?php

function load_custom_scripts() {
    wp_deregister_script( 'jquery' );
    wp_register_script('jquery', "https://code.jquery.com/jquery-3.2.1.min.js", [], null, true); // true will place script in the footer
    wp_enqueue_script('jquery');

    wp_register_script('vsg-js', get_stylesheet_directory_uri().'/assets/js/vsg_custom.min.js', ['jquery'], '', true);

    wp_enqueue_script('vsg-js');

}
if(!is_admin()) {
    add_action('wp_enqueue_scripts', 'load_custom_scripts', 99);
}