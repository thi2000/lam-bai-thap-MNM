<?php 
	class Wpopal_Core_WooCommerce_Admin_Taxonomies {

		/**
		 * Default brand ID.
		 *
		 * @var int
		 */
		private $default_cat_id = 0;

		/**
		 * Constructor.
		 */
		public function __construct() {
			 
			add_action( 'create_term', array( $this, 'create_term' ), 5, 3 );
			add_action( 'delete_term', array( $this, 'delete_term' ), 5 );
			add_action('cmb2_admin_init', array($this, 'taxonomy_metaboxes'));
			 
		}

		/**
		 * Order term when created (put in position 0).
		 *
		 * @param mixed  $term_id
		 * @param mixed  $tt_id
		 * @param string $taxonomy
		 */
		public function create_term( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( 'product_cat' != $taxonomy && ! taxonomy_is_product_attribute( $taxonomy ) ) {
				return;
			}

			$meta_name = taxonomy_is_product_attribute( $taxonomy ) ? 'order_' . esc_attr( $taxonomy ) : 'order';

			update_woocommerce_term_meta( $term_id, $meta_name, 0 );
		}

		/**
		 * When a term is deleted, delete its meta.
		 *
		 * @param mixed $term_id
		 */
		public function delete_term( $term_id ) {
			global $wpdb;

			$term_id = absint( $term_id );

			if ( $term_id && get_option( 'db_version' ) < 34370 ) {
				$wpdb->delete( $wpdb->woocommerce_termmeta, array( 'woocommerce_term_id' => $term_id ), array( '%d' ) );
			}
		}

		/**
		 * Register meta box fields with cmb2 plugin
	     *
	     * @return avoid 
		 */
		public function taxonomy_metaboxes() {

	        $prefix = 'woo_cat_';

	        $cmb_term = new_cmb2_box(array(
	            'id'           => 'woo_category_meta',
	            'title'        => __('Metabox', 'wpopal'), // Doesn't output for term boxes
	            'object_types' => array('term'),
	            'taxonomies'   => array('product_cat'),
	            // 'new_term_section' => true, // Will display in the "Add New Category" section
	        ));

	        $cmb_term->add_field(array(
	            'name'       => __('Logo', 'wpopal'),
	            'desc' => __('Location image', 'homefinder'),
	            'id'         => $prefix . 'logo',
	            'type'       => 'file',
	            'options'    => array(
	                'url' => false, // Hide the text input for the url
	            ),
	            'query_args' => array(
	                'type' => 'image',
	            ),
	        ));

	        $cmb_term->add_field(array(
	            'name'       => __('Banner', 'wpopal'),
	            'desc' => __('Show the banner in product category page or any widgets', 'wpopal'),
	            'id'         => $prefix . 'banner',
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

	new Wpopal_Core_WooCommerce_Admin_Taxonomies();
?>
