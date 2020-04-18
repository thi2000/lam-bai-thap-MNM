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

if( !class_exists("Wpopal_Core_WooCommerce_Loop_Layout") ) {
	
	class Wpopal_Core_WooCommerce_Loop_Layout {

		public $layout = '';

		public static $instance;

		/**
		 * instance
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 *
		 */
		public function set_default_hook( $layout ){
			// remove breadscrumb
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			add_filter( 'body_class', [$this,'custom_class'] );


			// link to product in produc
			remove_action( 'woocommerce_shop_loop_item_title'	  , 'woocommerce_template_loop_product_title', 10 );
			add_action( 'woocommerce_shop_loop_item_title' , 'wpopal_woocommerce_template_loop_product_title', 10 );
 

			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
			// if enable product category

			if(  get_theme_mod( 'woocommerce_enable_product_cat_loop') ){
				add_action( 'woocommerce_shop_loop_item_title' , 'wpopal_woocommerce_product_loop_category' , 9 );
			}

			$this->layout = $layout ? $layout : 'default'; 

			$this->product_images_hook();

			add_filter( 'post_class', array( $this, 'set_product_post_class' ), 21, 3 );


			if( !get_theme_mod("woocommerce_disable_addition_nav") ) {
				// render horizontal filter block at top of catalog page
				add_action( 'woocommerce_before_shop_loop',        'wpopal_woocommerce_addition_nav',                 20 );

			}

			$this->hook_loop_wrap_product();
			
			if( get_theme_mod("woocommerce_enable_top_filter") ) {
				// render horizontal filter block at top of catalog page
				add_action( 'woocommerce_before_shop_loop',        'wpopal_woocommerce_horizontal_filters',                 20 );
			}
			
			// render selected filter options
			add_action( 'woocommerce_before_shop_loop',        'wpopal_woocommerce_clear_filters_selected',                 22 );

			$option = get_theme_mod( 'woocommerce_catalog_pagination_mode' );

			switch ( $option ) {
				case 'load_more':
				case 'infinite':
					add_action( 'woocommerce_after_shop_loop',        'wpopal_woocommerce_load_more_button',                 35 );
					break;
				
				default:
					add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
					add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
					break;
			}

		}
		
		/**
		 * Add wcspt-has-gallery class to products that have at least one gallery image.
		 *
		 * @param array $classes
		 * @param array $class
		 * @param int $post_id
		 * @return array
		 */
		public function set_product_post_class( $classes, $class, $post_id ) {
			if ( ! $post_id || get_post_type( $post_id ) !== 'product' ) {
				return $classes;
			}
			
			global $product;
			
			if ( is_object( $product ) ) {
				
				$image_ids = $this->get_gallery_img_ids( $product );
				
				if ( $image_ids ) {
					$classes[] = 'product-has-gallery';
				}
			}
			
			return $classes;
		}

		/**
		 * Returns the gallery image ids.
		 *
		 * @param WC_Product $product
		 * @return array
		 */
		public function get_gallery_img_ids( $product ) {
			if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
				$image_ids = $product->get_gallery_image_ids();
			} else {
				// Deprecated in WC 3.0.0
				$image_ids = $product->get_gallery_attachment_ids();
			}
			
			return $image_ids;
		}

		/**
		 * Add Custom class into body tag: add product class style as global
		 */
		public function custom_class( $classes ) {
		     
		    $classes[] = 'product-loop-style-'. $this->layout;
		 
		    return $classes;
		}

		/**
		 * Show add to cart at end of block, and show others buttons in content product top
		 */ 
		public function set_default(){

			/**
			 * Styles
			 *
			 * @see  wpopal_woocommerce_scripts()
			 */
			/**
			 * Layout default for loop product
			 *
			 * @see  wpopal_before_content()
			 * @see  wpopal_after_content()
			 * @see  woocommerce_breadcrumb()
			 * @see  wpopal_shop_messages()
			 */
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
			remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
			remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
			add_action( 'woocommerce_before_main_content',    'wpopal_before_content',                10 );
			add_action( 'woocommerce_after_main_content',     'wpopal_after_content',                 10 );
			add_action( 'wpopal_content_top',             'wpopal_shop_messages',                 15 );
			//remove_action( 'wpopal_before_content',          'woocommerce_breadcrumb',                   10 );


			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper',               9 );
		//	add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper_close',         31 );

			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper',               9 );
			add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_before_shop_loop',       'wpopal_woocommerce_pagination',        30 );
			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper_close',         31 );


			$this->remove_hook_button_actions();
			add_action( 'woocommerce_before_shop_loop_item_title', [$this,'render_buttons_actions'], 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			$this->hook_loop_wrap_top();
		}

		/**
		 * Create container wrapping all content inside
		 */
		public function hook_loop_wrap_product(){
			add_action( 'woocommerce_before_shop_loop_item', function(){  
				echo '<div class="product-wrap">'; 
			}, 1 );

			add_action( 'woocommerce_after_shop_loop_item', function(){
				echo '</div>';
			}, 22 );
		}

		/**
		 * Create container wrapping images, label with class product-content-top
		 */
		public function hook_loop_wrap_top(){
			add_action( 'woocommerce_before_shop_loop_item', function(){  
				echo '<div class="product-content-top">'; 
			}, 1 );

			add_action( 'woocommerce_shop_loop_item_title', function(){
				echo '</div>';
			}, 1 );
		}

		/**
		 * Create container wrapping title, price.... with class product-content-bottom
		 */
		public function hook_loop_wrap_bottom(){
			add_action( 'woocommerce_shop_loop_item_title', function(){  
				echo '<div class="product-content-bottom">'; 
			}, 1 );

			add_action( 'woocommerce_after_shop_loop_item', function(){
				echo '</div>';
			}, 20 );
		}


		/**
		 * Create container wrapping images, label with class product-content-top
		 */
		public function hook_loop_wrap_list_top(){
			add_action( 'woocommerce_before_shop_loop_item', function(){  
				echo '<div class="row"><div class="product-content-top wp-col-4">'; 
			}, 1 );

			add_action( 'woocommerce_shop_loop_item_title', function(){
				echo '</div>';
			}, 1 );
		}

		/**
		 * Create container wrapping title, price.... with class product-content-bottom
		 */
		public function hook_loop_wrap_list_bottom(){
			add_action( 'woocommerce_shop_loop_item_title', function(){  
				echo '<div class="product-content-bottom wp-col-8">'; 
			}, 1 );

			add_action( 'woocommerce_after_shop_loop_item', function(){
				echo '</div></div>';
			}, 20 );
		}



		/**
		 * Remove render button wishlist, compare, add to card from 3rd plugins
		 */
		public function remove_hook_button_actions(){

			global $yith_woocompare;
			// change button cart //
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		    if( $yith_woocompare ){
		    	remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
		    }

		    if( class_exists("YITH_WCQV_Frontend") ){  
		    	remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend() , 'yith_add_quick_view_button' ), 15 );
		    }
		    ?>
		    <?php 
		}


		public function product_images_hook(){

			$option =  get_theme_mod( 'woocommerce_product_loop_images' );

			switch ( $option ) {
				case 'swap':
					
				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_swap' ), 10 );		
				break;	

				case 'gallery':
				
				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
				add_action( 'woocommerce_before_shop_loop_item_title', 'wpopal_woocommerce_loop_product_images_slider', 10 );
				
				break;		
				default:
					# code...
					break;
			}

			if( get_theme_mod( 'woocommerce_enable_product_swatch_loop' ) ){  
				add_action( 'woocommerce_before_shop_loop_item_title', 'wpopal_woocommerce_render_variable', 10 );
			}
		}

		public function product_swap(){
			
			global $product; 

			$image_ids = $this->get_gallery_img_ids( $product );

			if ( $image_ids ) {
				$id = apply_filters( 'wpopal_loop_single_last_image', false ) ? end( $image_ids ) : reset( $image_ids );
				$size             = 'shop_catalog';
				$classes          = 'attachment-' . $size . ' product-img-second';
				echo wp_get_attachment_image( $id, $size, false, array( 'class' => $classes ) );
			} 

		}

		/**
		 * Re-render all buttons: add to cart, wishlist, compare, add favious 
		 */
		public function render_all_buttons_actions(){ 
			global $yith_woocompare;
		?>
			<div class="wpopal-button-actions">
		    	<div class="button-cart-action">
		    		<?php echo woocommerce_template_loop_add_to_cart(); ?>
		    	</div>
		    	<?php if( class_exists("YITH_WCQV_Frontend") ): ?>
		    	<div class="button-quickview-action">
		    		<?php echo YITH_WCQV_Frontend()->yith_add_quick_view_button(); ?>
		    	</div>
		    	<?php endif; ?>
		    	<?php if( class_exists("YITH_WCWL") ): ?>
		    		<div class="button-wishlist-action">
		    		<?php echo do_shortcode( "[yith_wcwl_add_to_wishlist]"); ?>
		    		</div>
		    	<?php endif; ?>	
		    	<?php if( is_object($yith_woocompare) && method_exists( $yith_woocompare->obj, "add_compare_link")  ) :  ?>
		    	<div class="button-compare-action">	
		    		<?php echo $yith_woocompare->obj->add_compare_link(); ?>
		    	</div>	
		    	<?php endif; ?>	
		    </div>	

		<?php }

		/**
		 * Re-render all buttons: wishlist, compare, add favious and without add to cart
		 */
		public function render_buttons_actions(){ 
			global $yith_woocompare;
		?>
			<div class="wpopal-button-actions">
		    	<?php if( class_exists("YITH_WCQV_Frontend") ): ?>
		    	<div class="button-quickview-action">
		    		<?php echo YITH_WCQV_Frontend()->yith_add_quick_view_button(); ?>
		    	</div>
		    	<?php endif; ?>
		    	<?php if( class_exists("YITH_WCWL") ): ?>
		    		<div class="button-wishlist-action">
		    		<?php echo do_shortcode( "[yith_wcwl_add_to_wishlist]"); ?>
		    		</div>
		    	<?php endif; ?>	
	    		<?php if( is_object($yith_woocompare) && method_exists( $yith_woocompare->obj, "add_compare_link")  ) :  ?>
		    	<div class="button-compare-action">	
		    		<?php echo $yith_woocompare->obj->add_compare_link(); ?>
		    	</div>	
		    	<?php endif; ?>	
		    </div>	

		<?php }

		/**
		 * magic function to set layout hook
		 */
		public function set_layout( $layout ){

			$this->layout = $layout; 
			$method = apply_filters( 'wpopal_woocommerce_set_layoyt', 'set_'.str_replace( "-", "_", $layout ).'_hooks' , $layout ); 

			if( method_exists( $this, $method ) &&  $layout ){
				$this->$method();
			} else {
				do_action( 'wpopal_set_product_loop_layout', $layout );
			}
		}	

		/**
		 * Define more product layout template using for special module
		 */
		public function set_layout_1_template( $template, $slug, $name  ) {
			if( $slug == "content" && $name == "product" ){ 
				return WPOPAL_PLUGIN_TEMPLATE_DIR. 'woocommerce/content-1-product.php';
			}
			return $template;
		}

		/**
		 * Define more product layout template using for special module
		 */
		public function set_layout_2_template( $template, $slug, $name  ) {
			if( $slug == "content" && $name == "product" ){ 
				return WPOPAL_PLUGIN_TEMPLATE_DIR. 'woocommerce/content-2-product.php';
			}
			return $template;
		}

		/** 
		 *  Display all icon button in content product top. Default buttons are hide, hover to show all
		 */
		public function set_layout_1_hooks(){
			// remove breadscrumb
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			/**
			 * Styles
			 *
			 * @see  wpopal_woocommerce_scripts()
			 */
			/**
			 * Layout default for loop product
			 *
			 * @see  wpopal_before_content()
			 * @see  wpopal_after_content()
			 * @see  woocommerce_breadcrumb()
			 * @see  wpopal_shop_messages()
			 */
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
			remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
			remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
			add_action( 'woocommerce_before_main_content',    'wpopal_before_content',                10 );
			add_action( 'woocommerce_after_main_content',     'wpopal_after_content',                 10 );
			add_action( 'wpopal_content_top',             'wpopal_shop_messages',                 15 );
			//remove_action( 'wpopal_before_content',          'woocommerce_breadcrumb',                   10 );

			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper',               9 );
		//	add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper_close',         31 );

			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper',               9 );
			add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_before_shop_loop',       'wpopal_woocommerce_pagination',        30 );
			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper_close',         31 );

			$this->remove_hook_button_actions();
			add_action( 'woocommerce_before_shop_loop_item_title', [$this,'render_all_buttons_actions'], 10 );
			 
			$this->hook_loop_wrap_top();
		}

		
		/**
		 * Show add to cart and description in overlap, and show other button in content top.
		 */
		public function set_layout_2_hooks(){  	
			/**
			 * Styles
			 *
			 * @see  wpopal_woocommerce_scripts()
			 */
			/**
			 * Layout default for loop product
			 *
			 * @see  wpopal_before_content()
			 * @see  wpopal_after_content()
			 * @see  woocommerce_breadcrumb()
			 * @see  wpopal_shop_messages()
			 */
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
			remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
			remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
			add_action( 'woocommerce_before_main_content',    'wpopal_before_content',                10 );
			add_action( 'woocommerce_after_main_content',     'wpopal_after_content',                 10 );
			add_action( 'wpopal_content_top',             'wpopal_shop_messages',                 15 );
			//remove_action( 'wpopal_before_content',          'woocommerce_breadcrumb',                   10 );

			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper',               9 );
		//	add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper_close',         31 );

			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper',               9 );
			add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_before_shop_loop',       'wpopal_woocommerce_pagination',        30 );
			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper_close',         31 );

			$this->remove_hook_button_actions();
			add_action( 'woocommerce_before_shop_loop_item_title', [$this,'render_buttons_actions'], 10 );

			add_action( 'woocommerce_after_shop_loop_item', function(){
				echo '<div class="fade-in-block">';
			}, 10 );

			add_action( 'woocommerce_after_shop_loop_item', function(){
				global $post; 
 
				if( $post ) {
					echo '<div class="product-desc">'.$post->post_excerpt.'</div>';
				}

			}, 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_after_shop_loop_item', function(){
				echo '</div>';
			}, 10 );

			
			$this->hook_loop_wrap_top();
			$this->hook_loop_wrap_bottom();
		}

		/**
		 * Show other buttons at left of box, and button + swatches color at bottom.
		 */
		public function set_layout_3_hooks(){  
		
			/**
			 * Styles
			 *
			 * @see  wpopal_woocommerce_scripts()
			 */
			/**
			 * Layout default for loop product
			 *
			 * @see  wpopal_before_content()
			 * @see  wpopal_after_content()
			 * @see  woocommerce_breadcrumb()
			 * @see  wpopal_shop_messages()
			 */
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
			remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
			remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
			add_action( 'woocommerce_before_main_content',    'wpopal_before_content',                10 );
			add_action( 'woocommerce_after_main_content',     'wpopal_after_content',                 10 );
			add_action( 'wpopal_content_top',             'wpopal_shop_messages',                 15 );
			//remove_action( 'wpopal_before_content',          'woocommerce_breadcrumb',                   10 );

			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper',               9 );
		//	add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper_close',         31 );

			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper',               9 );
			add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_before_shop_loop',       'wpopal_woocommerce_pagination',        30 );
			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper_close',         31 );

			$this->remove_hook_button_actions();
			add_action( 'woocommerce_before_shop_loop_item_title', [$this,'render_buttons_actions'], 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			 

		//	$this->hook_loop_wrap_product();
			$this->hook_loop_wrap_top();
		}

		/**
		 * Show Image as big one and show price on it.
		 */
		public function set_layout_4_hooks(){ 
			/**
			 * Styles
			 *
			 * @see  wpopal_woocommerce_scripts()
			 */
			/**
			 * Layout default for loop product
			 *
			 * @see  wpopal_before_content()
			 * @see  wpopal_after_content()
			 * @see  woocommerce_breadcrumb()
			 * @see  wpopal_shop_messages()
			 */
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
			remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
			remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
			add_action( 'woocommerce_before_main_content',    'wpopal_before_content',                10 );
			add_action( 'woocommerce_after_main_content',     'wpopal_after_content',                 10 );
			add_action( 'wpopal_content_top',             'wpopal_shop_messages',                 15 );
			//remove_action( 'wpopal_before_content',          'woocommerce_breadcrumb',                   10 );

			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper',               9 );
		//	add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper_close',         31 );

			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper',               9 );
			add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_before_shop_loop',       'wpopal_woocommerce_pagination',        30 );
			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper_close',         31 );

			$this->remove_hook_button_actions();
			add_action( 'woocommerce_before_shop_loop_item_title', [$this,'render_buttons_actions'], 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			$this->hook_loop_wrap_top();
		}


		public function set_list_hooks(){  
			/**
			 * Styles
			 *
			 * @see  wpopal_woocommerce_scripts()
			 */
			/**
			 * Layout default for loop product
			 *
			 * @see  wpopal_before_content()
			 * @see  wpopal_after_content()
			 * @see  woocommerce_breadcrumb()
			 * @see  wpopal_shop_messages()
			 */
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
			remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
			remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
			remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );
			add_action( 'woocommerce_before_main_content',    'wpopal_before_content',                10 );
			add_action( 'woocommerce_after_main_content',     'wpopal_after_content',                 10 );
			add_action( 'wpopal_content_top',             'wpopal_shop_messages',                 15 );
			//remove_action( 'wpopal_before_content',          'woocommerce_breadcrumb',                   10 );


			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper',               9 );
		//	add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
			add_action( 'woocommerce_after_shop_loop',        'wpopal_sorting_wrapper_close',         31 );

			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper',               9 );
			add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
			//add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
			//add_action( 'woocommerce_before_shop_loop',       'wpopal_woocommerce_pagination',        30 );
			add_action( 'woocommerce_before_shop_loop',       'wpopal_sorting_wrapper_close',         31 );

			$this->remove_hook_button_actions();
			add_action( 'woocommerce_before_shop_loop_item_title', [$this,'render_buttons_actions'], 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_after_shop_loop_item', function(){
				global $post; 
 
				if( $post ) {
					echo '<div class="product-desc">'.$post->post_excerpt.'</div>';
				}

			}, 10 );

			$this->hook_loop_wrap_list_top();
			$this->hook_loop_wrap_list_bottom();
		}
	}
}
?>