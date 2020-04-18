<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class OSF_Custom_Post_Type_Footer
 */
class OSF_Custom_Post_Type_Footer {

    public function __construct() {
        $this->create_post_type();
        add_action( 'template_include', array( $this, 'template_include' ) );
       
    }

    /**
     * @return string
     */
    public function get_icon($name) {
        $name = wp_basename( $name, '.php' );
        if (file_exists( OE_PLUGIN_DIR . '/assets/images/post-type/' . $name . '.png' )){
            return OE_PLUGIN_URI . '/assets/images/post-type/' . $name . '.png';
        } else{
            return 'dashicons-admin-post';
        }
    }
    
    /**
     * @return void
     */
    public function create_post_type()
    {

        $labels = array(
            'name'               => __('Footer', "opalelementor"),
            'singular_name'      => __('Footer', "opalelementor"),
            'add_new'            => __('Add New Footer', "opalelementor"),
            'add_new_item'       => __('Add New Footer', "opalelementor"),
            'edit_item'          => __('Edit Footer', "opalelementor"),
            'new_item'           => __('New Footer', "opalelementor"),
            'view_item'          => __('View Footer', "opalelementor"),
            'search_items'       => __('Search Footers', "opalelementor"),
            'not_found'          => __('No Footers found', "opalelementor"),
            'not_found_in_trash' => __('No Footers found in Trash', "opalelementor"),
            'parent_item_colon'  => __('Parent Footer:', "opalelementor"),
            'menu_name'          => __('Footer Builder', "opalelementor"),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => __('List Footer', "opalelementor"),
            'supports'            => array('title', 'editor', 'thumbnail'), //page-attributes, post-formats
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => $this->get_icon(__FILE__),
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => true,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => true,
            'capability_type'     => 'post'
        );
        register_post_type('footer', $args);
        add_post_type_support( 'footer', 'elementor' );
        
    }

    /**
     * template include function callback
     */
    public function template_include( $template ) {
        if ( get_query_var('post_type') !== 'footer' ) {
            return $template;
        }
 
        $template = OE_PLUGIN_TEMPLATE_DIR . 'elementor-preview.php';
        
        return $template;
    }
}

new OSF_Custom_Post_Type_Footer;