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

<article <?php post_class('blog-list-item'); ?> id="post-<?php the_ID(); ?>">

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
        <div class="entry-excerpt">
            <p><?php echo wp_trim_words(get_the_content(), 60, '...'); ?></p>
            <div class="latehome_free-read-more-link-wrap">
                <a class="btn-primary-icon latehome_free-read-more-link" href=" <?php echo esc_url(get_permalink()); ?> ">
                   <span class="button-icon"><i class="fa fa-chevron-circle-right"></i> </span>
                   <span class="button-text"><?php echo esc_html__('Read More','latehome_free') ?> </span>
                </a>
            </div>
        </div>
    </div>
    <!-- .entry-content -->
</article><!-- #post-## -->
