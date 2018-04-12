<?php
/* Provides the most neccessary info */

$context = Timber::get_context();

$context['url_home'] = esc_url(home_url('/'));

//ACF Options
$context['options'] = get_fields('options');

//Adds breadcrumb navxt plugin if active to twig functions
function twig_bcn_display(){
    if (function_exists('bcn_display')) : bcn_display(); endif;
}
$context['twig_bcn_display'] = TimberHelper::ob_function('twig_bcn_display');