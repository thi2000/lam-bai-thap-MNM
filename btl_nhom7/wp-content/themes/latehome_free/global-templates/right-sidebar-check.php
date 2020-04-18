<?php
/**
 * Right sidebar check.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$sidebar_pos = apply_filters("latehome_free_sidebar_position", get_theme_mod('latehome_free_sidebar_position'));


?>

</div><!-- #closing the primary container from /global-templates/left-sidebar-check.php -->


<?php if ('right' === $sidebar_pos || 'both' === $sidebar_pos) : ?>
    <?php get_template_part('partials/sidebar/sidebar-right'); ?>
<?php endif; ?>
