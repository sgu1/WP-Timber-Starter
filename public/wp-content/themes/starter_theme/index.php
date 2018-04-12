<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */
/* ======== Required ======== */
require_once(__DIR__ . '/logic/base.php');

//Create the post data variable to be used in template
$context['post'] = $post = is_page() ? new TimberPost() : [];

//ACF
require_once(__DIR__ . '/logic/acf/acf_displays.php');

/* --------------------------------- */

$templates = array( 'index.twig' ); //Defualt template for everything

if( is_front_page() ){
	//Do something
}
elseif (is_page()){
	array_unshift( $templates, 'page-' . $post->post_name . '.twig', 'page.twig', 'index.twig' );
}
elseif (is_home()){
	$context['posts'] = new Timber\PostQuery();
	array_unshift( $templates, 'blog_home.twig' );
}
else{

}

Timber::render( $templates, $context );