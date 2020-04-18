<?php
/**
 * Search results partial template.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">

        <?php the_title(sprintf('<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h4>'); ?>

        <?php if ('post' == get_post_type()) : ?>

            <div class="entry-meta">

                <?php latehome_free_posted_on(); ?>

            </div><!-- .entry-meta -->

        <?php endif; ?>

    </header><!-- .entry-header -->

    <div class="entry-summary">

        <?php the_excerpt(); ?>

    </div><!-- .entry-summary -->

</article><!-- #post-## -->
