<?php
/**
 * Jetpack
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }


/*
* Improved Jetpack Support.
*/
if ( ! function_exists( 'wp_tpl_jetpack_support' ) ) {


	/**
	 * Adds Support for Jetpack features.
	 *
	 * @access public
	 * @return Theme Support.
	 */
	function wp_tpl_jetpack_support() {

		// Support Jetpack Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		// Support Tonesque.
		add_theme_support( 'tonesque' );

		// Jetpack Breadcrumbs.
		// https://jeremy.hu/jetpack-add-utm-tracking-to-sharing-buttons/ !
		// https://jeremy.hu/redirect-jetpack-subscriptions/ !
		// https://jeremy.hu/jetpack-missing-images-related-posts/ !
		// Social Menu Support (https://themeshaper.com/2016/02/12/jetpack-social-menu/).
		add_theme_support( 'jetpack-social-menu' );

		// Support Jetpack Social Links (https://jetpack.com/support/social-links/).
		add_theme_support( 'social-links', array( 'facebook', 'twitter', 'linkedin', 'google_plus', 'tumblr' ) );

		/**
		 * Support Infinite Scroll (https://jetpack.com/support/infinite-scroll/).
		 *
		 * @access public
		 * @return void

		function wp_tpl_jetpack_setup() {
			add_theme_support( 'infinite-scroll', array(
				'type'           => 'scroll',
				'footer_widgets' => false,
				'container'      => '', // Add our Container ID.
				'wrapper'        => true,
				'render'         => false,
				'posts_per_page' => false,
			) );
		}
		add_action( 'after_setup_theme', 'wp_tpl_jetpack_setup' );
		*/

		// Support Featured Content (https://jetpack.com/support/featured-content/).
		add_theme_support( 'featured-content', array(
			'filter' => 'wp_tpl_get_featured_content',
			'max_posts' => 20,
			'post_types' => array( 'post' ),
		));

		/**
		 * Get Featured Content.
		 *
		 * @access public
		 * @return Featured Content.
		 */
		function wp_tpl_get_featured_content() {

			return apply_filters( 'wp_tpl_get_featured_content', array() );
		}

		/**
		 * Set Default Image for Related Posts (when no featured image exists) [http://jetpack.me/support/related-posts/customize-related-posts/].
		 *
		 * @access public
		 * @param mixed $media Media.
		 * @param mixed $post_id Post ID.
		 * @param mixed $args Args.
		 * @return Default Image.
		function wp_tpl_jetpack_related_defaultimage( $media, $post_id, $args ) {
			if ( $media ) {
				return $media;
			} else {
				$permalink = get_permalink( $post_id );
				$url = apply_filters( 'jetpack_photon_url', get_template_directory_uri() . 'YOUR_LOGO_IMG_URL' );

				return array( array(
				'type'  => 'image',
				'from'  => 'custom_fallback',
				'src'   => esc_url( $url ),
				'href'  => $permalink,
				),
				);
			}
		}
		add_filter( 'jetpack_images_get_images', 'wp_tpl_jetpack_related_defaultimage', 10, 3 );
		*/

		/**
		 * wp_tpl_custom_photon function.
		 *
		 * @access public
		 * @param mixed $args
		 * @return void
		 */
		/*
		function wp_tpl_custom_photon( $args ) {
    			$args['quality'] = 80;
			$args['strip']   = 'all';
    			$args['filter']  = 'grayscale';
    			return $args;
		}
		add_filter( 'jetpack_photon_pre_args', 'wp_tpl_custom_photon' );
		*/

		/*
		// Jetpack Login: https://jeremy.hu/wpbudapest-jetpack-secrets/
		add_filter( 'jetpack_remove_login_form', '__return_true', 9999 );
		add_filter( 'jetpack_sso_bypass_login_forward_wpcom', '__return_true', 9999 );
		add_filter( 'jetpack_sso_display_disclaimer', '__return_false', 9999 );

		add_filter( 'wp_authenticate_user', function() {
		 return new WP_Error( 'wpcom-required', “Pas de connection ici.” );
		}, 9999 );
		add_filter( 'allow_password_reset', '__return_false' );

		// Force 2 factor authentication
		add_filter( 'jetpack_sso_require_two_step', '__return_true' );
		*/

	}
}

add_action( 'after_setup_theme', 'wp_tpl_jetpack_support' );
