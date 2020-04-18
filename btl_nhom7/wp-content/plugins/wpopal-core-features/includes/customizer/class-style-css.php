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

class WpOpal_Style_Css {
 	

 	public $selectors = array();
	/**
	 * @import declarations to be added to top of CSS
	 *
	 * @var string
	 */
	public $google_fonts = array();

	/**
	 * get instance of this
	 */
	public static function get_instance(){ 
		static $_instance; 
		if( !$_instance ){  
			$_instance = new self();
		}
		return $_instance; 
	}
 

	/**
	 * Rebuild CSS
	 *
	 * Cache check called in Styles_Plugin::get_css to avoid initializing this class
	 */
	public function get_css( $settings ) {   
		
		global $wp_customize;

		$css = '';
	
 
		$this->selectors =   WpOpal_Style_Customizer::get_selector_data( $this->selectors );
 
		foreach ($settings as $panel => $sections ) {
		
			foreach ( $sections as $group => $elements ) {
				foreach ( $elements as $element ) {
					if ( $class = WpOpal_Style_Customizer::get_element_class( $element ) ) {
			 			if( method_exists($class, "get_css")){ 

			 				$_panel = preg_replace( "#\s+#", "_", trim(strtolower( $panel ) ) ); 
			 				if( isset($element['id']) )	{
						 		$element['id'] = $_panel.'_'.$element['id'];	
						 	} 

			 				if( isset($element['selector_key']) ){
			 					$key = $element['selector_key']; 
			 					if( isset($this->selectors[$key]) ){
			 					 	$element['selector'] = $this->selectors[$key];
			 					}
			 				}

							$control = new $class( $group, $element );

							$css .= $control->get_css();
			 			} else {
			 				// echo $class; die;
			 			}
					}
				}
			}
		}
		
		 
		$css = apply_filters( 'wpopal_customize_css_output', $css );
		
		if( $css ) {
			
			$css = implode( '', $this->google_fonts ) .$this->minify( $css ); 
	
			if( empty($css) ){
				$css = ' body {} ';
			}   

			set_theme_mod(  "wpopal_customize_css", $css );
		
			return $css;
		}
	}

	/**
	 * Minimize CSS output using CSS Tidy.
	 * 
	 * @see styles_css_output filter
	 * @author JetPack by Automattic
	 */
	public function minify( $css ) {
		// Allow minification to be disabled with add_filter( 'styles_minify_css', '__return_false' );
		if ( !apply_filters( 'styles_minify_css', true ) ) {
			return $css;
		}

		if ( !class_exists( 'csstidy') ) {
			include dirname( __FILE__ ) . '/csstidy/class.csstidy.php';
		}

		$csstidy = new csstidy();
		$csstidy->optimize = new csstidy_optimise( $csstidy );

		$csstidy->set_cfg( 'remove_bslash',              false );
		$csstidy->set_cfg( 'compress_colors',            true );
		$csstidy->set_cfg( 'compress_font-weight',       true );
		$csstidy->set_cfg( 'remove_last_;',              true );
		$csstidy->set_cfg( 'case_properties',            true );
		$csstidy->set_cfg( 'discard_invalid_properties', true );
		$csstidy->set_cfg( 'css_level',                  'CSS3.0' );
		$csstidy->set_cfg( 'template',                   'highest');
		$csstidy->parse( $css );

		$css = $csstidy->print->plain();

		return $css;
	}

}
