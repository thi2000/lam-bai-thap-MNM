<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<?php do_action('latehome_free_content_bottom'); ?>
</div>

<?php do_action('latehome_free_after_site_content'); ?>
<?php
/**
 * latehome_free_before_footer hook.
 *
 * @since 0.1
 */
do_action('latehome_free_before_footer');
?>

<div <?php latehome_free_footer_class(); ?>>
    <?php
    /**
     * latehome_free_before_footer_content hook.
     *
     * @since 0.1
     */
    do_action('latehome_free_before_footer_content');

    /**
     * latehome_free_footer hook.
     *
     * @since 1.3.42
     *
     * @hooked latehome_free_construct_footer_widgets - 5
     * @hooked latehome_free_construct_footer - 10
     */
    do_action('latehome_free_footer');

    /**
     * latehome_free_after_footer_content hook.
     *
     * @since 0.1
     */
    do_action('latehome_free_after_footer_content');
    ?>
</div><!-- .site-footer -->


</div></section>

<?php
/**
 * latehome_free_after_footer hook.
 *
 * @since 2.1
 */
do_action('latehome_free_after_footer');

wp_footer();

?>


</body>

</html>

