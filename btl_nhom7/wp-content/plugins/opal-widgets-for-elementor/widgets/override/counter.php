<?php

namespace Elementor;

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor counter widget.
 *
 * Elementor widget that displays stats and numbers in an escalating manner.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Counter extends Widget_Counter
{

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
    public function get_name()
    {
        return 'counter';
    }

    /**
     * Get widget title.
     *
     * Retrieve counter widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Counter', 'opalelementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve counter widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-counter';
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
    public function get_script_depends()
    {
        return ['jquery-numerator'];
    }

    /**
     * Register counter widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_counter',
            [
                'label' => __('Counter', 'opalelementor'),
            ]
        );

        $this->add_control(
            'starting_number',
            [
                'label' => __('Starting Number', 'opalelementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $this->add_control(
            'ending_number',
            [
                'label' => __('Ending Number', 'opalelementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => __('Number Prefix', 'opalelementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 1,
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => __('Number Suffix', 'opalelementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Plus', 'opalelementor'),
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => __('Show Icon', 'opalelementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'opalelementor'),
                'label_off' => __('Hide', 'opalelementor'),
            ]
        );

        $this->add_control(
            'icon_select',
            [
                'label' => __('Icon select', 'opalelementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'use_icon',
                'options' => [
                    'use_icon' => __('Use Icon', 'opalelementor'),
                    'use_image' => __('Use Image', 'opalelementor'),
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'opalelementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_select' => 'use_image',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label'      => __(' Size', 'opalelementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-counter .elementor-icon-counter img, {{WRAPPER}} .elementor-counter .elementor-icon-counter svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_select' => 'use_image',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Choose Icon', 'opalelementor'),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
                'condition' => [
                    'icon_select' => 'use_icon',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => __('Animation Duration', 'opalelementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 2000,
                'min' => 100,
                'step' => 100,
            ]
        );

        $this->add_control(
            'thousand_separator',
            [
                'label' => __('Thousand Separator', 'opalelementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'opalelementor'),
                'label_off' => __('Hide', 'opalelementor'),
            ]
        );

        $this->add_control(
            'thousand_separator_char',
            [
                'label' => __('Separator', 'opalelementor'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'thousand_separator' => 'yes',
                ],
                'options' => [
                    '' => 'Default',
                    '.' => 'Dot',
                    ' ' => 'Space',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'opalelementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Cool Number', 'opalelementor'),
                'placeholder' => __('Cool Number', 'opalelementor'),
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => __('Alignment', 'opalelementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => __('Left', 'opalelementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'top' => [
                        'title' => __('Top', 'opalelementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'opalelementor'),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'toggle' => false,
                'prefix_class' => 'elementor-position-',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __('View', 'opalelementor'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(

            'section_number',
            [
                'label' => __('Number', 'opalelementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => __('Text Color', 'opalelementor'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-number-wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_number',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-counter-number-wrapper',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Title', 'opalelementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Text Color', 'opalelementor'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-counter-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon',
            [
                'label' => __('Icon', 'opalelementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'opalelementor'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-counter' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-counter svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_icon',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-icon-counter',
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
    protected function _content_template()
    {
        return;
    }

    /**
     * Render counter widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $has_icon = !empty($settings['icon']);

        if ($has_icon) {
            $this->add_render_attribute('icon', 'class', $settings['icon']);
            $this->add_render_attribute('icon', 'aria-hidden', 'true');
        }

        $this->add_render_attribute('counter', [
            'class' => 'elementor-counter-number',
            'data-duration' => $settings['duration'],
            'data-to-value' => $settings['ending_number'],
        ]);

        if (!empty($settings['thousand_separator'])) {
            $delimiter = empty($settings['thousand_separator_char']) ? ',' : $settings['thousand_separator_char'];
            $this->add_render_attribute('counter', 'data-delimiter', $delimiter);
        }
        ?>
        <div class="elementor-counter">
            <?php $this->get_image_icon(); ?>
            <div class="elementor-counter-wrapper">
                <div class="elementor-counter-number-wrapper">
                    <span class="elementor-counter-number-prefix"><?php echo $settings['prefix']; ?></span>
                    <span <?php echo $this->get_render_attribute_string('counter'); ?>><?php echo $settings['starting_number']; ?></span>
                    <span class="elementor-counter-number-suffix"><?php echo $settings['suffix']; ?></span>
                </div>
                <?php if ($settings['title']) : ?>
                    <div class="elementor-counter-title"><?php echo $settings['title']; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function get_image_icon() {
        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['show_icon']):
            ?>
            <div class="elementor-icon-counter">
                <?php if ('use_image' === $settings['icon_select'] && !empty($settings['image']['url'])) :
                    $image_url = '';
                    $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, '', 'image');
                    $image_url = $settings['image']['url'];
                    $path_parts = pathinfo($image_url);
                    if ($path_parts['extension'] === 'svg') {
                        $image   = $this->get_settings_for_display('image');
                        $pathSvg = get_attached_file($image['id']);
                        $image_html = osf_elementor_get_icon_svg($pathSvg);
                    }
                    echo $image_html;
                ?>
                <?php elseif ('use_icon' === $settings['icon_select'] && !empty($settings['icon'])) : ?>
                    <i <?php echo $this->get_render_attribute_string('icon'); ?>></i>
                <?php endif; ?>
            </div>
        <?php
        endif;
    }
}

