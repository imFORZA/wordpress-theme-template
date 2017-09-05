<?php
/**
 * Header
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

?>
<!DOCTYPE HTML>
<html class="no-js" <?php language_attributes(); ?>>
<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<header class="site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">


</header>


<nav class="navbar navbar-default" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-nav-collapse">
				<span class="sr-only"><?php esc_html_e( 'Toggle navigation', '%%TEXTDOMAIN%%' ); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
	</div>
<?php
	wp_nav_menu( array(
		'menu'              => 'primary-navigation',
		'theme_location'    => 'primary-navigation',
		'depth'             => 2,
		'container'         => 'div',
		'container_class'   => 'collapse navbar-collapse',
		'container_id'      => 'primary-nav-collapse',
		'menu_class'        => 'nav navbar-nav',
		'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
		'walker'            => new WP_Bootstrap_Navwalker(),
		)
	);
?>
</nav>


<?php get_template_part( 'breadcrumbs' ); ?>
