<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

class OSF_Elementor_Offcanvas_Widget extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-offcanvas-sb';
	}

	public function get_title() {
		return __( 'Opal offcanvas', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_script_depends() {
		return [
			'wpopal-offcanvas',
		];
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'elementor' ),
			'sm' => __( 'Small', 'elementor' ),
			'md' => __( 'Medium', 'elementor' ),
			'lg' => __( 'Large', 'elementor' ),
			'xl' => __( 'Extra Large', 'elementor' ),
		];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'elementor' ),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label'        => __( 'Type', 'elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => [
					''        => __( 'Default', 'elementor' ),
					'info'    => __( 'Info', 'elementor' ),
					'success' => __( 'Success', 'elementor' ),
					'warning' => __( 'Warning', 'elementor' ),
					'danger'  => __( 'Danger', 'elementor' ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Click here', 'elementor' ),
				'placeholder' => __( 'Click here', 'elementor' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
				'default'     => [
					'url' => '#',
				],
			]
		);


		$this->add_control(
			'size',
			[
				'label'          => __( 'Size', 'elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'sm',
				'options'        => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => __( 'Off Canvas Icon', 'elementor' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'default'     => '',
			]
		);


		$this->add_control(
			'offcanvas_align',
			[
				'label'       => __( 'Align Right', 'elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Show the button on right of list', 'elementor' ),
				'default'     => 'no',
			]
		);


		$this->add_control(
			'view',
			[
				'label'   => __( 'View', 'elementor' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label'       => __( 'Button ID', 'elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => time(),
				'title'       => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'elementor' ),
				'label_block' => false,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.',
					'elementor' ),
				'separator'   => 'before',

			]
		);

		$this->end_controls_section();
		////////////////
		$this->start_controls_section(
			'section_container',
			[
				'label' => __( 'Container', 'elementor' ),
			]
		);


		$this->add_control(
			'container_appear',
			[
				'label'   => __( 'Appear Style', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left,overlay',
				'options' => [
					'right,overlay' => __( 'Right overlay', 'elementor' ),
					'left,overlay'  => __( 'Left overlay', 'elementor' ),
					'right,push'    => __( 'Right Push', 'elementor' ),
					'left,push'     => __( 'Left Push', 'elementor' ),
				],
			]
		);
		$menus = $this->get_available_menus();
		$this->add_control(
			'menu',
			[
				'label'        => __( 'Menu', 'opalelementor' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => $menus,
				'default'      => $menus ? array_keys( $menus )[0] : "",
				'save_default' => true,
				'separator'    => 'after',
				'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'opalelementor' ), admin_url( 'nav-menus.php' ) ),
			]
		);

		$this->add_control(
			'container_logo',
			[
				'label'   => __( 'Enable Logo', 'elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'enable_others_link',
			[
				'label'   => __( 'Enable User - Cart Links', 'elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->end_controls_section();
		////////////////
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_a1',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_hover',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover',
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'elementor' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .elementor-button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => __( 'Padding', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}


	public function render_offcanvas() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'offcanvas-container', 'id', 'c' . $settings['button_css_id'] );
		} else {
			$this->add_render_attribute( 'offcanvas-container', 'id', 'c-elementor-button-link' );
		}
		?>

        <aside class="js-offcanvas" <?php echo $this->get_render_attribute_string( 'offcanvas-container' ); ?> role="complementary">

            <div class="offcanvas-inner">
				<?php if ( $settings['container_logo'] === 'yes' ) : ?>
					<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): ?>
                        <div class="offcanvas-logo">
							<?php the_custom_logo(); ?>
                        </div>
					<?php endif; ?>
				<?php endif; ?>
                <button class="js-offcanvas-close" data-button-options='{"modifiers":"m1,m2"}'><i class="fa fa-close" aria-hidden="true"></i></button>
                <div class="offcanvas-top">
					<?php echo get_search_form(); ?>
                </div>
                <div class="offcanvas-content">
					<?php
					$args = apply_filters( 'offcanvas_nav_menu_args', [
						'echo'        => false,
						'menu'        => $settings['menu'],
						'menu_class'  => 'opalelementor-nav-menu',
						'menu_id'     => 'menu-' . time() . rand( 0, 100 ) . '-' . $this->get_id(),
						'fallback_cb' => '__return_empty_string',
						'container'   => '',
					] );


					// Add custom filter to handle Nav Menu HTML output.
					add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
					add_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
					add_filter( 'nav_menu_item_id', '__return_empty_string' );

					$html = wp_nav_menu( $args );

					// Remove all our custom filters.
					remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ] );
					remove_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );

					echo $html;
					?>
                </div>
                <div class="offcanvas-bottom">
					<?php echo $this->render_bottom(); ?>
                </div>
            </div>
        </aside>

	<?php }


	public function handle_link_classes( $atts, $item, $args, $depth ) {
		$classes = $depth ? 'opalelementor-sub-item' : 'opalelementor-item';

		if ( in_array( 'current-menu-item', $item->classes ) ) {
			$classes .= '  opalelementor-item-active';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' ' . $classes;
		}

		return $atts;
	}

	public function handle_sub_menu_classes( $classes ) {
		$classes[] = 'opalelementor-nav-menu--dropdown';

		return $classes;
	}

	protected function render_bottom() {
		$settings = $this->get_settings();
		$settings = wp_parse_args( $settings, [
			'enable_label' => false,
			'icon'         => '',
			'style'        => '',
		] );
		$others   = [];
		if ( osf_elementor_is_woocommerce_activated() ) {
			$account_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$others       = apply_filters( 'opalelementor_offcanvas_links', [
				[
					'link'  => get_permalink( wc_get_page_id( 'cart' ) ),
					'title' => __( 'My shopping cart', 'opalelementor' ),
					'icon'  => 'fa  fa-shopping-cart',
				],
			] );
		} else {
			$account_link = wp_login_url();
		}
		$id = $this->get_id();

		?>
		<?php foreach ( $others as $other ): ?>
			<?php
			echo '<a href="' . esc_html( $other['link'] ) . '"> '
			     . '<i class="' . $other['icon'] . '"></i> '
			     . $other['title'] .

			     ' </a>';
			?>
		<?php endforeach; ?>
		<?php
		echo '<a href="' . esc_html( $account_link ) . '"> '
		     . '<i class="fa fa-user"></i> '
		     . __( 'Account', 'opalelementor' ) .

		     ' </a>';
		?>

		<?php
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {

		add_action( 'wp_footer', [ $this, 'render_offcanvas' ], 99 );
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );


		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
			$this->add_render_attribute( 'button', 'class', 'c-elementor-button-link' );


			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );
		$this->add_render_attribute( 'button', 'data-appear', $settings['container_appear'] );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button', 'id', 'b' . $settings['button_css_id'] );
			$this->add_render_attribute( 'button', 'data-container', 'c' . $settings['button_css_id'] );
		} else {
			$this->add_render_attribute( 'button', 'id', 'b-elementor-button-link' );
			$this->add_render_attribute( 'button', 'data-container', 'c-elementor-button-link' );
		}

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}


		$this->add_render_attribute( 'button_others', 'class', 'elementor-button-others' );
		$this->add_render_attribute( 'button_others', 'role', 'button' );
		$this->add_render_attribute( 'button_others', 'data-appear', $settings['container_appear'] );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button_others', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button_others', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		if ( isset( $settings['offcanvas_align'] ) && $settings['offcanvas_align'] == 'yes' ) {
			$this->add_render_attribute( 'button_wrap', 'class', 'elementor-float-right' );
		}
		$others = [];
		if ( osf_elementor_is_woocommerce_activated() ) {
			$account_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$others       = apply_filters( 'opalelementor_offcanvas_links', [
				[
					'link'  => get_permalink( wc_get_page_id( 'cart' ) ),
					'title' => __( 'My Shopping Cart', 'opalelementor' ),
					'icon'  => 'fa  fa-shopping-cart',
				],
			] );
		} else {
			$account_link = wp_login_url();
		}

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<span <?php echo $this->get_render_attribute_string( 'button_wrap' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
			</a></span>
			<?php
			if ( isset( $settings['enable_others_link'] ) && $settings['enable_others_link'] == 'yes' ) :

				foreach ( $others as $other ): ?>
					<?php
					echo '<a href="' . esc_html( $other['link'] ) . '" ' . $this->get_render_attribute_string( 'button_others' ) . '> <i class="' . $other['icon'] . '"></i></a>';
					?>
				<?php endforeach; ?>
				<?php
				echo '<a href="' . esc_html( $account_link ) . '" ' . $this->get_render_attribute_string( 'button_others' ) . '><i class="fa fa-user"></i></a>';
			endif;
			?>
        </div>
		<?php
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since  1.5.0
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align'      => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text'            => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>

        <span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) ) : ?>
                <span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
			</span>
			<?php endif; ?>
			<?php if ( ! empty( $settings['text'] ) ) : ?>
                <span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
			<?php endif; ?>
		</span>
		<?php
	}
}
