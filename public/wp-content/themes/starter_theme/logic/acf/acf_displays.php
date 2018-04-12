<?php

require_once(__DIR__ . '/example_crazy_display.php');

//Get ACF page layout templates in an array
if (class_exists('acf') && is_page()){
	if (have_rows('page_flex_layout')){
		//Use optional optData array to supply required data and globals into functions
		$optData = [];
		$optData['post'] = $post;
		
		//This is the acf flexible field array, it keeps and display the fields in order
		$arrViewsAcfLayouts = [];
		while (have_rows('page_flex_layout')){
			the_row();
			//Get the field name
			$currentLayout = get_row_layout();
			//Do logic if there is any
			$data = call_user_func('acfGet_'.$currentLayout, $optData);
			$data['row'] = get_row(true);
			echo($rowIndex);
			//Render the correct acf layout template into array
			$arrViewsAcfLayouts[] = Timber::compile('page_flex_'.$currentLayout.'.twig', $data);
		}
		//This will be rendered out in your specific page template
		$context['arrViewsAcfLayouts'] = $arrViewsAcfLayouts;
	}
}