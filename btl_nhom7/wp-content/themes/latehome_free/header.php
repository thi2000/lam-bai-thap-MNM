<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title"
              content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
        <link rel="profile" href="//gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
    </head>

<body <?php body_class(); ?>>
<section class="body-inner">

    <div class="hfeed site" id="page">
<?php
/**
 * latehome_free_before_header hook.
 *
 * @since 0.1
 *
 * @hooked latehome_free_do_skip_to_content_link - 2
 * @hooked latehome_free_top_bar - 5
 * @hooked latehome_free_add_navigation_before_header - 5
 */
do_action('latehome_free_before_header');

/**
 * latehome_free_header hook.
 *
 * @since 1.3.42
 *
 * @hooked latehome_free_construct_header - 10
 */
do_action('latehome_free_header');

/**
 * latehome_free_after_header hook.
 *
 * @since 0.1
 *
 * @hooked latehome_free_after_header - 10
 */
do_action('latehome_free_after_header');
?>
<?php do_action('latehome_free_before_site_content'); ?>
    <div class="site-content">
<?php do_action('latehome_free_content_top'); ?>