<?php
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * @Class WpOpal_Customizer_Control_Style_Background_Color
 * 
 * 
 */
class  WpOpal_Customizer_Control_Style_Border_Color extends WpOpal_Customizer_Control_Style {
	public $suffix = 'border color';
	public $template = '$selector { border-color: $value; }';

	public function __construct( $group, $element ) {
		parent::__construct( $group, $element );
	}

	/**
	 * Register item with $wp_customize
	 */
	public function add_item() {
		global $wp_customize;

		$wp_customize->add_setting( $this->setting, $this->get_setting_args() );

		$control = new WP_Customize_Color_Control(
			$wp_customize,
			$this->id ,
			$this->get_control_args()
		);
		$wp_customize->add_control( $control );
	}


	public function post_message( $js='' ) {
		$selector = str_replace( "'", "\'", $this->selector );

		$js .= str_replace(
			array( '@setting@', '@selector@' ),
			array( $this->setting, $selector ),
			file_get_contents( WPOPAL_PLUGIN_DIR . '/assets/js/customize/post-message-part-border-color.js' )
		);

		return $js . PHP_EOL;
	}

	/**
	 * Return CSS based on setting value
	 */
	public function get_css(){
		$value = $this->get_element_setting_value();

		$css = '';
		if ( $value ) {
			$args = array(
				'template' => $this->template,
				'value' => $value,
			);
			$css = $this->apply_template( $args );
		}

		// Filter effects final CSS output, but not postMessage updates
		return apply_filters( 'styles_css_border_color', $css );
	}
}