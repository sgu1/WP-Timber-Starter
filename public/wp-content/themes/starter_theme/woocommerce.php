<?php

/* ======== Required ======== */
require_once(__DIR__ . '/logic/base.php');

//Create the post data variable to be used in template
$context['post'] = $post = Timber::get_post();

//ACF
require_once(__DIR__ . '/logic/acf/acf_displays.php');

/* --------------------------------- */

if( is_singular( 'product' ) ) {
    $context['post']    = Timber::get_post();
    $product            = wc_get_product($context['post']->ID);
    $context['product'] = $product;

    Timber::render( 'views/woo/woo_single-product.twig', $context );
} else {
    $posts = Timber::get_posts();
    $context['products'] = $posts;

    if ( is_product_category() ) {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $context['category'] = get_term( $term_id, 'product_cat' );
        $context['title'] = single_term_title( '', false );
    }

    Timber::render( 'views/woo/woo_archive.twig', $context );
}