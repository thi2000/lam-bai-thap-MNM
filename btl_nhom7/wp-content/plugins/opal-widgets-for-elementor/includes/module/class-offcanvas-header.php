<?php

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add Fixed Header Left Sidebar
 */	
class OSF_Elementor_Fixed_Header_Module  {

	public function __construct() {
		

		$this->add_actions();
	}

	public function get_name() {
		return 'fixed_header';
	}

	public function register_controls( Controls_Stack $element ) {

 
		if( get_post_type()  != 'header' ){
			return true; 
		}


		$element->start_controls_section(
			'section_fixed_header_effect',
			[
				'label' => __( 'Fixed Header Right Or Left', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'fixed_header',
			[
				'label' => __( 'Enable', 'opalelementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'opalelementor' ),
				'label_off' => __( 'Off', 'opalelementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,				
				'prefix_class'  => 'opalelementor-'
			]
		);
		
		$element->add_control(
			'fixed_header_notice',
			[
				'raw' => __( 'IMPORTANT: Fixed Header Right Or Left is best used with Elementor Pro fixed option enabled.', 'opalelementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition' => [
				    
					'fixed_header!' => '',
				],
			]
		);

		$element->add_control(
			'fixed_header_on',
			[
				'label' => __( 'Enable On', 'opalelementor' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => 'true',
				'default' => [ 'desktop' ],
				'options' => [
					'desktop' => __( 'Desktop', 'opalelementor' ),
					'tablet' => __( 'Tablet', 'opalelementor' )
				],
				'condition' => [
					'fixed_header!' => ''
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'fixed_header_width',
			[
				'label' => __( 'Counter width', 'opalelementor' ),
				'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range' => [
					'px' => [
						'min' => 100,
						'max' => 500,
					] 
				],
                'selectors'     => [
                	'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',          
                ],
			]
		);


		 	
		  
		$element->end_controls_section();
	}

	private function add_actions() {

		if( !function_exists('is_plugin_active') ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			
		}
		
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_controls' ] );	

		add_action( 'elementor/frontend/section/before_render', [ $this, 'before_render_section' ] );	
	}

	public function before_render_section( $section ){
		$settings = $section->get_settings_for_display();

		if(  isset($settings['fixed_header']) && $settings['fixed_header'] == 'yes' ) {
			$section->add_render_attribute( '_wrapper', 'class', 'opalelementor-header-left' );
			if( isset($settings['fixed_header_width']['size']) ) {
				$section->add_render_attribute( '_wrapper', 'data-width', $settings['fixed_header_width']['size'].$settings['fixed_header_width']['unit'] );
			}
		}
 
	}
}

new OSF_Elementor_Fixed_Header_Module();
