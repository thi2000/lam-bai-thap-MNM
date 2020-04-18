<?php

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Elementor_List_Widget extends Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'opal-list';
	}

	public function get_title() {
		return __( 'Opal List', 'opalelementor' );
	}
	
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_categories() {
        return [ 'opal-addons' ];
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
				'label' => __( 'List', 'opalelementor' ),
			]
		);

        $this->add_control(
            'views',
            [
                'label' => __( 'List Items', 'opalelementor' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'title' => __( 'List Item #1', 'opalelementor' ),
                        'icon' => 'fa fa-check',
                        'content' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opalelementor' ),
                    ],
                    [
                        'title' => __( 'List Item #2', 'opalelementor' ),
                        'icon' => 'fa fa-check',
                        'content' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opalelementor' ),
                    ],
                ],
                'fields'      => [
                    [
                        'name' => 'title',
                        'label' => __( 'Title', 'opalelementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Tab Title', 'opalelementor' ),
                        'placeholder' => __( 'Tab Title', 'opalelementor' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'icon',
                        'label' => __( 'Icon', 'opalelementor' ),
                        'type' => Controls_Manager::ICON,
                        'default' => __( 'fa fa-check', 'opalelementor' ), 
                        'label_block' => true,
                    ],
                    [
                        'name' => 'content',
                        'label' => __( 'Content', 'opalelementor' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'opalelementor' ),
                        'label_block' => true,
                    ],
                    
                ],

                'title_field' => '{{{ title }}}',
            ]
        );
        
        $this->add_control(
            'layout',
            [
                'label'   => __('Layout', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'default'       => __('Default', 'opalelementor'),
                    'icon' 			=> __('Icon', 'opalelementor'),
                    'number' 		=> __('Number', 'opalelementor'),
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_list',
			[
				'label' => __( 'List', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => __( 'Space Between', 'opalelementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-items:not(.opalelementor-inline-items) .opalelementor-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .opalelementor-list-items:not(.opalelementor-inline-items) .opalelementor-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .opalelementor-list-items.opalelementor-inline-items .opalelementor-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .opalelementor-list-items.opalelementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .opalelementor-list-items.opalelementor-inline-items .opalelementor-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .opalelementor-list-items.opalelementor-inline-items .opalelementor-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_responsive_control(
			'icon_align',
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
			'section_icon_style',
			[
				'label' => __( 'Icon', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-icon i' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => __( 'Hover', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-item:hover .opalelementor-list-icon .opalelementor-list-number' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'opalelementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_width',
			[
				'label' => __( 'Width', 'opalelementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-icon' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_number_style',
			[
				'label' => __( 'Number', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'number',
				],
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => __( 'Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-icon .opalelementor-list-number' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'number_color_hover',
			[
				'label' => __( 'Hover', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-item:hover .opalelementor-list-icon .opalelementor-list-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				'selector' => '{{WRAPPER}} .opalelementor-list-number',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_responsive_control(
			'number_size',
			[
				'label' => __( 'Size', 'opalelementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-icon .opalelementor-list-number' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_width',
			[
				'label' => __( 'Width', 'opalelementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-icon' => 'flex: 0 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label' => __( 'Title', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Title Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color_hover',
			[
				'label' => __( 'Hover', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-item:hover .opalelementor-list-text' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .opalelementor-list-item',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .list-item-right p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color_hover',
			[
				'label' => __( 'Hover', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .opalelementor-list-item:hover .list-item-right p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .list-item-right p',
			]
		);

		$this->end_controls_section();
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

		$this->add_render_attribute( 'icon_list', 'class', 'opalelementor-list-items' );
		$this->add_render_attribute( 'list_item', 'class', 'opalelementor-list-item' );
		?>
		<ul <?php echo $this->get_render_attribute_string( 'icon_list' ); ?>>
			<?php

			foreach ( $settings['views'] as $index => $item ) :
				$repeater_setting_key = $this->get_repeater_setting_key( 'title', 'views', $index );
				$this->add_render_attribute( $repeater_setting_key, 'class', 'opalelementor-list-text' );

				$this->add_inline_editing_attributes( $repeater_setting_key );

				$number = $index + 1;
				if ($number <= 9) {$number = "0".$number; }
				?>
				<li class="opalelementor-list-item" >
					<?php
					if ( ! empty( $item['icon'] ) &&  $settings['layout'] === 'icon'  ) :
						?>
						<span class="opalelementor-list-icon">
							<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
						</span>
					<?php endif; ?>
					<?php if ( $settings['layout'] === 'number'  ) :
						?>
						<span class="opalelementor-list-icon">
							<span class="opalelementor-list-number"><?php echo $number; ?></span>
						</span>
					<?php endif; ?>
					<div class="list-item-right">
						<h4 <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo esc_attr($item['title']); ?></h4>
						<p><?php if( ! empty( $item['content']) ) { echo esc_attr($item['content']); } ?></p>
					</div>
				</li>
				<?php
			endforeach;
			?>
		</ul>
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
		?>
		<#
			view.addRenderAttribute( 'icon_list', 'class', 'opalelementor-list-items' );
			view.addRenderAttribute( 'list_item', 'class', 'opalelementor-list-item' );

		#>
		<# if ( settings.views ) { #>
			<ul {{{ view.getRenderAttributeString( 'icon_list' ) }}}>
			<# _.each( settings.views, function( item, index ) {

					var iconTextKey = view.getRepeaterSettingKey( 'title', 'views', index );

					view.addRenderAttribute( iconTextKey, 'class', 'opalelementor-list-text' );

					view.addInlineEditingAttributes( iconTextKey ); 

					var number = index + 1;
					if ( number <= 9) { number = "0"+number; }
					#>

					<li {{{ view.getRenderAttributeString( 'list_item' ) }}}>
						
						<# if ( item.icon && settings.layout ==='icon' ) { #>
						<span class="opalelementor-list-icon">
							<i class="{{ item.icon }}" aria-hidden="true"></i>
						</span>
						<# } #>

						<# if ( settings.layout ==='number' ) { #>
						<span class="opalelementor-list-icon">
							<span class="opalelementor-list-number">{{{ number }}}</span>
						</span>
						<# } #>
						<div class="list-item-right">
							<h4 {{{ view.getRenderAttributeString( iconTextKey ) }}}>{{{ item.title }}}</h4>
							<p>{{{ item.content }}}</p>
						</div>
					</li>
				<#
				} ); #>
			</ul>
		<#	} #>

		<?php
	}
}
