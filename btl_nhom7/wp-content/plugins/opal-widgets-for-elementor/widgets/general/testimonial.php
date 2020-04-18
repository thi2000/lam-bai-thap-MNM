<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class OSF_Elementor_Testimonial_Widget extends OSF_Elementor_Slick_Widget{

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-testimonials';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Testimonials', 'opalelementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => __('Testimonials', 'opalelementor'),
            ]
        );

        $this->image_control = false ;
        $this->add_control(
            'testimonials',
            [
                'label'       => __('Testimonials Item', 'opalelementor'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => [
                    [
                        'name'        => 'testimonial_content',
                        'label'       => __('Content', 'opalelementor'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                        'label_block' => true,
                        'rows'        => '10',
                    ],
                    [
                        'name'       => 'testimonial_image',
                        'label'      => __('Choose Image', 'opalelementor'),
                        'default'    => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'type'       => Controls_Manager::MEDIA,
                        'show_label' => false,
                    ],
                    [
                        'name'    => 'testimonial_name',
                        'label'   => __('Name', 'opalelementor'),
                        'default' => 'John Doe',
                        'type'    => Controls_Manager::TEXT,
                    ],
                    [
                        'name'    => 'testimonial_job',
                        'label'   => __('Job', 'opalelementor'),
                        'default' => 'Designer',
                        'type'    => Controls_Manager::TEXT,
                    ],
                    [
                        'name'        => 'testimonial_link',
                        'label'       => __('Link to', 'opalelementor'),
                        'placeholder' => __('https://your-link.com', 'opalelementor'),
                        'type'        => Controls_Manager::URL,
                    ],
                ],
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'testimonial_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'testimonial_alignment',
            [
                'label'       => __('Alignment', 'opalelementor'),
                'type'        => Controls_Manager::CHOOSE,
                'default'     => 'center',
                'options'     => [
                    'left'   => [
                        'title' => __('Left', 'opalelementor'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'opalelementor'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'opalelementor'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'label_block' => false,
//                'prefix_class' => 'elementor-testimonial-text-align-',
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label'   => __('Columns', 'opalelementor'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 6 => 6],
            ]
        );

        $this->add_control(
            'testimonial_layout',
            [
                'label'   => __('Layout', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout_1',
                'options' => [
                    'layout_1'   => __('Layout 1', 'opalelementor'),
                    'layout_2'   => __('Layout 2', 'opalelementor'),
                    'layout_3'   => __('Layout 3', 'opalelementor'),
                    'layout_4'   => __('Layout 4', 'opalelementor'),
                ],
            ]
        );
         
         $this->add_control(
            'enable_carousel',
            [
                'label' => __('Enable', 'opalelementor'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();
     

        $this->add_slick_controls(  array('enable_carousel' => 'yes') , ' .product-slick-carousel ' );

        // Style.
        $this->start_controls_section(
            'section_style_testimonial_style',
            [
                'label' => __('Content', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_content_color',
            [
                'label'     => __('Text Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        $this->end_controls_section();

        // Image.
        $this->start_controls_section(
            'section_style_testimonial_image',
            [
                'label'     => __('Image', 'opalelementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label'      => __('Image Size', 'opalelementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'opalelementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_testimonial_name',
            [
                'label' => __('Name', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label'     => __('Text Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name, {{WRAPPER}} .elementor-testimonial-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_testimonial_job',
            [
                'label' => __('Job', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => __('Text Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['testimonials']) && is_array($settings['testimonials'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-wrapper');
            $this->add_render_attribute('wrapper', 'class', $settings['testimonial_layout']);
            if ($settings['testimonial_alignment']) {
                $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-text-align-' . $settings['testimonial_alignment']);
            }
            // Row
            $this->add_render_attribute('row', 'class', 'row-items');
            
            $this->add_render_attribute('row', 'data-elementor-columns', $settings['column']);
            if (!empty($settings['column_tablet'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
            }
            if (!empty($settings['column_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
            }

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-testimonial-item');
            $this->add_render_attribute('item', 'class', 'column-item');

            if ($settings['enable_carousel'] === 'yes') {
                $data = $this->get_settings_json();
                $this->add_render_attribute( 'wrapper', 'data-settings', $data );
                $this->add_render_attribute( 'wrapper', 'class', "elementor-opal-slick-slider elementor-slick-slider" );
            }
            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php foreach ($settings['testimonials'] as $testimonial): 
                        ?>
                        <div <?php echo $this->get_render_attribute_string('item'); ?> <?php if( $settings['testimonial_layout'] === 'layout_4') {
                            echo 'style="background-image:url('.esc_url($testimonial['testimonial_image']['url']).')"'; } ?> >
                            <?php if($settings['testimonial_layout'] == 'layout_1'): ?>
                                <?php $this->render_image($settings, $testimonial); ?>
                            <?php endif; ?>
                            <div class="elementor-testimonial-content">
                                <?php echo $testimonial['testimonial_content']; ?>
                            </div>
                            <?php if($settings['testimonial_layout'] == 'layout_3'): ?>
                                <?php $this->render_image($settings, $testimonial); ?>
                            <?php endif; ?>
                            <div class="elementor-testimonial-meta-inner">
                                <?php if($settings['testimonial_layout'] == 'layout_2'): ?>
                                    <?php $this->render_image($settings, $testimonial); ?>
                                <?php endif; ?>
                                <div class="elementor-testimonial-details">
                                    <?php
                                    $testimonial_name_html = $testimonial['testimonial_name'];
                                    if (!empty($testimonial['testimonial_link']['url'])) :
                                        $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . $testimonial_name_html . '</a>';
                                    endif;
                                    ?>
                                    <div class="elementor-testimonial-name"><?php echo $testimonial_name_html; ?></div>
                                    <div class="elementor-testimonial-job"><?php echo $testimonial['testimonial_job']; ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $testimonial){ ?>
        <div class="elementor-testimonial-image">
        <?php
            $testimonial['testimonial_image_size']             = $settings['testimonial_image_size'];
            $testimonial['testimonial_image_custom_dimension'] = $settings['testimonial_image_custom_dimension'];
            if (!empty($testimonial['testimonial_image']['url'])) :
                $image_html = Group_Control_Image_Size::get_attachment_image_html($testimonial, 'testimonial_image');
                echo $image_html;
            endif;
        ?>
        </div>
    <?php
    }

}
