<?php
/**
 * Sidebar
 *
 * @package client-template-theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

?>
<aside class="site-sidebar sidebar-default widget-area" id="default-sidebar" role="complementary" itemscope itemtype="https://schema.org/WPSideBar">

	<?php dynamic_sidebar( 'default-sidebar' ); ?>

</aside>
