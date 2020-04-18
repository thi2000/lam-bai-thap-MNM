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

abstract class WpOpal_Customizer_Control_Style {

	public $group_priority = 1;

	/**
	 * Default setting value 
	 */
	public $default = '';

	// From $element
	public $selector;
	public $type;    
	public $label;   
	public $priority;
	public $id;      
	public $setting; 
	
	/**
	 * Template CSS for $selector and $value to be filled into
	 *
	 * @var string
	 **/
	public $template;

	public function __construct( $group, $element) {
		$this->group = $group;
		$this->element = $element;

		if ( !empty( $element['template'] ) ) {
			$this->template = $element['template'];
		}

		if ( !empty( $element['default'] ) ) {
			$this->default = $element['default'];
		}
	
		foreach( array( 'selector', 'type', 'label', 'priority' ) as $key ) {
			if ( isset( $element[$key] ) ) {
				$this->$key = $element[$key];
			}
		}
		 
		$this->maybe_add_important_to_template();  
		
		$this->id       = $this->get_element_id(); // must call append_suffix_to_label first

		$this->setting  = $this->id;// $this->get_setting_id(); // must call append_suffix_to_label first
 

		if ( empty( $this->selector ) ) { return false; }


		// postMessage javascript callback
		if ( 'postMessage' == $this->get_transport() ) {  
			add_filter( 'wpopal_customize_preview', array( $this, 'post_message' ) );
		}

	}

	/**
	 * Register control and setting with $wp_customize
	 * @return null
	 */
	abstract public function add_item();

	/**
	 * Return args passed into $wp_customize->add_control()
	 * @return array
	 */
	public function get_control_args() {
		$args = array(
			'label'    => __( $this->label, 'styles' ),
			'section'  => $this->group,
			'settings' => $this->setting,
			'priority' => $this->priority . $this->group_priority,
		);
		return $args;
	}

	/**
	 * Return args passed into $wp_customize->add_control()
	 * @return array
	 */
	public function get_setting_args( $subsetting = null ) {
		$default = null;
		if ( ! empty( $subsetting ) ) {
			if ( isset( $this->default[$subsetting] ) ) {
				$default = $this->default[$subsetting];
			}
		}
		else if ( ! is_array( $this->default ) ) {
			$default = $this->default;
		}
		$args = array(
			'default'    => $default,
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
			'transport'  => $this->get_transport(),
		);
		return $args;
	}
 	
 	/**
 	 *
 	 */
 	public function get_element_setting_value() {

		$value = get_theme_mod(  $this->id );
 
		if ( !empty( $value ) ) {
			return $value;
		}else {
			return false;
		}
		
	}


	/**
	 * @param array $element Values related to this control, like CSS selector and control type
	 * @return string Unique, sanatized ID for this element based on label and type
	 */
	public function get_element_id() {
		if( isset($this->element["id"]) ){
			return $this->element['id'];
		}
		$key = trim( sanitize_key( $this->label . '_' . $this->type ), '_' );
		return str_replace( '-', '_', $key );
	}

 

	public function get_transport() {  
		$transport = 'refresh';

		if ( 
			method_exists( $this, 'post_message' ) 
			&& empty( $this->element['template'] ) // No custom CSS template set
			&& false == strpos( $this->selector, ':' ) // jQuery doesn't understand pseudo-selectors like :hover and :focus
		) {
			// postMessage supported
			$transport = 'postMessage';
		}

		return $transport;
	}

	/**
	 * If important is set to "true" in the element JSON, 
	 * add !important to CSS template
	 */
	public function maybe_add_important_to_template() {
		if ( isset( $this->element['important'] ) && !empty( $this->element['important'] ) ) {
			$this->template = str_replace( ';', ' !important;', $this->template );			
		}
	}
 	
 	public function apply_template( $args ) {

		$template = $args['template'];
		unset( $args['template'] );


		foreach ( $args as $key => $value ) {
			$template = str_replace( '$'.$key, $value, $template );
		}

		$template = str_replace( '$selector', $this->selector, $template );

		return $template;
	}

	/**
	 * Convert CSS selector into jQuery-compatible selector
	 */
	public function jquery_selector() {
		$selector = str_replace( "'", "\'", $this->selector );

		return $selector;
	}
	

}