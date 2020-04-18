<?php

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class OSF_Elementor_Navigation_Nav_Widget extends Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        // `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
        return 'opal-navigation-menu';
    }

    public function get_title() {
        return __( 'Opal Simple Nav Menu', 'opalelementor' );
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    public function on_export($element) {
        unset($element['settings']['menu']);

        return $element;
    }

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        return $options;
    }


     protected function _register_controls() {

        $menus = $this->get_available_menus();

        $this->start_controls_section(
        'section_extra',
        [
            'label' => __( 'Menu Site', 'opalelementor' ),
        ]
        );
       $this->add_control(
            'menu',
            [
                'label'        => __('Menu', 'opalelementor'),
                'type'         => Controls_Manager::SELECT,
                'options'      => $menus,
                'default'      => $menus ? array_keys($menus)[0] : "",
                'save_default' => true,
                'separator'    => 'after',
                'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'opalelementor'), admin_url('nav-menus.php')),
            ]
        );

        $this->add_control(
            'pointer',
            [
                'label'     => __('Pointer', 'opalelementor'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none'        => __('None', 'rochic-core'),
                    'underline'   => __('Underline', 'rochic-core'),
                    'overline'    => __('Overline', 'rochic-core'),
                    'double-line' => __('Double Line', 'rochic-core'),
                    'framed'      => __('Framed', 'rochic-core'),
                    'background'  => __('Background', 'rochic-core'),
                    'text'        => __('Text', 'rochic-core'),
                    'dot'         => __('Dot', 'rochic-core'),
                    'icon'         => __('icon', 'rochic-core'),
                ],
                'prefix_class' => 'e--pointer-',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Choose Icon', 'opalelementor' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-angle-right',
                'condition' => [
                    'pointer' => 'icon',
                ],
                
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'available_menus_style',
            [
                'label' => __( 'Navigation Menu', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

       

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'menu_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .opalelementor-simple-nav-menu li a',
            ]
        );


        $this->add_control(
            'menu_color',
            [
                'label' => __( 'Text Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .opalelementor-simple-nav-menu li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __( 'Hover Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .opalelementor-simple-nav-menu li a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .opalelementor-simple-nav-menu li.current-menu-item > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pointer_menus_style',
            [
                'label' => __( 'Pointer', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pointer_color',
            [
                'label' => __( 'Pointer color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default'   => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .opalelementor-item::before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .opalelementor-simple-nav-menu li i' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    public function get_value( array $options = [] ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        if ( $custom_logo_id ) {
            $url = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
        } else {
            $url = Elementor\Utils::get_placeholder_image_src();
        }

        return [
            'id' => $custom_logo_id,
            'url' => $url,
        ];
    }

    protected function render() {
           
        $settings = $this->get_active_settings();

        if($settings['icon'] && $settings['pointer'] === 'icon') {
            $icon = '<i class="'.$settings['icon'].'"></i>';
        }else {
            $icon = '';
        }

        $args = apply_filters( 'opal_nav_simple_menu_args',[
            'echo'        => false,
            'menu'        => $settings['menu'],
            'menu_class'  => 'opalelementor-simple-nav-menu menu',
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'fallback_cb' => '__return_empty_string',
            'container'   => '',
            'before'      => $icon,
        ] );

        // Add custom filter to handle Nav Menu HTML output.
        add_filter('nav_menu_link_attributes', [$this, 'handle_link_classes'], 10, 4);
       

        // General Menu.
        $menu_html = wp_nav_menu($args);

        // Remove all our custom filters.
        remove_filter('nav_menu_link_attributes', [$this, 'handle_link_classes']);
       
        echo $menu_html; ?>

        <?php
    }

    public function handle_link_classes($atts, $item, $args, $settings) {

        $classes = 'opalelementor-item';

        $atts['class'] = $classes;
       
        return $atts;
    }

    

    public function render_plain_content() {
    }
}
