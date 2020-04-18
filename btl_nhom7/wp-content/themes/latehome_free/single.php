<?php
/**
 * The template for displaying all single posts.
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

$layout = apply_filters('latehome_free_blog_single_layout', get_theme_mod('latehome_free_blog_single_layout'));

?>
<div class="wrapper" id="single-wrapper">

    <?php get_template_part('partials/single-layout/single', $layout); ?>

</div><!-- Wrapper end -->

<?php get_footer(); ?>
