<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

/**
 * Class OSF_Elementor_Blog
 */
class OSF_Elementor_Masonry_posts_Widget extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-masonry-posts';
    }

    public function get_title() {
        return __('Opal Masonry Posts', 'opalelementor');
    }

    public function get_script_depends() {
        return [
            'jquery-isotope',
            'imagesloaded'
        ];
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
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __('Posts Per Page', 'opalelementor'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
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
                'default' => 'post_date',
                'options' => [
                    'post_date'  => __('Date', 'opalelementor'),
                    'post_title' => __('Title', 'opalelementor'),
                    'menu_order' => __('Menu Order', 'opalelementor'),
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
                'options'  => $this->get_post_categories(),
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
            'style',
            [
                'label'     => __('Style Item Layout', 'opalelementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => $this->get_template_post_type(),
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label'     => __('Columns', 'opalelementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 3,
                'options'   => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 6 => 6]
            ]
        );
         
        $this->add_control(
            'alignment',
            [
                'label' => __( 'Alignment', 'opalelementor' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'opalelementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'opalelementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'opalelementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .entry-header, {{WRAPPER}} .entry-content' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination',
            [
                'label' => __('Pagination', 'opalelementor'),
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label'   => __('Pagination', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''                      => __('None', 'opalelementor'),
                    'numbers'               => __('Numbers', 'opalelementor'),
                    'prev_next'             => __('Previous/Next', 'opalelementor'),
                    'numbers_and_prev_next' => __('Numbers', 'opalelementor') . ' + ' . __('Previous/Next', 'opalelementor'),
                ],
            ]
        );

        $this->add_control(
            'pagination_page_limit',
            [
                'label'     => __('Page Limit', 'opalelementor'),
                'default'   => '5',
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );

        $this->add_control(
            'pagination_numbers_shorten',
            [
                'label'     => __('Shorten', 'opalelementor'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
                'condition' => [
                    'pagination_type' => [
                        'numbers',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_prev_label',
            [
                'label'     => __('Previous Label', 'opalelementor'),
                'default'   => __('&laquo; Previous', 'opalelementor'),
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_next_label',
            [
                'label'     => __('Next Label', 'opalelementor'),
                'default'   => __('Next &raquo;', 'opalelementor'),
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_align',
            [
                'label'     => __('Alignment', 'opalelementor'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
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
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_image',
            [
                'label'     => __('Image', 'opalelementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'image_padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-header img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'image_margin',
            [
                'label' => __( 'Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-header img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();  

        $this->start_controls_section(
            'section_title',
            [
                'label'     => __('Title', 'opalelementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .entry-content .entry-title a',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Color hover', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_margin',
            [
                'label' => __( 'Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();   

        $this->start_controls_section(
            'section_description',
            [
                'label'     => __('Description', 'opalelementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .entry-content .entry-excerpt, {{WRAPPER}} .entry-content .entry-excerpt p',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __('Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-excerpt, {{WRAPPER}} .entry-content .entry-excerpt p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'description_margin',
            [
                'label' => __( 'Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();   

        $this->start_controls_section(
            'section_button',
            [
                'label'     => __('Button', 'opalelementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .entry-content .entry-excerpt a.wpopalbootstrap-read-more-link',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => __('Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-excerpt a.wpopalbootstrap-read-more-link' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_color_hover',
            [
                'label'     => __('Color hover', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-excerpt a.wpopalbootstrap-read-more-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-excerpt a.wpopalbootstrap-read-more-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_margin',
            [
                'label' => __( 'Margin', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-content .entry-excerpt a.wpopalbootstrap-read-more-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        

        $this->end_controls_section();   

        $this->start_controls_section(
            'section_pagination_style',
            [
                'label'     => __('Pagination', 'opalelementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pagination_typography',
                'selector' => '{{WRAPPER}} .elementor-pagination',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_control(
            'pagination_color_heading',
            [
                'label'     => __('Colors', 'opalelementor'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('pagination_colors');

        $this->start_controls_tab(
            'pagination_color_normal',
            [
                'label' => __('Normal', 'opalelementor'),
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => __('Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_color_hover',
            [
                'label' => __('Hover', 'opalelementor'),
            ]
        );

        $this->add_control(
            'pagination_hover_color',
            [
                'label'     => __('Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_color_active',
            [
                'label' => __('Active', 'opalelementor'),
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label'     => __('Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pagination_spacing',
            [
                'label'     => __('Space Between', 'opalelementor'),
                'type'      => Controls_Manager::SLIDER,
                'separator' => 'before',
                'default'   => [
                    'size' => 10,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)'  => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)'       => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)'        => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function get_post_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'category',
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



    public static function get_query_args($settings) {
        $query_args = [
            'post_type' => 'post',
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish', // Hide drafts/private posts for admins
        ];

        if(!empty( $settings['categories'])){
            $categories = array();
            foreach($settings['categories'] as $category){
                $cat = get_term_by('slug', $category, 'category');
                if(!is_wp_error($cat) && is_object($cat)){
                    $categories[] = $cat->term_id;
                }
            }

            if($settings['cat_operator'] == 'AND'){
                $query_args['category__and'] = $categories;
            }elseif($settings['cat_operator'] == 'IN'){
                $query_args['category__in'] = $categories;
            }else{
                $query_args['category__not_in'] = $categories;
            }
        }

        $query_args['posts_per_page'] = $settings['posts_per_page'];

        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        return $query_args;
    }

    public function get_current_page() {
        if ('' === $this->get_settings('pagination_type')) {
            return 1;
        }

        return max(1, get_query_var('paged'), get_query_var('page'));
    }

    public function get_posts_nav_link($page_limit = null) {
        if (!$page_limit) {
            $page_limit = $this->query_posts()->max_num_pages;
        }

        $return = [];

        $paged = $this->get_current_page();

        $link_template     = '<a class="page-numbers %s" href="%s">%s</a>';
        $disabled_template = '<span class="page-numbers %s">%s</span>';

        if ($paged > 1) {
            $next_page = intval($paged) - 1;
            if ($next_page < 1) {
                $next_page = 1;
            }

            $return['prev'] = sprintf($link_template, 'prev', get_pagenum_link($next_page), $this->get_settings('pagination_prev_label'));
        } else {
            $return['prev'] = sprintf($disabled_template, 'prev', $this->get_settings('pagination_prev_label'));
        }

        $next_page = intval($paged) + 1;

        if ($next_page <= $page_limit) {
            $return['next'] = sprintf($link_template, 'next', get_pagenum_link($next_page), $this->get_settings('pagination_next_label'));
        } else {
            $return['next'] = sprintf($disabled_template, 'next', $this->get_settings('pagination_next_label'));
        }

        return $return;
    }

    protected function render_loop_footer() {

        $parent_settings = $this->get_settings();
        if ('' === $parent_settings['pagination_type']) {
            return;
        }

        $page_limit = $this->query_posts()->max_num_pages;
        if ('' !== $parent_settings['pagination_page_limit']) {
            $page_limit = min($parent_settings['pagination_page_limit'], $page_limit);
        }

        if (2 > $page_limit) {
            return;
        }

        $this->add_render_attribute('pagination', 'class', 'elementor-pagination');

        $has_numbers   = in_array($parent_settings['pagination_type'], ['numbers', 'numbers_and_prev_next']);
        $has_prev_next = in_array($parent_settings['pagination_type'], ['prev_next', 'numbers_and_prev_next']);

        $links = [];

        if ($has_numbers) {
            $links = paginate_links([
                'type'               => 'array',
                'current'            => $this->get_current_page(),
                'total'              => $page_limit,
                'prev_next'          => false,
                'show_all'           => 'yes' !== $parent_settings['pagination_numbers_shorten'],
                'before_page_number' => '<span class="elementor-screen-only">' . __('Page', 'opalelementor') . '</span>',
            ]);
        }

        if ($has_prev_next) {
            $prev_next = $this->get_posts_nav_link($page_limit);
            array_unshift($links, $prev_next['prev']);
            $links[] = $prev_next['next'];
        }

        ?>
        <div class="pagination">
            <nav class="elementor-pagination" role="navigation" aria-label="<?php esc_attr_e('Pagination', 'opalelementor'); ?>">
                <?php echo implode(PHP_EOL, $links); ?>
            </nav>
        </div>
        <?php
    }


    public function query_posts() {
        $query_args = $this->get_query_args( $this->get_settings());
        return new WP_Query($query_args);
    }


    protected function render() {
        $settings = $this->get_settings_for_display();

        $query    = $this->query_posts();

        if (!$query->found_posts) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'elementor-post-wrapper wpopal-blog-'. $settings['style'] .'-style elementor-masonry-style' );
 
        $this->add_render_attribute('row', 'class', 'row elementor-items-container');
       
        $class = 'wp-col-md-'.floor(12/$settings['column']);

        if( isset($settings['column_tablet']) && $settings['column_tablet'] ) {
            $class .= ' wp-col-sm-'.floor(12/$settings['column_tablet']);
        }
        if( isset($settings['column_tablet']) && $settings['column_mobile'] ) {
            $class .= ' wp-col-xs-'.floor(12/$settings['column_mobile']);
        }


        if( is_dir(get_template_directory() .'/partials/loop-blog/') ){
            $template = 'partials/loop-blog/' . $settings['style'] ; 
        } else {
            $template = '';
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>

             <ul class="isotype-filter">
                  
                    <li><a href="#" data-filter="filter-all">
                            <span><?php echo __( 'All' , 'opalelementor' ); ?></span>
                    </a></li> 
                   
                <?php  if(isset($settings['categories']) && $settings['categories']) :
                    foreach( $settings['categories'] as $category):
                        $cat = get_term_by('slug', $category, 'category');
                        if(!is_wp_error($cat) && is_object($cat)) : ?>
                            <li><a href="<?php echo get_category_link($cat->term_id); ?>" data-filter="filter-<?php echo esc_attr( $cat->slug ); ?>">
                                <span><?php echo esc_attr( $cat->name ); ?></span>
                            </a></li>           
                        <?php    
                        endif; 
                    endforeach; 
                endif;?>   

            </ul>    


            <div <?php echo $this->get_render_attribute_string('row') ?>>

                <?php
                while ($query->have_posts()) {
                    $categories = get_the_category();
                     $eclass = ' ';
                    foreach( $categories as $category ){
                        $eclass .= ' filter-'.$category->slug;
                    }

                    $query->the_post(); ?>
                     <div class="<?php echo esc_attr( $class ) . $eclass; ?> filter-all column-item"  >
                        <?php  get_template_part( $template ); ?>
                    </div>
                <?php } ?>
            </div>

            <?php $this->render_loop_footer(); ?>
        </div>
        <?php
        wp_reset_postdata();
    }

    private function get_template_post_type(){
        $folderes = glob( get_template_directory() .'/partials/loop-blog/*');
        $output = array();

        foreach( $folderes as $folder ){
            $folder = str_replace( "item-", '', str_replace( '.php', '', wp_basename($folder) ) );
            $value = str_replace( '_', ' ', str_replace('-', ' ', ucfirst($folder)) );
            $output[$folder] = $value;
        }

        return $output;
    }

}