<?php 
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * @Class Wpopal_Core_WooCommerce_Brand
 * 
 * Create taxomony named Brand having relationship with product and register widget for filtering
 */
class Wpopal_Core_WooCommerce_Brand{
    
  
    public function __construct(){


		add_action( 'init', array($this,'product_brands'), 0 );
        add_action('cmb2_admin_init', array($this, 'taxonomy_metaboxes'));

        add_action( 'widgets_init', array($this, 'register_widget' ) );
	}
    
    /**
     * Reguster brand widget 
     * 
     * @return avoid 
     */ 
    public function register_widget(){
        register_widget( 'Wpopal_Core_Widget_Product_Brands' );
    }

    /**
	 * Register brand 
	 */
    public function product_brands() {
		$labels = array(
            'name'                       => esc_html__('Brands','wpopal'),
            'singular_name'              => esc_html__('Brands','wpopal'),
            'menu_name'                  => esc_html__('Brands','wpopal'),
            'all_items'                  => esc_html__('All Brands','wpopal'),
            'parent_item'                => esc_html__('Parent Brand','wpopal'),
            'parent_item_colon'          => esc_html__('Parent Brand:','wpopal'),
            'new_item_name'              => esc_html__('New Brand Name','wpopal'),
            'add_new_item'               => esc_html__('Add New Brands','wpopal'),
            'edit_item'                  => esc_html__('Edit Brand','wpopal'),
            'update_item'                => esc_html__('Update Brand','wpopal'),
            'separate_items_with_commas' => esc_html__('Separate Brand with commas','wpopal'),
            'search_items'               => esc_html__('Search Brands','wpopal'),
            'add_or_remove_items'        => esc_html__('Add or remove Brands','wpopal'),
            'choose_from_most_used'      => esc_html__('Choose from the most used Brands','wpopal'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => false,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
            'rewrite'                    => array('slug' => 'product-brand')
        );
        register_taxonomy( 'product_brand', 'product', $args );
	}

	/**
	 * Register meta box fields with cmb2 plugin
     *
     * @return avoid 
	 */
	public function taxonomy_metaboxes() {

        $prefix = 'product_brand_';

        $cmb_term = new_cmb2_box(array(
            'id'           => 'product_brand',
            'title'        => __('Product Metabox', 'wpopal'), // Doesn't output for term boxes
            'object_types' => array('term'),
            'taxonomies'   => array('product_brand'),
            // 'new_term_section' => true, // Will display in the "Add New Category" section
        ));

        $cmb_term->add_field(array(
            'name'       => __('Logo', 'wpopal'),
            //                'desc' => __('Location image', 'homefinder'),
            'id'         => $prefix . 'logo',
            'type'       => 'file',
            'options'    => array(
                'url' => false, // Hide the text input for the url
            ),
            'query_args' => array(
                'type' => 'image',
            ),
        ));
    }
}
new Wpopal_Core_WooCommerce_Brand();
?>
