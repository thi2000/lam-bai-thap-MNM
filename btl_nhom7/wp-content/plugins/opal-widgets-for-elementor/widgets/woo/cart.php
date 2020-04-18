<?php

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class OSF_Elementor_Cart_Widget extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-cart';
	}

	public function get_title() {
		return __( 'Woo Mini Cart', 'opalelementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_script_depends() {
        return [
            'wpopal-offcanvas'
        ];
    }
    
	public function get_categories() {
		return [ 'opal-woo' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'cart_content',
			[
				'label' => __( 'WooCommerce Cart', 'opalelementor' ),
			]
		);


		$this->add_control(
			'fixed_content_cart',
			[
				'label'       => __('Show Fixed Content Right', 'opalelementor'),
				'type'        => Controls_Manager::SWITCHER,
				'default'	  => 'no',
			]
		);



		$this->add_control(
			'icon',
			[
				'label' => __( 'Choose Icon', 'opalelementor' ),
				'type' => Controls_Manager::ICON,
				'default' => 'opal-icon-cart',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Or Choose Image/SVG', 'opalelementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Shopping cart', 'opalelementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_hover',
			[
				'label' => __( 'Title Hover', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'View your shopping cart', 'opalelementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_items',
			[
				'label'       => __('Show Total Items', 'opalelementor'),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_subtotal',
			[
				'label'       => __('Show Subtotal', 'opalelementor'),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'style_circle',
			[
				'label'       => __('Circle Style', 'opalelementor'),
				'type'        => Controls_Manager::SWITCHER,
				'default'	  => 'no',
			]
		);

		$this->add_control(
            'alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}}',
                ],
                
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

		$this->add_control(
            'title_heading_circle',
            [
                'label' => __( 'Circle', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
					'style_circle' => 'yes',
				],
            ]
        );

		$this->add_control(
	        'circle_size',
	        [
	            'label' => __( 'Circle Size', 'opalelementor' ),
	            'type' => Controls_Manager::SLIDER,
	            'default' => [
	                'size' => 50,
	            ],
	            'range' => [
	                'px' => [
	                    'min' => 25,
	                ],
	            ],
	            'selectors' => [
	                '{{WRAPPER}} .cart-contents .icon_img, .cart-contents i' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
	            ],
	            'condition' => [
					'style_circle' => 'yes',
				],
	        ]
	    );

        $this->add_control(
			'circle_bg_color',
			[
				'label' => __( 'Background Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .cart-contents .icon_img, .cart-contents i' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'style_circle' => 'yes',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'circle_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .cart-contents .icon_img, .cart-contents i',
                'separator' => 'before',
                'condition' => [
					'style_circle' => 'yes',
				],
            ]
        );

		$this->add_control(
            'circle_border_radius',
            [
                'label' => __( 'Border Radius', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .cart-contents .icon_img, .cart-contents i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
					'style_circle' => 'yes',
				],
            ]
        );

		$this->add_control(
            'title_heading_icon',
            [
                'label' => __( 'Icon', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart-contents i' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
	        'icon_size',
	        [
	            'label' => __( 'Icon Size', 'opalelementor' ),
	            'type' => Controls_Manager::SLIDER,
	            'default' => [
	                'size' => 24,
	            ],
	            'range' => [
	                'px' => [
	                    'min' => 6,
	                ],
	            ],
	            'selectors' => [
	                '{{WRAPPER}} .cart-contents i' => 'font-size: {{SIZE}}{{UNIT}};',
	                '{{WRAPPER}} .cart-contents .icon_img svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
	                '{{WRAPPER}} .cart-contents .icon_img img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
	            ],
	        ]
	    );

		$this->add_control(
            'title_heading_counter',
            [
                'label' => __( 'Counter', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
					'show_items' => 'yes',
				],
            ]

        );

		$this->add_control(
			'item_color',
			[
				'label' => __( 'Counter Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .cart-contents .count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_items' => 'yes',
				],
			]
		);

		$this->add_control(
			'item_bg_color',
			[
				'label' => __( 'Counter Background Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .cart-contents .count' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_items' => 'yes',
				],
			]
		);

		$this->add_control(
            'title_heading_amount',
            [
                'label' => __( 'Amount', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
					'show_subtotal' => 'yes',
				],
            ]
        );

        $this->add_control(
            'amount_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .header-button .amount' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'condition' => [
					'show_subtotal' => 'yes',
				],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'amount_typography',
                'selector' => '{{WRAPPER}} .header-button .amount',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'condition' => [
					'show_subtotal' => 'yes',
				],
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => __( 'Label', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cart-contents .title' => 'color: {{VALUE}};',
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
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .cart-contents .title',
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
            'title_heading_circle_hover',
            [
                'label' => __( 'Circle', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
					'style_circle' => 'yes',
				],
            ]
        );

        $this->add_control(
			'circle_bg_color_hover',
			[
				'label' => __( 'Background Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .cart-contents .icon_img:hover, .cart-contents i:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'style_circle' => 'yes',
				],
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'circle_border_hover',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .cart-contents .icon_img:hover, .cart-contents i:hover',
                'separator' => 'before',
                'condition' => [
					'style_circle' => 'yes',
				],
            ]
        );

		$this->add_control(
            'title_heading_icon_hover',
            [
                'label' => __( 'Icon', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'icon_color_hover',
			[
				'label' => __( 'Icon Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart-contents i:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
            'title_heading_counter_hover',
            [
                'label' => __( 'Counter', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
					'show_items' => 'yes',
				],
            ]
        );

		$this->add_control(
			'item_text_color_hover',
			[
				'label' => __( 'Counter Hover Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart-contents .count:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_items' => 'yes',
				],
			]
		);

		$this->add_control(
			'item_background_color_hover',
			[
				'label' => __( 'Counter Hover Background Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cart-contents .count:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_items' => 'yes',
				],
			]
		);

		$this->add_control(
            'title_heading_amount_hover',
            [
                'label' => __( 'Amount', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
					'show_subtotal' => 'yes',
				],
            ]
        );

		$this->add_control(
			'amount_hover_color',
			[
				'label' => __( 'Amount Hover Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .header-button .amount:hover' => 'color: {{VALUE}}',
				],
			]
		);


        $this->add_control(
            'title_heading_hover',
            [
                'label' => __( 'Label', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => __( 'Title Hover Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cart-contents .title:hover' => 'color: {{VALUE}};',
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
                'name' => 'title_typography_hover',
                'selector' => '{{WRAPPER}} .cart-contents .title:hover',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _render_image_icon( $settings ){
        $image_html = '';
   
        if(!empty($settings['image']['url'])){
            $image_url = $settings['image']['url']; 
            $path_parts = pathinfo($image_url);
            if ($path_parts['extension'] === 'svg') {
                $pathSvg = get_attached_file( $settings['image']['id'] );
                return osf_elementor_get_icon_svg($pathSvg);
            }  
             $image_html = Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
        }
        return $image_html; 
    }

	protected function render() {
		$settings = $this->get_settings(); 

		$image_html = $this->_render_image_icon($settings);

		if( isset($settings['style_circle']) && $settings['style_circle'] == 'yes') {
			$style_circle = 'style_circle'; 
		}else {
			$style_circle = '';
		}

		$fixed_content_cart = '';
		$wrap = '';
		$title = '';
		if( isset($settings['fixed_content_cart']) && $settings['fixed_content_cart'] =='yes' ) {
			$wrap = '-fixed-right';
		}

		$id = $this->get_id();
		?>
        <div class="<?php echo apply_filters( "osf_elementor_cart_mini_wrap", "elementor-dropdown".$wrap );?>">

        	<?php if( empty($wrap) ): ?> 
        	 <a data-toggle="toggle" class="cart-contents header-button <?php echo esc_html( $style_circle ); ?>" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php echo esc_attr( $settings['title_hover'] ); ?>">
        	<?php else : ?> 	

            <a id="button-cart-<?php echo $id; ?>" data-appear="right,overlay" data-container="content-cart-<?php echo $id; ?>"  data-toggle="toggle" class="cart-contents cart-button header-button <?php echo esc_html( $style_circle ); ?>" href="#" title="<?php echo esc_attr( $settings['title_hover'] ); ?>">
            <?php endif; ?>	
            	<?php if (!empty($image_html) && $image_html ) {
              			echo '<span class="icon_img">' . $image_html . '</span>';
              		} else {

              			$cart_icon = empty( $settings['icon'] ) ? 'opal-icon-cart' : $settings['icon']; ?>

              			<i class="<?php echo esc_attr( $cart_icon ); ?>" aria-hidden="true"></i>
              			
              		<?php } ?>
              	
                <span class="title"><?php echo esc_html( $settings['title']); ?></span>
                <?php if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart): ?>
                    <?php if($settings['show_subtotal']): ?>
                        <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span>
                    <?php endif; ?>

                    <?php if($settings['show_items']): ?>
                        <span class="count">h<?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
                        <span class="count-text"><?php echo wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "opalelementor")); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </a>
            <div id="content-cart-<?php echo $id; ?>" class="<?php echo apply_filters( "osf_elementor_cart_mini_content_menu", "elementor-dropdown-menu".$wrap );?>">

            	<?php 

            	if( isset($settings['fixed_content_cart']) && $settings['fixed_content_cart'] =='yes' ) { ?>
				<h3 class="text-center"><?php echo __( 'My Cart', 'opalelementor' ); ?></h3> 		
				<?php }	?>

            	<?php the_widget('WC_Widget_Cart', 'title='); ?>
            </div>
        </div>
    <?php
	}
}