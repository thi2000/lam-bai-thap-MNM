<?php

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor counter widget.
 *
 * Elementor widget that displays stats and numbers in an escalating manner.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Counter_Widget extends Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve counter widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */

	public function get_name() {
		return 'opal-counter';
	}

	public function get_title() {
		return __( 'Opal Counter', 'opalopalelementor' );
	}
	
	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
        return [ 'opal-addons' ];
    }
	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'countimator', 'handlebars' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'counter' ];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_counter',
			[
				'label' => __( 'Counter', 'opalelementor' ),
			]
		);

		$this->add_control(
			'max_number',
			[
				'label' => __( 'Max Number', 'opalelementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
			]
		);

		$this->add_control(
			'ending_number',
			[
				'label' => __( 'Ending Number', 'opalelementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
			]
		);

		$this->add_control(
			'prefix',
			[
				'label' => __( 'Number Prefix', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => 1,
			]
		);

		$this->add_control(
			'suffix',
			[
				'label' => __( 'Number Suffix', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Plus', 'opalelementor' ),
				'selector' => [ 
					'{{WRAPPER}} .counter-wheel-content:after' => 'content: "{{VALUE}}";',
				],
			]
		);

		$this->add_control(
			'duration',
			[
				'label' => __( 'Animation Duration', 'opalelementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1400,
				'min' => 100,
				'step' => 100,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Cool Number', 'opalelementor' ),
				'placeholder' => __( 'Cool Number', 'opalelementor' ),
			]
		);
		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'opalelementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'opalelementor' ),
			]
		);


		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'opalelementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_responsive_control(
			'counter_align',
			[
				'label' => __( 'Alignment', 'opalelementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'opalelementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'opalelementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'opalelementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_advanced',
			[
				'label' => __( 'Advanced', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'counter_width',
			[
				'label' => __( 'Counter width', 'opalelementor' ),
				'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em'],
                'range' => [
					'px' => [
						'min' => 25,
						'max' => 300,
					],
					'em' => [
						'min' => 5,
						'max' => 50,
					],
				],
                'selectors'     => [
                	'{{WRAPPER}} .counter-wheel' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',          
                ],
			]
		);

		$this->add_control(
			'counter_background',
			[
				'label' => __( 'Background', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-wheel' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-wheel' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'             => esc_html('Shadow','opalelementor'),
                'name'              => 'counter_shadow',
                'selector'          => '{{WRAPPER}} .counter-wheel',
            ]
        );

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border width', 'opalelementor' ),
				'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em'],
                'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
				],
                'selectors'     => [
                	'{{WRAPPER}} .counter-wheel' => 'padding: {{SIZE}}{{UNIT}};',          
                ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number',
			[
				'label' => __( 'Number', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => __( 'Text Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .counter-wheel-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_number',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .counter-wheel-content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .counter-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .counter-title',
			]
		);

		$this->add_responsive_control(
            'text_margin',
            [
                'label' => __( 'Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_description',
			[

				'label' => __( 'Description', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .counter-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_description',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .counter-description',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render counter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="opal-counter">
			<div class="counter counter-wheel" data-duration="{{settings.duration}}" data-style="wheel" data-max="{{settings.max_number}}" data-value="{{ settings.ending_number }}" data-count="0"  data-pad="{{ settings.prefix }}">0</div>
			<# if ( settings.title ) {
				#><div class="counter-title">{{{ settings.title }}}</div><#
			} #>
			<# if ( settings.description ) {
				#><div class="counter-description">{{{ settings.description }}}</div><#
			} #>
			
		</div>
		<?php
	}
	/**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$ending_number = $settings['ending_number'];
		$max_number = $settings['max_number'];
		$prefix = $settings['prefix'];
		$suffix = $settings['suffix'];
		$duration = $settings['duration'];
		
		?>
		<div class="opal-counter">
			<div class="counter counter-wheel" data-duration="<?php echo esc_attr($duration);?>" data-style="wheel" data-max="<?php echo esc_attr($max_number);?>" data-value="<?php echo esc_attr($ending_number);?>" data-count="0"  data-pad="<?php echo esc_attr($prefix);?>" data-template="{{count}}<?php echo esc_attr($suffix);?>">0</div>
			<div class="counter-content">
				<?php if ( $settings['title'] ) : ?>
					<h4 class="counter-title"><?php echo $settings['title']; ?></h4>
				<?php endif; ?>
				<?php if ( $settings['description'] ) : ?>
					<div class="counter-description"><?php echo $settings['description']; ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
