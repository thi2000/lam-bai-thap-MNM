<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class OSF_Custom_Post_Type_Header
 */
class OSF_Custom_Post_Type_Header {

    public function __construct() {
        $this->create_post_type();

        add_action( 'template_include', array( $this, 'template_include' ) );
        add_action('cmb2_admin_init', array( $this, 'metabox') );

       
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
            'name'               => __('Header', "opalelementor"),
            'singular_name'      => __('Header', "opalelementor"),
            'add_new'            => __('Add New Header', "opalelementor"),
            'add_new_item'       => __('Add New Header', "opalelementor"),
            'edit_item'          => __('Edit Header', "opalelementor"),
            'new_item'           => __('New Header', "opalelementor"),
            'view_item'          => __('View Header', "opalelementor"),
            'search_items'       => __('Search Headers', "opalelementor"),
            'not_found'          => __('No Headers found', "opalelementor"),
            'not_found_in_trash' => __('No Headers found in Trash', "opalelementor"),
            'parent_item_colon'  => __('Parent Header:', "opalelementor"),
            'menu_name'          => __('Header Builder', "opalelementor"),
        );

        $args = array(
            'labels'              => $labels,
            'hierarchical'        => true,
            'description'         => __('List Header', "opalelementor"),
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
        register_post_type('header', $args);
        add_post_type_support( 'header', 'elementor' );
    }

    /**
     * template include function callback
     */
    public function template_include( $template ) {
        if ( get_query_var('post_type') !== 'header' ) {
            return $template;
        }
        $template = OE_PLUGIN_TEMPLATE_DIR . 'elementor-preview.php';
        return $template;
    }

    public function metabox( $cmb=array() ){

        $prefix = 'wpopal_'; 
        
        /// Quotes /// 
        $cmb = new_cmb2_box( array(
            'id'           => 'header_settings',
            'title'        => esc_html__( 'Header Settings', 'wpopal-core' ),
            'object_types' => array( 'header' ),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'      => 'post-format-quote', // The option key and admin menu page slug.
        ) );

         $cmb->add_field( array(
            'name'    => esc_html__( 'Header Style', 'wpopal-core' ),
            'id'      => $prefix . 'header_style',
            'desc' => '',
            'type'    => 'select',
            'options' => array(
                ''    => __( 'Default' , 'wpopal' ),
                'opalelementor-header-abs'    => __( 'Absolute' , 'wpopal' ),
            ),
            'default' => '',
        ) );
        return $cmb;
    }
}

new OSF_Custom_Post_Type_Header;

