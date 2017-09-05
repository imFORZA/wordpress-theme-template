<?php
/**
 * Custom Login
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Custom CSS for Login Page.
 *
 * @access public
 * @return void
 */
function wp_tpl_custom_login() {

	wp_register_style( 'custom-login', get_template_directory_uri() . '/assets/css/custom-login.css', true, 'all' );
	wp_enqueue_style( 'custom-login' );
	remove_filter( 'wp_admin_css', 'wp_admin_css' );

}
add_action( 'login_head', 'wp_tpl_custom_login' );

/**
 * Change URL for Login Logo.
 *
 * @access public
 * @return Home URL.
 */
function wp_tpl_wp_login_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'wp_tpl_wp_login_url' );

/**
 * Hides "Powered by WordPress" Title on Login Logo.
 *
 * @access public
 * @return Site Title.
 */
function wp_tpl_wp_login_title() {

	return get_option( 'blogname' );

}
add_filter( 'login_headertitle', 'wp_tpl_wp_login_title' );
