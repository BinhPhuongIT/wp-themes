<?php
/*
Plugin Name: Avia Template Builder
*/



require_once( dirname(__FILE__) . '/php/template-builder.class.php' );

$builder = new AviaBuilder();

//activates the builder safe mode. this hides the shortcodes that are built with the content builder from the default wordpress content editor. 
//can also be set to "debug", to show shortcode content and extra shortcode container field
$builder->setMode( 'safe' ); 