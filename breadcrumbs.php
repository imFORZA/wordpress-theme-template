<?php
/**
 * Breadcrumbs
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/*
* Name: Breadcrumbs
* Description: This file is used to display Yoast Breadcrumbs, and similar styles to Twitter Bootstrap.
* Further Documentation: https://getbootstrap.com/components/#breadcrumbs
*/

// WordPress SEO Breadcrumb.
if ( function_exists( 'yoast_breadcrumb' ) ) {
	yoast_breadcrumb( '<ol class="breadcrumb"><li>', '</li></ol>' );
} elseif ( function_exists( 'jetpack_breadcrumbs' ) ) {
	jetpack_breadcrumbs();
}
