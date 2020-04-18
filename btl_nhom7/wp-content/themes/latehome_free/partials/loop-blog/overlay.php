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

<article <?php post_class('blog-overlay-item'); ?> id="post-<?php the_ID(); ?>">
    <?php if ($url) : ?>
        <div class="overlay-img-bg" style="background-image:url('<?php echo esc_url($url); ?>');"></div>
    <?php endif; ?>

    <div class="entry-content">
        <div class="entry-meta">
            <?php latehome_free_posted_on(); ?>
        </div><!-- .entry-meta -->
        
        <?php the_title(sprintf('<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h5>'); ?>
        

        <div class="entry-excerpt">
            <?php
            the_excerpt();
            ?>
        </div>

    </div><!-- .entry-content -->
    <!-- .entry-content -->

</article><!-- #post-## -->
