<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Text_Shadow;
use ElementorPro\Plugin;

defined( 'ABSPATH' ) || exit();

class OSF_Elementor_Banner_Widget extends Widget_Base {

	protected function get_all_post() {
		$post_types        = get_post_types();
		$post_type_not__in = [ 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'elementor_library', 'post' ];

		foreach ( $post_type_not__in as $post_type_not ) {
			unset( $post_types[ $post_type_not ] );
		}
		$post_type = array_values( $post_types );


		$all_posts = get_posts( [
				'posts_per_page' => -1,
				'post_type'      => $post_type,
			]
		);
		$options   = [];
		if ( ! empty( $all_posts ) && ! is_wp_error( $all_posts ) ) {
			foreach ( $all_posts as $post ) {
				$options[ $post->ID ] = strlen( $post->post_title ) > 20 ? substr( $post->post_title, 0, 20 ) . '...' : $post->post_title;
			}
		}

		return $options;
	}

	public function get_name() {
		return 'opal-addon-banner';
	}

	public function get_title() {
		return __( 'Opal Banner', 'opalelementor' );
	}

	public function get_icon() {
		return 'pa-banner';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'opal_global_settings',
			[
				'label' => esc_html__( 'Image', 'opalelementor' ),
			]
		);

		$this->add_control(
			'opal_image',
			[
				'label'         => esc_html__( 'Image', 'opalelementor' ),
				'description'   => esc_html__( 'Select an image for the Banner', 'opalelementor' ),
				'type'          => Controls_Manager::MEDIA,
				'default'       => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'show_external' => true,
			]
		);

		$this->add_control( 'opal_link_url_switch',
			[
				'label' => esc_html__( 'Link', 'opalelementor' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'opal_image_link_switcher',
			[
				'label'       => esc_html__( 'Custom Link', 'opalelementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => esc_html__( 'Add a custom link to the banner', 'opalelementor' ),
				'condition'   => [
					'opal_link_url_switch' => 'yes',
				],
			]
		);

		$this->add_control(
			'opal_image_custom_link',
			[
				'label'         => esc_html__( 'Set custom Link', 'opalelementor' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'What custom link you want to set to banner?', 'opalelementor' ),
				'condition'     => [
					'opal_image_link_switcher' => 'yes',
					'opal_link_url_switch'     => 'yes',
				],
				'show_external' => false,
			]
		);

		$this->add_control(
			'opal_image_existing_page_link',
			[
				'label'       => esc_html__( 'Existing Page', 'opalelementor' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Link the banner with an existing page', 'opalelementor' ),
				'condition'   => [
					'opal_image_link_switcher!' => 'yes',
					'opal_link_url_switch'      => 'yes',
				],
				'multiple'    => false,
				'options'     => $this->get_all_post(),
			]
		);

		$this->add_control(
			'opal_image_link_open_new_tab',
			[
				'label'       => esc_html__( 'New Tab', 'opalelementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => esc_html__( 'Choose if you want the link be opened in a new tab or not', 'opalelementor' ),
				'condition'   => [
					'opal_link_url_switch' => 'yes',
				],
			]
		);

		$this->add_control(
			'opal_image_link_add_nofollow',
			[
				'label'       => esc_html__( 'Nofollow Option', 'opalelementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => esc_html__( 'if you choose yes, the link will not be counted in search engines', 'opalelementor' ),
				'condition'   => [
					'opal_link_url_switch' => 'yes',
				],
			]
		);

		$this->add_control(
			'opal_image_animation',
			[
				'label'       => esc_html__( 'Effect', 'opalelementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'opal_animation1',
				'description' => esc_html__( 'Choose a hover effect for the banner', 'opalelementor' ),
				'options'     => [
					'opal-banner-animation-1' => 'Effect 1',
					'opal-banner-animation-2' => 'Effect 2',
					'opal-banner-animation-3' => 'Effect 3',
					'opal-banner-animation-4' => 'Effect 4',
					'opal-banner-animation-5' => 'Effect 5',
					'opal-banner-animation-6' => 'Effect 6',
				],
			]
		);

		$this->add_control(
			'opal_active',
			[
				'label'       => esc_html__( 'Always Hovered', 'opalelementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Choose if you want the effect to be always triggered', 'opalelementor' ),

			]
		);

		$this->add_control(
			'opal_hover_effect',
			[
				'label'   => esc_html__( 'Hover Effect', 'opalelementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'      => esc_html__( 'None', 'opalelementor' ),
					'zoomin'    => esc_html__( 'Zoom In', 'opalelementor' ),
					'zoomout'   => esc_html__( 'Zoom Out', 'opalelementor' ),
					'scale'     => esc_html__( 'Scale', 'opalelementor' ),
					'grayscale' => esc_html__( 'Grayscale', 'opalelementor' ),
					'blur'      => esc_html__( 'Blur', 'opalelementor' ),
					'bright'    => esc_html__( 'Bright', 'opalelementor' ),
					'sepia'     => esc_html__( 'Sepia', 'opalelementor' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'opal_height',
			[
				'label'   => esc_html__( 'Height', 'opalelementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => 'Default',
					'custom'  => 'Custom',
				],
				'default' => 'default',

			]
		);

		$this->add_responsive_control(
			'opal_custom_height',
			[
				'label'       => esc_html__( 'Min Height', 'opalelementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Set a minimum height value in pixels', 'opalelementor' ),
				'condition'   => [
					'opal_height' => 'custom',
				],
				'selectors'   => [
					'{{WRAPPER}} .opal-elementor-banner' => 'height: {{VALUE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'opal_img_vertical_align',
			[
				'label'     => esc_html__( 'Vertical Align', 'opalelementor' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'opal_height' => 'custom',
				],
				'options'   => [
					'flex-start' => esc_html__( 'Top', 'opalelementor' ),
					'center'     => esc_html__( 'Middle', 'opalelementor' ),
					'flex-end'   => esc_html__( 'Bottom', 'opalelementor' ),
					'inherit'    => esc_html__( 'Full', 'opalelementor' ),
				],
				'default'   => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .opal_elementor-banner-img-wrap' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'opal_extra_class',
			[
				'label'       => esc_html__( 'Extra Class', 'opalelementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add extra class name.', 'opalelementor' ),
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'opal_image_section',
			[
				'label' => esc_html__( 'Content', 'opalelementor' ),
			]
		);

		$this->add_control(
			'opal_title',
			[
				'label'       => esc_html__( 'Title', 'opalelementor' ),
				'placeholder' => esc_html__( 'Enter title to this banner', 'opalelementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Opal Banner', 'opalelementor' ),
				'label_block' => false,
			]
		);

		$this->add_control(
			'opal_title_tag',
			[
				'label'       => esc_html__( 'HTML Tag', 'opalelementor' ),
				'description' => esc_html__( 'Select a heading tag for the title. Headings are defined with H1 to H6 tags', 'opalelementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h3',
				'options'     => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'opal_description_hint',
			[
				'label' => esc_html__( 'Description', 'opalelementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'opal_description',
			[
				'label'       => esc_html__( 'Description', 'opalelementor' ),
				'description' => esc_html__( 'Give the description to this banner', 'opalelementor' ),
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
					'opalelementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'opal_link_switcher',
			[
				'label'     => esc_html__( 'Button', 'opalelementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'opal_link_url_switch!' => 'yes',
				],
			]
		);


		$this->add_control(
			'opal_more_text',
			[
				'label'     => esc_html__( 'Text', 'opalelementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [ 'active' => true ],
				'default'   => 'Click Here',
				'condition' => [
					'opal_link_switcher'    => 'yes',
					'opal_link_url_switch!' => 'yes',
				],
			]
		);

		$this->add_control(
			'opal_link_selection',
			[
				'label'       => esc_html__( 'Link Type', 'opalelementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'url'  => esc_html__( 'URL', 'opalelementor' ),
					'link' => esc_html__( 'Existing Page', 'opalelementor' ),
				],
				'default'     => 'url',
				'label_block' => true,
				'condition'   => [
					'opal_link_switcher'    => 'yes',
					'opal_link_url_switch!' => 'yes',
				],
			]
		);

		$this->add_control(
			'opal_link',
			[
				'label'       => esc_html__( 'Link', 'opalelementor' ),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'url' => '#',
				],
				'placeholder' => 'https://opaladdons.com/',
				'label_block' => true,
				'condition'   => [
					'opal_link_selection'   => 'url',
					'opal_link_switcher'    => 'yes',
					'opal_link_url_switch!' => 'yes',
				],
			]
		);

		$this->add_control(
			'opal_existing_link',
			[
				'label'       => esc_html__( 'Existing Page', 'opalelementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->get_all_post(),
				'multiple'    => false,
				'condition'   => [
					'opal_link_selection'   => 'link',
					'opal_link_switcher'    => 'yes',
					'opal_link_url_switch!' => 'yes',
				],
				'label_block' => true,
			]
		);


		$this->add_control( 'opal_title_text_align',
			[
				'label'     => esc_html__( 'Alignment', 'opalelementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'opalelementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'opalelementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'opalelementor' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'left',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .opal-elementor-banner-title, {{WRAPPER}} .opal-elementor-banner-content, {{WRAPPER}} .opal-banner-read-more' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'opal_responsive_section',
			[
				'label' => esc_html__( 'Responsive', 'opalelementor' ),
			] );

		$this->add_control( 'opal_responsive_switcher',
			[
				'label' => esc_html__( 'Responsive', 'opalelementor' ),
				'type'  => Controls_Manager::SWITCHER,
			] );

		$this->add_control( 'opal_min_range',
			[
				'label'       => esc_html__( 'Minimum Size', 'opalelementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Note: minimum size for extra small screens is 1px.', 'opalelementor' ),
				'default'     => 1,
				'condition'   => [
					'opal_responsive_switcher' => 'yes',
				],
			] );

		$this->add_control( 'opal_max_range',
			[
				'label'       => esc_html__( 'Maximum Size', 'opalelementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Note: maximum size for extra small screens is 767px.', 'opalelementor' ),
				'default'     => 767,
				'condition'   => [
					'opal_responsive_switcher' => 'yes',
				],
			] );

		$this->end_controls_section();

		$this->start_controls_section(
			'opal_opacity_style',
			[
				'label' => esc_html__( 'Image', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'opal_image_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-elementor-banner' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'opal_image_opacity',
			[
				'label'     => esc_html__( 'Image Opacity', 'opalelementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => .1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opal-elementor-banner .opal-elementor-banner-img' => 'opacity: {{SIZE}};',
				],
			]
		);


		$this->add_control(
			'opal_image_hover_opacity',
			[
				'label'     => esc_html__( 'Hover Opacity', 'opalelementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => .1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opal-elementor-banner .opal-elementor-banner-img.active' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'opal_image_border',
				'selector' => '{{WRAPPER}} .opal-elementor-banner',
			]
		);

		$this->add_responsive_control(
			'opal_image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'opalelementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .opal-elementor-banner' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'opal_title_style',
			[
				'label' => esc_html__( 'Title', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'opal_color_of_title',
			[
				'label'     => esc_html__( 'Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .opal-elementor-banner-desc .opal_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'opal_style2_title_bg',
			[
				'label'       => esc_html__( 'Title Background', 'opalelementor' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2f2f2',
				'description' => esc_html__( 'Choose a background color for the title', 'opalelementor' ),
				'condition'   => [
					'opal_image_animation' => 'opal_animation5',
				],
				'selectors'   => [
					'{{WRAPPER}} .opal_animation5 .opal-elementor-banner-desc' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'opal_title_typography',
				'selector' => '{{WRAPPER}} .opal-elementor-banner-desc .opal_title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'label'    => esc_html__( 'Shadow', 'opalelementor' ),
				'name'     => 'opal_title_shadow',
				'selector' => '{{WRAPPER}} .opal-elementor-banner-desc .opal_title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'opal_styles_of_content',
			[
				'label' => esc_html__( 'Description', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'opal_color_of_content',
			[
				'label'     => esc_html__( 'Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .opal_banner .opal_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'opal_content_typhography',
				'selector' => '{{WRAPPER}} .opal_banner .opal_content',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'label'    => esc_html__( 'Shadow', 'opalelementor' ),
				'name'     => 'opal_description_shadow',
				'selector' => '{{WRAPPER}} .opal_banner .opal_content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'opal_styles_of_button',
			[
				'label'     => esc_html__( 'Button', 'opalelementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'opal_link_switcher'    => 'yes',
					'opal_link_url_switch!' => 'yes',
				],
			]
		);

		$this->add_control(
			'opal_color_of_button',
			[
				'label'     => esc_html__( 'Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .opal_banner .opal-banner-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'opal_hover_color_of_button',
			[
				'label'     => esc_html__( 'Hover Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .opal_banner .opal-banner-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'opal_button_typhography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .opal_banner .opal-banner-link',
			]
		);

		$this->add_control(
			'opal_backcolor_of_button',
			[
				'label'     => esc_html__( 'Background Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal_banner .opal-banner-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'opal_hover_backcolor_of_button',
			[
				'label'     => esc_html__( 'Hover Background Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal_banner .opal-banner-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'opal_button_border',
				'selector' => '{{WRAPPER}} .opal_banner .opal-banner-link',
			]
		);

		$this->add_control( 'opal_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'opalelementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .opal_banner .opal-banner-link' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'label'    => esc_html__( 'Shadow', 'opalelementor' ),
				'name'     => 'opal_button_shadow',
				'selector' => '{{WRAPPER}} .opal_banner .opal-banner-link',
			]
		);

		$this->add_responsive_control( 'opal_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'opalelementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .opal_banner .opal-banner-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

		$this->end_controls_section();

	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'opal_title' );
		$this->add_inline_editing_attributes( 'opal_description', 'advanced' );

		$title_tag  = $settings['opal_title_tag'];
		$title      = $settings['opal_title'];
		$full_title = '<' . $title_tag . ' class="opal-elementor-banner-title opal_title"><div ' . $this->get_render_attribute_string( 'opal_title' ) . '>' . $title . '</div></' . $title_tag . '>';

		$link = isset( $settings['opal_image_link_switcher'] ) && $settings['opal_image_link_switcher'] != '' ? $settings['opal_image_custom_link']['url'] : get_permalink( $settings['opal_image_existing_page_link'] );

		$link_title = $settings['opal_image_link_switcher'] != 'yes' ? get_the_title( $settings['opal_image_existing_page_link'] ) : '';

		$open_new_tab    = $settings['opal_image_link_open_new_tab'] == 'yes' ? ' target="_blank"' : '';
		$nofollow_link   = $settings['opal_image_link_add_nofollow'] == 'yes' ? ' rel="nofollow"' : '';
		$full_link       = '<a class="opal-elementor-banner-link" href="' . $link . '" title="' . $link_title . '"' . $open_new_tab . $nofollow_link . '></a>';
		$animation_class = $settings['opal_image_animation'];
		$hover_class     = ' ' . $settings['opal_hover_effect'];
		$extra_class     = isset( $settings['opal_extra_class'] ) && $settings['opal_extra_class'] != '' ? ' ' . $settings['opal_extra_class'] : '';
		$active          = $settings['opal_active'] == 'yes' ? ' active' : '';
		$full_class      = $animation_class . $hover_class . $extra_class . $active;
		$min_size        = $settings['opal_min_range'] . 'px';
		$max_size        = $settings['opal_max_range'] . 'px';


		$banner_url = 'url' == $settings['opal_link_selection'] ? $settings['opal_link']['url'] : get_permalink( $settings['opal_existing_link'] );

		ob_start();
		?>
        <div class="opal_banner" id="opal-banner-<?php echo esc_attr( $this->get_id() ); ?>">
            <div class="opal-elementor-banner <?php echo $full_class; ?> opal-banner-min-height">
				<?php if ( isset( $settings['opal_image']['url'] ) && $settings['opal_image']['url'] != '' ): ?>
					<?php if ( $settings['opal_height'] == 'custom' ): ?>
                        <div class="opal_elementor-banner-img-wrap">
					<?php endif; ?>
                    <img class="opal-elementor-banner-img" alt="null" src="<?php echo $settings['opal_image']['url']; ?>">
					<?php if ( $settings['opal_height'] == 'custom' ): ?>
                        </div>
					<?php endif; ?>
				<?php endif; ?>
                <div class="opal-elementor-banner-desc">
					<?php echo $full_title; ?>
                    <div class="opal-elementor-banner-content opal_content">
                        <div <?php echo $this->get_render_attribute_string( 'opal_description' ); ?>><?php echo $settings['opal_description']; ?></div>
                    </div>
					<?php if ( 'yes' == $settings['opal_link_switcher'] && ! empty( $settings['opal_more_text'] ) ) : ?>

                        <div class="opal-banner-read-more">
                            <a class="opal-banner-link" <?php if ( ! empty( $banner_url ) ) : ?> href="<?php echo esc_url( $banner_url ); ?>"<?php endif; ?><?php if ( ! empty( $settings['opal_link']['is_external'] ) ) : ?> target="_blank" <?php endif; ?><?php if ( ! empty( $settings['opal_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>><?php echo esc_html( $settings['opal_more_text'] ); ?></a>
                        </div>

					<?php endif; ?>
                </div>
				<?php
				if ( $settings['opal_link_url_switch'] == 'yes' && ( ! empty( $settings['opal_image_custom_link']['url'] ) || ! empty( $settings['opal_image_existing_page_link'] ) ) ) {
					echo $full_link;
				}
				?>
            </div>
			<?php if ( $settings['opal_responsive_switcher'] == 'yes' ) : ?>
                <style>
                    @media (min-width: <?php echo esc_attr( $min_size ); ?> ) and (max-width:<?php echo esc_attr($max_size) ?>) {
                        #opal-banner-<?php echo esc_attr( $this->get_id() ); ?> .opal-elementor-banner-content {
                            display: none;
                        }
                    }
                </style>
			<?php endif; ?>

        </div>
		<?php echo ob_get_clean();
	}
}

