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

<article <?php post_class('blog-grid-item'); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">
        <?php if (get_the_post_thumbnail()): ?>
        <div class="post-thumbnail">
        <?php do_action('latehome_free_loop_post_preview'); ?>
        </div>
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php if ('post' == get_post_type()) : ?>
            <div class="entry-meta">
                <?php latehome_free_posted_on(); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
        <?php the_title(sprintf('<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h5>'); ?>
        

        <div class="entry-excerpt">
            <?php
            the_excerpt();
            ?>
        </div>

    </div><!-- .entry-content -->
</article><!-- #post-## -->
