<?php
/**
 * Index
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

?>
				<div class="page-header">
					<h1 class="page-title">
						<?php if ( is_category() ) {
							esc_attr_e( 'Posts Categorized: ' );
							single_cat_title(); } elseif ( is_tag() ) {
	esc_attr_e( 'Posts Tagged: ' );
							single_tag_title(); } elseif ( is_author() ) {
								esc_attr_e( 'Posts By: ' );
								get_the_author_meta( 'display_name' ); } elseif ( is_day() ) {
								esc_attr_e( 'Daily Archives: ' );
								the_time( 'l, F j, Y' ); } elseif ( is_month() ) {
									esc_attr_e( 'Monthly Archives: ' );
									the_time( 'F Y' ); } elseif ( is_year() ) {
									esc_attr_e( 'Yearly Archives: ' );
									the_time( 'Y' );
									} elseif ( is_archive() ) { esc_attr_e( 'Blog', '%%TEXTDOMAIN%%' ); } ?>
					</h1>
				</div>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<h2><?php the_title(); ?></h2>

	<?php the_post_thumbnail( 'thumbnail', array( 'itemprop' => 'image' ) ); ?>

	<?php the_content(); ?>

</div>

<?php endwhile; else : ?>
	<p><?php esc_attr_e( 'Sorry, no posts matched your criteria.', '%%TEXTDOMAIN%%' ); ?></p>
<?php endif; ?>

<?php echo wp_link_pages(); ?>

<?php esc_attr_e( paginate_links() ); ?>


<?php get_sidebar(); ?>

<?php get_footer(); ?>
