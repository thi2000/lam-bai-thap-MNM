<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class OSF_Elementor_Wishlist_Widget extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-wishlist';
	}

	public function get_title() {
		return __( 'Woo Wishlist Nav', 'opalelementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'opal-woo' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'cart_content',
			[
				'label' => __( 'WooCommerce Wishlist', 'opalelementor' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Choose Icon', 'opalelementor' ),
				'type' => Controls_Manager::ICON,
				'default' => 'opal-icon-wishlist',
			]
		);

		$this->add_control(
			'show_subtotal',
			[
				'label'       => __('Show Total', 'opalelementor'),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

        $this->add_control(
            'enable_label',
            [
                'label' => __( 'Enable Label', 'elementor' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

		$this->add_control(
			'title_hover',
			[
				'label' => __( 'Title Hover', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'View wishlist ', 'opalelementor' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_lable_style',
			[
				'label' => __( 'Style', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_button_colors' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => __( 'Normal', 'opalelementor' ),
			]
		);

        $this->add_responsive_control(
            'icon_fontsize',
            [
                'label' => __( 'Icon Font Size', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-header-wishlist .fa' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .fa' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'icon_bg',
			[
				'label' => __( 'Icon Background', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .fa' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .opal-header-wishlist .fa',
                'separator' => 'before',
                
            ]
        );

		$this->add_control(
            'icon_border_radius',
            [
                'label' => __( 'Border Radius', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .opal-header-wishlist .fa' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
            'icon_padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .opal-header-wishlist .fa' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'item_color',
			[
				'label' => __( 'Item Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->add_control(
			'item_background_color',
			[
				'label' => __( 'Background Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

        $this->add_control(
            'heading_hover',
            [
                'label' => __( 'Label', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __( 'Label Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .opal-header-wishlist .label' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'labe_typography',
                'selector' => '{{WRAPPER}} .opal-header-wishlist .label',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => __( 'Hover', 'opalelementor' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => __( 'Icon Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .fa:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_bg_hover',
			[
				'label' => __( 'Icon Background', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .fa:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border_hover',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .opal-header-wishlist .fa:hover',
                'separator' => 'before',
                
            ]
        );

		$this->add_control(
			'item_text_color_hover',
			[
				'label' => __( 'Item Text Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->add_control(
			'item_background_color_hover',
			[
				'label' => __( 'Background Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

		

        $this->add_control(
            'heading_label_hover',
            [
                'label' => __( 'Label', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_hover_color',
            [
                'label' => __( 'Label Hover Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .opal-header-wishlist .label:hover' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_hover_typography',
                'selector' => '{{WRAPPER}} .opal-header-wishlist .label:hover',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'heading_icon_hover',
            [
                'label' => __( 'Icon', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
		
		$this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->add_control(
            'wishlist_alignment',
            [
                'label' => __('Alignment', 'opalelementor'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'opalelementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'opalelementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'opalelementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}}',
                ],
            ]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = wp_parse_args( $this->get_settings(), array(
                'enable_label' => false,
                'icon' => ''
            ) );

		$items = '';

		if (function_exists('yith_wcwl_count_all_products')) {
			$items = '<div class="site-header-wishlist d-inline-block">';
			$items .= '<a class="opal-header-wishlist header-button" title="'. esc_attr($settings['title_hover']).'" href="'. esc_url(get_permalink(get_option('yith_wcwl_wishlist_page_id'))).'">';
			$items .= '<i class="fa '. $settings['icon'].'" aria-hidden="true"></i>';
			if($settings['show_subtotal']){
				$items .= '<span class="count">'. esc_html(yith_wcwl_count_all_products()).'</span>';
			}
			$items .= ( $settings['enable_label'] ? '<span class="label">'.__( 'Wishlist', 'opalelementor' ).'</span>' : '' );
			$items .= '</a>';
			$items .= '</div>';
		}
		echo ($items);

	}
}