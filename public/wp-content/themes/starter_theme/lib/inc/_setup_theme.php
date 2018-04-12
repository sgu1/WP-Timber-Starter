<?php
/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
1.0 - MISC
    1.1 Disable XMLRPC
    1.2 Allow SVG Upload
    1.3 Pre Get Posts
2.0 Theme Setup
*/

/**************************
 * 1.0 MISC
 **************************/

/* 1.1 Disable XMLRPC 
---------------------
*/
add_filter('xmlrpc_enabled', '__return_false');


/* 1.2 Allow SVG Upload
---------------------
*/
// Allow SVG uploads to Media Library
add_filter(
    'upload_mimes',
    function ($mimes) {
        $mimes['svg'] = 'image/svg+xml';

        return $mimes;
    }
);


/* 1.3 Pre Get Posts
---------------------
*/
// // Hook above function to the pre_get_posts action
// add_action( 'pre_get_posts', 'main_query_modify_blog' );
// //This function will modify the main query on the blog home page so is_home().
// function main_query_modify_blog( $query ) {

// }

/**************************
 * 2.0 Theme Setup
 **************************/
add_action( 'after_setup_theme', 'theme_setup' );
function theme_setup(){
        
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // Enable and register menus
    add_theme_support( 'menus' );
    register_nav_menus( array(
        'Primary' => esc_html__( 'Primary Navigation', 'vsg' ),
    ) );

    /*This feature allows the use of HTML5 markup for the search forms, 
     *comment forms, comment lists, gallery, and caption.
    */
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

    /*
    * In short, with a theme that supports Post Formats, a blogger can change how each post looks 
    * by choosing a Post Format from a radio-button list.
    * See https://developer.wordpress.org/themes/functionality/post-formats/
    */
    add_theme_support('post-formats', [
        'aside',
        'image',
        'video',
        'quote',
        'link',
    ]);

    // Enable excerpt support for pages
    add_post_type_support('page', 'excerpt');
    
    /*
    * This is what displays your WordPress version number in your header.
    * No one really needs to know the exact version of WordPress we’re using, safe to remove.
    */
    remove_action('wp_head', 'wp_generator');
    // We don’t use Windows Live Writer, completely useless and should be removed.
    remove_action('wp_head', 'wlwmanifest_link');
    // Disable the emoji bloat WP adds to sites
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    //Image Sizes
    // add_image_size('small', 320, 320, false);

    // add_image_size('retina', 2300, 2300, false);

    // update_option('large_size_w', 1280);
    // update_option('large_size_h', 1280);
    // update_option('large_crop', 0);

    // update_option('medium_size_w', 640);
    // update_option('medium_size_h', 640);
    // update_option('medium_crop', 0);

    // update_option('thumbnail_size_w', 160);
    // update_option('thumbnail_size_h', 160);
    // update_option('thumbnail_crop', 1);

    // add_filter('jpeg_quality', create_function('', 'return 80;'));

} //End of theme_setup()