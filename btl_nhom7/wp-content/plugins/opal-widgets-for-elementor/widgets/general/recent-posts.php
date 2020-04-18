<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;
/**
 * Class OSF_Elementor_Blog
 */
class OSF_Elementor_Recent_posts_Widget extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-recent-post';
    }

    public function get_title() {
        return __('Opal Recent Posts', 'opalelementor');
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
        return 'eicon-wordpress';
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
            'layout',
            [
                'label' => __('Layout', 'opalelementor'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'show_thumbnail',
            [
                'label' => __( 'Show Thumbnail', 'opalelementor' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $image_sizes = array();
        foreach ( get_intermediate_image_sizes() as $size ) {
            $image_sizes[$size] = $size;
        }
        $this->add_control(
            'thumbnail_size',
            [
                'label' => __( 'Thumbnail Size', 'opalelementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => $image_sizes,
                'default' => 'thumbnail',
                'condition' => [
                    'show_thumbnail' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => __( 'Show Date', 'opalelementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => __( 'Show author', 'opalelementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_desc',
            [
                'label' => __( 'Show Description', 'opalelementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'date_style_section',
            [
                'label' => __( 'Date', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .article-post .meta .date' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .article-post .meta .date',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'author_style_section',
            [
                'label' => __( 'Author', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_author' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'author_label_color',
            [
                'label' => __( 'Label Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .article-post .author-label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_label_typo',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .article-post .author-label',
                'label' => __( 'Label Typography', 'opalelementor' )
            ]
        );

        $this->add_control(
            'author_name_color',
            [
                'label' => __( 'Author Name', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .article-post .author-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_name_typo',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .article-post .author-name',
                'label' => __( 'Name Typography', 'opalelementor' )
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'title_section',
            [
                'label' => __( 'Title', 'opalelementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .article-post .title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Hover Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .article-post .title:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .article-post .title'
            ]
        );

        $this->end_controls_section();
    }

    public static function get_query_args($control_id, $settings) {
        $defaults = [
            $control_id . '_post_type' => 'post',
            $control_id . '_posts_ids' => [],
            'orderby'                  => 'date',
            'order'                    => 'desc',
            'posts_per_page'           => 3,
            'offset'                   => 0,
        ];

        $settings = wp_parse_args($settings, $defaults);


        if ('current_query' === 'post') {
            $current_query_vars = $GLOBALS['wp_query']->query_vars;

            return $current_query_vars;
        }

        $query_args = [
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish', // Hide drafts/private posts for admins
        ];


        $query_args['post_type']      = 'post';
        $query_args['posts_per_page'] = $settings['posts_per_page'];
        $query_args['tax_query']      = [];

        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        if (0 < $settings['offset']) {
            /**
             * Due to a WordPress bug, the offset will be set later, in $this->fix_query_offset()
             * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
             */
            $query_args['offset_to_fix'] = $settings['offset'];
        }

        $taxonomies = get_object_taxonomies('post', 'objects');

        foreach ($taxonomies as $object) {
            $setting_key = $control_id . '_' . $object->name . '_ids';

            if (!empty($settings[$setting_key])) {
                $query_args['tax_query'][] = [
                    'taxonomy' => $object->name,
                    'field'    => 'term_id',
                    'terms'    => $settings[$setting_key],
                ];
            }
        }

        return $query_args;
    }

    public function query_posts() {
        $query_args = $this->get_query_args('posts', $this->get_settings());
        return new WP_Query($query_args);
    }

    protected function render() {
        $settings = wp_parse_args( $this->get_settings_for_display(), array(
                'thumbnail_size' => 'thumbnail',
                'show_thumbnail' => 'yes',
                'show_desc' => 'no',
                'show_author' => 'yes',
                'show_date' => 'yes'
            ) );
        $thumbnail_size = ! empty( $settings['thumbnail_size'] ) ? $settings['thumbnail_size'] : 'thumbnail';
        $query    = $this->query_posts();

        if (!$query->found_posts) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'elementor-recent-post-wrapper');
        $this->add_render_attribute('row', 'class', 'row');

        ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php while ($query->have_posts()) { $query->the_post(); ?>
                        <article class="article-post article-<?php echo esc_attr( get_the_ID() ) ?>">
                            <?php if ( ! empty( $settings['show_thumbnail'] ) && $settings['show_thumbnail'] == 'yes' ) : ?>
                                <div class="media"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumbnail_size ) ?></a></div>
                            <?php endif; ?>
                            <div class="detail">
                                <div class="meta">
                                    <?php if ( ! empty( $settings['show_author'] ) && $settings['show_author'] == 'yes' ) : ?>
                                        <span class="author-label"><?php __( 'Post by', 'opalelementor' ) ?></span>
                                        <span class="author-name"><?php printf( '%s', get_the_author_meta( 'first_name', get_post_field( 'post_author', get_the_ID() ) ) ) ?></span>
                                    <?php endif; ?>

                                    <?php if ( ( ! empty( $settings['show_author'] ) && $settings['show_author'] == 'yes' ) && ( ! empty( $settings['show_date'] ) && $settings['show_date'] == 'yes' ) ) : ?>
                                        <span class="spacetor">|</span>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $settings['show_date'] ) && $settings['show_date'] == 'yes' ) : ?>
                                        <span class="date"><?php echo esc_html( get_the_date( get_option( 'date_format' ) ) ) ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
                                <?php if ( ! empty( $settings['show_desc'] ) && $settings['show_desc'] == 'yes' ) : ?>
                                    <p><?php the_excerpt() ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </div>
        <?php

        wp_reset_postdata();

    }

}