<?php
/**
 * Declaring widgets
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('widgets_init', 'latehome_free_widgets_init');

if (!function_exists('latehome_free_widgets_init')) {
    /**
     * Initializes themes widgets.
     */
    function latehome_free_widgets_init() {
        register_sidebar(array(
            'name' => esc_html__('Right Sidebar', 'latehome_free'),
            'id' => 'right-sidebar',
            'description' => esc_html__('Right sidebar widget area', 'latehome_free'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Left Sidebar', 'latehome_free'),
            'id' => 'left-sidebar',
            'description' => esc_html__('Left sidebar widget area', 'latehome_free'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));


        register_sidebar(array(
            'name' => esc_html__('User Sidebar', 'latehome_free'),
            'id' => 'user-sidebar',
            'description' => esc_html__('User dashboard sidebar widget area', 'latehome_free'),
            'before_widget' => '<aside id="%1$s" class="widget-no-border">',
            'after_widget' => '</aside>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
    }
} // endif function_exists( 'latehome_free_widgets_init' ).
