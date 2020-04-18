<?php
/**
 * Template Name: Opal Estate User Dashboard Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package latehome_free
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

remove_action( 'latehome_free_before_site_content', 'latehome_free_breadcrumb' );
$user_sidebar = apply_filters( "latehome_free_user_sidebar", 'user-sidebar' );

get_header( 'no-sidebar' );
?>
<?php if ( get_current_user_id() ): ?>
    <div class="dashboard-navbar">
        <div class="clearfix">
            <div class="pull-left navbar-left">
                <button class="btn btn-link" id="show-user-sidebar-btn">
                    <i class="fa fa-bars"></i>
                </button>

                <div class="navbar-brand">
                    <!-- Your site title as branding in the menu -->
					<?php if ( ! has_custom_logo() ) { ?>
					<?php if ( is_front_page() && is_home() ) : ?>
                        <h1 class="navbar-brand mb-0">
                            <a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url">
								<?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
					<?php else : ?>
                        <a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url">
							<?php bloginfo( 'name' ); ?>
                        </a>
					<?php endif; ?>
					<?php } else {
						the_custom_logo();
					} ?><!-- end custom logo -->
                </div>

            </div>

            <div class=" pull-right">
                <ul class="list-inline">
                    <li>
                        <div class="opalestate-user-greeting opalestate-popup hover-align-right">
                            <div class="popup-head"><a href="#"><?php $user_id = get_current_user_id(); ?>
                                    <img src="<?php echo OpalEstate_User::get_author_picture( $user_id ); ?>" alt="<?php esc_attr_e( 'User Avatar', 'latehome_free' ); ?>"/>
                                    <span class="notify active"></span>
                                </a>
                            </div>
                            <div class="popup-body">
                                <div class="account-dashboard-content">
									<?php
									if ( function_exists( 'opalestate_management_user_menu_tabs' ) ) {
										opalestate_management_user_menu_tabs();
									}
									?>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>

    <div class="wrapper opalestate-user-management" id="opalestate-user-management">
        <div class="container-full" id="content">
            <div class="opal-row-inner">
                <div class=" user-dasboard-sidebar">
                    <div class="user-dasboard-sidebar-inner">

						<?php
						global $current_user;

						if ( is_user_logged_in() ) : ?>
                            <div class="profile-top">

                            </div>
                            <div class="profile-bottom">
								<?php opalestate_management_user_menu_tabs(); ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
                <div class="content-area" id="primary">

                    <div class="site-main" id="main" role="main">
						<?php if ( isset( $_GET['tab'] ) ) : ?>
							<?php opalestate_management_show_content_page_tab(); ?>
						<?php else : ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'partials/loop/content', 'page' ); ?>
								<?php
								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
								?>
							<?php endwhile; // end of the loop. ?>
						<?php endif; ?>
                    </div><!-- #main -->
                </div><!-- #primary -->
            </div><!-- .row end -->
        </div><!-- Container end -->
    </div><!-- Wrapper end -->
<?php else : ?>

    <div class="wrapper opalestate-user-management" id="opalestate-user-management">
        <div class="container">
            <div class="opalestate-panel-myaccount">
                <div class="management-header text-center">
                    <h2><?php esc_html_e( 'Login to your account', 'latehome_free' ); ?></h2>
                    <p><?php esc_html_e( 'Logining in allows you to edit your property or submit a property, save favorite real estate.', 'latehome_free' ); ?></p>
                </div>
				<?php echo do_shortcode( "[opalestate_myaccount]" ); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php get_footer( 'header/no-sidebar' ); ?>
