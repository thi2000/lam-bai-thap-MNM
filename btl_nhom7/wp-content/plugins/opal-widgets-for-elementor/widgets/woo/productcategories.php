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

class OSF_Elementor_ProductCategories_Widget extends OSF_Elementor_Slick_Widget{

    /**
     * Get widget name.
     *
     * Retrieve category widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-productcategories';
    }

    /**
     * Get widget title.
     *
     * Retrieve category widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Woo Product Categories', 'opalelementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve category widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-woocommerce';
    }

    public function get_categories() {
        return array('opal-woo');
    }

    /**
     * Register category widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->image_control = false;
        $this->start_controls_section(
            'section_category',
            [
                'label' => __('Categories', 'opalelementor'),
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'       => __('Categories Item', 'opalelementor'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => [
                    [
                        'name'     => 'category',
                        'label'    => __('Category', 'opalelementor'),
                        'type'     => Controls_Manager::SELECT2,
                        'options'  => $this->get_product_categories(),
                        'multiple' => false,
                        'show_label' => true,
                    ],
                    [
                        'name'       => 'category_image',
                        'label'      => __('Choose Image', 'opalelementor'),
                        'default'    => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'type'       => Controls_Manager::MEDIA,
                        'show_label' => false,
                    ] 
                ],
                'title_field' => 'Category ',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'category_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `category_image_size` and `category_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'category_alignment',
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
//                'prefix_class' => 'elementor-category-text-align-',
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label'   => __('Columns', 'opalelementor'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 6 => 6],
                'prefix_class' => 'elementor-grid%s-' ,
                'condition' => [
                    'enable_carousel!' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'column_gap',
            [
                'label' => __( 'Columns Gap', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-items-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}'
                     
                ],
                'condition' => [
                    'enable_carousel!' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'category_layout',
            [
                'label'   => __('Layout', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout_1',
                'options' => [
                    'layout_1'   => __('Default', 'opalelementor'),
                    'layout_2'   => __('Circle Icon Style', 'opalelementor'),
                    'layout_3'   => __('Layout 3', 'opalelementor'),
                ],
            ]
        );

        $this->add_control(
            'enable_label',
            [
                'label' => __('Enable label', 'opalelementor'),
                'type'  => Controls_Manager::SWITCHER,
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
        
         // Image.
        $this->start_controls_section(
            'section_style_category_container',
            [
                'label'     => __('Container', 'opalelementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'container_margin',
            [
                'label'      => __('Margin', 'opalelementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-category-item .inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_padding',
            [
                'label'      => __('Padding', 'opalelementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-category-item .inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'container_border',
                'selector'  => '{{WRAPPER}} .elementor-category-item .inner',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'container_image_border_radius',
            [
                'label'      => __('Border Radius', 'opalelementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-category-item .inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_bg_color',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-category-item .inner' => 'background-color: {{VALUE}}',
                ] 
                
            ]
        );


        $this->end_controls_section();
        //////////////// Image.
        $this->start_controls_section(
            'section_style_category_image',
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
                    '{{WRAPPER}} .elementor-category-wrapper .elementor-category-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'background_tabs' );

        $this->start_controls_tab( 'background_normal',
            [
                'label' => __( 'Normal', 'opalelementor' ),
                'condition' => [
                    'category_layout' => 'layout_2',
                ],
            ]
        );

        $this->add_control(
            'item_background_color',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .layout_2 .elementor-category-image' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'category_layout' => 'layout_2',
                ],
            ]
        );
        
     
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'background_hover',
            [
                'label' => __( 'Hover', 'opalelementor' ),
                'condition' => [
                    'category_layout' => 'layout_2',
                ],
            ]
        );

        $this->add_control(
            'item_background_color_hover',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-category-item:hover .elementor-category-image' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'category_layout' => 'layout_2',
                ],
            ]
        );
        
        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .elementor-category-wrapper .elementor-category-image img',
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
                    '{{WRAPPER}} .elementor-category-wrapper .elementor-category-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_category_name',
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
                    '{{WRAPPER}} .elementor-category-name, {{WRAPPER}} .elementor-category-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-category-name',
            ]
        );

        $this->add_control(
            'name_padding',
            [
                'label'      => __('Padding', 'opalelementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-category-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Count.
        $this->start_controls_section(
            'section_style_category_count',
            [
                'label' => __('Count', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'count_text_color',
            [
                'label'     => __('Text Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-category-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'count_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-category-count',
            ]
        );

        $this->end_controls_section();

    }

    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }
    /**
     * Render category widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['categories']) && is_array($settings['categories'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-category-wrapper');
            $this->add_render_attribute('wrapper', 'class', $settings['category_layout']);
            if ($settings['category_alignment']) {
                $this->add_render_attribute('wrapper', 'class', 'elementor-category-text-align-' . $settings['category_alignment']);
            }
            if( $settings['enable_carousel'] ) {
                // Row
                $this->add_render_attribute('wrapper', 'class', 'elementor-opal-slick-slider elementor-slick-slider');
                $data = $this->get_settings_json();
                $this->add_render_attribute( 'wrapper', 'data-settings', $data );
                $this->add_render_attribute('row', 'class', 'row-items');
            } else {
                // Row
                $this->add_render_attribute('row', 'class', 'elementor-grid elementor-items-container');
            }
          
             

            
            if (!empty($settings['column_tablet'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
            }
            if (!empty($settings['column_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
            }

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-category-item');
            $this->add_render_attribute('item', 'class', 'column-item');

            

            ?>
              <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                    <div <?php echo $this->get_render_attribute_string('row') ?>>
                        <?php foreach ($settings['categories'] as $category):
                    
                            $term = get_term_by( 'slug', trim($category['category']), 'product_cat' ); 
                            if( $term  ):
                        ?>
                            <div <?php echo $this->get_render_attribute_string('item'); ?>><div class="inner">
                                
                                <?php $this->render_image($settings, $category); ?>
                                
                                <div class="elementor-category-meta-inner">
                                 
                                    <div class="elementor-category-details">
                                        <?php
                                        $category_name_html = $term->name;
                                        $link = get_category_link($term->term_id);
                                        $category_name_html = '<a href="' . esc_url($link) . '">' . $category_name_html . '</a>';
                                     
                                        ?>
                                        <div class="elementor-category-name"><?php echo $category_name_html; ?></div>
                                        <div class="elementor-category-count">
                                            <?php echo $term->count;?>
                                            <?php if($settings['enable_label'] === 'yes' ): ?>
                                                <span><?php echo esc_html( 'Item', 'opalelementor');?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div></div>
                            <?php endif; ?>    
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
        }
    }

    private function render_image($settings, $category){ ?>
        <div class="elementor-category-image">
        <?php
            $category['category_image_size']             = $settings['category_image_size'];
            $category['category_image_custom_dimension'] = $settings['category_image_custom_dimension'];
            if (!empty($category['category_image']['url'])) :
                $image_html = Group_Control_Image_Size::get_attachment_image_html($category, 'category_image');
                echo $image_html;
            endif;
        ?>
        </div>
    <?php
    }

}
