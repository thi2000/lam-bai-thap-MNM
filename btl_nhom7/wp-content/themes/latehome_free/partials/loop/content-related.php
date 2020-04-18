<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">
        <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">

        <div class="meta-post-categories">
            <div class="inner">
                <?php echo get_the_category_list(', '); ?>
            </div>
        </div>

        <?php the_title(sprintf('<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h4>'); ?>

        <?php if ('post' == get_post_type()) : ?>
            <div class="entry-meta">
                <?php latehome_free_posted_on(); ?>
            </div><!-- .entry-meta -->

            <?php
            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'latehome_free'),
                'after' => '</div>',
            ));
            ?>

        <?php endif; ?>

    </div>
    <!-- .entry-content -->
</article><!-- #post-## -->
