<?php
/**
 * Template Name: Full Width Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

?>

<div class="wrapper" id="full-width-page-wrapper">

    <div class="container-full" id="content">

        <div class="row">

            <div class="wp-col-md-12 content-area" id="primary">

                <div class="site-main" id="main" role="main">

                    <?php while (have_posts()) : the_post(); ?>

                        <?php get_template_part('partials/loop/content', 'page'); ?>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :

                            comments_template();

                        endif;
                        ?>

                    <?php endwhile; // end of the loop. ?>

                </div><!-- #main -->

            </div><!-- #primary -->

        </div><!-- .row end -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
