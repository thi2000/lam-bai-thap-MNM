<?php 
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if( !class_exists("Wpopal_Core_WooCommerce_Single_Layout") ) {

	/**
	 * @Class Wpopal_Core_WooCommerce_Single_Layout
	 * 
	 * Set layout template for single product page and set block layout for product images block, content tabs block
	 */
	class Wpopal_Core_WooCommerce_Single_Layout {

		
		public function set_default_hooks(){


			// make inner summary containers
			add_action( 'woocommerce_single_product_summary', function(){
				echo '<div class="summary-inner">';
			}, 1 );

			add_action( 'woocommerce_single_product_summary', function(){
				echo '</div>';
			}, 99 );


			add_action( 'woocommerce_before_add_to_cart_quantity', function(){
				echo '<div class="quantity-box"><input type="button" value="-" class="minus">';
			} , 1 );

			add_action( 'woocommerce_after_add_to_cart_quantity', function(){
				echo '<input type="button" value="+" class="plus"></div>';
			} , 20 );


			/// show product share 
			add_action( 'woocommerce_share' ,'wpopal_social_share_post' );
	 		

	 		/// hook 
	 		if( class_exists("Wpopal_Core_Product_Navigation") ) {
	 			add_action( 'wp_footer', array( Wpopal_Core_Product_Navigation::instance(), 'single_product_navigation' ),	30 );
	 		}


	 		add_action( 'woocommerce_single_product_summary', array($this,'add_extra_info'), 60 );

	 
			return $this;
		}

		public function add_extra_info(){
			$logo = get_theme_mod( 'wpopal_single_security_logo' );
			$info = get_theme_mod( 'wpopal_single_more_info' ); ?>

			<div class="product-extra-info">
				<div class="product-extra-desc">
					<?php echo $info; ?>
				</div>	
			<?php if( $logo ) :   ?>

				<div class="product-extra-security-info">
					<h5><?php esc_html_e( 'Guaranteed Safe Checkout', 'wpopal' ); ?></h5>
					<img src="<?php echo esc_attr( $logo ); ?>" class="image-responsive">
				</div>
			<?php endif; ?>	
			</div>
			<?php 	
		}

		public function hook_button_actions(){

		}

		/**
		 * Call method for setting layout hooks for selected option
		 * 
		 */
		public function set_layout( $layout ){
			
			if( $layout != 'split' ){
				add_action( 'woocommerce_before_single_product_summary', function(){
		 			echo '<div class="single-content-top">';
		 		}, 1 );
		 		add_action( 'woocommerce_after_single_product_summary', function(){
		 			echo '</div>';
		 		}, 9 );
			}

			if( get_theme_mod('woocommerce_single_sticky_disable') != 1 ){
				wp_enqueue_script( 'imagesloaded' );
				add_filter( 'body_class', function( $classes ) {
				    return array_merge( $classes, array( 'single-product-sticky' ) );
				} );
			}
		

			$method = 'layout_'.$layout.'_hooks'; 
			if( method_exists( $this, $method ) &&  $layout ){
				$this->{$method}();
			}
		}

		/**
		 * Display product images block and summary block in center 
		 *
		 */
		public function layout_center_hooks(){  


			add_filter( 'wpopal_woocommerce_container_width', function () {
				return 'container-fluid';
			});
			// ..
			add_action( 'woocommerce_before_single_product_summary', function(){
				echo '<div class="p-content-top"><div class="container">';
			}, 1 );
			add_action( 'woocommerce_after_single_product_summary', function(){
				echo '</div></div>';
			}, 1 ); 
			///
			// ..
			add_action( 'woocommerce_after_single_product_summary', function(){
				echo '<div class="p-content-bottom"><div class="container">';
			}, 2 );
			add_action( 'woocommerce_after_single_product_summary', function(){
				echo '</div></div>';
			}, 100 ); 
			///
			add_filter( 'body_class', function( $classes ) {
			    return array_merge( $classes, array( 'single-center-layout' ) );
			} );


		}

		/**
		 * Display product images block and summary block in center 
		 *
		 */
		public function layout_small_hooks(){  
			add_filter( 'body_class', function( $classes ) {

			    return array_merge( $classes, array( 'single-small-layout' ) );
			} );
		}

		/**
		 * Display product images block and summary block in center 
		 *
		 */
		public function layout_big_hooks(){  
			add_filter( 'body_class', function( $classes ) {

			    return array_merge( $classes, array( 'single-big-layout' ) );
			} );
		}
		
		/**
		 * Images block and summary block in center in container with backgrouds seeing as fullwidth
		 *
		 */ 
		public function layout_fullwidth_hooks(){

			//remove action
			//remove_action('woocommerce_before_main_content', 'wpopal_woocommerce_wrapper_start', 10);
			//remove_action('woocommerce_after_main_content', 'wpoapl_woocommerce_wrapper_end', 10);

			//add_action('woocommerce_before_single_product', 'wpopal_woocommerce_wrapper_start', 10);
			//add_action('woocommerce_after_single_product', 'wpoapl_woocommerce_wrapper_end', 10);

			add_filter( 'body_class', function( $classes ) {
			    return array_merge( $classes, array( 'single-fullwidth-layout' ) );
			} );
		}

		/**
		 *  Set product images block and summery + content tabs in each part having same width. Break  others out of the block : upsell , related.... 
		 *
		 */ 
		public function layout_split_hooks(){   

			add_filter( 'body_class', function( $classes ) {
			    return array_merge( $classes, array( 'single-split-layout' ) );
			} );		
			// 
			add_action( 'woocommerce_before_single_product_summary', function (){
				echo '<div class="container-inner"><div class="row"><div class="wp-col-6 wp-col-xs-12">';
			}, 1 );	

			add_action( 'woocommerce_before_single_product_summary', function (){
				echo '</div><div class="wp-col-6 wp-col-xs-12"><div class="right-content">';
			}, 31 );	

			////
			add_action( 'woocommerce_after_single_product_summary', function (){
				echo '</div></div></div>';
			}, 16 );	
		}

		public function layout_sidebar_hooks(){
			add_filter( 'body_class', function( $classes ) {
			    return array_merge( $classes, array( 'single-sidebar-layout' ) );
			} ); 


			add_action( 'woocommerce_before_single_product_summary', function (){
				echo '<div class="row"><div class="wp-col-9 wp-col-xs-12">';
			}, 1 );	
			

			add_action( 'woocommerce_after_single_product_summary', array($this,'product_sidebar') 

			 , 1 );
			add_action( 'woocommerce_after_single_product_summary', function (){
				echo '</div>';
			}, 2 );	
		}

		public function product_sidebar(){  ?>
			</div><div class="wp-col-3 wp-col-xs-12">
			<?php if( is_active_sidebar('sidebar-single-shop') ): ?>
			 
				<div class="product-sidebar-content">
					<?php dynamic_sidebar( 'sidebar-single-shop' ); ?>
				</div>	

			<?php endif; ?>
			</div>
		<?php }

	 	/**
	 	 * Set product images block with selected option from customizer 
	 	 * 
	 	 */
		public function set_product_images_hooks( $layout ){   

			wp_enqueue_script( 'jquery-sticky-kit' );

			switch ( $layout ) {
				case 'thumb_left_slider':
					add_filter( 'wpopal_product_thumbnail_columns', function () {
						return 1;
					} );

					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-images-thumb-left' ) );
					} );	
					break;
				case 'thumb_right_slider': 
					add_filter( 'wpopal_product_thumbnail_columns', function () {
						return 1;
					} );
					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-images-thumb-right' ) );
					} );
					break;

				case 'thumb_bot_slider': 
					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-images-thumb-bottom' ) );
					} );
					break;
				case 'one_columns': 
					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-images-onecol' ) );
					} );

					remove_theme_support( 'wc-product-gallery-zoom' );
					remove_theme_support( 'wc-product-gallery-lightbox' );
					remove_theme_support( 'wc-product-gallery-slider' );	
					remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
					add_action( 'woocommerce_product_thumbnails', 'wpopal_woocommerce_single_product_images', 20 );
					break;

				case 'two_columns': 
					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-images-2-cols' ) );
					} );

					remove_theme_support( 'wc-product-gallery-zoom' );
					remove_theme_support( 'wc-product-gallery-lightbox' );
					remove_theme_support( 'wc-product-gallery-slider' );	
					remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
					add_action( 'woocommerce_product_thumbnails', 'wpopal_woocommerce_single_product_images', 20 );
					break;
				case 'slider': 

					
					
					remove_theme_support( 'wc-product-gallery-zoom' );
					remove_theme_support( 'wc-product-gallery-lightbox' );
					remove_theme_support( 'wc-product-gallery-slider' );	
					remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
					remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

					add_action( 'woocommerce_before_single_product_summary', 'wpopal_woocommerce_single_product_images_slider', 20 );

					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-images-slider' ) );
					} );				
				break;
			}
		}

		/**
		 *
		 */
		protected function content_accordion_hooks(){
			
			wp_enqueue_script("jquery-ui-accordion");
		
			/// add content accordion
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			add_action( 'woocommerce_after_single_product_summary', [$this,'output_product_data_tabs'], 10 );

		}

		public function output_product_data_tabs() {
	    	echo Wpopal_Core_Template_Loader::get_template_part( 'woocommerce/single-product/accordion' );
	    }


		/**
	 	 * Set product images block with selected option from customizer 
	 	 *  support accordion, veritical, and default.
	 	 * 
	 	 */
		public function set_content_tabs( $layout ){
			switch ( $layout ) {
				case 'accordion':
					$this->content_accordion_hooks();
					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-content-accordion' ) );
					} );	
					break;
				case 'vertical_tabs': 
					add_filter( 'body_class', function( $classes ) {
					    return array_merge( $classes, array( 'single-veritcal-tabs' ) );
					} );
				break;
			}
		}
		
	}
}
?>
