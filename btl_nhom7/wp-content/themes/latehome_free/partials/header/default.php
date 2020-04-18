<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
$container = get_theme_mod('latehome_free_container_type');
?>
<!-- ******************* The Navbar Area ******************* -->
<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">
    <a class="skip-link screen-reader-text sr-only"
       href="#content"><?php esc_html_e('Skip to content', 'latehome_free'); ?></a>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="<?php echo esc_attr($container); ?>">
            <div class="row ml-0 mr-0">
                <div class="navbar-brand">
                    <!-- Your site title as branding in the menu -->
                    <?php if (!has_custom_logo()) { ?>
                    <?php if (is_front_page() && is_home()) : ?>
                        <h1 class="navbar-brand mb-0">
                            <a rel="home" href="<?php echo esc_url(home_url('/')); ?>"
                               title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"
                               itemprop="url"><?php bloginfo('name'); ?></a></h1>
                    <?php else : ?>

                        <a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>"
                           title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"
                           itemprop="url"><?php bloginfo('name'); ?></a>

                    <?php endif; ?>
                    <?php } else {
                        the_custom_logo();
                    } ?><!-- end custom logo -->
                </div>

                <div class="d-flex ml-auto">
                    <button id="navbar-toggler-mobile" data-appear="left,overlay" class="navbar-toggler" type="button"
                            data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-align-justify"></i>
                    </button>
                </div>

                <div class="d-none d-lg-block navbar-collapse">
                    <!-- The WordPress Menu goes here -->
                    <?php wp_nav_menu(
                        apply_filters("latehome_free_main_navbar_args", array(
                            'theme_location' => 'primary',
                            'container_class' => 'collapse navbar-collapse',
                            'container_id' => 'navbarNavDropdown',
                            'menu_class' => 'navbar-nav mx-auto',
                            'fallback_cb' => '',
                            'menu_id' => 'main-navigation',
                            'depth' => 4,
                            'walker' => new latehome_free_Bootstrap_Navwalker()
                        ))
                    ); ?>
                </div>
            </div>
        </div><!-- .container -->
    </nav>
    <!-- .site-navigation -->
</div><!-- #wrapper-navbar end -->