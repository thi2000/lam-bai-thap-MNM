<?php
/**
 * latehome_free enqueue scripts
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'latehome_free_theme_scripts_styles' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function latehome_free_theme_scripts_styles() {
		// Get the theme data.
		$the_theme = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );
			
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		$css_version = $theme_version . '.' . filemtime(get_template_directory() . '/style'.$suffix.'.css');
		wp_enqueue_style( 'latehome_free-styles', get_stylesheet_directory_uri() . '/style'.$suffix.'.css', array(), $css_version );

//		$css_version = $theme_version . '.' . filemtime(get_template_directory() . '/style.css');
//		wp_enqueue_style( 'latehome_free-styles', get_stylesheet_directory_uri() . '/style.css', array(), $css_version );
 
		/// 
		$js_version = $theme_version . '.' . filemtime(get_template_directory() . '/assets/js/theme'.$suffix.'.js');
		wp_enqueue_script( 'latehome_free-scripts', get_template_directory_uri() . '/assets/js/theme'.$suffix.'.js', array('jquery'), $js_version, true );

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }


		if( !latehome_free_is_enable_custom_fonts() ) {
			wp_enqueue_style( 'latehome_free-fonts', latehome_free_fonts_url(), array(), null );
		}

    }
}
add_action('wp_enqueue_scripts', 'latehome_free_theme_scripts_styles', 100);


if( !function_exists("latehome_free_3rd_scripts_styles") ){
	
	/**
	 * Load theme's JavaScript and CSS from 3 rd plugins.
	 */
	function latehome_free_3rd_scripts_styles( ) {

		//1. load jquery swiper javascript libs
		wp_register_script(
			'jquery-smooth-scroll',
			get_template_directory_uri(). '/assets/3rd/smooth-scroll.min.js',
			[
				'jquery',
			],
			'4.4.3',
			true
		);
		
		 
		//1. load jquery swiper javascript libs
		wp_register_script(
			'jquery-modernizr',
			get_template_directory_uri(). '/assets/3rd/modernizr.min.js',
			[
				'jquery',
			],
			'4.4.3',
			true
		);
		 wp_enqueue_script( 'jquery-modernizr');

        //1. load jquery swiper javascript libs
        wp_register_script(
            'jquery-swiper',
            get_template_directory_uri() . '/assets/3rd/swiper/swiper.min.js',
            [
                'jquery',
            ],
            '4.4.3',
            true
        );

        //1. load jquery swiper javascript libs
        wp_register_script(
            'jquery-magnific-popup',
            get_template_directory_uri() . '/assets/3rd/jquery.magnific-popup.min.js',
            [
                'jquery',
            ],
            '4.4.3',
            true
        );

		// 2. load isotope using for masory 
		wp_register_script(
			'jquery-isotope',
			get_template_directory_uri(). '/assets/3rd/isotope.pkgd.min.js',
			[
				'jquery',
			],
			'4.4.3',
			true
		);
		
		wp_register_style( 'magnific-popup', get_template_directory_uri() . '/assets/3rd/magnific-popup.css');
        wp_enqueue_style( 'magnific-popup');

        // 3. load preload image
        // 2. load isotope using for masory

		// load		 
		wp_enqueue_script( 'jquery-swiper' );
		wp_enqueue_script( 'jquery-magnific-popup' );
		// load script is page 
		//if( is_archive() && get_theme_mod('latehome_free_blog_archive_layout') == 'masonry' ){
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'jquery-isotope' );
		//}
		
		// check if enable elementor plugin to ovoid load duplicate css and script
		if( !latehome_free_is_elementor_activated() ){
			wp_register_style( 'swiper-style', get_template_directory_uri(). '/assets/3rd/swiper/swiper.css' );
			wp_enqueue_style( 'swiper-style');
		} else {
			wp_enqueue_script( 'jquery-smooth-scroll');
		}

        wp_register_style( 'font-awesome', get_template_directory_uri(). '/assets/css/font-awesome.min.css' );
        wp_enqueue_style( 'font-awesome');

		wp_register_script(
			'jquery-smartmenu-bs',
			get_template_directory_uri(). '/assets/3rd/smartmenu/jquery.smartmenus.bootstrap-4.js',
			[
				'jquery',
			],
			'4.4.3',
			true
		);
		// check if enable opal widget elementor plugin to ovoid load duplicate css and script
		if( !class_exists("OSF_Elementor_Loader") ) {
			wp_enqueue_script('smartmenus', get_template_directory_uri(). '/assets/3rd/smartmenu/jquery.smartmenus.js', false, true);
			wp_enqueue_script( 'jquery-smartmenu-bs' );
		} else {
			wp_register_style('opal-elementor-frontend',  get_template_directory_uri(). '/assets/css/elementor-frontend.css' );
            wp_enqueue_style( 'opal-elementor-frontend' );
		}
	}
}

add_action('wp_enqueue_scripts', 'latehome_free_3rd_scripts_styles', 1);


/**
 * Remove some duplicate lib styles
 */
function latehome_free_dequence_styles() {

    wp_deregister_style('font-awesome-icon');
    wp_deregister_style('yith-wcwl-font-awesome');
    wp_styles()->add_data('font-awesome', 'after', '');
}

add_action('wp_print_styles', 'latehome_free_dequence_styles', 1 );

/**
 * Register custom fonts.
 */
function latehome_free_fonts_url() {
	$fonts_url = '';

    /*
     * Translators: If there are characters in your language that are not
     * supported by Libre Franklin, translate this to 'off'. Do not translate
     * into your own language.
     */
    $font = esc_html_x('on', 'Global font: on or off', 'latehome_free');

    if ('off' !== $font) {
        $font_families = array();

        $font_families[] = 'Rubik:300,400,500,700,900';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}
