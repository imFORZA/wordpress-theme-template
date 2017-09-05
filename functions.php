<?php
/**
 * Functions
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Support Bootstrap for Navigation. */
require_once( 'includes/wp-bootstrap-navwalker.php' );

/* Support Bootstrap for Images. */
require_once( 'includes/wp-bootstrap-images.php' );

/* Load Bootstrap Scripts. */
require_once( 'includes/wp-bootstrap-scripts.php' );

/* Load Helper Scripts/Functions. */
require_once( 'includes/helpers.php' );

/* Offer Custom Login Page. */
require_once( 'includes/custom-login.php' );


// Set content width value based on the theme's design.
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

if ( ! function_exists( 'wp_tpl_setup' ) ) {

	/**
	 * The wp_tpl_setup function.
	 *
	 * @access public
	 * @return void
	 */
	function wp_tpl_setup() {

		// Add theme support for Automatic Feed Links.
		add_theme_support( 'automatic-feed-links' );

		// Add theme support for Translation.
		load_theme_textdomain( '%%TEXTDOMAIN%%', get_template_directory().'/languages' );

		// Let WordPress Manage Title Tags.
		add_theme_support( 'title-tag' );

		// Support HTML5.
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		// Support Widget Selective Refresh in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Support Post Formats (https://codex.wordpress.org/Post_Formats).
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video' ) );

		// Support Featured Images.
		add_theme_support( 'post-thumbnails' );

		// Support Yoast SEO Breadcrumbs.
		add_theme_support( 'yoast-seo-breadcrumbs' );

		// Enable support for site logo.
		add_image_size( '%%TEXTDOMAIN%%-logo', 500, 500 );
		add_theme_support( 'site-logo', array( 'size' => '%%TEXTDOMAIN%%-logo' ) );

		// Add our Theme Image Sizes.
		add_image_size( 'publicize', 200, 200, true ); // 200 x 200, Minimum required for Jetpack Publicize.
		add_image_size( 'google-knowledgegraph-logo', 151, 151, false ); //
		add_image_size( 'google-knowledgegraph-logo-small', 72, 72, false ); //

		// Support Custom Editor CSS.
		add_editor_style( array( '/assets/css/editor-style.css' ) );

		// Support WordPress Menus.
		if ( function_exists( 'register_nav_menu' ) ) {
			register_nav_menu( 'primary-navigation', 'Primary Navigation' ); // Primary Navigation.
		}

		/*
		// Add theme support for Custom Background.
		$background_defaults = array(
        'default-color'          => '',
        'default-image'          => '',
        'default-repeat'         => '',
        'default-position-x'     => '',
        'default-attachment'     => '',
        'wp-head-callback'       => '_custom_background_cb',
        'admin-head-callback'    => '',
        'admin-preview-callback' => ''
		);
		add_theme_support( 'custom-background', $background_defaults );
		*/

		/*
		// Add theme support for Custom Header.
		$header_defaults = array(
        'default-image'          => '',
        'width'                  => 0,
        'height'                 => 0,
        'flex-width'             => true,
        'flex-height'            => true,
        'random-default'         => false,
        'header-text'            => false,
        'default-text-color'     => '',
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-header', $header_defaults );
		*/

		/*
		// Provide default Headers.
		$headers = array(
		'Header 1' => array(
			'description'   => __( 'Header 1', '%%TEXTDOMAIN%%' ),
			'url'           => '/assets/images/header1.png',
			'thumbnail_url' => '/assets/images/header1_thumbnail.png',
		),
		);
		register_default_headers( $headers );
		*/

	}
}

add_action( 'after_setup_theme', 'wp_tpl_setup' );



if ( ! function_exists( 'wp_tpl_register_sidebars' ) ) {

	/**
	 * Register Widget Areas
	 *
	 * @access public
	 * @return void
	 */
	function wp_tpl_register_sidebars() {

		if ( function_exists( 'register_sidebar' ) ) {

			// Default Sidebar.
			register_sidebar(array(
					'id' => 'default-sidebar',
					'name' => __( 'Default Sidebar', '%%TEXTDOMAIN%%' ),
					'description' => __( 'The default sidebar typically used on blog post pages.', '%%TEXTDOMAIN%%' ),
					'class' => 'widget',
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => '</h3>',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
			));
		}
	}


	add_action( 'widgets_init', 'wp_tpl_register_sidebars' );
}

/**
 * Scripts & Styles.
 *
 * @access public
 * @return void
 */
function wp_tpl_assets() {

	if ( ! is_admin() ) {

		/* CSS Stylesheets. */

		// Main Stylesheet.
		wp_register_style( '%%TEXTDOMAIN%%', get_stylesheet_uri(), false, null, 'all' );
		wp_enqueue_style( '%%TEXTDOMAIN%%' );

		/* Javascript. */

		// Load jQuery.
		wp_enqueue_script( 'jquery' );

		// Google Fonts.
		wp_register_script( 'webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', null, null, true );
		wp_enqueue_script( 'webfont' );
		wp_add_inline_script( 'webfont', 'WebFont.load({google:{families: ["Source Sans Pro:400,600,700,400italic,700italic:latin", "Roboto Condensed:400,700:latin"]}});' );

		// Script required for WordPress Comments.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	} // endif.
} // end wp_tpl_scripts.
add_action( 'wp_enqueue_scripts', 'wp_tpl_assets' );
