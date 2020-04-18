<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Producttabs_Widget extends  OSF_Elementor_Slick_Widget{

    public function get_categories() {
        return array('opal-woo');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-producttabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Woo Product Tabs', 'opalelementor' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $templates = Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();

        $options = [
            '0' => '— ' . __( 'Select', 'opalelementor' ) . ' —',
        ];

        $types = [];

        foreach ( $templates as $template ) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __( 'Tabs', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => __( 'Tabs Items', 'opalelementor' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'tab_title' => __( 'Tab #1', 'opalelementor' ),
                        'source' => 'html',
                        'tab_html' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opalelementor' ),
                    ],
                    [
                        'tab_title' => __( 'Tab #2', 'opalelementor' ),
                        'source' => 'html',
                        'tab_html' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'opalelementor' ),
                    ],
                ],
                'fields'      => [
                    [
                        'name' => 'tab_title',
                        'label' => __( 'Title & Content', 'opalelementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Tab Title', 'opalelementor' ),
                        'placeholder' => __( 'Tab Title', 'opalelementor' ),
                        'label_block' => true,
                    ],
                    [
                        'name'    => 'limit',
                        'label'   => __('Posts Per Page', 'opalelementor'),
                        'type'    => Controls_Manager::NUMBER,
                        'default' => 6,
                    ],
                    [
                        'name'    => 'column',
                        'label'   => __('columns', 'opalelementor'),
                        'type'    => \Elementor\Controls_Manager::SELECT,
                        'default' => 3,
                        'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5=> 5, 6 => 6],
                    ],
                    [
                        'name'    => 'orderby',
                        'label'   => __('Order By', 'opalelementor'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'date',
                        'options' => [
                            'date'       => __('Date', 'opalelementor'),
                            'id'         => __('Post ID', 'opalelementor'),
                            'menu_order' => __('Menu Order', 'opalelementor'),
                            'popularity' => __('Number of purchases', 'opalelementor'),
                            'rating'     => __('Average Product Rating', 'opalelementor'),
                            'title'      => __('Product Title', 'opalelementor'),
                            'rand'       => __('Random', 'opalelementor'),
                        ],
                    ],
                    [
                        'name'    => 'order',
                        'label'   => __('Order', 'opalelementor'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'desc',
                        'options' => [
                            'asc'  => __('ASC', 'opalelementor'),
                            'desc' => __('DESC', 'opalelementor'),
                        ],
                    ],
                    [
                        'name'     => 'categories',
                        'label'    => __('Categories', 'opalelementor'),
                        'type'     => Controls_Manager::SELECT2,
                        'options'  => $this->get_product_categories(),
                        'multiple' => true,
                    ],
                    [
                        'name'      => 'cat_operator',
                        'label'     => __('Category Operator', 'opalelementor'),
                        'type'      => Controls_Manager::SELECT,
                        'default'   => 'IN',
                        'options'   => [
                            'AND'    => __('AND', 'opalelementor'),
                            'IN'     => __('IN', 'opalelementor'),
                            'NOT IN' => __('NOT IN', 'opalelementor'),
                        ],
                        'condition' => [
                            'categories!' => ''
                        ],
                    ],
                    [
                        'name'    => 'product_type',
                        'label'   => __('Product Type', 'opalelementor'),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'newest',
                        'options' => [
                            'newest'       => __('Newest Products', 'opalelementor'),
                            'on_sale'      => __('On Sale Products', 'opalelementor'),
                            'best_selling' => __('Best Selling', 'opalelementor'),
                            'top_rated'    => __('Top Rated', 'opalelementor'),
                            'featured'     => __('Featured Product', 'opalelementor'),
                        ],
                    ]
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );


        $this->add_control(
            'type',
            [
                'label' => __( 'Type', 'opalelementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __( 'Horizontal', 'opalelementor' ),
                    'vertical' => __( 'Vertical', 'opalelementor' ),
                ],
                'prefix_class' => 'elementor-tabs-view-',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'align_items',
            [
                'label'        => __('Align', 'opalelementor'),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'options'      => [
                    'left'    => [
                        'title' => __('Left', 'opalelementor'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'opalelementor'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'opalelementor'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'opal-tab-title-align-',
                'condition'    => [
                    'type' => 'horizontal',
                ],
            ]
        );


        $this->add_control(
            'limit',
            [
                'label'   => __('Posts Per Page', 'opalelementor'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'   => __('columns', 'opalelementor'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5=> 5, 6 => 6],
                'prefix_class' => 'woocommerce-grid%s-',
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label'   => __('Paginate', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'       => __('None', 'opalelementor'),
                    'pagination' => __('Pagination', 'opalelementor'),
                ],
            ]
        );

       $this->add_control(
            'product_layout',
            [
                'label'   => __('Product Layout', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'content',
                'options' => osf_elementor_product_loop_layouts()
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


        /////


        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => __( 'Tabs', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'navigation_width',
            [
                'label' => __( 'Navigation Width', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'type' => 'vertical',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => __( 'Border Width', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content, {{WRAPPER}} .elementor-tabs-content-wrapper' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => __( 'Border Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content, {{WRAPPER}} .elementor-tabs-content-wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => __( 'Title', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('pagination_colors');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __('Normal', 'opalelementor'),
            ]
        );

        $this->add_control(
            'tab_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         $this->add_responsive_control(
            'text_margin',
            [
                'label' => __( 'Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .elementor-tab-desktop-title',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius Active', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __('Hover', 'opalelementor'),
            ]
        );

        $this->add_control(
            'tab_color_hover',
            [
                'label' => __( 'Color Hover', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_control(
            'background_color_hover',
            [
                'label' => __( 'Background Color Hover', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover' => 'background-color: {{VALUE}};'
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border_hover',
                'selector' => '{{WRAPPER}} .elementor-tab-desktop-title:hover',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => __('Active', 'opalelementor'),
            ]
        );

        $this->add_control(
            'tab_active_color',
            [
                'label' => __( 'Active Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
            ]
        );

        $this->add_control(
            'background_color_active',
            [
                'label' => __( 'Background Color Active', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border_active',
                'selector' => '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'heading_content',
            [
                'label' => __( 'Content', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => __( 'Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
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

    protected function get_product_type($atts, $product_type) {
        switch ($product_type) {
            case 'featured':
                $atts['visibility'] = "featured";
                break;

            default:
                break;
        }
        return $atts;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $tabs = $this->get_settings_for_display( 'tabs' );

        $settings = $this->get_settings_for_display();


        $id_int = substr( $this->get_id_int(), 0, 3 );
        ?>
        <div class="elementor-tabs" role="tablist">
            <div class="elementor-tabs-wrapper">
                <?php
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;

                    $class = ($index == 0)? 'elementor-active' : '';

                    $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

                    $this->add_render_attribute( $tab_title_setting_key, [
                        'id' => 'elementor-tab-title-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-title', 'elementor-tab-desktop-title', $class],
                        'data-tab' => $tab_count,
                        'tabindex' => $id_int . $tab_count,
                        'role' => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ] );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>><?php echo $item['tab_title']; ?></div>
                <?php endforeach; ?>
            </div>
            <div class="elementor-tabs-content-wrapper">
                <?php
                foreach ( $tabs as $index => $item ) :
                    $producttab = $item;
                    $tab_count = $index + 1;

                    $class_content = ($index == 0)? 'elementor-active' : '';

                    $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-content', 'elementor-clearfix', $class_content],
                        'data-tab' => $tab_count,
                        'role' => 'tabpanel',
                        'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                    ] );

                    $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                        <?php

                        $type     = 'products';
                        $atts     = [
                            'limit'          => $settings['limit'],
                            'columns'        => $settings['column'],
                            'orderby'        => $producttab['orderby'],
                            'order'          => $producttab['order'],
                            'product_layout' => 'grid',
                        ];

                        $atts = $this->get_product_type($atts, $producttab['product_type']);
                        if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
                            $type = 'sale_products';
                        } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
                            $type = 'best_selling_products';
                        } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
                            $type = 'top_rated_products';
                        }

                        if (!empty($producttab['categories'])) {
                            $atts['category']     = $producttab['categories'];
                            $atts['cat_operator'] = $producttab['cat_operator'];
                        }


                        if ($settings['paginate'] === 'pagination') {
                            $atts['paginate'] = 'true';
                        }


                        ?>

                        <?php
                        $tab_count = $index + 1;

                        $class_content = ($index == 0)? 'elementor-active' : '';

                        $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                        $this->add_render_attribute( $tab_content_setting_key, [
                            'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                            'class' => [ 'elementor-tab-content', 'elementor-clearfix', $class_content],
                            'data-tab' => $tab_count,
                            'role' => 'tabpanel',
                            'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                        ] );

                        $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
                        ?>

                            <?php
                            if( isset($atts['category']) && is_array( $atts['category'] ) ){
                                $atts['category'] = implode( ",", $atts['category']  );
                            }

                            $product_type = $this->parse_product_type($producttab['product_type']);

                            $shortcode = new WC_Shortcode_Products($atts, $product_type);

                            $this->render_carousel_or_grid( $settings, $shortcode->get_content() );

                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function parse_product_type( $type ) {
	    switch ($type) {
		    case 'newest':
			    $product_type = 'recent_products';
			    break;
		    case 'on_sale':
			    $product_type = 'sale_products';
			    break;
		    case 'best_selling':
			    $product_type = 'best_selling_products';
			    break;
		    case 'top_rated':
			    $product_type = 'top_rated_products';
			    break;
		    case 'featured':
			    $product_type = 'featured_products';
			    break;

		    default:
			    $product_type = 'products';
			    break;
	    }
	    return $product_type;
    }
}
