<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


$right_sidebar = apply_filters("latehome_free_right_sidebar", 'right-sidebar');


if (!is_active_sidebar($right_sidebar)) {
    return;
}

$sidebar_pos = apply_filters("latehome_free_sidebar_position", get_theme_mod('latehome_free_sidebar_shop_position'));

?>

<?php if ('both' === $sidebar_pos) : ?>
<div class="wp-col-md-4 widget-area column-sidebar" id="sidebar-right-shop1" role="complementary">
    <?php else : ?>
    <div class="wp-col-lg-4 wp-col-md-12 wp-col-sm-12 widget-area column-sidebar" id="sidebar-right-shop"
         role="complementary">
        <?php endif; ?>
        <?php dynamic_sidebar($right_sidebar); ?>

    </div><!-- #right-sidebar -->
