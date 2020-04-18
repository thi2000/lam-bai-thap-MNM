<?php
/**
 * Left sidebar check.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$left_sidebar = apply_filters("latehome_free_left_sidebar", 'left-sidebar');
$right_sidebar = apply_filters("latehome_free_right_sidebar", 'right-sidebar');
$sidebar_pos = apply_filters("latehome_free_sidebar_position", get_theme_mod('latehome_free_sidebar_position'));

?>
<?php if ('left' === $sidebar_pos || 'both' === $sidebar_pos) : ?>
    <?php get_template_part('partials/sidebar/sidebar', 'left'); ?>
<?php endif; ?>

<?php
$html = '';
if ('right' === $sidebar_pos || 'left' === $sidebar_pos) {
    $html = '<div class="';
    if ((is_active_sidebar($right_sidebar) && 'right' === $sidebar_pos) || (is_active_sidebar($left_sidebar) && 'left' === $sidebar_pos)) {
        $html .= 'wp-col-lg-8 wp-col-md-12 wp-col-sm-12 content-area" id="primary">';
    } else {
        $html .= 'wp-col-md-12 content-area" id="primary">';
    }

    echo trim($html); // WPCS: XSS OK.
} elseif ('both' === $sidebar_pos) {
    $html = '<div class="';
    if (is_active_sidebar($right_sidebar) && is_active_sidebar($left_sidebar)) {
        $html .= 'wp-col-md-6 content-area" id="primary">';
    } elseif (is_active_sidebar($right_sidebar) || is_active_sidebar($left_sidebar)) {
        $html .= 'wp-col-lg-8 wp-col-md-12 wp-col-sm-12 content-area" id="primary">';
    } else {
        $html .= 'wp-col-md-12 content-area" id="primary">';
    }

    echo trim($html); // WPCS: XSS OK.

} else {
    echo '<div class="wp-col-md-12 content-area" id="primary">';
}
