<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Button_Contact_Form extends  Widget_Button {
    public function get_name() {
        return 'opal-button-contact7';
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_title() {
        return __('Opal Button Contact Form 7', 'opalelementor');
    }


    public function get_categories() {
        return [ 'opal-addons' ];
    }

    public function get_script_depends() {
        return [ 'magnific-popup' ];
    }

    public function get_style_depends(){
        return ['magnific-popup'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'contactform7',
            [
                'label' => __('General', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');

        $contact_forms[''] = __('Please select form', 'opalelementor');
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = __('No contact forms found', 'opalelementor');
        }

        $this->add_control(
            'cf_id',
            [
                'label'   => __('Select contact form', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => $contact_forms,
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label' => __( 'Form name', 'opalelementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Request A Call Back', 'opalelementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Sub Title', 'opalelementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Free consultation', 'opalelementor' ),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        parent::_register_controls();

        $this->start_controls_section(
            'section_form_style',
            [
                'label' => __( 'Form Style', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'background_color_form',
                [
                    'label' => __( 'Background Color', 'opalelementor' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_4,
                    ],
                    'default' => '#fff',
                    'selectors' => [
                        '#opal-contactform-popup-{{ID}}' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'width_form',
                [
                    'label' => __( 'Width', 'opalelementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '500',
                    'description' => ['px'],
                    'selectors' => [
                        '#opal-contactform-popup-{{ID}}' => 'max-width: {{VALUE}}px;',
                    ],
                ]
            );

            $this->add_control(
                'padding_form',
                [
                    'label' => __( 'Padding', 'opalelementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '20',
                    'description' => 'px',
                    'selectors' => [
                        '#opal-contactform-popup-{{ID}}' => 'padding: {{VALUE}}px;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_align',
                [
                    'label' => __( 'Text Alignment', 'opalelementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left'    => [
                            'title' => __( 'Left', 'opalelementor' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'opalelementor' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'opalelementor' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'opalelementor' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    //'prefix_class' => 'elementor%s-align-',
                    'default' => 'left',
                    'selectors' => [
                        '#opal-contactform-popup-{{ID}}' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'form_color',
                [
                    'label' => __( 'Text Color', 'opalelementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '#opal-contactform-popup-{{ID}}' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'heading_color',
                [
                    'label'     => __('Heading Color', 'opalelementor'),
                    'type'      => Controls_Manager::COLOR,
                    'scheme'    => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'   => '',
                    'selectors' => [
                        '#opal-contactform-popup-{{ID}} .form-title' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'heading_typography',
                    'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '#opal-contactform-popup-{{ID}} .form-title',
                ]
            );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => __( 'Headhing Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .form-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => __('Sub title Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '#opal-contactform-popup-{{ID}} .subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => __( 'Subtitle Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->remove_control('link');
    }

    protected function render(){
        $settings = $this->get_settings_for_display();

        if(!$settings['cf_id']){
            return;
        }


        $args['id']    = $settings['cf_id'];
        $args['title'] = $settings['form_name'];


        $this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );
        $this->add_render_attribute( 'wrapper', 'class', 'opal-button-contact7' );

        $this->add_render_attribute( 'button', 'href', '#opal-contactform-popup-'.esc_attr( $this->get_id() ) );
        $this->add_render_attribute( 'button', 'class', 'elementor-button' );
        $this->add_render_attribute( 'button', 'role', 'button' );
        $this->add_render_attribute( 'button', 'data-effect', 'mfp-zoom-in' );

        if ( ! empty( $settings['size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
        }

        if ( $settings['hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        ?>
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                    <?php $this->render_text(); ?>
                </a>
            </div>
            <?php

        ?>
        <div id="opal-contactform-popup-<?php echo esc_attr( $this->get_id()); ?>" class="mfp-hide contactform-content">
            <div class="heading-form">
                <div class="subtitle"><?php echo esc_html($settings['sub_title']);?></div>
                <div class="form-title"><?php echo esc_html($settings['form_name']);?></div>
            </div>
            <?php echo osf_do_shortcode('contact-form-7', $args); ?>
        </div>
<?php

    }

    protected function _content_template() {
        return;
    }
}