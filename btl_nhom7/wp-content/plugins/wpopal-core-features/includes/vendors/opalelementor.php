<?php 
/**
 * @class Wpopal_Core_Opal_Elementor
 *
 * Wpopal_Core_Opal_Elementor is responsible for check header and footer builder were actived to display html.
 *  
 *
 * @since 1.0.0
 */
class Wpopal_Core_Opal_Elementor {

	public $theme; 
	public function __construct() {
		
	 	
		if( !is_admin() ){
			// $this->display_header
			
			add_action( 'wp', array( $this, 'display_header_footer' ) , 99 );
			add_action( 'wp', array( $this, 'display_set_header_footer' ) , 2 );
			

		}  else {
			// add_action( 'osf_elementor_product_loop_layouts', array($this, 'product_loop_layouts'), 39 );
		}

		add_action( 'customize_register', array( $this, 'customize_register' ), 100 );
		$my_theme = wp_get_theme();
		if($child_theme = $my_theme->get('Template') ) {
			$this->theme = $child_theme;
		}else {
			$this->theme = wp_get_theme();
		}	
	}

	public function display_set_header_footer(){
		add_filter("opalelementor_get_header_builder", array($this,'setup_custom_builder')  );
	}

	public function product_loop_layouts() {
		return  array(
					'content' 		=> __( 'Grid', 'wpopal' ),
					'content-list'  => __( 'List', 'wpopal' ),
		            'content-split' => __( 'Split Style', 'wpopal' ),
				);
	}
	/**
	 * Process to display html of header and footer from elementor builder
	 *
	 * @var avoid
	 */
	public function display_header_footer () { 
  		global $osf_header, $osf_footer; 

		if( $osf_header ){

			add_action( 'template_redirect', array( $this, 'setup_header' ) );
			add_action( $this->theme.'_header', 'opalelementor_render_header' );
		} 

		if( $osf_footer ){  
			add_action( 'template_redirect', array( $this, 'setup_footer' ) );
			add_action( $this->theme.'_footer', 'opalelementor_render_footer' );
		}


		
	}

 
	/**
	 * Remove all actions replate display html from files and remove any widget inside
	 *
	 * @var avoid
	 */
	public function setup_footer(){  

		 remove_action( $this->theme . '_footer',  $this->theme . '_footer' );
	}

	/**
	 * Remove all actions replate display html from files and remove any widget inside
	 *
	 * @var avoid
	 */
	public function setup_header(){  
		remove_action( $this->theme.'_header', $this->theme.'_header' );
	}
 
	public function setup_custom_builder(){ 

		if( class_exists("Woocommerce") ){
				if(  is_product() ){ 
	  			return $this->get_custom_header_woo();
			} else if( is_shop() || is_tax() ){
		 		if( $slug = get_theme_mod('woo_archive_header') ) { 
		        	return get_page_by_path($slug, OBJECT, 'header');
		        }
			}  
		}


		if( is_single() && get_post_type() == 'post' ) { 
			return $this->get_custom_header_post();
		}
	}

	/**
	 *
	 */
	private function get_custom_header_post( ) {
		$post_id = get_the_ID(); 
		$osf_header = '';	
        if ( (bool)osf_elementor_get_metabox( $post_id, 'osf_enable_custom_header', false) ) {
            if (($slug = osf_elementor_get_metabox( $post_id, 'osf_header_layout', 'default')) !== 'default') {
                $osf_header = get_page_by_path($slug, OBJECT, 'header');
            }
        } else if( $slug = get_theme_mod('post_header_builder') ) {
        	$osf_header = get_page_by_path($slug, OBJECT, 'header');
        }
        else if ( ($slug = get_theme_mod('osf_header_builder', '')) ) {
            $osf_header = get_page_by_path($slug, OBJECT, 'header');
        }

        return $osf_header;
	}

	/**
	 *
	 */
	private function get_custom_header_woo(){
		$osf_header = '';	
		if( $slug = get_theme_mod('woo_single_header_builder') ) { 
        	$osf_header = get_page_by_path($slug, OBJECT, 'header');
        }
        return $osf_header;
	}

	/**
	 *
	 */
	public function post_setup_header_footer(){
		global $osf_header, $osf_footer;

		$post_id = get_the_ID(); 

        if ( (bool)osf_elementor_get_metabox( $post_id, 'osf_enable_custom_header', false) ) {
            if (($slug = osf_elementor_get_metabox( $post_id, 'osf_header_layout', 'default')) !== 'default') {
                $osf_header = get_page_by_path($slug, OBJECT, 'header');
            }
        } else if( $slug = get_theme_mod('post_header_builder') ) {
        	$osf_header = get_page_by_path($slug, OBJECT, 'header');
        }
        else if ( ($slug = get_theme_mod('osf_header_builder', '')) ) {
            $osf_header = get_page_by_path($slug, OBJECT, 'header');
        }
       
 		/// 
        if ( osf_elementor_get_metabox( $post_id, 'osf_enable_custom_footer', false) ) {
           
            $footer_slug = osf_elementor_get_metabox( $post_id, 'osf_footer_layout', '');

        } else if( get_theme_mod('post_footer_layout') ) { 
        	 $footer_slug = get_theme_mod('post_footer_layout');
        } else {
            $footer_slug = get_theme_mod('osf_footer_layout', '');
        }

        if( $footer_slug ) {
            $osf_footer = get_page_by_path( $footer_slug, OBJECT, 'footer' );
        }
	}

	/**
	 *
	 */
	public function customize_register( $wp_customize ){

		$wp_customize->add_section( 'osf_header', array(
            'title'          => __( 'Header Builder' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

		// =========================================
   
        $wp_customize->add_setting( 'post_header_builder', array(
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( new OSF_Customize_Control_Headers( $wp_customize, 'post_header_builder', array(
            'section' => 'osf_header',
            'label' => __( 'Header Builder For Single Post' ),
        ) ) );

        $wp_customize->selective_refresh->add_partial(
		    'post_header_builder', array(
		        'selector'          => 'body',
		        'settings'          => 'post_header_builder',
		        'render_callback' => '__return_false',
		    )
		);

		if( class_exists("WooCommerce") ) { 
			// Custom header for Archive Woocommerce 
        	$wp_customize->add_setting( 'woo_single_header_builder', array(
	            'transport'         => 'postMessage',
	            'sanitize_callback' => 'sanitize_text_field',
	        ) );
	        $wp_customize->add_control( new OSF_Customize_Control_Headers( $wp_customize, 'woo_single_header_builder', array(
	            'section' => 'osf_header',
	            'label' => __( 'WooCommerce: Header Builder For Single Product' ),
	        ) ) );

	        $wp_customize->selective_refresh->add_partial(
			    'woo_single_header_builder', array(
			        'selector'          => 'body',
			        'settings'          => 'woo_single_header_builder',
			        'render_callback' => '__return_false',
			    )
			);
			/// Custom Header For Single Woocommerce
	        $wp_customize->add_setting( 'woo_archive_header', array(
	            'transport'         => 'postMessage',
	            'sanitize_callback' => 'sanitize_text_field',
	        ) );
	        $wp_customize->add_control( new OSF_Customize_Control_Headers( $wp_customize, 'woo_archive_header', array(
	            'section' => 'osf_header',
	            'label' => __( 'WooCommerce: Header Builder For Archive/Category' ),
	        ) ) );

	        $wp_customize->selective_refresh->add_partial(
			    'woo_archive_header', array(
			        'selector'          => 'body',
			        'settings'          => 'woo_archive_header',
			        'render_callback' => '__return_false',
			    )
			);
        }

        $wp_customize->add_section( 'osf_footer', array(
            'title'          => __( 'Footer Builder' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

		 if(class_exists('OSF_Customize_Control_Footers')){
            $wp_customize->add_setting( 'post_footer_layout', array(
                'default'           => '0',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Footers( $wp_customize, 'post_footer_layout', array(
                'section' => 'osf_footer',
                'label' => __( 'Footer Builder For Single Post' ),
            ) ) );

            $wp_customize->selective_refresh->add_partial(
			    'post_footer_layout', array(
			        'selector'          => 'body',
			        'settings'          => 'post_footer_layout',
			        'render_callback' => '__return_false',
			    )
			);
			
	        }
	}
}

new Wpopal_Core_Opal_Elementor();
?>