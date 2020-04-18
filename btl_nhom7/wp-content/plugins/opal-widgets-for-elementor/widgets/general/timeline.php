<?php

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Elementor_Timeline_Widget extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-timeline';
	}

	public function get_title() {
		return __( 'Opal Timeline', 'opalelementor' );
	}
	
	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
        return [ 'opal-addons' ];
    }

    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'imagesloaded' ];
    }

	/**
	 * Register icon list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Timeline', 'opalelementor' ),
			]
		);

        $this->add_control(
            'timelines',
            [
                'label' => __( 'Timeline Items', 'opalelementor' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'date' => __( '1/1/2017', 'opalelementor' ),
                        'heading' => __( 'Heading #1', 'opalelementor' ),
                        'description' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opalelementor' ),
                    ],
                    [
                        'date' => __( '1/1/2018', 'opalelementor' ),
                        'heading' => __( 'Heading #2', 'opalelementor' ),
                        'description' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opalelementor' ),
                    ],
                    [
                        'date' => __( '1/1/2019', 'opalelementor' ),
                        'heading' => __( 'Heading #3', 'opalelementor' ),
                        'description' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opalelementor' ),
                    ],
                ],
                'fields'      => [
                    [
                        'name' => 'date',
                        'label' => __( 'Date', 'opalelementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'd/m/Y', 'opalelementor' ),
                        'placeholder' => __( 'd/m/Y', 'opalelementor' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'heading',
                        'label' => __( 'Heading', 'opalelementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Heading', 'opalelementor' ), 
                        'label_block' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => __( 'Description', 'opalelementor' ),
                        'type' => Controls_Manager::WYSIWYG,
                        'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'opalelementor' ),
                        'label_block' => true,
                    ],
                    
                ],

                'title_field' => '{{{ date }}}',
            ]
        );

        $this->end_controls_section();

        // Style Tab.
		$this->register_cards_layout_controls();
		$this->register_spacing_style_controls();
		$this->register_cards_style_controls();
		$this->register_date_style_controls();
		$this->register_vertical_separator_style_controls();
	}

	/**
	 * Registers cards layout controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_cards_layout_controls() {
		// Timeline card starts from here.
		$this->start_controls_section(
			'section_timeline_layout',
			[
				'label' => __( 'Layout', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'timeline_align',
				[
					'label'        => __( 'Orientation', 'opalelementor' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'center',
					'options'      => [
						'left'   => [
							'title' => __( 'Left', 'opalelementor' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'opalelementor' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'opalelementor' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'render_type'  => 'template',
					'toggle'       => false,
					'prefix_class' => 'opal-timeline--',
				]
			);

			$this->add_control(
				'timeline_align_responsive',
				[
					'label'        => __( 'Responsive Support', 'opalelementor' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'tablet',
					'options'      => [
						'none'   => __( 'Inherit', 'opalelementor' ),
						'tablet' => __( 'For Tablet & Mobile', 'opalelementor' ),
						'mobile' => __( 'For Mobile', 'opalelementor' ),
					],
					'render_type'  => 'template',
					'prefix_class' => 'opal-timeline-responsive-',
					'condition'    => [
						'timeline_align' => 'center',
					],
				]
			);

			$this->add_control(
				'timeline_responsive',
				[
					'label'        => __( 'Responsive Orientation', 'opalelementor' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Right', 'opalelementor' ),
					'label_off'    => __( 'Left', 'opalelementor' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'timeline_align'             => 'center',
						'timeline_align_responsive!' => 'none',
					],
				]
			);

			// Timeline content Alignment.
			$this->add_responsive_control(
				'card_content_align',
				[
					'label'       => __( 'Content Alignment', 'opalelementor' ),
					'description' => __( 'Note: Keep above setting unselected to align content w.r.t. timeline item\'s orientation.', 'opalelementor' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => [
						'left'   => [
							'title' => __( 'Left', 'opalelementor' ),
							'icon'  => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'opalelementor' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'opalelementor' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'selectors'   => [
						'{{WRAPPER}} .opal-timeline-main .opal-day-right .opal-events-inner-new' => 'text-align: {{VALUE}};',
						'{{WRAPPER}} .opal-timeline-main .opal-day-left .opal-events-inner-new' => 'text-align: {{VALUE}};',
					],
				]
			);

			// Vertical divider arrow, date postion.
			$this->add_control(
				'timeline_arrow_position',
				[
					'label'        => __( 'Arrow Alignment', 'opalelementor' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'top'    => [
							'title' => __( 'Top', 'opalelementor' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center' => [
							'title' => __( 'Middle', 'opalelementor' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'bottom' => [
							'title' => __( 'Bottom', 'opalelementor' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'render_type'  => 'template',
					'default'      => 'center',
					'prefix_class' => 'opal-timeline-arrow-',
					'separator'    => 'after',
				]
			);

		// Timeline spacing ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers spacing controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_spacing_style_controls() {

		// Timeline spacing starts from here.
		$this->start_controls_section(
			'section_timeline_spacing',
			[
				'label' => __( 'Spacing', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Horizontal spacing between cards.
		$this->add_responsive_control(
			'timeline_horizontal_spacing',
			[
				'label'     => __( 'Horizontal Spacing', 'opalelementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 20,
						'step' => 1,
					],
				],
				'selectors' => [
					/* CENTER */
					'{{WRAPPER}}.opal-timeline--center .opal-timeline-marker' => 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px;',

					'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-marker' => 'margin-right: {{SIZE}}px; margin-left: 0;',
					'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-marker' => 'margin-right: {{SIZE}}px; margin-left: 0;',

					'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .opal-timeline-marker' => 'margin-left: {{SIZE}}px; margin-right: 0;',
					'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .opal-timeline-marker' => 'margin-left: {{SIZE}}px; margin-right: 0;',

					/* LEFT */
					'{{WRAPPER}}.opal-timeline--left .opal-timeline-marker' => 'margin-right: {{SIZE}}px;',

					/* RIGHT */
					'{{WRAPPER}}.opal-timeline--right .opal-timeline-marker' => 'margin-left: {{SIZE}}px;',
				],
			]
		);

		// Vertical spacing between cards.
		$this->add_responsive_control(
			'timeline_vertical_spacing',
			[
				'label'     => __( 'Vertical Spacing', 'opalelementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .opal-timeline-field:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
					'{{WRAPPER}} .opal-timeline-field:last-child' => 'margin-bottom: 0px;',
					// , {{WRAPPER}}.opal-timeline--center .opal-timeline-marker
				],
			]
		);

		// Heading bottom spacing.
		$this->add_responsive_control(
			'timeline_heading_spacing',
			[
				'label'     => __( 'Heading Bottom Spacing', 'opalelementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .opal-timeline-heading' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		// Heading bottom spacing.
		$this->add_responsive_control(
			'timeline_date_spacing',
			[
				'label'     => __( 'Date Bottom Spacing', 'opalelementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'condition' => [
					'timeline_align' => [ 'left', 'right' ],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .opal-date-inner .inner-date-new p' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		// Timeline spacing ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers cards style controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_cards_style_controls() {
		// Timeline card starts from here.
		$this->start_controls_section(
			'section_timeline_cards',
			[
				'label' => __( 'Timeline Items', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// New tab starts here.
		$this->start_controls_tabs( 'tabs_cards' );

		// Tab Default starts here.
		$this->start_controls_tab( 'tab_card_default', [ 'label' => __( 'DEFAULT', 'opalelementor' ) ] );

			$this->add_control(
				'timeline_heading_tag',
				[
					'label'   => __( 'Heading Tag', 'opalelementor' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'h1'  => __( 'H1', 'opalelementor' ),
						'h2'  => __( 'H2', 'opalelementor' ),
						'h3'  => __( 'H3', 'opalelementor' ),
						'h4'  => __( 'H4', 'opalelementor' ),
						'h5'  => __( 'H5', 'opalelementor' ),
						'h6'  => __( 'H6', 'opalelementor' ),
						'div' => __( 'div', 'opalelementor' ),
						'p'   => __( 'p', 'opalelementor' ),
					],
					'default' => 'h3',
				]
			);

			$this->add_control(
				'timeline_card_heading_color',
				[
					'label'     => __( 'Heading Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .opal-timeline-heading, {{WRAPPER}} .opal-timeline-main .opal-timeline-heading-text .elementor-inline-editing' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card default content text color.
			$this->add_control(
				'timeline_default_card_color',
				[
					'label'     => __( 'Description Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_3,
					],
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .opal-timeline-desc-content, {{WRAPPER}} .opal-timeline-main .inner-date-new,{{WRAPPER}} .opal-timeline-main a .opal-timeline-desc-content' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card default content typography.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'    => __( 'Heading Typograhy', 'opalelementor' ),
					'name'     => 'timeline_card_heading_typography',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .opal-timeline-main .opal-timeline-heading, {{WRAPPER}} .opal-timeline-main .opal-timeline-heading-text .elementor-inline-editing',
				]
			);

			// Timeline card default content typography.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'    => __( 'Description Typograhy', 'opalelementor' ),
					'name'     => 'timeline_default_card_typography',
					'selector' => '{{WRAPPER}} .opal-timeline-main .opal-timeline-desc-content, {{WRAPPER}} .opal-timeline-main .inner-date-new',
					'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				]
			);

			// Timeline card default background color.
			$this->add_control(
				'timeline_default_card_bg_color',
				[
					'label'     => __( 'Background Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#dddddd',
					'selectors' => [
						'{{WRAPPER}} .opal-events-inner-new' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.opal-timeline--center .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--right .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--right .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.opal-timeline--center .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.opal-timeline--right .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.opal-timeline--right .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'{{WRAPPER}}.opal-timeline--left .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--center .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--left .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.opal-timeline--left .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.opal-timeline--center .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.opal-timeline--left .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
					],
				]
			);

			$this->add_control(
				'timeline_cards_box_shadow',
				[
					'label'        => __( 'Box Shadow', 'opalelementor' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'YES', 'opalelementor' ),
					'label_off'    => __( 'NO', 'opalelementor' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);

			$this->add_control(
				'timeline_cards_box_shadow_color',
				[
					'label'     => __( 'Shadow Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0,0,0,0.5)',
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-shadow-yes .opal-events-inner-new' => 'filter: drop-shadow(0px 1px {{timeline_cards_box_shadow_blur.SIZE}}px {{VALUE}});',
						'{{WRAPPER}} .opal-timeline-shadow-yes .opal-events-inner-new' => '-webkit-filter: drop-shadow(0px 1px {{timeline_cards_box_shadow_blur.SIZE}}px {{VALUE}});',
					],
					'condition' => [
						'timeline_cards_box_shadow' => 'yes',
					],
				]
			);

			$this->add_control(
				'timeline_cards_box_shadow_blur',
				[
					'label'     => __( 'Shadow Blur Effect', 'opalelementor' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 4,
						'unit' => 'px',
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 10,
							'step' => 1,
						],
					],
					'condition' => [
						'timeline_cards_box_shadow' => 'yes',
					],
				]
			);

			// Card border radius.
			$this->add_responsive_control(
				'timeline_cards_border_radius',
				[
					'label'      => __( 'Rounded Corners', 'opalelementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => [
						'top'    => '4',
						'bottom' => '4',
						'left'   => '4',
						'right'  => '4',
						'unit'   => 'px',
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .opal-day-right .opal-events-inner-new' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .opal-day-left .opal-events-inner-new'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Item padding.
			$this->add_responsive_control(
				'timeline_cards_padding',
				[
					'label'      => __( 'Padding', 'opalelementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .opal-timeline-main .opal-day-right .opal-events-inner-new' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .opal-timeline-main .opal-day-left .opal-events-inner-new' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		// Tab card default ends.
		$this->end_controls_tab();

		// Tab Focused starts here.
		$this->start_controls_tab( 'tab_card_focused', [ 'label' => __( 'FOCUSED', 'opalelementor' ) ] );

			$this->add_control(
				'timeline_focused_heading_color',
				[
					'label'     => __( 'Heading Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .in-view .opal-timeline-heading, {{WRAPPER}} .opal-timeline-main .in-view .opal-timeline-heading-text .elementor-inline-editing' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card focused content text color.
			$this->add_control(
				'timeline_focused_card_color',
				[
					'label'     => __( 'Description Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .in-view .opal-timeline-desc-content, {{WRAPPER}} .opal-timeline-main .in-view .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);


			// Timeline card focused background color.
			$this->add_control(
				'timeline_focused_card_bg_color',
				[
					'label'     => __( 'Background Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .in-view .opal-events-inner-new' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.opal-timeline--center .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--center .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--left .in-view .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--right .in-view .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.opal-timeline--center .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.opal-timeline--center .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.opal-timeline--left .in-view .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.opal-timeline--right .in-view .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .in-view .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .in-view .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

					],
				]
			);

		// Card Focused tab ends.
		$this->end_controls_tab();

		// Tab Hover starts here.
		$this->start_controls_tab( 'tab_card_hover', [ 'label' => __( 'HOVER', 'opalelementor' ) ] );

			$this->add_control(
				'timeline_hover_heading_color',
				[
					'label'     => __( 'Heading Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .animate-border:hover .opal-timeline-heading, {{WRAPPER}} .opal-timeline-main .animate-border:hover .opal-timeline-heading-text .elementor-inline-editing' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card hover content text color.
			$this->add_control(
				'timeline_hover_card_color',
				[
					'label'     => __( 'Description Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .opal-days .animate-border:hover .opal-timeline-desc-content, {{WRAPPER}} .opal-days .animate-border:hover .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

			// Timeline card hover background color.
			$this->add_control(
				'timeline_hover_card_bg_color',
				[
					'label'     => __( 'Background Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .animate-border:hover .opal-events-inner-new' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.opal-timeline--center div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--center div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--left div.opal-timeline-main .animate-border:hover .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--right div.opal-timeline-main .animate-border:hover .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}};',

						'.rtl {{WRAPPER}}.opal-timeline--center div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'.rtl {{WRAPPER}}.opal-timeline--center div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.opal-timeline--left div.opal-timeline-main .animate-border:hover .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'.rtl {{WRAPPER}}.opal-timeline--right div.opal-timeline-main .animate-border:hover .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',
						'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-left: 13px solid {{VALUE}}; border-right: none;',

						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',

						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-right .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
						'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right div.opal-timeline-main .animate-border:hover .opal-day-left .opal-timeline-arrow:after' => 'border-right: 13px solid {{VALUE}}; border-left: none;',
					],
				]
			);

		// Tab Hover ends here.
		$this->end_controls_tab();

		// Tab card section ends here.
		$this->end_controls_tabs();

		// Timeline Cards ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers vertical separator controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_vertical_separator_style_controls() {
		// Timeline vertical divider starts from here.
		$this->start_controls_section(
			'section_timeline_middle_divider',
			[
				'label' => __( 'Connector', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Vertical divider width.
		$this->add_control(
			'timeline_separator_width',
			[
				'label'     => __( 'Connector Width', 'opalelementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 3,
				],
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					],
				],
				'selectors' => [
					// General.
					'{{WRAPPER}} .opal-timeline__line' => 'width: {{SIZE}}px;',
				],
			]
		);


		// Default Icon Background Size slider.
		$this->add_responsive_control(
			'timeline_all_icon_size',
			[
				'label'      => __( 'Background Size', 'opalelementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
					'em' => [
						'min' => 1.5,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => '3',
					'unit' => 'em',
				],
				'selectors'  => [
					'{{WRAPPER}} .opal-timeline-marker' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .opal-timeline-arrow'  => 'height: {{SIZE}}{{UNIT}};',

					'{{WRAPPER}}.opal-timeline--left .opal-timeline__line' => 'left: calc( 25% + {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}}.opal-timeline--right .opal-timeline__line' => 'right: calc( 25% + {{SIZE}}{{UNIT}} / 2 );',

					'.rtl {{WRAPPER}}.opal-timeline--left .opal-timeline__line' => 'right: calc( 25% + {{SIZE}}{{UNIT}} / 2 ); left: auto;',
					'.rtl {{WRAPPER}}.opal-timeline--right .opal-timeline__line' => 'left: calc( 25% + {{SIZE}}{{UNIT}} / 2 ); right: auto;',

					'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',
					'(tablet){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .opal-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',

					'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',
					'(tablet).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline-res-right .opal-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',

					'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',
					'(mobile){{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .opal-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',

					'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline__line' => 'right: calc( {{SIZE}}{{UNIT}} / 2 ); left: auto;',
					'(mobile).rtl {{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline-res-right .opal-timeline__line' => 'left: calc( {{SIZE}}{{UNIT}} / 2 ); right: auto;',
				],
			]
		);

		// New tab starts here.
		$this->start_controls_tabs( 'tabs_divider' );

		// Tab Default starts here.
		$this->start_controls_tab( 'tab_divider_default', [ 'label' => __( 'DEFAULT', 'opalelementor' ) ] );

			// Default vertical divider color.
			$this->add_control(
				'timeline_divider_color',
				[
					'label'     => __( 'Line Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.opal-timeline--center .opal-timeline__line' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--left .opal-timeline__line' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.opal-timeline--right .opal-timeline__line' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-tablet .opal-timeline__line' => 'background-color: {{VALUE}};',

						'{{WRAPPER}}.opal-timeline--center.opal-timeline-responsive-mobile .opal-timeline__line' => 'background-color: {{VALUE}};',
					],
				]
			);

			// Default Divider icon background color.
			$this->add_control(
				'timeline_divider_icon_bg_color',
				[
					'label'     => __( 'Background Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .animate-border .opal-timeline-marker' => 'background: {{VALUE}};',
					],
				]
			);

		// Tab Default ends.
		$this->end_controls_tab();

		// Tab Focused starts.
		$this->start_controls_tab( 'tab_divider_focused', [ 'label' => __( 'FOCUSED', 'opalelementor' ) ] );

			$this->add_control(
				'timeline_divider_scroll_color',
				[
					'label'     => __( 'Line Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .opal-timeline__line__inner' => 'background-color: {{VALUE}};width: 100%;',
					],
				]
			);

			// Focused divider icon background color.
			$this->add_control(
				'timeline_divider_icon_bg_scroll_color',
				[
					'label'     => __( 'Background Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => [
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					],
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .opal-days .in-view .in-view-timeline-icon' => 'background: {{VALUE}};',
					],
				]
			);

		// Tab Focused ends.
		$this->end_controls_tab();

		// Tab Hover starts.
		$this->start_controls_tab( 'tab_divider_hover', [ 'label' => __( 'HOVER', 'opalelementor' ) ] );

			// Hover divider icon background color.
			$this->add_control(
				'timeline_divider_icon_bg_hover_color',
				[
					'label'     => __( 'Background Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .opal-days .animate-border:hover .opal-timeline-marker' => 'background: {{VALUE}};',
					],
				]
			);

		// Tab Hover Ends.
		$this->end_controls_tab();

		// Tabs ends here.
		$this->end_controls_tabs();

		// Section Vertical Divider ends here.
		$this->end_controls_section();
	}

	/**
	 * Registers date style controls.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function register_date_style_controls() {
		// Timeline Dates starts from here.
		$this->start_controls_section(
			'section_timeline_dates',
			[
				'label' => __( 'Dates', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'date_tabs' );

		// Tab Date default starts.
		$this->start_controls_tab( 'tab_default_date', [ 'label' => __( 'DEFAULT', 'opalelementor' ) ] );

			// Timeline date typography.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'date_typography_default',
					'selector' => '{{WRAPPER}} .opal-timeline-main .inner-date-new',
				]
			);

			// Timeline date color.
			$this->add_control(
				'date_color_default',
				[
					'label'     => __( 'Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

		// Tab Date default ends.
		$this->end_controls_tab();

		// Tab Date Focused starts.
		$this->start_controls_tab( 'tab_focused_date', [ 'label' => __( 'FOCUSED', 'opalelementor' ) ] );

			// Timeline date color.
			$this->add_control(
				'date_color_focused',
				[
					'label'     => __( 'Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-days .in-view .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

		// Tab Date focused ends.
		$this->end_controls_tab();

		// Tab Date hover starts.
		$this->start_controls_tab( 'tab_hover_date', [ 'label' => __( 'HOVER', 'opalelementor' ) ] );

			// Timeline date color.
			$this->add_control(
				'date_color_hover',
				[
					'label'     => __( 'Color', 'opalelementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .opal-timeline-main .opal-days .animate-border:hover .inner-date-new' => 'color: {{VALUE}};',
					],
				]
			);

		// Tab Date hover ends.
		$this->end_controls_tab();

		// Tab Date ends.
		$this->end_controls_tabs();

		// Timeline dates ends.
		$this->end_controls_section();
	}

	/**
	 * Get alignment of timeline.
	 *
	 * Written in PHP.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function get_horizontal_aligment() {

		if ( '' === $this->get_settings( 'timeline_align' ) ) {
			return 'center';
		}

		return $this->get_settings( 'timeline_align' );
	}


	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {	
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'timeline_wrapper', 'class', 'opal-timeline-wrapper' );
		$this->add_render_attribute( 'timeline_wrapper', 'class', 'opal-timeline-node' );
		
		if ( 'yes' == $settings['timeline_responsive'] ) {
			$this->add_render_attribute( 'timeline_wrapper', 'class', 'opal-timeline-res-right' );
		}
		if ( 'yes' == $settings['timeline_cards_box_shadow'] ) {
			$this->add_render_attribute( 'timeline_main', 'class', 'opal-timeline-shadow-yes' );
		}


		$this->add_render_attribute( 'timeline_main', 'class', 'opal-timeline-main' );
		$this->add_render_attribute( 'timeline_days', 'class', 'opal-days' );
		$this->add_render_attribute( 'line', 'class', 'opal-timeline__line' );
		$this->add_render_attribute( 'line-inner', 'class', 'opal-timeline__line__inner' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'timeline_wrapper' ); ?>>
			<?php
				$count        = 0;
				$current_side = '';
			?>

			<div <?php echo $this->get_render_attribute_string( 'timeline_main' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'timeline_days' ); ?>>
					<?php foreach ( $settings['timelines'] as $index => $item ) { ?>
						<?php
						$this->add_render_attribute(
							[
								'timeline_single_content' => [ 'class' => 'opal-date' ],
							]
						);

						$heading_setting_key = $this->get_repeater_setting_key( 'timeline_single_heading', 'timelines', $index );
						$this->add_render_attribute( $heading_setting_key, 'class', 'opal-timeline-heading' );
						$this->add_inline_editing_attributes( $heading_setting_key, 'advanced' );


						$content_setting_key = $this->get_repeater_setting_key( 'timeline_heading_content', 'timelines', $index );
						$this->add_render_attribute( $content_setting_key, 'class', 'opal-timeline-desc-content' );
						$this->add_inline_editing_attributes( $content_setting_key, 'advanced' );


						$date_setting_key = $this->get_repeater_setting_key( 'date', 'timelines', $index );
						$this->add_inline_editing_attributes( $date_setting_key, 'none' );


						
						$this->add_render_attribute( 'card_' . $item['_id'], 'class', 'timeline-icon-new' );
						$this->add_render_attribute( 'card_' . $item['_id'], 'class', 'out-view-timeline-icon' );
						
						$this->add_render_attribute( 'current_' . $item['_id'], 'class', 'elementor-repeater-item-' . $item['_id'] );
						$this->add_render_attribute( 'current_' . $item['_id'], 'class', 'opal-timeline-field animate-border' );
						$this->add_render_attribute( 'current_' . $item['_id'], 'class', 'out-view' );
						$this->add_render_attribute( 'timeline_alignment' . $item['_id'], 'class', 'opal-day-new' );

						$this->add_render_attribute( 'data_alignment' . $item['_id'], 'class', 'opal-timeline-widget' );
						if ( 0 == $count % 2 ) {
							$current_side = 'Left';
						} else {
							$current_side = 'Right';
						}

						if ( 'Right' === $current_side ) {
							$this->add_render_attribute( 'timeline_alignment' . $item['_id'], 'class', 'opal-day-left' );
							$this->add_render_attribute( 'data_alignment' . $item['_id'], 'class', 'opal-timeline-left' );
						} else {
							$this->add_render_attribute( 'timeline_alignment' . $item['_id'], 'class', 'opal-day-right' );
							$this->add_render_attribute( 'data_alignment' . $item['_id'], 'class', 'opal-timeline-right' );
						}
						$this->add_render_attribute( 'timeline_events' . $item['_id'], 'class', 'opal-events-new' );
						$this->add_render_attribute( 'timeline_events_inner' . $item['_id'], 'class', 'opal-events-inner-new' );

						$this->add_render_attribute( 'timeline_content' . $item['_id'], 'class', 'opal-content' );
						?>
						<div <?php echo $this->get_render_attribute_string( 'current_' . $item['_id'] ); ?>>
							<div <?php echo $this->get_render_attribute_string( 'data_alignment' . $item['_id'] ); ?>>
								<?php if ( 'left' == $settings['timeline_align'] ) { ?>
									<div class="opal-timeline-info">
										<?php
										if ( '' !== $item['date'] ) {
											?>
											<div class="opal-timeline-date-hide opal-date-inner"><div class="inner-date-new"><p <?php echo $this->get_render_attribute_string( $date_setting_key ); ?>><?php echo $item['date']; ?></p></div>
											</div>
										<?php } ?>

										<?php
										if ( '' !== $item['heading'] ) {
											?>
										<div class="opal-timeline-heading-text">
											<<?php echo $settings['timeline_heading_tag']; ?> <?php echo $this->get_render_attribute_string( $heading_setting_key ); ?>><?php echo $this->parse_text_editor( $item['heading'] ); ?></<?php echo $settings['timeline_heading_tag']; ?>>
										</div>
										<?php } ?>
									</div>
								<?php } ?>

								<div class="opal-timeline-marker">
									<i <?php echo $this->get_render_attribute_string( 'card_' . $item['_id'] ); ?>></i>
								</div>

								<div <?php echo $this->get_render_attribute_string( 'timeline_alignment' . $item['_id'] ); ?>>
									<div <?php echo $this->get_render_attribute_string( 'timeline_events' . $item['_id'] ); ?>>
										
										<div <?php echo $this->get_render_attribute_string( 'timeline_events_inner' . $item['_id'] ); ?>>
											
											<div <?php echo $this->get_render_attribute_string( 'timeline_content' . $item['_id'] ); ?>>	
												<?php if ( 'center' == $settings['timeline_align'] ) { ?>
													<?php
													if ( '' !== $item['heading'] ) {
														?>
													<div class="opal-timeline-heading-text">
														<<?php echo $settings['timeline_heading_tag']; ?> <?php echo $this->get_render_attribute_string( $heading_setting_key ); ?>><?php echo $this->parse_text_editor( $item['heading'] ); ?></<?php echo $settings['timeline_heading_tag']; ?>>
													</div>
													<?php } ?>
												<?php } ?>
												<?php
												if ( '' !== $item['description'] ) {
													?>
													<div <?php echo $this->get_render_attribute_string( $content_setting_key ); ?>><?php echo $this->parse_text_editor( $item['description'] ); ?></div>

												<?php } ?>
											</div>
											<div class="opal-timeline-arrow"></div>
										</div>
										
									</div>
								</div>
								<?php if ( 'right' == $settings['timeline_align'] ) { ?>
									<div class="opal-timeline-info">
										<?php
										if ( '' !== $item['date'] ) {
											?>
											<div class="opal-timeline-date-hide opal-date-inner"><div class="inner-date-new"><p <?php echo $this->get_render_attribute_string( $date_setting_key ); ?>><?php echo $item['date']; ?></p></div>
											</div>
										<?php } ?>

										<?php
										if ( '' !== $item['heading'] ) {
											?>
										<div class="opal-timeline-heading-text">
											<<?php echo $settings['timeline_heading_tag']; ?> <?php echo $this->get_render_attribute_string( $heading_setting_key ); ?>><?php echo $this->parse_text_editor( $item['heading'] ); ?></<?php echo $settings['timeline_heading_tag']; ?>>
										</div>
										<?php } ?>
									</div>
								<?php } ?>

								<?php if ( 'center' == $settings['timeline_align'] ) { ?>
									<div class="opal-timeline-date-new">
										<div class="opal-date-new">
											<div class="inner-date-new">
												<div <?php echo $this->get_render_attribute_string( $date_setting_key ); ?>><?php echo $item['date']; ?></div>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php ++$count; ?>
					<?php } ?>
				</div>		
				<div <?php echo $this->get_render_attribute_string( 'line' ); ?>>
					<div <?php echo $this->get_render_attribute_string( 'line-inner' ); ?>></div>
				</div>
			</div>
		</div>


		<?php
	}

	/**
	 * Render icon list widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
	
	}
}
