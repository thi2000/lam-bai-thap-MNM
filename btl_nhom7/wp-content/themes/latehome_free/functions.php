<?php
/**
 * latehome_free functions and definitions
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/// admin /// 
if (is_admin()) {
    require get_template_directory() . '/inc/admin/class-menu.php';
    /**
     * Load include plugins using for this project
     */
    require get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';
    require get_template_directory() . '/inc/tgm.php';
}

/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/classes/class-wp-bootstrap-navwalker.php';

/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/classes/class-offcanvas.php';


/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/functions.php';

/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/markup.php';


/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom pagination for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom hooks.
 */
require get_template_directory() . '/inc/template-hooks.php';


/**
 * Custom hooks.
 */
require get_template_directory() . '/inc/post-format-functions.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

if( class_exists("OpalEstate") ) {
	require get_template_directory() . '/inc/vendor/opalestate.php';
}
require get_template_directory() . '/inc/vendor/elementor-functions.php';
require get_template_directory() . '/inc/vendor/elementor-others.php';
