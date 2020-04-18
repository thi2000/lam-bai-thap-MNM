<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class OSF_Elementor_Navbarsearch_Widget extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-navbarsearch';
    }

    public function get_title() {
        return __( 'Opal Products Search Form', 'opalelementor' );
    }

    public function get_icon() {
        return 'eicon-site-search';
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'search_content',
            [
                'label' => __( 'Search Form', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => __( 'Placeholder', 'opalelementor' ),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'default' => __( 'Search', 'opalelementor' ) . '...',
            ]
        );

        $this->add_control(
            'heading_button_content',
            [
                'label' => __( 'Button', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => __( 'Type', 'opalelementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => __( 'Icon', 'opalelementor' ),
                    'text' => __( 'Text', 'opalelementor' ),
                ],
                'prefix_class' => 'elementor-search-form--button-type-',
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Text', 'opalelementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search', 'opalelementor' ),
                'separator' => 'after',
                'condition' => [
                    'button_type' => 'text',
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', 'opalelementor' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'search',
                'options' => [
                    'search' => [
                        'title' => __( 'Search', 'opalelementor' ),
                        'icon' => 'fa fa-search',
                    ],
                    'arrow' => [
                        'title' => __( 'Arrow', 'opalelementor' ),
                        'icon' => 'fa fa-arrow-right',
                    ],
                ],
                'render_type' => 'template',
                'prefix_class' => 'elementor-search-form--icon-',
                'condition' => [
                    'button_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => __( 'Size', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__container, {{WRAPPER}} .elementor-search-form__container .elementor-search-form__input' => 'min-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .search-category-container' => 'line-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-search-form__submit' => 'min-width: {{SIZE}}{{UNIT}}',
                    'body:not(.rtl) {{WRAPPER}} .elementor-search-form__icon' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3)',
                    'body.rtl {{WRAPPER}} .elementor-search-form__icon' => 'padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                    '{{WRAPPER}} .elementor-search-form__input, {{WRAPPER}}.elementor-search-form--button-type-text .elementor-search-form__submit' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3); padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_input_style',
            [
                'label' => __( 'Input', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'tabs_input_colors' );

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label' => __( 'Normal', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => __( 'Text Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__input,
                    {{WRAPPER}} .elementor-search-form__icon,
                    {{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button,
                    {{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
                    {{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label' => __( 'Border Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_focus',
            [
                'label' => __( 'Focus', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'input_text_color_focus',
            [
                'label' => __( 'Text Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__input,
                    {{WRAPPER}} .elementor-search-form--focus .elementor-search-form__icon,
                    {{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
                    {{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_background_color_focus',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__container' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_border_color_focus',
            [
                'label' => __( 'Border Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__container' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow_focus',
                'selector' => '{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_border_width',
            [
                'label' => __( 'Border Size', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'size' => 3,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'border-radius: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __( 'Button', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-search-form__submit',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'condition' => [
                    'button_type' => 'text',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button_colors' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => __( 'Text Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_type' => 'icon',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => __( 'Width', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'min-width: calc( {{SIZE}} * {{size.SIZE}}{{size.UNIT}} )',
                ],
            ]
        );

        $this->end_controls_section();
        
    }

    protected function render() {
        $settings = $this->get_settings();
        $this->add_render_attribute(
            'input', [
                'placeholder' => $settings['placeholder'],
                'class' => 'elementor-search-form__input',
                'type' => 'search',
                'name' => 's',
                'title' => __( 'Search', 'opalelementor' ),
                'value' => get_search_query(),
            ]
        );

        // Set the selected icon.
        if ( 'icon' == $settings['button_type'] ) {
            $icon_class = 'search';

            if ( 'arrow' == $settings['icon'] ) {
                $icon_class = is_rtl() ? 'arrow-left' : 'arrow-right';
            }

            $this->add_render_attribute( 'icon', [
                'class' => 'fa fa-' . $icon_class,
            ] );
        }
        $dropdown_args = array(
            'show_count'         => 1,
            'hierarchical'       => 1,
            'show_uncategorized' => 0,
            'show_option_none'   => __( 'All Categories', 'opalelementor' ),
        );
    ?>
        <form class="elementor-search-form" role="search" action="<?php echo home_url(); ?>" method="get">
            <div class="elementor-search-form__container">

                <input <?php echo $this->get_render_attribute_string('input'); ?>>
                <div class="input-group-addon search-category-container">
                    <?php osf_product_dropdown_categories( $dropdown_args ); ?>
                </div>
                
                <button class="elementor-search-form__submit" type="submit">
                    <?php if ( 'icon' === $settings['button_type'] ) : ?>
                        <i <?php echo $this->get_render_attribute_string('icon'); ?> aria-hidden="true"></i>
                    <?php elseif ( ! empty( $settings['button_text'] ) ) : ?>
                        <?php echo $settings['button_text']; ?>
                    <?php endif; ?>
                </button>
                <input type="hidden" name="post_type" value="product" />
            </div>
        </form>
       
        <?php
    }

    
}
