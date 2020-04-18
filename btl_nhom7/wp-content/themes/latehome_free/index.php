<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
$container = get_theme_mod('latehome_free_container_type');
$layout = get_theme_mod('latehome_free_blog_archive_layout');
$colclass = apply_filters('latehome_free_blog_columns_class', "wp-col-12");
?>

<div class="wrapper" id="index-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check and opens the primary div -->
            <?php get_template_part('global-templates/left-sidebar-check'); ?>


            <div class="site-main" id="main">

                <?php if (have_posts()) : ?>


                    <?php /* Start the Loop */ ?>


                    <div class="wpopal-blog-<?php echo esc_attr($layout); ?>-style">
                        <div class="row">

                            <?php if ($layout): ?>

                                <?php while (have_posts()) : the_post(); ?>
                                    <div class="<?php echo esc_attr($colclass); ?>">
                                        <?php

                                        /*
                                         * Include the Post-Format-specific template for the content.
                                         * If you want to override this in a child theme, then include a file
                                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                         */
                                        get_template_part('partials/loop-blog/' . $layout, get_post_format());
                                        ?>
                                    </div>
                                <?php endwhile; ?>

                            <?php elseif (is_home()) : ?>
                                <?php while (have_posts()) : the_post(); ?>
                                    <div class="<?php echo esc_attr($colclass); ?>">
                                        <?php

                                        /*
                                         * Include the Post-Format-specific template for the content.
                                         * If you want to override this in a child theme, then include a file
                                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                         */
                                        get_template_part('partials/loop/content-home', get_post_format());
                                        ?>
                                    </div>
                                <?php endwhile; ?>
                            <?php else : ?>

                                <?php while (have_posts()) : the_post(); ?>
                                    <div class="<?php echo esc_attr($colclass); ?>">
                                        <?php

                                        /*
                                         * Include the Post-Format-specific template for the content.
                                         * If you want to override this in a child theme, then include a file
                                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                         */
                                        get_template_part('partials/loop/content', get_post_format());
                                        ?>
                                    </div>
                                <?php endwhile; ?>

                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>

                    <?php get_template_part('partials/loop/content', 'none'); ?>

                <?php endif; ?>

            </div><!-- #main -->

            <!-- The pagination component -->
            <?php latehome_free_pagination(); ?>

            <!-- Do the right sidebar check -->
            <?php get_template_part('global-templates/right-sidebar-check'); ?>


        </div><!-- .row -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
