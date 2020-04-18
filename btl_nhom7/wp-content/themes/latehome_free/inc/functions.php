<?php
/**
 * Check custom font is enabled at customizer or elementor 's global setting.
 */
function latehome_free_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'latehome_free_mime_types');

/**
 * Check custom font is enabled at customizer or elementor 's global setting.
 */
function latehome_free_is_elementor_activated()
{
    return function_exists('elementor_load_plugin_textdomain');
}

/**
 * Check custom font is enabled at customizer or elementor 's global setting.
 */
function latehome_free_is_enable_custom_fonts()
{
    $custom_fonts = get_theme_mod('typography_body_font');
    // if enable custom font in customizer;
    if ($custom_fonts && isset($custom_fonts['family']) && $custom_fonts['family']) {
        return true;
    }
    // if use custom font from panel of elementor
    if( get_option('elementor_default_generic_fonts') && strtolower(get_option('elementor_default_generic_fonts')) != "sans-serif" && class_exists("OSF_Elementor_Loader") ){  
          return true; 
    }
    return false;
}

/**
 * Get file svg in folder and allow set color and height
 */
function latehome_free_get_svg($name, $color = '', $custom_height = '')
{
    global $wp_filesystem;
    require_once(ABSPATH . '/wp-admin/includes/file.php');
    WP_Filesystem();
    $folder = trailingslashit(get_template_directory()) . 'assets/svg';
    $file = $folder . '/' . $name . '.svg';

    if (file_exists($file)) {
        return get_template_directory_uri() . '/assets/svg/' . $name . '.svg';
    }
}

/**
 *  Find and get all svg files in folder
 */
function latehome_free_svg_in_folders($folder)
{

    $files = glob(trailingslashit(get_template_directory()) . 'assets/svg/' . $folder . '/*.svg');
    $output = array();
    foreach ($files as $file) {
        $name = str_replace('.svg', '', basename($file));
        $output[$name] = ucfirst(str_replace("-", " ", $name));
    }

    return $output;
}

/**
 * Get post/blog item layout template
 */
function latehome_free_get_blog_item_layouts()
{
    $folderes = glob(get_template_directory() . '/partials/loop-blog/*');
    $output = array();

    foreach ($folderes as $folder) {
        $folder = str_replace("item-", '', str_replace('.php', '', wp_basename($folder)));
        $value = str_replace('_', ' ', str_replace('-', ' ', ucfirst($folder)));
        $output[$folder] = $value;
    }

    return $output;
}

/**
 * show related post by category and id
 */
if (!function_exists('latehome_free_post_related_html')) {

    function latehome_free_post_related_html($relate_count = 4, $posttype = 'post', $taxonomy = 'category')
    {

        $terms = get_the_terms(get_the_ID(), $taxonomy);
        $termids = array();

        if ($terms) {
            foreach ($terms as $term) {
                $termids[] = $term->term_id;
            }
        }
        $args = array(
            'post_type' => $posttype,
            'posts_per_page' => $relate_count,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $termids,
                    'operator' => 'IN'
                )
            )
        );
        $template_name = 'related_' . $posttype . '.php';
        $relates = new WP_Query($args);

        if ($relates->have_posts()):
            $_id = 'posts-block-' . rand(1, 9);
            $item = 4;

            $left_sidebar = apply_filters("latehome_free_left_sidebar", 'left-sidebar');
            $right_sidebar = apply_filters("latehome_free_right_sidebar", 'right-sidebar');
            $sidebar_pos = apply_filters("latehome_free_sidebar_position", get_theme_mod('latehome_free_sidebar_position'));

            if ((is_active_sidebar($right_sidebar) && 'right' === $sidebar_pos) || (is_active_sidebar($left_sidebar) && 'left' === $sidebar_pos)) {
                $item = 3;
            }
            $data = array(
                'slidesPerView' => $item,
                'spaceBetween' => 30,
                'slidesPerGroup' => $item,
            );

            ?>
            <div class="post-related-block">
                <h3>
                    <span><?php esc_html_e('Related posts', 'latehome_free'); ?></span>
                </h3>
                <div class="related-posts-content wpopal-swiper-play swiper-container"
                     id="postcarousel-<?php echo esc_attr($_id); ?>"
                     data-swiper="<?php echo esc_attr(wp_json_encode($data)); ?>">
                    <div class="swiper-wrapper">
                        <?php
                        $class_column = 12 / $relate_count;
                        while ($relates->have_posts()) : $relates->the_post();
                            ?>
                            <div class="swiper-slide"><?php get_template_part('partials/loop/content', 'related'); ?> </div>
                        <?php
                        endwhile; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        <?php
        endif;
        wp_reset_postdata();
    }
}
?>