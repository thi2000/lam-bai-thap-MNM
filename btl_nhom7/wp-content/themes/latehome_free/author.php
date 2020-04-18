<?php
/**
 * The template for displaying the author pages.
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
$container = get_theme_mod('latehome_free_container_type');
$layout = get_theme_mod('latehome_free_blog_archive_layout');
?>


<div class="wrapper" id="author-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php get_template_part('global-templates/left-sidebar-check'); ?>

            <div class="site-main" id="main">

                <header class="page-header author-header">

                    <?php
                    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug',
                        $author_name) : get_userdata(intval($author));
                    ?>

                    <?php if (!empty($curauth->ID)) : ?>
                        <?php echo get_avatar($curauth->ID); ?>
                    <?php endif; ?>
                    <h1><?php esc_html_e('About:', 'latehome_free'); ?><?php echo esc_html($curauth->nickname); ?></h1>

                    <dl>
                        <?php if (!empty($curauth->user_url)) : ?>
                            <dt><?php esc_html_e('Website', 'latehome_free'); ?></dt>
                            <dd>
                                <a href="<?php echo esc_url($curauth->user_url); ?>"><?php echo esc_html($curauth->user_url); ?></a>
                            </dd>
                        <?php endif; ?>

                        <?php if (!empty($curauth->user_description)) : ?>
                            <dt><?php esc_html_e('Profile', 'latehome_free'); ?></dt>
                            <dd><?php echo esc_html($curauth->user_description); ?></dd>
                        <?php endif; ?>
                    </dl>

                    <h2><?php esc_html_e('Posts by', 'latehome_free'); ?> <?php echo esc_html($curauth->nickname); ?>
                        :</h2>

                </header><!-- .page-header -->


                <!-- The Loop -->
                <?php if (have_posts()) : ?>
                    <?php $colclass = apply_filters('latehome_free_blog_columns_class', "wp-col-12"); ?>

                    <?php /* Start the Loop */ ?>

                    <div class="wpopal-blog-<?php echo esc_attr($layout); ?>-style 1 ">
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

                <!-- End Loop -->


            </div><!-- #main -->

            <!-- The pagination component -->
            <?php latehome_free_pagination(); ?>

            <!-- Do the right sidebar check -->
            <?php get_template_part('global-templates/right-sidebar-check'); ?>

        </div> <!-- .row -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
