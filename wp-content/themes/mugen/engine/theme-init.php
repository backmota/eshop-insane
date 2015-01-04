<?php

add_action( 'after_setup_theme', 'if_setup' );

if ( ! function_exists( 'if_setup' ) ):

function if_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );
		add_image_size( 'blog-post-image', 840, 290, true ); // Blog Image
		add_image_size( 'post-thumb', 60, 60, true ); // Recent Post Widget Image
		add_image_size( 'portfolio-image-col1', 1140, 600, true ); // Portfolio Image Col 1
		add_image_size( 'portfolio-image-col2', 547, 340, true ); // Portfolio Image Col 2
		add_image_size( 'portfolio-image-col3', 349, 260, true ); // Portfolio Image Col 3
		add_image_size( 'portfolio-image-col4', 251, 191, true ); // Portfolio Image Col 4
		add_image_size( 'brand-image',234, 150, true); // Brand Image
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'headermenu' => __( 'Header Menu', THE_LANG )
	) );
	register_nav_menus( array(
		'mainmenu' => __( 'Main Menu', THE_LANG )
	) );
	register_nav_menus( array(
		'footermenu' => __( 'Footer Menu', THE_LANG )
	) );
	
	add_option(THE_THEMENAME.'_layerslider_activated',0);
	add_option(THE_THEMENAME.'_layerslider_version','1.0');
}
endif;

function exceptation(){
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
}