<?php

if (!defined('ABSPATH')) {
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
class OSF_Elementor_Products_Widget extends OSF_Elementor_Slick_Widget {
    
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
        return 'opal-products';
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
        return __('Woo Products', 'opalelementor');
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
        return 'eicon-woocommerce';
    }


    public static function get_button_sizes() {
        return [
            'xs' => __('Extra Small', 'opalelementor'),
            'sm' => __('Small', 'opalelementor'),
            'md' => __('Medium', 'opalelementor'),
            'lg' => __('Large', 'opalelementor'),
            'xl' => __('Extra Large', 'opalelementor'),
        ];
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

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
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
            'advanced',
            [
                'label' => __('Advanced', 'opalelementor'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
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
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __('Order', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __('ASC', 'opalelementor'),
                    'desc' => __('DESC', 'opalelementor'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'    => __('Categories', 'opalelementor'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->get_product_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
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
            ]
        );

        $this->add_control(
            'product_type',
            [
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

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Style', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('product_colors');

        $this->start_controls_tab(
            'title_normal',
            [
                'label' => __('Normal', 'opalelementor'),
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

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} li.product .woocommerce-loop-product__title a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product_list_widget li a' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selectors' => '{{WRAPPER}} li.product .woocommerce-loop-product__title, {{WRAPPER}} .product_list_widget li a',

            ]
        );

        $this->add_control(
            'heading_price',
            [
                'label' => __( 'Price', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price, {{WRAPPER}} .woocommerce-Price-amount' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .price, {{WRAPPER}} .woocommerce-Price-amount',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_active',
            [
                'label' => __('Hover', 'opalelementor'),
            ]
        );

        $this->add_control(
            'heading_title_hover',
            [
                'label' => __( 'Title hover', 'opalelementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Hover Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} li.product .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product_list_widget li a:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_control(
            'heading_price_hover',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Price hover', 'opalelementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'price_hover_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price:hover, {{WRAPPER}} .woocommerce-Price-amount:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
        $settings = $this->get_settings_for_display();
        $type     = 'on_sale';
        $atts     = [
            'limit'          => $settings['limit'],
            'columns'        => $settings['column'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
            'product_layout' => $settings['product_layout'],
            'carousel'       => $settings['enable_carousel'],
        ];

        $atts = $this->get_product_type($atts, $settings['product_type']);

        $type = $this->parse_product_type( $settings['product_type'] );

        if (!empty($settings['categories'])) {
            $atts['category']     = implode(',', $settings['categories']);
            $atts['cat_operator'] = $settings['cat_operator'];
        }


        if ($settings['paginate'] === 'pagination') {
            $atts['paginate'] = 'true';
        } 

        $shortcode = new Opal_WC_Shortcode_products( $atts, $type );    
        $this->render_carousel_or_grid( $settings, $shortcode->get_content( $settings['product_layout'] ) );
        
    }

    protected function get_query_results($query_args) {
        $query_args['paged'] = 2;
        $query = new WP_Query( $query_args );
        $paginated = !empty( $query->posts ) ? true : false;
        return $paginated;
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
