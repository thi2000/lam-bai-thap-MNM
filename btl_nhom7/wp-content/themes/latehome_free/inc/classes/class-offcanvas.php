<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * latehome_free_Offcanvas Theme Offcanvas menu
 *
 * @package latehome_free
 */
class latehome_free_Offcanvas
{

    /**
     * Constructor
     */
    public function __construct()
    {

        add_action('init', array($this, 'init'), 999);
    }

    public function init()
    {
        // only show offcanvas menu if enable Opal Elementor Widgets
        if (!class_exists("OSF_Elementor_Loader")) {
            add_action('wp_footer', [$this, 'render_offcanvas'], 99);
            add_action('wp_enqueue_scripts', [$this, 'enqueue'], 20);
        }

    }

    /**
     * Load offcanvas javascript and css files
     */
    public function enqueue()
    {
        // override or load first without loading file in plugin fore
        wp_register_script('wpopal-offcanvas', get_template_directory_uri() . '/assets/3rd/js-offcanvas.pkgd.min.js', array(), false, true);
        wp_enqueue_script('wpopal-offcanvas');


        wp_register_style('jquery-offcanvas', get_template_directory_uri() . '/assets/3rd/offcanvas.css');
        wp_enqueue_style('jquery-offcanvas');


    }

    /**
     * Render offcanvas menu html
     */
    public function render_offcanvas()
    {
        ?>

        <aside class="js-offcanvas" role="complementary" id="offcanvas-sidebar">
            <div class="offcanvas-inner">
                <?php if (function_exists('the_custom_logo') && has_custom_logo()): ?>
                    <div class="offcanvas-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php endif; ?>

                <button class="js-offcanvas-close" data-button-options='{"modifiers":"m1,m2"}'><i class="fa fa-close"
                                                                                                  aria-hidden="true"></i>
                </button>

                <div class="offcanvas-top">
                    <?php echo get_search_form(); ?>
                </div>
                <div class="offcanvas-content">
                    <?php wp_nav_menu(
                        apply_filters("latehome_free_main_navbar_args", array(
                            'theme_location' => 'primary',
                            'container_class' => 'collapse navbar-collapse',
                            'container_id' => 'navbarNavDropdown',
                            'menu_class' => 'navbar-nav mx-auto',
                            'fallback_cb' => '',
                            'menu_id' => 'main-navigation-offcanvas',
                            'depth' => 4,
                            'walker' => new latehome_free_Bootstrap_Navwalker()
                        ))
                    ); ?>
                </div>
                <div class="offcanvas-bottom">
                    <?php echo trim($this->render_bottom()); ?>
                </div>
            </div>
        </aside>
    <?php }

    /**
     * Render html in content bottom of the offcanvas
     */
    protected function render_bottom()
    {
        $others = array();
        ?>
        <?php foreach ($others as $other): ?>
        <?php
        echo '<a href="' . esc_html($other['link']) . '"> '
            . '<i class="' . $other['icon'] . '"></i> '
            . $other['title'] .

            ' </a>';
        ?>
    <?php endforeach; ?>
        <?php
    }
}

new latehome_free_Offcanvas();
?>