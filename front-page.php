<?php
/**
 * Front Page
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php the_title(); ?>
<?php the_content(); ?>


<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', '%%TEXTDOMAIN%%' ); ?></p>
<?php endif; ?>


<?php get_footer(); ?>
