<?php
/**
 * Single post partial template.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<?php do_action('latehome_free_content_single_before'); ?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <div class="post-thumbnail">
            <?php do_action('latehome_free_single_post_preview'); ?>
        </div>
        <div class="entry-meta">
            <?php latehome_free_posted_on(); ?>
        </div><!-- .entry-meta -->

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

<?php do_action('latehome_free_content_single_after'); ?>