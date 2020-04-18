<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package latehome_free
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

?>

<div class="wrapper" id="error-404-wrapper">
    <div class="container" id="content" tabindex="-1">
        <div class="page-content">
            <h2><?php esc_html_e('Oops, that link is broken.', 'latehome_free'); ?></h2>
            <p><?php esc_html_e('Page does not exist or some other error occured. Go to our Home page or go back to Previous page', 'latehome_free'); ?></p>

            <div class="page-content-bottom text-center">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                   class="btn btn-secondary"><?php esc_html_e('Homepage', 'latehome_free'); ?></a>
                <a href="javascript: history.go(-1)"
                   class="btn btn-secondary"><?php esc_html_e('Previous Page', 'latehome_free'); ?></a>
                
            </div>
        </div><!-- .page-content -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
