<?php
Timber::$dirname = array('views', 'views/page', 'views/single','views/partial','views/component','views/acf');

class TimberStarter extends TimberSite {

	function __construct() {
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		parent::__construct();
	}

	function add_to_context( $context ) {
        /*
		//$context['notes'] = 'These values are available everytime you call Timber::get_context();';
        */
        
        //Menu variable assignment
		$context['primaryMenu'] = new TimberMenu('Primary');
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		//wtf is this??!
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}