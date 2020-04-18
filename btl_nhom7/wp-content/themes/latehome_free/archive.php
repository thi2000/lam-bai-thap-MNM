<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<?php
$container = get_theme_mod('latehome_free_container_type');
$layout = get_theme_mod('latehome_free_blog_archive_layout');
?>

<div class="wrapper" id="archive-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">
            <!-- Do the left sidebar check -->
            <?php get_template_part('global-templates/left-sidebar-check'); ?>

            <div class="site-main" id="main">

                <?php if (have_posts()) : ?>
                    <?php $colclass = apply_filters('latehome_free_blog_columns_class', "wp-col-12"); ?>
                    <header class="page-header">
                        <?php
                        the_archive_title('<h1 class="page-title">', '</h1>');
                        the_archive_description('<div class="taxonomy-description">', '</div>');
                        ?>
                    </header><!-- .page-header -->

                    <?php /* Start the Loop */ ?>

                    <div class="wpopal-blog-<?php echo esc_attr($layout); ?>-style">
                        <div class="row">

                            <?php if ($layout): ?>

                                <?php while (have_posts()) : the_post(); ?>
                                    <div class="<?php echo esc_attr($colclass); ?> column-item">
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

        </div> <!-- .row -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
