<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$left_sidebar = apply_filters("latehome_free_left_sidebar", 'left-sidebar');

if (!is_active_sidebar($left_sidebar)) {
    return;
}
$sidebar_pos = apply_filters("latehome_free_sidebar_position", get_theme_mod('latehome_free_sidebar_shop_position'));


?>

<?php if ('both' === $sidebar_pos) : ?>
<div class="wp-col-md-4  widget-area column-sidebar" id="sidebar-left-shop" role="complementary">
    <?php else : ?>
    <div class="wp-col-lg-4 wp-col-md-12 wp-col-sm-12 widget-area  column-sidebar" id="sidebar-left-shop"
         role="complementary">
        <?php endif; ?>
        <?php dynamic_sidebar($left_sidebar); ?>

    </div><!-- #right-sidebar -->
