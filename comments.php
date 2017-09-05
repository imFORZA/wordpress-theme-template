<?php
/**
 * Comments
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

wp_list_comments(); ?>

	<?php comment_form(); ?>
	<?php comments_template(); ?>


<?php paginate_comments_links();
