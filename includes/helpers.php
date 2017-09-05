<?php
/**
 * Helpers
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Auto set Featured Image if none exists.
 *
 * @access public
 * @return void
 */
function wp_tpl_auto_featured_image() {
	global $post;

	if ( ! has_post_thumbnail( $post->ID ) ) {
		$attached_image = get_children( "post_parent=$post->ID&amp;post_type=attachment&amp;post_mime_type=image&amp;numberposts=1" );

		if ( $attached_image ) {
			foreach ( $attached_image as $attachment_id => $attachment ) {
				set_post_thumbnail( $post->ID, $attachment_id );
			}
		}
	}
}
// Use it temporary to generate all featured images.
// add_action( 'the_post', 'wp_tpl_auto_featured_image' );
// Used for new posts.
add_action( 'save_post', 'wp_tpl_auto_featured_image' );
add_action( 'draft_to_publish', 'wp_tpl_auto_featured_image' );
add_action( 'new_to_publish', 'wp_tpl_auto_featured_image' );
add_action( 'pending_to_publish', 'wp_tpl_auto_featured_image' );
add_action( 'future_to_publish', 'wp_tpl_auto_featured_image' );
