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
        <?php if (get_the_post_thumbnail()): ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php echo get_the_post_thumbnail($post->ID, 'latehome_free-featured-image-full'); ?>
                </a>
            </div>
        <?php endif; ?>
        <?php if ('post' == get_post_type()) : ?>
            <div class="entry-meta">
                <?php latehome_free_posted_on(); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
        
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
        <?php the_title(sprintf('<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h3>'); ?>
        <?php if ('post' == get_post_type()) :
            /* translators: %s: Name of current post */
            the_content(sprintf(
                __('Read more<span class="screen-reader-text"> "%s"</span>', 'latehome_free'),
                get_the_title()
            ));
            ?>

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
