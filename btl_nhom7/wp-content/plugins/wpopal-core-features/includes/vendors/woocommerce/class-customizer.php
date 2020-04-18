<?php
/**
 * Wpopal_Core WooCommerce Customizer Class
 *
 * @package  wpopal
 * @since    2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wpopal_Core_WooCommerce_Customizer' ) ) :

	/**
	 * The Wpopal_Core Customizer class
	 */
	class Wpopal_Core_WooCommerce_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 2.4.0
		 * @return void
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'product_customize_register' ), 10 );
			add_action( 'customize_register', array( $this, 'catalog_customize_register' ), 10 );


			add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
			add_filter( 'wpopal_setting_default_values', array( $this, 'setting_default_values' ) );

			add_action( 'customize_save_after', array( $this,'customize_save_after' ) );

			add_filter( 'wpopal_customizer_json_files', array( $this,'add_customizer_setting'  ), 50, 2 );
		}



		public function add_customizer_setting( $files ){
			$files['woocommerce'] = WPOPAL_PLUGIN_DIR . 'includes/customizer/settings/woocommerce.json';
			return $files; 
		} 


		public function customize_save_after(){
 
			if( class_exists('WC_Session_Handler')) {
				$session = WC()->session;
				$session->set( 'view_cols',  null );
				$session->set( 'show_per_page', null );
			} 
		}
		/**
		 * 
		 */
		public function catalog_customize_register ( $wp_customize ){

			$wp_customize->add_setting(
				'woocommerce_product_catalog_layout', array(
					'default'               => apply_filters( 'woocommerce_product_catalog_layout_default', "" ),
					'capability'        	=> 'manage_woocommerce',
				)
			);

			$wp_customize->add_control(
				'woocommerce_product_catalog_layout', array(
					'type'                  => 'select',
					'section'               => 'woocommerce_product_catalog',
					'label'                 => __( 'Product Loop Layout', 'wpopal' ),
					'description'           => __( 'Set layout of product loop showing in Category Page, Archive Page, Product widget... It is as default layout', 'wpopal' ),
					'priority'              => 1,
					'choices'     => apply_filters( 'wpopal_woocommerce_product_catalog_layout', array(
						'' 		      => __( 'Default', 'wpopal' ),
						'layout-1'   			  => __( 'Layout 1', 'wpopal' ),
						'layout-2'   			  => __( 'Layout 2', 'wpopal' ),
						'layout-3'   			  => __( 'Layout 3', 'wpopal' ),
						'layout-4'   			  => __( 'Layout 4', 'wpopal' ),
					) ),
				)
			);
			
			/// ////
			$wp_customize->add_setting(
				'woocommerce_product_loop_images', array(
					'default'               => apply_filters( 'woocommerce_product_loop_images', "" ),
					'capability'        	=> 'manage_woocommerce',
				)
			);

			$wp_customize->add_control(
				'woocommerce_product_loop_images', array(
					'type'                  => 'select',
					'section'               => 'woocommerce_product_catalog',
					'label'                 => __( 'Product Loop Layout', 'wpopal' ),
					'description'           => __( 'Set layout of product loop showing in Category Page, Archive Page, Product widget... It is as default layout', 'wpopal' ),
					'priority'              => 1,
					'choices'     => apply_filters( 'woocommerce_product_loop_images', array(
						'' 		      => __( 'Simple', 'wpopal' ),
						'swap'   	  => __( 'Swap', 'wpopal' ),
						'gallery'	   => __( 'Gallery', 'wpopal' )
					) ),
				)
			);
			
			// enable product category 
			$wp_customize->add_setting(
				'woocommerce_enable_product_swatch_loop', array(
					'default'               => false,
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);

			$wp_customize->add_control(
				'woocommerce_enable_product_swatch_loop', array(
					'type'                  => 'checkbox',
					'section'               => 'woocommerce_product_catalog',
					'label'                 => __( 'Enale Product Color Swatch', 'wpopal' ),
					'description'           => __( 'Show all color in loop product.', 'wpopal' ),
					'priority'              => 2,
				)
			);


			// enable product category 
			$wp_customize->add_setting(
				'woocommerce_enable_product_cat_loop', array(
					'default'               => false,
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);

			$wp_customize->add_control(
				'woocommerce_enable_product_cat_loop', array(
					'type'                  => 'checkbox',
					'section'               => 'woocommerce_product_catalog',
					'label'                 => __( 'Loop Product Category', 'wpopal' ),
					'description'           => __( 'Show Product category in loop item.', 'wpopal' ),
					'priority'              => 2,
				)
			);


			// sidebar 
			$wp_customize->add_setting( 'woocommerce_catalog_pagination_mode', array(
				'default'           => '',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			) );

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'woocommerce_catalog_pagination_mode', array(
						'label'       => __( 'Pagination Mode', 'wpopal' ),
						'description' => __( 'Pagination style will be showed in page numbers, load more, infinite load.',
						'wpopal' ),
						'section'     => 'woocommerce_product_catalog',
						'settings'    => 'woocommerce_catalog_pagination_mode',
						'type'        => 'select',
						'sanitize_callback' => '',
						'choices'     => array(
							'' => __( 'Pagination Page Numbers', 'wpopal' ),
							'load_more'  => __( 'Ajax Load More', 'wpopal' ),
							'infinite'  => __( 'Ajax infinite load', 'wpopal' ) 
						),
						'priority'    => '4',
					)
			) );

			// enable product category 
			$wp_customize->add_setting(
				'woocommerce_disable_addition_nav', array(
					'default'               => false,
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);

			$wp_customize->add_control(
				'woocommerce_disable_addition_nav', array(
					'type'                  => 'checkbox',
					'section'               => 'woocommerce_product_catalog',
					'label'                 => __( 'Disable Addition Navigation', 'wpopal' ),
					'description'           => __( 'Disable custom Switch view mode, change limited show per page', 'wpopal' ),
					'priority'              => 2,
				)
			);

			// enable product category 
			$wp_customize->add_setting(
				'woocommerce_enable_top_filter', array(
					'default'               => false,
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);

			$wp_customize->add_control(
				'woocommerce_enable_top_filter', array(
					'type'                  => 'checkbox',
					'section'               => 'woocommerce_product_catalog',
					'label'                 => __( 'Enable Top filter Sidebar', 'wpopal' ),
					'description'           => __( 'Display all widget filter at top of listing block', 'wpopal' ),
					'priority'              => 2,
				)
			);


			// sidebar 
			$wp_customize->add_setting( 'woocommerce_sidebar_shop_position', array(
				'default'           => 'right',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			) );

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'woocommerce_sidebar_shop_position', array(
						'label'       => __( 'Sidebar Positioning', 'wpopal' ),
						'description' => __( 'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
						'wpopal' ),
						'section'     => 'woocommerce_product_catalog',
						'settings'    => 'woocommerce_sidebar_shop_position',
						'type'        => 'select',
						'sanitize_callback' => '',
						'choices'     => array(
							'right' => __( 'Right sidebar', 'wpopal' ),
							'left'  => __( 'Left sidebar', 'wpopal' ),
							'both'  => __( 'Left & Right sidebars', 'wpopal' ),
							'none'  => __( 'No sidebar', 'wpopal' ),
						),
						'priority'    => '20',
					)
			) );


		}
		/**
		 * Returns an array of the desired default Wpopal_Core Options
		 *
		 * @param array $defaults array of default options.
		 * @since 2.4.0
		 * @return array
		 */
		public function setting_default_values( $defaults = array() ) {
			$defaults['wpopal_sticky_add_to_cart'] = true;
			$defaults['wpopal_product_navigation'] = true;

			return $defaults;
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 2.4.0
		 */
		public function product_customize_register( $wp_customize ) {
 
			/**
			 * Product Page
			 */
			$wp_customize->add_section(
				'wpopal_single_product_page', array(
					'title'                 => __( 'Single Product Page', 'wpopal' ),
					'priority'              => 60,
					'panel'          => 'woocommerce',
				)
			);

			$wp_customize->add_setting(
				'woocommerce_single_sticky_disable', array(
					'default'               => apply_filters( 'woocommerce_single_sticky_disable', false ),
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);

			$wp_customize->add_control(
				'woocommerce_single_sticky_disable', array(
					'type'                  => 'checkbox',
					'section'               => 'wpopal_single_product_page',
					'label'                 => __( 'Disable Sticky Content Top', 'wpopal' ),
					'description'           => __( 'Enable sticky content keep one fixed position while mouse scrolling apply for gallery and summary box', 'wpopal' ),
					'priority'              => 10,
				)
			);

 
			$wp_customize->add_setting(
				'wpopal_product_navigation', array(
					'default'               => apply_filters( 'wpopal_default_product_navigation', true ),
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);
			$wp_customize->add_control(
				'wpopal_product_navigation', array(
					'type'                  => 'checkbox',
					'section'               => 'wpopal_single_product_page',
					'label'                 => __( 'Product Navigation', 'wpopal' ),
					'description'           => __( 'Displays next and previous links on product pages. A product thumbnail is displayed with the title revealed on hover.', 'wpopal' ),
					'priority'              => 20,
				)
			);

			$wp_customize->selective_refresh->add_partial( 'wpopal_single_product_page', array(
				'selector'        => 'body',
				'render_callback' =>  "return true;",
			) );



			// product single layout style

			///product Layout
			$wp_customize->add_setting(
				'wpopal_product_layout_style',
				array(
					'default'           => 'default',
					'capability'        	=> 'manage_woocommerce',
				)
			);

			$wp_customize->add_control(
				'wpopal_product_layout_style',
				array(
					'label'       => __( 'Product Display Style', 'wpopal' ),
					'description' => __( 'Set product layout style in variant', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_product_layout_style',
					'type'        => 'select',
					'priority'              => 21,
					'choices'     => apply_filters( 'woocommerce_product_layout_style', array(
						'center'   			  => __( 'Center', 'wpopal' ),
						'fullwidth'  		  => __( 'Fullwidth', 'wpopal' ),
						'split'		 		  => __( 'Split', 'wpopal' ),
						'split_accordion'	  => __( 'Split & Accordion'	 	 , 'wpopal' ),
						'small'		 		  => __( 'Small Gallery' , 'wpopal' ),
						'big'		 		  => __( 'Big Gallery'	 , 'wpopal' ),
						'sidebar'		 	  => __( 'Sidebar'	 	 , 'wpopal' ),
						'one_columns'		  => __( 'One Cloum'	 	 , 'wpopal' ),

						'two_columns'		  => __( 'One Cloum'	 	 , 'wpopal' ),
						'slider'		  => __( 'One Cloum'	 	 , 'wpopal' ),
						'thumb_left_slider'		  => __( 'One Cloum'	 	 , 'wpopal' ),
						'thumb_right_slider'		  => __( 'One Cloum'	 	 , 'wpopal' ),
						'vertical_tabs'		  => __( 'One Cloum'	 	 , 'wpopal' ),
						'accordion'		  => __( 'One Cloum'	 	 , 'wpopal' ),

						'custom'			  => __( 'Custom'	 	 , 'wpopal' ),
					) ),
				)
			);
			
			///product Layout
			$wp_customize->add_setting(
				'wpopal_product_layout',
				array(
					'default'           => 'default',
					'capability'        	=> 'manage_woocommerce',
				)
			);

			$wp_customize->add_control(
				'wpopal_product_layout',
				array(
					'label'       => __( 'Product Layout', 'wpopal' ),
					'description' => __( 'How to show images, tabs nice view with selected layout?', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_product_layout',
					'type'        => 'select',
					'priority'              => 21,
					'choices'     => apply_filters( 'woocommerce_default_catalog_orderby_options', array(
						'default' 		      => __( 'Default', 'wpopal' ),
						'center'   			  => __( 'Center', 'wpopal' ),
						'fullwidth'  		  => __( 'Fullwidth', 'wpopal' ),
						'split'		 		  => __( 'Split', 'wpopal' ),
						'small'		 		  => __( 'Small Gallery' , 'wpopal' ),
						'big'		 		  => __( 'Big Gallery'	 , 'wpopal' ),
						'sidebar'		 	  => __( 'Sidebar'	 	 , 'wpopal' ),
					) ),
				)
			);
			

			// // / /
			$wp_customize->add_setting(
				'wpopal_product_related',
				array(
					'default'              => 4,
 
					'capability'           => 'manage_woocommerce',
					'sanitize_callback'    => 'absint',
					'sanitize_js_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'wpopal_product_related',
				array(
					'label'       => __( 'Related Product per row', 'wpopal' ),
					'description' => __( 'How many products should be shown per row?', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_product_related',
					'type'        => 'number',
					'priority'              => 30,
					'input_attrs' => array(
						'min'  =>  3,
						'max'  => 12,
						'step' => 1,
					),
				)
			);


			$wp_customize->add_setting(
				'wpopal_product_related_limited',
				array(
					'default'              => 4,
 
					'capability'           => 'manage_woocommerce',
					'sanitize_callback'    => 'absint',
					'sanitize_js_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'wpopal_product_related_limited',
				array(
					'label'       => __( 'Related Product Limited', 'wpopal' ),
					'description' => __( 'How many products should be fetched to show?', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_product_related_limited',
					'type'        => 'number',
					'priority'              => 30,
					'input_attrs' => array(
						'min'  =>  3,
						'max'  => 12,
						'step' => 1,
					),
				)
			);


			// product more information
			$wp_customize->add_setting(
				'wpopal_single_more_info',
				array(
					'default'              => "",
 
					'capability'           => 'manage_woocommerce',

				)
			);

			$wp_customize->add_control(
				'wpopal_single_more_info',
				array(
					'label'       => __( 'Product Extra Information', 'wpopal' ),
					'description' => __( 'Display more information in bottom of summary?', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_single_more_info',
					'type'        => 'textarea',
					'priority'              => 30
				)
			);
			/// 
			$wp_customize->add_setting(
				'wpopal_single_security_logo',
				array(
					'default'              => 4,
					'capability'           => 'manage_woocommerce'
				)
			);
			$wp_customize->add_control(
		       new WP_Customize_Image_Control(
		           $wp_customize,
		           'wpopal_single_security_logo',
		           array(
		               'label'      => __( 'Security logo', 'theme_name' ),
		               'section'    => 'wpopal_single_product_page',
		               'settings'   => 'wpopal_single_security_logo',
		               'context'    => '' ,
		               'priority'              => 30,
		           )
		       )
		   );


			///product main content 
			$wp_customize->add_setting(
				'wpopal_product_images',
				array(
					'default'           => 'default',
					'sanitize_callback' => 'wp_kses_post' 
				)
			);

			$wp_customize->add_control(
				'wpopal_product_images',
				array(
					'label'       => __( 'Product Image Block', 'wpopal' ),
					'description' => __( 'How should show images in gallery, slideshow....?', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_product_images',
					'type'        => 'select',
					'priority'              => 21,
					'choices'     => apply_filters( 'woocommerce_default_catalog_orderby_options', array(
						'default' 		      => __( 'Default', 'wpopal' ),
						'thumb_left_slider'   => __( 'Thumbnail Left and Slider', 'wpopal' ),
						'thumb_right_slider'  => __( 'Thumbnail Right and Slider', 'wpopal' ),
						'thumb_bot_slider'    => __( 'Thumbnail Bottom and Slider', 'wpopal' ),
						'one_columns'         => __( 'No Slider Image In One Column', 'wpopal' ),
						'two_columns' 		  => __( 'No Slider Image In Two Column', 'wpopal' ),
						'slider' 			  => __( 'No Thumbnail and Slider', 'wpopal' ),
					) ),
				)
			);


			// product comment template

			///product main content 
			$wp_customize->add_setting(
				'wpopal_product_comment_template',
				array(
					'default'           => 'advanced',
					'sanitize_callback' => 'wp_kses_post' 
				)
			);

			$wp_customize->add_control(
				'wpopal_product_comment_template',
				array(
					'label'       => __( 'Comment Template', 'wpopal' ),
					'description' => __( 'How should show images in gallery, slideshow....?', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_product_comment_template',
					'type'        => 'select',
					'priority'              => 21,
					'choices'     => apply_filters( 'woocommerce_product_comment_template', array(
						'' 		     => __( 'Default', 'wpopal' ),
						'advanced'   => __( 'Advanded', 'wpopal' )
					) ),
				)
			);

			///product main content 
			$wp_customize->add_setting(
				'wpopal_product_tabs',
				array(
					'default'           => 'default',
					'sanitize_callback' => 'wp_kses_post' 
				)
			);

			$wp_customize->add_control(
				'wpopal_product_tabs',
				array(
					'label'       => __( 'Content In Tabs?', 'wpopal' ),
					'description' => __( 'Show content in tabs or accordion .....?', 'wpopal' ),
					'section'     => 'wpopal_single_product_page',
					'settings'    => 'wpopal_product_tabs',
					'type'        => 'select',
					'priority'              => 21,
					'choices'     => apply_filters( 'woocommerce_default_catalog_orderby_options', array(
						'default' 		    => __( 'Default Tabs', 'wpopal' ),
						'vertical_tabs' 	=> __( 'Vertical Tabs', 'wpopal' ),
						'accordion'  		=> __( 'Accordion', 'wpopal' )
					) ),
				)
			);


			/// // /
/*
			$wp_customize->add_setting( 'woocommerce_sidebar_shop_single_position', array(
				'default'           => 'none',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			) );
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'woocommerce_sidebar_shop_single_position', array(
						'label'       => __( 'Sidebar Positioning', 'wpopal' ),
						'description' => __( 'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
						'wpopal' ),
						'section'     => 'wpopal_single_product_page',
						'settings'    => 'woocommerce_sidebar_shop_single_position',
						'type'        => 'select',
						'sanitize_callback' => '',
						'choices'     => array(
							'right' => __( 'Show Sidebar At Left', 'wpopal' ),
							'left'  => __( 'Show Sidebar At Right', 'wpopal' ),
							'none'  => __( 'No sidebar', 'wpopal' ),
						),
						'priority'    => '20',
					)
			) ); */

		}


		public function sanitize_default_product_images( $value ) {
			$options = apply_filters( 'woocommerce_default_catalog_orderby_options', array(
				'menu_order' => __( 'Default sorting (custom ordering + name)', 'wpopal' ),
				'popularity' => __( 'Popularity (sales)', 'wpopal' ),
				'rating'     => __( 'Average rating', 'wpopal' ),
				'date'       => __( 'Sort by most recent', 'wpopal' ),
				'price'      => __( 'Sort by price (asc)', 'wpopal' ),
				'price-desc' => __( 'Sort by price (desc)', 'wpopal' ),
			) );

			return array_key_exists( $value, $options ) ? $value : 'default';
		}
		/**
		 * Get Customizer css.
		 *
		 * @see get_wpopal_theme_mods()
		 * @since 2.4.0
		 * @return string $styles the css
		 */
		public function get_css() { 
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * @since 2.4.0
		 * @return void
		 */
		public function add_customizer_css() {
			wp_add_inline_style( 'wpopal-woocommerce-style', $this->get_css() );
		}

	}

endif;

return new Wpopal_Core_WooCommerce_Customizer();
