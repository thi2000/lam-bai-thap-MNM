<?php
/**
 * Wpopal_Core WooCommerce Class
 *
 * @package  wpopal
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wpopal_Core_WooCommerce' ) ) :

	/**
	 * The Wpopal_Core WooCommerce Integration class
	 */
	class Wpopal_Core_WooCommerce {

		public static $instance;

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			

			add_action( 'after_setup_theme', array( $this, 'setup' ), 999 );
			add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 20 );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
			add_action( 'widgets_init', array($this, 'register_widget' ) );

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.5', '<' ) ) {
				add_action( 'wp_footer', array( $this, 'star_rating_script' ) );
			}

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
				add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ) );
			}

			// Integrations.
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_integrations_scripts' ), 99 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 140 );

			add_filter( 'wc_get_template_part',        array( $this, 'get_template_parts' ), 10, 3 );

			$this->load_modules();

			add_filter( 'comments_template', array( __CLASS__, 'comments_template_loader' ), 50 );
		
			if( !get_theme_mod("woocommerce_disable_addition_nav") && !is_customize_preview() ) {
				add_action( 'woocommerce_before_shop_loop', [$this,'wc_setup_loop'], 20 );
				add_action( 'init', [$this,'set_shop_view_action'], 10 );
				add_filter( 'loop_shop_per_page', [$this,'custom_products_per_page'], 20 );
			}
 			
			if( !wpopal_is_theme_layout_customizate_support() ){ 

				add_action( 'template_redirect', [$this, 'set_custom_single_layout'] ); 
				add_action( 'template_redirect', [$this, 'set_product_loop_layout'], 1 );

				if ( ! empty( $_REQUEST['action'] ) && 'elementor_ajax' === $_REQUEST['action'] && is_admin() ) { 
	            	add_action( 'init', [ $this, 'set_product_loop_layout' ], 100 );
	        	}
	        }
		}
		
		/**
		 * instance
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Load comments template.
		 *
		 * @param string $template template to load.
		 * @return string
		 */
		public static function comments_template_loader( $template ) {
			if ( get_post_type() !== 'product' ) {
				return $template;
			}

			$dir  = WPOPAL_PLUGIN_TEMPLATE_DIR. 'woocommerce/';  
			$option = apply_filters("wpopal_product_comment_template",get_theme_mod( 'wpopal_product_comment_template', 'advanced' ) );
 
			if ( $option == 'advanced' && file_exists( trailingslashit( $dir ) . 'single-product-reviews.php' ) ) { 
				return trailingslashit( $dir ) . 'single-product-reviews.php';
			}
			return $template; 
		}


		
		public function load_templates( $template, $template_name, $template_path ) {

            global $woocommerce;

            $_template = $template;
            
            if ( ! $template_path ) {
                $template_path = $woocommerce->template_url;
            }
            
            $woo_path  = WPOPAL_PLUGIN_TEMPLATE_DIR. 'woocommerce/';  
            $template = locate_template( array( $woo_path . $template_name, $template_name ) );

            if ( ! $template && file_exists( $woo_path . $template_name ) ) {
                $template = $woo_path . $template_name;
            }
            
            if ( ! $template ) {
                $template = $_template;
            }

            return $template;
        }

        /**
         *
         */
        public function custom_products_per_page( $per_page ) {

        	if( class_exists('WC_Session_Handler')) {
        		$session = WC()->session;
				$show_per_page =  $session->get('show_per_page'); 
				if( $show_per_page ) {
    		 		 return $show_per_page;
    		 	}
			} 
			return $per_page;
		}

		/**
         *
         */
        public function wc_setup_loop( ){
			if( isset( $GLOBALS['woocommerce_loop'] ) ){ 
				$col =  $this->get_loop_columns(); 
				if( $col ) {
    		 		$GLOBALS['woocommerce_loop']['columns'] = $col;
    		 	}
    		}
        }


        /**
         *
         */
       public function set_shop_view_action() {

			if( class_exists('WC_Session_Handler')) {

				$session = WC()->session;
				
				if ( is_null( $session ) ) return;

				if ( isset( $_REQUEST['view_cols'] ) ) {
					$col = (int) $_REQUEST['view_cols']; 
					$session->set( 'view_cols',  ($col < 1 || $col > 4 ? null: $col) );
				}
				if ( isset( $_REQUEST['show_per_page'] ) ) {
					$col = (int) $_REQUEST['show_per_page']; 
					$session->set( 'show_per_page',  ($col < 1 || $col > 24 ? null: $col) );
				}
			} 
		}
			

		public function get_loop_columns (){
			return wpopal_woocommerce_get_loop_columns();
		}

		/**
	     *  Set product loop layout with setting from Customizer and query string.
	     * 
	     * @return avoid 
	     */
		public function set_product_loop_layout(){

		 
			$layout =  isset($_GET['product_layout']) && $_GET['product_layout'] ?  $_GET['product_layout'] : get_theme_mod( 'woocommerce_product_catalog_layout');
			
			$object = Wpopal_Core_WooCommerce_Loop_Layout::instance(); 

		  				  	
		  	$col = $this->get_loop_columns();
		  	if( $col == 1 && ( is_shop() || is_product_category() || is_product_tag() || is_tax() ) ){
		  		$layout = 'list';
		  	}

		  	$object->set_default_hook( $layout ); 

			if( $layout ){
				$loop_layout = $object->set_layout( $layout );
			} else {
				$object->set_default();
			}
		 
		}


		/**
	     * Get include supported files from this, just only display many layout styles of product in loop
	     * 
	     * @return String $template 
	     */
	    public function get_template_parts( $template, $slug, $name ) {

	        $woo_path  = WPOPAL_PLUGIN_TEMPLATE_DIR. 'woocommerce/';  
	        if ( file_exists( $woo_path . "{$slug}-{$name}.php" ) ) {
	            $template = $woo_path . "{$slug}-{$name}.php"; 
	        }
	        
	        return $template;
	    }

		/**
		 * Load 3rd rich features as product navigation, 
		 */
		public function load_modules () {
			
			$path = WPOPAL_PLUGIN_INC_DIR.'vendors/woocommerce/';
 
			if( get_theme_mod('wpopal_product_navigation') ){ 
				// include single pagination to next and preview
				require_once( $path . 'navigation/navigation.php' );
			}
			
				//include brand
			require_once( $path . 'swatches/function.php' );

			require_once( $path . 'sizechart/class-sizechart.php' );
			//include brand
			require_once( $path . 'brand/class-brand.php' );
			require_once( $path . 'brand/class-widget.php' );

			/// product deal
			require_once( $path .'deal/class-product-deal.php' );

 			require_once( $path .'template_functions.php' );	
			require_once( $path .'woo-functions.php' );
			require_once( $path .'template-hooks.php' );

			require_once( $path . 'class-customizer.php' ); 
			///

			require_once( $path .'product/class-loop-layout.php' );	
			require_once( $path .'product/class-single-layout.php' );	

			if( is_admin() ){
				require_once( $path . 'class-taxonomies.php' ); 
			}

			
		}

		public function register_widget(){
 			if( class_exists("Wpopal_Core_Widget_Product_Brands") ) {
	        	register_widget( 'Wpopal_Core_Widget_Product_Brands' );
	    	}
	    }

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 2.4.0
		 * @return void
		 */ 
		public function setup() { 
			add_theme_support(
				'wpopal-core', apply_filters(
					'wpopal_woocommerce_args', array(
						'single_image_width'    => 416,
						'thumbnail_image_width' => 324,
						'product_grid'          => array(
							'default_columns' => 3,
							'default_rows'    => 4,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1,
						),
					)
				)
			);

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );	
		}

		public function set_custom_single_layout(){

			if( is_product() ){ 
				
				// set global layout /// 
				$layout =  isset($_GET['opt']) && $_GET['opt'] ?  $_GET['opt'] : get_theme_mod( 'wpopal_product_layout');
		
				$single_layout = new Wpopal_Core_WooCommerce_Single_Layout( $layout );
			

				$style = apply_filters( "wpopal_product_layout_style", get_theme_mod( 'wpopal_product_layout_style') );


				/// set product image block 
				switch ( $style ) {
					
					case 'default':
						
						$single_layout->set_default_hooks()->set_layout( 'small' );	
						break;
					case 'center':
						
						$single_layout->set_default_hooks()->set_layout( 'center' );	
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'default' );

						break;

					case 'fullwidth':
						
						$single_layout->set_default_hooks()->set_layout( 'fullwidth' );	

						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'default' );

						break;	

					case 'split':
						
						$single_layout->set_default_hooks()->set_layout( 'split' , false );
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'default' );

						remove_filter( 'comments_template', array( __CLASS__, 'comments_template_loader' ), 50 );

						break;	

					case 'split_accordion':
						
						$single_layout->set_default_hooks()->set_layout( 'split' , false  );
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'accordion' );

						remove_filter( 'comments_template', array( __CLASS__, 'comments_template_loader' ), 50 );

						break;	

					case 'small':
	 
						$single_layout->set_default_hooks()->set_layout( 'small' );
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'default' );

						break;	
					case 'big':
	 
						$single_layout->set_default_hooks()->set_layout( 'big' );
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'default' );

						break;		
					case 'sidebar':
						
						// set layout theme
						$single_layout->set_default_hooks()->set_layout( 'sidebar' );
						$single_layout->set_content_tabs( 'default' );
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );

						break;		

					case 'one_columns' : 

						$single_layout->set_default_hooks()->set_layout( 'small', true );	
						$single_layout->set_product_images_hooks( 'one_columns' );
						$single_layout->set_content_tabs( 'default' );

						break;

					case 'two_columns' : 

						$single_layout->set_default_hooks()->set_layout( 'small', true );	
						$single_layout->set_product_images_hooks( 'two_columns' );
						$single_layout->set_content_tabs( 'default' );

						break;	

					case 'slider' : 

						$single_layout->set_default_hooks()->set_layout( 'default', true );	
						$single_layout->set_product_images_hooks( 'slider' );
						$single_layout->set_content_tabs( 'default' );

						break;	

					case 'thumb_left_slider' : 

						$single_layout->set_default_hooks()->set_layout( 'small' );	
						$single_layout->set_product_images_hooks( 'thumb_left_slider' );
						$single_layout->set_content_tabs( 'default' );

						break;		

					case 'thumb_right_slider' : 
						$single_layout->set_default_hooks()->set_layout( 'small' );	
						$single_layout->set_product_images_hooks( 'thumb_right_slider' );
						$single_layout->set_content_tabs( 'default' );

						break;			
					
					case 'vertical_tabs' : 
						$single_layout->set_default_hooks()->set_layout( 'small' );	
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'vertical_tabs' );

						break;		

					case 'accordion' : 
						$single_layout->set_default_hooks()->set_layout( 'small' );	
						$single_layout->set_product_images_hooks( 'thumb_bot_slider' );
						$single_layout->set_content_tabs( 'accordion' );
						break;		
					default:

						$single_layout->set_default_hooks()->set_layout( trim($layout) );

						$layout = apply_filters("wpopal_product_images", get_theme_mod( 'wpopal_product_images') ); 
						$single_layout->set_product_images_hooks( trim($layout) );
						
						/// set content tabs blocks
						$layout = apply_filters("wpopal_product_images", get_theme_mod( 'wpopal_product_tabs') );  
						$single_layout->set_content_tabs( trim($layout) );
						break;
				}
			}
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 * If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 *
		 * @since 2.1.0
		 * @return void
		 */
		public function add_customizer_css() {
		//	wp_add_inline_style( 'wpopal-woocommerce-style', $this->get_woocommerce_extension_css() );
		}

		/**
		 * Assign styles to individual theme mod.
		 *
		 * @deprecated 2.3.1
		 * @since 2.1.0
		 * @return void
		 */
		public function set_wpopal_style_theme_mods() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.3.1' );
			} else {
				_deprecated_function( __FUNCTION__, '2.3.1' );
			}
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$classes[] = 'woocommerce-active';

			// Remove `no-wc-breadcrumb` body class.
			$key = array_search( 'no-wc-breadcrumb', $classes );

			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}

			return $classes;
		}

		/**
		 * WooCommerce specific scripts & stylesheets
		 *
		 * @since 1.0.0
		 */
		public function woocommerce_scripts() {
			global $wpopal_version;

 			
		}

		/**
		 * Star rating backwards compatibility script (WooCommerce <2.5).
		 *
		 * @since 1.6.0
		 */
		public function star_rating_script() {
			 
		}

		/**
		 * Related Products Args
		 *
		 * @param  array $args related products args.
		 * @since 1.0.0
		 * @return  array $args related products args
		 */
		public function related_products_args( $args ) {
			$perrows = get_theme_mod( 'wpopal_product_related_limited') ? get_theme_mod( 'wpopal_product_related_limited') : 4;
			$columns = get_theme_mod( 'wpopal_product_related') ? get_theme_mod( 'wpopal_product_related') : 4;
			$args = apply_filters(
				'wpopal_related_products_args', array(
					'posts_per_page' => $perrows,
					'columns'        =>  $columns,
				)
			);

			return $args;
		}

		/**
		 * Product gallery thumbnail columns
		 *
		 * @return integer number of columns
		 * @since  1.0.0
		 */
		public function thumbnail_columns() {
			$columns = 4;

			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 5;
			}

			return intval( apply_filters( 'wpopal_product_thumbnail_columns', $columns ) );
		}

		/**
		 * Products per page
		 *
		 * @return integer number of products
		 * @since  1.0.0
		 */
		public function products_per_page() {
			return intval( apply_filters( 'wpopal_products_per_page', 12 ) );
		}

		/**
		 * Query WooCommerce Extension Activation.
		 *
		 * @param string $extension Extension class name.
		 * @return boolean
		 */
		public function is_woocommerce_extension_activated( $extension = 'WC_Bookings' ) {
			return class_exists( $extension ) ? true : false;
		}

		/**
		 * Remove the breadcrumb delimiter
		 *
		 * @param  array $defaults The breadcrumb defaults.
		 * @return array           The breadcrumb defaults.
		 * @since 2.2.0
		 */
		public function change_breadcrumb_delimiter( $defaults ) {
			$defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
			$defaults['wrap_before'] = '<div class="wpopal-breadcrumb"><div class="col-full"><nav class="woocommerce-breadcrumb">';
			$defaults['wrap_after']  = '</nav></div></div>';
			return $defaults;
		}

		
		/**
		 * Integration Styles & Scripts
		 *
		 * @return void
		 */
		public function woocommerce_integrations_scripts() {
			global $wpopal_version;

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			/**
			 * Bookings
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Bookings' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-bookings-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/bookings.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-bookings-style', 'rtl', 'replace' );
			}


			/**
			 * Wishlists
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Wishlists_Wishlist' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-wishlists-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/wishlists.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-wishlists-style', 'rtl', 'replace' );
			}

			/**
			 * AJAX Layered Nav
			 */
			if ( $this->is_woocommerce_extension_activated( 'SOD_Widget_Ajax_Layered_Nav' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-ajax-layered-nav-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/ajax-layered-nav.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-ajax-layered-nav-style', 'rtl', 'replace' );
			}

			/**
			 * Composite Products
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Composite_Products' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-composite-products-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/composite-products.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-composite-products-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Photography
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Photography' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-photography-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/photography.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-photography-style', 'rtl', 'replace' );
			}

			/**
			 * Product Reviews Pro
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Product_Reviews_Pro' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-product-reviews-pro-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/product-reviews-pro.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-product-reviews-pro-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Smart Coupons
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Smart_Coupons' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-smart-coupons-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/smart-coupons.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-smart-coupons-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Deposits
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Deposits' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-deposits-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/deposits.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-deposits-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Product Bundles
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Bundles' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-bundles-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/bundles.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-bundles-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Multiple Shipping Addresses
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Ship_Multiple' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-sma-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/ship-multiple-addresses.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-sma-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Advanced Product Labels
			 */
			if ( $this->is_woocommerce_extension_activated( 'Woocommerce_Advanced_Product_Labels' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-apl-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/advanced-product-labels.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-apl-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Mix and Match
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Mix_and_Match' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-mix-and-match-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/mix-and-match.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-mix-and-match-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Memberships
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Memberships' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-memberships-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/memberships.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-memberships-style', 'rtl', 'replace' );
			}

			/**
			 * WooCommerce Quick View
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Quick_View' ) ) {
				wp_enqueue_style( 'wpopal-woocommerce-quick-view-style', get_template_directory_uri() . '/assets/css/woocommerce/extensions/quick-view.css', 'wpopal-woocommerce-style' );
				wp_style_add_data( 'wpopal-woocommerce-quick-view-style', 'rtl', 'replace' );
			}

			/**
			 * Checkout Add Ons
			 */
			if ( $this->is_woocommerce_extension_activated( 'WC_Checkout_Add_Ons' ) ) {
				add_filter( 'wpopal_sticky_order_review', '__return_false' );
			}

			wp_enqueue_script( 'jquery-sticky-kit' );


			wp_register_script( 'wpopal-woo', trailingslashit( WPOPAL_PLUGIN_URI ) . 'assets/js/plugin.js', array(), $wpopal_version, true , 99 );
			wp_enqueue_script( 'wpopal-woo' );

		}

		/**
		 * Get extension css.
		 *
		 * @see get_wpopal_theme_mods()
		 * @return array $styles the css
		 */
		public function get_woocommerce_extension_css() { 
		}
	}

endif;

Wpopal_Core_WooCommerce::get_instance();