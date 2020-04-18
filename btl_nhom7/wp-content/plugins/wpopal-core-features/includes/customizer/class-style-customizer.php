<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalsingleproperty
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) $date$ wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;
	
	/**
	 *
	 *
	 */
	class WpOpal_Style_Customizer {

		protected $css; 
		protected $settings; 
		protected $selectors; 

		function __construct( ) {
 			
 			add_action( 'customize_register', array( $this, 'init_customize_control' ), 1 ); 
 
			add_action( 'customize_register', array( $this, 'add_panels' ), 10 );
			add_action( 'customize_preview_init',  array( $this, 'customize_preview_init' ) );

			// Load settings from various sources with filters
			add_filter( 'wpopal_customizer_json_files', array( $this, 'load_settings_from_base' ), 50 );
			add_action( 'customize_save_after', array( $this, 'customize_save_after' ) );

			add_action( 'wp_head', array( $this, 'wp_head' ), 1000 );
		 	

		 	add_action('admin_enqueue_scripts', array($this, 'load_3d_scripts'), 999);
       		add_action('customize_controls_enqueue_scripts', array($this, 'init_panel_customize_js'));

       		// Elementor Fix Noitice
       		add_action('after_switch_theme', array($this, 'set_elementor_option'));
	        add_action('customize_save_after', array($this, 'set_elementor_option'));

	        add_action('init', array($this, 'setup_global_css'));
		}

		/**
		 * Output <style> tag in head.
		 *
		 * For dynamic CSS, this is much faster than using a <link> tag, which would reload WordPress.
		 * @see http://stylesplugin.com/our-first-review
		 */
		public function wp_head() {
			echo implode( PHP_EOL, array(
				'',
				'<!-- Styles cached and displayed inline for speed -->',
				'<style type="text/css" id="wpopal-customize-css">',
				$this->get_css(),
				'</style>',
				'',
			));
		}

		public function setup_global_css() {
        if (!get_transient('opal-customizer-update-color')) {
            return;
        }	
	    if (function_exists('elementor_load_plugin_textdomain')){
	        delete_transient('opal-customizer-update-color');
		        $global = new Elementor\Core\Files\CSS\Global_CSS('global.css');
		        $global->update_file();

		    }
		}

	    public function set_elementor_option() {  

	        $color_primary   = get_theme_mod('primary_color_hue', '#0160b4');
	        $color_secondary = get_theme_mod('secondary_color_hue', '#00c484');
	        $body_color      = get_theme_mod('body_color_hue', '#222222');
	        $options 		 = get_option('elementor_scheme_color'); 

	       	if( is_array($options) ) { 
		        $scheme_colors   = array_values( $options );
		        if ($color_primary != $scheme_colors[0] || $color_secondary != $scheme_colors[1] || $body_color != $scheme_colors[2]) {
		            update_option('elementor_scheme_color', [
		                '1' => $color_primary,
		                '2' => $color_secondary,
		                '3' => $body_color,
		                '4' => $scheme_colors[3],
		            ]);
		            set_transient('opal-customizer-update-color', true, MINUTE_IN_SECONDS);
		        }
		    }
	    }

    	
		/**
		 *
		 *
		 */
		public function init_css() {
			if ( !is_a( $this->css, 'Styles_CSS') ) {

				require_once dirname( __FILE__ ) . '/class-style-control.php';
				require_once dirname( __FILE__ ) . '/class-style-css.php';

				$this->css = WpOpal_Style_Css::get_instance( $this );
			}
		}

		public function customize_save_after () {
			return $this->get_css();
		}
		
		/**
		 * Build css cache made by settings and save in theme option
		 *
		 */
		public function get_css() {
			global $wp_customize;

			$css = false;

			if ( empty( $wp_customize ) ) {  
				$css =   get_theme_mod( 'wpopal_customize_css' ); 
			}	

			if ( !empty( $wp_customize ) || empty( $css ) || apply_filters( 'wpopal_customize_force_rebuild', false ) ) {
				// Rebuild
				$settings = $this->get_settings(); 
				$this->init_css();
				return $this->css->get_css( $settings );
			}else {
				return $css;
			}
		}

		/**
		 * Render cached scripts using to preview anything while changing value of options
		 *
		 */
		public function customize_preview_init() { 
			add_action( 'wp_footer', array( $this, 'preview_js' ) );
		}

		/**
		 * Output javascript for WP Customizer preview postMessage transport
		 */
		public function preview_js() {
			// Ensure dependencies have been output by now.
			wp_print_scripts( array( 'jquery', 'customize-preview' ) );

			?> 
			<script>
				( function( $ ){

					<?php echo apply_filters( 'wpopal_customize_preview', '' ) ; ?>

				} )( jQuery );
			</script>
			<?php
		}


		/**
	     * @return void
	     */
	    public function init_customize_control() {  
	    	
	    	require_once('class-style-control.php');
            /** inject:customize_control */
	        require_once 'control/background-position.php';
			require_once 'control/button-group.php';
			require_once 'control/button-move.php';
			require_once 'control/button-switch.php';
			require_once 'control/color.php';
			require_once 'control/editor.php';
			require_once 'control/font-style.php';
 
			require_once 'control/google-font.php';
		 
			require_once 'control/heading.php';
			require_once 'control/image-select.php';
			require_once 'control/sidebar.php';
			require_once 'control/slider.php';


     
	    }

	    /**
	     * Get override selector setting data
	     */
	    public static function get_selector_data( $selectors ){
	    	$json_file = WPOPAL_PLUGIN_DIR . 'includes/customizer/settings/selector/selector.json';
	   	 	$selectors = self::load_settings_from_json_file( $json_file, $selectors ); 	
	   	 	return $selectors; 	
	    }

		/**
		 * Load settings as JSON either from transient / API or theme file
		 *
		 * @return array
		 */
		public function get_settings() {

			if ( !empty( $this->settings ) ) {
				return $this->settings;
			}

			$this->selectors = self::get_selector_data( $this->selectors );
			foreach( (array) apply_filters( 'wpopal_customizer_json_files', array() ) as $json_file ) {
				$this->settings = self::load_settings_from_json_file( $json_file, $this->settings );
			}


			// echo '<Pre>' . print_r( $this->settings ,1 ); die; 

			return apply_filters( 'wpopal_customizer_settings', $this->settings );
		}

		/**
		 * Display customizer settings panels from json files, as default load setting from the plugin.
		 *
		 * @return avoid 
		 */ 
		public function add_panels( $wp_customize ) { 
			global $wp_customize;

			$i = 950; 
			foreach ( (array) $this->get_settings() as $panel => $sections ) {
				$i++;
				 
				$_panel = preg_replace( "#\s+#", "_", trim(strtolower( $panel ) ) ); 

				
				$wp_customize->add_panel( $_panel, array(
		            'title'          => $panel,
		            'capability'     => 'edit_theme_options',
		            'priority'       => 1,
		        ));
				 
				$this->add_sections( $_panel, $sections, $wp_customize ); 
			}


	 		
		}

		/**
		 *
		 *
		 */ 
		public function add_sections( $_panel, $sections, $wp_customize ) {  
			global $wp_customize;

			$i = 10;
			foreach ( (array) $sections as $group => $elements ) {
				$i++;
				$_section =  preg_replace( "#\s+#", "_", $_panel."_".trim(strtolower( $group ) ) ); 
				$wp_customize->add_section(  $_section, array(
		            'title'          => $group,
		            'capability'     => 'edit_theme_options',
		            'panel'          => $_panel, 
		            'priority'       => $i, 
		        ) );

				$this->add_items( $_section, $elements, $wp_customize, true, $_panel );
			}

		}

		/**
		 * add control item with override setting selectors class and automatic set id with prefix.
		 *
		 */
		public function add_items( $_section, $elements, $wp_customize, $add_item=true, $_panel) {
			static $i;


			foreach ( (array) $elements as $key => $element ) {
				$i++;
				$element['priority'] = $i;
			 	
			 	if( isset($element['id']) )	{
			 		$element['id'] = $_panel.'_'.$element['id'];	
			 	} 


 				if( isset($element['selector_key']) ){
 					$key = $element['selector_key']; 
 					if( isset($this->selectors[$key]) ){
 					 	$element['selector'] = $this->selectors[$key];
 					}
 				}

				if ( $class = self::get_element_class( $element ) ) {
					$control = new $class( $_section, $element );
					if ( $add_item ) {
						$control->add_item();
					}
					$this->controls[] = $control;
				} 
			}
 	

		}

		/**
		 * Return name of static class for Customizer Control based on "type"
		 */
		public static function get_element_class( $element ) {

			if ( empty( $element['type'] ) ) { return false; }
			$type = self::sanitize_type( $element['type'] );

			// e.g., Styles_Control_Background_Color
			$class = "WpOpal_Customizer_Control_Style_$type"; 

			if ( class_exists( $class ) ) {  
				return $class;
			}else {
				$file = dirname( __FILE__ ) . '/control/' . strtolower( str_replace('_', '-', $type ) ) . '.php';   
				if ( file_exists( $file ) ) {
					include $file;
					return $class;
				}else {
					// trigger_error( 'Could not find class ' . $class, E_USER_ERROR );
					return false;
				}
			}
		}

		static public function sanitize_type( $type ) {
			$type = str_replace( array('-', '_'), ' ', $type );
			$type = ucwords( $type );
			$type = str_replace( ' ', '_', $type );
			return $type;
		}
		/**
		 * Load settings from theme file formatted as JSON
		 */
		public function load_settings_from_theme( $json_files ) {
			$json_files[] = get_stylesheet_directory() . '/customize.json';
			return $json_files;
		}

		/**
		 * Load settings from theme file formatted as JSON
		 */
		public function load_settings_from_base( $json_files ) {
			$json_files['typography'] = WPOPAL_PLUGIN_DIR . 'includes/customizer/settings/typography.json';
			$json_files['layout'] = WPOPAL_PLUGIN_DIR . 'includes/customizer/settings/layout.json';
			$json_files['color'] = WPOPAL_PLUGIN_DIR . 'includes/customizer/settings/color.json';
			$json_files['button'] = WPOPAL_PLUGIN_DIR . 'includes/customizer/settings/button.json';
			return $json_files;
		}


		/**
		 *
		 */
		public static function load_settings_from_json_file( $json_file, $default_settings = array() ) {
			$settings = array();
			if ( file_exists( $json_file ) ) {
				$json =  preg_replace('!/\*.*?\*/!s', '', file_get_contents( $json_file ) ); // strip comments before decoding
				$settings = json_decode( $json, true );

				if ( $json_error = self::get_json_error( $json_file, $settings ) ) {
					wp_die( $json_error );
				}
			}

			if( !is_array($default_settings) ){
				$default_settings = array();
			}
			return array_merge_recursive( $settings, $default_settings );
		}

		/**
		 *
		 *
		 */
		public static function get_json_error( $json_file, $json_result ) {
			$path = str_replace( ABSPATH, '', $json_file );
			$url = site_url( $path );
			
			$syntax_error = 'Malformed JSON. Check for errors. PHP <a href="http://php.net/manual/en/function.json-decode.php" target="_blank">json_decode</a> does not support comments or trailing commas.';
			$template = '<h3>JSON error</h3>%s<p>Please check <code><a href="%s" target="_blank">%s</a></code></p>';

			// PHP 5.2
			if ( !function_exists( 'json_last_error' ) ) {
				if ( null == $json_result ) {
					return sprintf( $template, $syntax_error, $url, $path );
				}
				return false;
			}
			
			// PHP 5.3+
			switch ( json_last_error() ) {
				case JSON_ERROR_NONE:           return false; break;
				case JSON_ERROR_DEPTH:          $error = 'Maximum stack depth exceeded.'; break;
				case JSON_ERROR_STATE_MISMATCH: $error = 'Underflow or the modes mismatch.'; break;
				case JSON_ERROR_CTRL_CHAR:      $error = 'Unexpected control character.'; break;
				case JSON_ERROR_SYNTAX:         $error = $syntax_error; break;
				case JSON_ERROR_UTF8:           $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.'; break;
				default:                        $error = 'Unknown JSON error.'; break;
			}

			return sprintf( $template, $error, $url, $path );
		}

	    /**
	     * Load customizer js using for editing
	     */
	    public function init_panel_customize_js() { 
	        wp_enqueue_script(
	            'wpopal-admin-customize',
	            WPOPAL_PLUGIN_URI . 'assets/js/customizer.js',
	            array('jquery'),
	            null,
	            true
	        );
	    }

	    /**
	     * Load 3rd javascripts 
	     * @return void
	     */
	    public function load_3d_scripts($hook) {
	        global $post;
	        
	        if ($hook === 'widgets.php') {
	            wp_enqueue_script(
	                'wpopal-admin-color',
	                WPOPAL_PLUGIN_URI . 'assets/3rd-party/alpha-color-picker/alpha-color-picker.js',
	                array('jquery'),
	                null,
	                true
	            );
	        }

	        wp_enqueue_script(
	            'wpopal-admin-select2',
	            WPOPAL_PLUGIN_URI . 'assets/3rd-party/select2/select2.js',
	            array('jquery'),
	            null,
	            true
	        );

	        wp_enqueue_style('wpopal-admin-style',
	            WPOPAL_PLUGIN_URI . 'assets/css/admin.min.css');
	    }
	}

	new WpOpal_Style_Customizer();
?>