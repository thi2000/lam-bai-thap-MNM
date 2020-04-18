<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$url = get_the_post_thumbnail_url($post->ID, 'metro');
?>

<article <?php post_class('blog-mark-hover-item'); ?> id="post-<?php the_ID(); ?>">

    <!--    --><?php //latehome_free_blog_posted_date(); ?>
    <header class="entry-header">
        <div class="post-thumbnail">
            <?php do_action('latehome_free_loop_post_preview'); ?>
        </div>
    </header><!-- .entry-header -->

    <div class="mark-hover-content">
        <div class="entry-content">
            <?php the_title(sprintf('<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
                '</a></h5>'); ?>

            <div class="entry-meta">
                <?php latehome_free_posted_on(); ?>
            </div><!-- .entry-meta -->

        </div><!-- .entry-header -->
    </div><!-- .entry-content -->

</article><!-- #post-## -->
