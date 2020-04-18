<?php
/**
 * latehome_free Theme Customizer
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function latehome_free_customize_preview_js()
{
    wp_enqueue_script('latehome_free-customize-preview', get_theme_file_uri('/assets/js/customize-preview.js'), array('customize-preview'), '20181108', true);
}

add_action('customize_preview_init', 'latehome_free_customize_preview_js', 99);


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if (!function_exists('latehome_free_customize_register')) {
    /**
     * Register basic customizer support.
     *
     * @param object $wp_customize Customizer reference.
     */
    function latehome_free_customize_register($wp_customize)
    {
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';


        $wp_customize->remove_section('fl-presets');  //Modify this line as needed


        /**
         * Primary color.
         */
        $wp_customize->add_setting(
            'primary_color',
            array(
                'default' => 'default',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            'primary_color',
            array(
                'type' => 'radio',
                'label' => esc_html__('Primary Color', 'latehome_free'),
                'choices' => array(
                    'default' => esc_html_x('Default', 'primary color', 'latehome_free'),
                    'custom' => esc_html_x('Custom', 'primary color', 'latehome_free'),
                ),
                'section' => 'color_style_theme',
                'priority' => 5,
            )
        );


        // Add primary color hue setting and control.
        $wp_customize->add_setting(
            'primary_color_hue',
            array(
                'default' => "",
                'transport' => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'primary_color_hue',
                array(
                    'label' => esc_html__('Primary Color', 'latehome_free'),
                    'description' => esc_html__('Apply a custom color for buttons, links, featured images, etc.', 'latehome_free'),
                    'section' => 'color_style_theme',

                )
            )
        );

        // Add primary color hue setting and control.
        $wp_customize->add_setting(
            'secondary_color_hue',
            array(
                'default' => "",
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'secondary_color_hue',
                array(
                    'label' => esc_html__('Secondary Color', 'latehome_free'),
                    'description' => esc_html__('Apply a custom color for buttons, links, featured images, etc.', 'latehome_free'),
                    'section' => 'color_style_theme',

                )
            )
        );

        // Add primary color hue setting and control.
        $wp_customize->add_setting(
            'body_color_hue',
            array(
                'default' => "",
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'body_color_hue',
                array(
                    'label' => esc_html__('Body Color', 'latehome_free'),
                    'section' => 'color_style_theme',
                )
            )
        );

        /**
         * Button Style.
         */
        $wp_customize->add_setting(
            'button_style',
            array(
                'default' => 'gradient',
                'transport' => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            'button_style',
            array(
                'type' => 'select',
                'label' => esc_html__('Button Style', 'latehome_free'),
                'choices' => array(
                    'default' => esc_html__('Default', 'latehome_free'),
                    'gradient' => esc_html__('gradient', 'latehome_free'),
                ),
                'section' => 'color_style_theme',
            )
        );


        $wp_customize->add_setting('gradient_color_left', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        // enable product category
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'gradient_color_left', array(
                    'label' => esc_html__('Button Gradient Color', 'latehome_free'),
                    'section' => 'color_style_theme',
                )
            )
        );

        $wp_customize->add_setting('gradient_color_right', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        // enable product category
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'gradient_color_right', array(
                    'label' => '',
                    'section' => 'color_style_theme',
                )
            )
        );
    }
}
add_action('customize_register', 'latehome_free_customize_register');

/**
 * Select sanitization function
 *
 * @param string $input Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function latehome_free_theme_slug_sanitize_select($input, $setting)
{

    // Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
    $input = sanitize_key($input);

    // Get the list of possible select options.
    $choices = $setting->manager->get_control($setting->id)->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return (array_key_exists($input, $choices) ? $input : $setting->default);

}

/**
 * Register individual settings through customizer's API.
 *
 * @param WP_Customize_Manager $wp_customize Customizer reference.
 */
if (!function_exists('latehome_free_theme_layout_customizer')) {

    function latehome_free_theme_layout_customizer($wp_customize)
    {

        $wp_customize->add_panel('layout', array(
            'title' => esc_html__('Layout', 'latehome_free'),
            'capability' => 'edit_theme_options',
            'priority' => 1,
        ));

        // Theme layout settings.
        $wp_customize->add_section('layout_theme', array(
            'title' => esc_html__('Theme', 'latehome_free'),
            'capability' => 'edit_theme_options',
            'description' => esc_html__('Set layout global theme layout style', 'latehome_free'),
            'priority' => 3,
            'panel' => 'layout'
        ));

        ///

        $wp_customize->add_setting('latehome_free_layout_style', array(
            'default' => 'default',
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'latehome_free_layout_style', array(
                    'label' => esc_html__('Global Layout Style', 'latehome_free'),
                    'description' => esc_html__('Set global layout style boxed or fullwidth having custom background image, custom width.',
                        'latehome_free'),
                    'section' => 'layout_theme',
                    'settings' => 'latehome_free_layout_style',
                    'type' => 'select',
                    'choices' => array(
                        'default' => esc_html__('Default', 'latehome_free'),
                        'boxed' => esc_html__('Boxed', 'latehome_free'),

                    ),
                    'priority' => '2',
                )
            ));

    }
}
add_action('customize_register', 'latehome_free_theme_layout_customizer');

/**
 * Register individual settings through customizer's API.
 *
 * @param WP_Customize_Manager $wp_customize Customizer reference.
 */
if (!function_exists('latehome_free_post_layout_customize_register')) {

    function latehome_free_post_layout_customize_register($wp_customize)
    {


        // Theme layout settings.
        $wp_customize->add_section('latehome_free_blog_options', array(
            'title' => esc_html__('Post Settings', 'latehome_free'),
            'capability' => 'edit_theme_options',
            'description' => esc_html__('Set blog layout display in varials style and design', 'latehome_free'),
            'priority' => 3,
        ));


        $wp_customize->add_setting('latehome_free_sidebar_position', array(
            'default' => 'right',
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'latehome_free_sidebar_position', array(
                    'label' => esc_html__('Archive Sidebar Positioning', 'latehome_free'),
                    'description' => esc_html__('Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
                        'latehome_free'),
                    'section' => 'latehome_free_blog_options',
                    'settings' => 'latehome_free_sidebar_position',
                    'type' => 'select',
                    'sanitize_callback' => 'latehome_free_theme_slug_sanitize_select',
                    'choices' => array(
                        'right' => esc_html__('Right sidebar', 'latehome_free'),
                        'left' => esc_html__('Left sidebar', 'latehome_free'),
                        'both' => esc_html__('Left & Right sidebars', 'latehome_free'),
                        'none' => esc_html__('No sidebar', 'latehome_free'),
                    ),
                    'priority' => '2',
                )
            ));

        // single blog post

        /// //
        $wp_customize->add_setting('latehome_free_blog_archive_layout', array(
            'default' => '',
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'latehome_free_blog_archive_layout', array(
                    'label' => esc_html__('Blog Archive layout', 'latehome_free'),
                    'description' => esc_html__('Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
                        'latehome_free'),
                    'section' => 'latehome_free_blog_options',
                    'settings' => 'latehome_free_blog_archive_layout',
                    'type' => 'select',
                    'sanitize_callback' => 'latehome_free_theme_slug_sanitize_select',
                    'choices' => latehome_free_get_blog_item_layouts(),
                    'priority' => '3',
                )
            ));
        /////// ///

        $wp_customize->add_setting('latehome_free_sidebar_single_position', array(
            'default' => 'right',
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'latehome_free_sidebar_single_position', array(
                    'label' => esc_html__('Single Sidebar Position', 'latehome_free'),
                    'description' => esc_html__('Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
                        'latehome_free'),
                    'section' => 'latehome_free_blog_options',
                    'settings' => 'latehome_free_sidebar_single_position',
                    'type' => 'select',
                    'sanitize_callback' => 'latehome_free_theme_slug_sanitize_select',
                    'choices' => array(
                        'right' => esc_html__('Right sidebar', 'latehome_free'),
                        'left' => esc_html__('Left sidebar', 'latehome_free'),
                        'both' => esc_html__('Left & Right sidebars', 'latehome_free'),
                        'none' => esc_html__('No sidebar', 'latehome_free'),
                    ),
                    'priority' => '20',
                )
            ));
        // sidebar
        $wp_customize->add_setting('latehome_free_blog_single_layout', array(
            'default' => '',
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'latehome_free_blog_single_layout', array(
                    'label' => esc_html__('Single Layout', 'latehome_free'),
                    'description' => esc_html__('Set single layout in view single post.',
                        'latehome_free'),
                    'section' => 'latehome_free_blog_options',
                    'settings' => 'latehome_free_blog_single_layout',
                    'type' => 'select',
                    'sanitize_callback' => '',
                    'choices' => array(
                        '' => esc_html__('Basic Style', 'latehome_free'),
                        'blog' => esc_html__('Style 1', 'latehome_free'),
                        'blog-v2' => esc_html__('Style 2', 'latehome_free'),
                        'blog-v3' => esc_html__('Style 3', 'latehome_free')
                    ),
                    'priority' => '22',
                )
            ));

        // enable product category
        $wp_customize->add_setting(
            'latehome_free_post_related', array(
                'default' => false,
                'sanitize_callback' => 'wp_validate_boolean',
            )
        );

        $wp_customize->add_control(
            'latehome_free_post_related', array(
                'type' => 'checkbox',
                'section' => 'latehome_free_blog_options',
                'label' => esc_html__('Enable Post Related', 'latehome_free'),
                'description' => esc_html__('Show post related by category.', 'latehome_free'),
                'priority' => 2,
            )
        );

        /// / / /
        $wp_customize->add_setting(
            'latehome_free_blog_columns',
            array(
                'default' => 1,
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
                'sanitize_js_callback' => 'absint',
            )
        );

        $wp_customize->add_control(
            'latehome_free_blog_columns',
            array(
                'label' => esc_html__('Blog per row', 'latehome_free'),
                'description' => esc_html__('How many products should be shown per row?', 'latehome_free'),
                'section' => 'latehome_free_blog_options',
                'settings' => 'latehome_free_blog_columns',
                'type' => 'number',
                'input_attrs' => array(
                    'min' => 1,
                    'max' => 5,
                    'step' => 1,
                ),
            )
        );

        /// enable or disable preloader
    }
}
add_action('customize_register', 'latehome_free_post_layout_customize_register');

/**
 * Add customizer configuration for page preloader
 */
if (!function_exists('latehome_free_customize_preloader')) {
    function latehome_free_customize_preloader($wp_customize)
    {

        // Theme layout settings.
        $wp_customize->add_panel('layout_options', array(
            'title' => esc_html__('Preloader', 'latehome_free'),
            'capability' => 'edit_theme_options',
            'description' => esc_html__('Set blog layout display in varials style and design', 'latehome_free'),
            'priority' => 2
        ));


        // Theme layout settings.
        $wp_customize->add_section('container_options', array(
            'title' => esc_html__('Page Container', 'latehome_free'),
            'capability' => 'edit_theme_options',
            'description' => esc_html__('Set blog layout display in varials style and design', 'latehome_free'),
            'priority' => 2,
            'panel' => 'layout_options'
        ));

        $wp_customize->add_setting('latehome_free_container_type', array(
            'default' => 'container',
            'type' => 'theme_mod',
            'sanitize_callback' => 'latehome_free_theme_slug_sanitize_select',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'latehome_free_container_type', array(
                    'label' => esc_html__('Container Width', 'latehome_free'),
                    'description' => esc_html__('Choose between Bootstrap\'s container and container-fluid', 'latehome_free'),
                    'section' => 'container_options',
                    'settings' => 'latehome_free_container_type',
                    'type' => 'select',
                    'choices' => array(
                        'container' => esc_html__('Fixed width container', 'latehome_free'),
                        'container-fluid' => esc_html__('Full width container', 'latehome_free'),
                    ),
                    'priority' => '1',
                )
            ));

        // Theme layout settings.
        $wp_customize->add_section('preload_layout_options', array(
            'title' => esc_html__('Page Preloader', 'latehome_free'),
            'capability' => 'edit_theme_options',
            'description' => esc_html__('Set Page Preloader settings', 'latehome_free'),
            'priority' => 2,
            'panel' => 'layout_options'
        ));

        $wp_customize->add_setting(
            'latehome_free_preload_enable', array(
                'default' => false,
                'sanitize_callback' => 'wp_validate_boolean',
            )
        );

        $wp_customize->add_control(
            'latehome_free_preload_enable', array(
                'type' => 'checkbox',
                'section' => 'preload_layout_options',
                'label' => esc_html__('Enable Page Preloader', 'latehome_free'),
                'description' => esc_html__('Enable Page Preloader while loading pages.', 'latehome_free'),
                'priority' => 2,
            )
        );

        $wp_customize->add_setting('latehome_free_preload_logo', array(
            'default' => '',
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'latehome_free_preload_logo',
                array(
                    'label' => esc_html__('Upload a logo', 'latehome_free'),
                    'section' => 'preload_layout_options',
                    'settings' => 'latehome_free_preload_logo'
                )
            )
        );

        ///
        $wp_customize->add_setting('latehome_free_preload_svg', array(
            'default' => '',
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'latehome_free_preload_svg', array(
                    'label' => esc_html__('Svg Icon', 'latehome_free'),
                    'description' => esc_html__('Select preloading icon showing on center of the panel',
                        'latehome_free'),
                    'section' => 'preload_layout_options',
                    'settings' => 'latehome_free_preload_svg',
                    'type' => 'select',
                    'sanitize_callback' => 'latehome_free_theme_slug_sanitize_select',
                    'choices' => latehome_free_svg_in_folders('loaders'),
                    'priority' => '3',
                )
            ));

        // Add page background color setting and control.
        $wp_customize->add_setting('latehome_free_preload_bg', array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'latehome_free_preload_bg', array(
            'label' => esc_html__('Page Background Color', 'latehome_free'),
            'section' => 'preload_layout_options',
        )));
        //


        // Add page background color setting and control.
        // $wp_customize->add_setting('latehome_free_preload_svgcolor', array(
        //     'default' => '',
        //     'sanitize_callback' => 'sanitize_hex_color',
        //     'transport' => 'postMessage',
        // ));
		//
        // $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'latehome_free_preload_svgcolor', array(
        //     'label' => esc_html__('Svg Icon Color', 'latehome_free'),
        //     'section' => 'preload_layout_options',
        // )));
    }
}
add_action('customize_register', 'latehome_free_customize_preloader');

/**
 * Automatic set default values for postion and style, containner width after active the theme.
 */
if (!function_exists('latehome_free_setup_theme_default_settings')) {
    function latehome_free_setup_theme_default_settings()
    {

        // check if settings are set, if not set defaults.
        // Caution: DO NOT check existence using === always check with == .
        // Latest blog posts style.
        $latehome_free_posts_index_style = get_theme_mod('latehome_free_posts_index_style');
        if ('' == $latehome_free_posts_index_style) {
            set_theme_mod('latehome_free_posts_index_style', 'default');
        }

        // Sidebar position.
        $latehome_free_sidebar_position = get_theme_mod('latehome_free_sidebar_position');
        if ('' == $latehome_free_sidebar_position) {
            set_theme_mod('latehome_free_sidebar_position', 'right');
        }

        // Sidebar position.
        $latehome_free_sidebar_single_position = get_theme_mod('latehome_free_sidebar_single_position');
        if ('' == $latehome_free_sidebar_single_position) {
            set_theme_mod('latehome_free_sidebar_single_position', 'right');
        }

        // Container width.
        $latehome_free_container_type = get_theme_mod('latehome_free_container_type');
        if ('' == $latehome_free_container_type) {
            set_theme_mod('latehome_free_container_type', 'container');
        }


    }
}
?>
