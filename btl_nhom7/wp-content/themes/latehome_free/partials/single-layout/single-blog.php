<div class="single-blog-v1" id="content" tabindex="-1">

    <div class="site-main" id="main">

        <?php while (have_posts()) : the_post(); ?>

            <div class="container">
                <div class="row">
                    <div class=" wp-col-12">

                        <?php do_action('latehome_free_content_single_before'); ?>
                        <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                            <header class="entry-header">

                                <?php the_title('<h2 class="entry-title">', '</h2>'); ?>

                                <div class="entry-meta">

                                    <?php latehome_free_posted_on(); ?>

                                </div><!-- .entry-meta -->

                                <?php do_action('latehome_free_single_post_preview'); ?>

                            </header><!-- .entry-header -->


                            <div class="entry-content">

                                <?php the_content(); ?>

                                <?php
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'latehome_free'),
                                    'after' => '</div>',
                                ));
                                ?>

                            </div><!-- .entry-content -->

                            <footer class="entry-footer">

                                <?php latehome_free_entry_footer(); ?>
                                <?php do_action('latehome_free_single_entry_footer_after'); ?>
                            </footer><!-- .entry-footer -->

                        </article><!-- #post-## -->

                    </div><!-- #main -->
                </div>
            </div><!-- .row -->

            <?php echo latehome_free_post_prev_next(); ?>

            <div class="container comment-container">
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            </div>

        <?php endwhile; // end of the loop. ?>
    </div>


</div><!-- Container end -->