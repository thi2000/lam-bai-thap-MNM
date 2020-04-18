<?php
/**
 * Storefront Customizer Class
 *
 * @package  storefront
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'OpalElementor_Customizer' ) ) :

	/**
	 * The Storefront Customizer class
	 */
	class OpalElementor_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action('customize_register', array($this, 'include_controls'), 1);
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
		}

		public function include_controls( ){
			require( dirname(__FILE__).'/footer.php' );
			require( dirname(__FILE__).'/header.php' );
		}
		 
		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			$wp_customize->add_section( 'osf_header', array(
	            'title'          => __( 'Header Builder' ),
	            'capability'     => 'edit_theme_options',
	            'panel'          => '', 
	            'priority'       => 1, 
	        ) );

			// =========================================
	   
            $wp_customize->add_setting( 'osf_header_builder', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Headers( $wp_customize, 'osf_header_builder', array(
                'section' => 'osf_header',
                'label' => __( 'Header Builder' ),
            ) ) );

            $wp_customize->selective_refresh->add_partial(
			    'osf_header_builder', array(
			        'selector'          => 'body',
			        'settings'          => 'osf_header_builder',
			        'render_callback' => '__return_false',
			    )
			);
    
	        $wp_customize->add_section( 'osf_footer', array(
	            'title'          => __( 'Footer Builder' ),
	            'capability'     => 'edit_theme_options',
	            'panel'          => '', 
	            'priority'       => 1, 
	        ) );

			 if(class_exists('OSF_Customize_Control_Footers')){
	            $wp_customize->add_setting( 'osf_footer_layout', array(
	                'default'           => '0',
	                'sanitize_callback' => 'sanitize_text_field',
	            ) );
	            $wp_customize->add_control( new OSF_Customize_Control_Footers( $wp_customize, 'osf_footer_layout', array(
	                'section' => 'osf_footer',
	                'label' => __( 'Layout' ),
	            ) ) );

	            $wp_customize->selective_refresh->add_partial(
				    'osf_footer_layout', array(
				        'selector'          => 'body',
				        'settings'          => 'osf_footer_layout',
				        'render_callback' => '__return_false',
				    )
				);
				
	        }
		}
	}
endif;
return new OpalElementor_Customizer();
