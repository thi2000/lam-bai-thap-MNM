<?php
/**
 * Theme basic setup.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Set the content width based on the theme's design and stylesheet.
if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}

add_action('after_setup_theme', 'latehome_free_setup');

if (!function_exists('latehome_free_setup')) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function latehome_free_setup()
    {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on latehome_free, use a find and replace
         * to change 'latehome_free' to the name of your theme in all the template files
         */
        load_theme_textdomain('latehome_free', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'latehome_free'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Adding Thumbnail basic support
         */
        add_theme_support('post-thumbnails');

        /*
         * Adding support for Widget edit icons in customizer
         */
        add_theme_support('customize-selective-refresh-widgets');


        add_editor_style('assets/css/style-editor.css');

        /*
         * Enable support for Post Formats.
         * See https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('latehome_free_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Set up the WordPress Theme logo feature.
        add_theme_support('custom-logo');

        add_image_size( 'property-loop', 573, 367, true ); // 220 pixels wide by 180 pixels tall, hard crop mode

        // Check and setup theme default settings.
        latehome_free_setup_theme_default_settings();
    }
}
if (!function_exists('latehome_free_import_attachment_image_size')) {
    /**
     * Matching and resizing images with url.
     *
     *  $ouput = array(
     *        'allowed' => 1, // allow resize images via using GD Lib php to generate image
     *        'height'  => 900,
     *        'width'   => 800,
     *        'file_name' => 'blog_demo.jpg'
     *   );
     */
    function latehome_free_import_attachment_image_size($url)
    {

        $name = basename($url);

        $output = array(
            'allowed' => 0
        );

        if (preg_match("#product-#", $name)) {
            $output = array(
                'allowed' => 1,
                'height' => 1000,
                'width' => 800,
                'file_name' => $name
            );
        }

        if (preg_match("#team-about-us#", $name)) {
            $output = array(
                'allowed' => 1,
                'height' => 800,
                'width' => 600,
                'file_name' => $name
            );
        }

        return $output;
    }
}
add_action('wpopal_import_attachment_image_size', 'latehome_free_import_attachment_image_size', 1, 2);

////////

add_filter('excerpt_more', 'latehome_free_custom_excerpt_more');

if (!function_exists('latehome_free_custom_excerpt_more')) {
    /**
     * Removes the ... from the excerpt read more link
     *
     * @param string $more The excerpt.
     *
     * @return string
     */
    function latehome_free_custom_excerpt_more($more)
    {
        return '';
    }
}

add_filter('wp_trim_excerpt', 'latehome_free_all_excerpts_get_more_link');

if (!function_exists('latehome_free_all_excerpts_get_more_link')) {
    /**
     * Adds a custom read more link to all excerpts, manually or automatically generated
     *
     * @param string $post_excerpt Posts's excerpt.
     *
     * @return string
     */
    function latehome_free_all_excerpts_get_more_link($post_excerpt)
    {

        return $post_excerpt . ' <div class="latehome_free-read-more-link-wrap"><a class="latehome_free-read-more-link" href="' . esc_url(get_permalink(get_the_ID())) . '">' . esc_html__('Read More',
                'latehome_free') . '</a></div>';
    }
}
add_filter('get_custom_logo', 'latehome_free_custom_logo');

if (!function_exists('latehome_free_custom_logo')) {
    function latehome_free_custom_logo()
    {
        $custom_logo_id = get_theme_mod('custom_logo');
        $html = sprintf('<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
            esc_url(home_url('/')),
            wp_get_attachment_image($custom_logo_id, 'full', false, array(
                'class' => 'custom-logo',
                'alt' => 'Logo',
            ))
        );
        return $html;
    }
}

/**
 * Fixed matching data after import samples called in importing data.
 */
function latehome_free_get_data_sample() {
    WP_Filesystem();
    global $wp_filesystem;

    $data_file = trim( wp_upload_dir()['basedir'] ).'/data.json';

    if( file_exists( $data_file) ){
        return json_decode( $wp_filesystem->get_contents( $data_file ), true );
    }
    
    return array();
}

/**
 * Fixed matching data after import samples 
 */
function latehome_free_import_sample_others() {

    $importer = new WpOpal_Core_Admin_Content_Importer();
    // for agent 
    $importer->set_data( latehome_free_get_data_sample() );

    // for agency 
    $post_types = array(
        'opalestate_agent',
        'opalestate_agency'
    );

    $user_id = username_exists("agent");

    if( !$user_id ){
        $user_id = opalestate_create_user(
            array(
                'user_login' => 'agent',
                'user_email' => 'agent@demo.com',
                'user_pass'  => 'agent',
            )
        );
        $wp_user_object = new WP_User( $user_id );
        $wp_user_object->set_role('opalestate_agent');
    }

    $i = 1; 
    $j = 1;
    foreach ( $post_types as $p_type ) {
        $args = array( 
            'numberposts'     => -1, 
            'post_type'       => $p_type
        );
        $posts = get_posts($args);
      
        foreach( $posts as $post ){
            // create user 
            $id = get_post_meta( $post->ID, OPALESTATE_AGENCY_PREFIX.'avatar_id', true );
         
            if( $id > 0 ){
                
                $new_image_id = $importer->get_attachment_id( 'wpopal_import_id', $id ); 
                
                if(  $new_image_id ) {
                    update_post_meta( $post->ID, OPALESTATE_AGENCY_PREFIX.'avatar_id', $new_image_id );
                    update_post_meta( $post->ID, OPALESTATE_AGENCY_PREFIX.'avatar', wp_get_attachment_url($new_image_id) );
                }
            }

            $id = get_post_meta( $post->ID, OPALESTATE_AGENT_PREFIX.'avatar_id', true );
      
            if( $id > 0 ){
                $new_image_id = $importer->get_attachment_id( 'wpopal_import_id', $id ); 
                if(  $new_image_id ) {
                    update_post_meta( $post->ID, OPALESTATE_AGENT_PREFIX.'avatar_id', $new_image_id );
                    update_post_meta( $post->ID, OPALESTATE_AGENT_PREFIX.'avatar', wp_get_attachment_url($new_image_id) );

                    if( $i == 1 ) {   
                        $i++;
                        update_post_meta( $post->ID, OPALESTATE_AGENT_PREFIX.'user_id', $user_id );
                 
                        update_user_meta( $user_id , OPALESTATE_USER_PROFILE_PREFIX . 'related_id', $post->ID ); 
                        update_user_meta( $user_id , OPALESTATE_USER_PROFILE_PREFIX.'avatar_id', $new_image_id );
                        update_user_meta( $user_id , OPALESTATE_USER_PROFILE_PREFIX.'avatar', wp_get_attachment_url($new_image_id) );
                    } 
                }
            }
        }
    }

    // change roles 
    $args = array( 
        'numberposts'     => -1, 
        'post_type'       => 'opalestate_property'
    );
    $posts = get_posts($args);
    foreach ( $posts as $post ) {
        $arg = array(
            'ID' => $post->ID,
            'post_author' => $user_id,
        );
        wp_update_post( $arg );
    }
    // and set default agency for one accounts
}   
add_action( "wpopal_import_sample_others", "latehome_free_import_sample_others" );