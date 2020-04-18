<?php
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * @Class OSF_Elementor_Addons
 * 
 * Register category widget and register widgets, override some ore widget of elementor.
 */
class OSF_Elementor_Addons {


    public function __construct() {
        
       
        add_action('elementor/widgets/widgets_registered', array($this, 'include_widgets'));
        add_action('elementor/widgets/widgets_registered', array($this, 'override_widgets'));
        
        add_action('init', [$this, 'regeister_scripts_frontend']);
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_scripts_frontend']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_style_frontend']);

        add_action('elementor/editor/after_enqueue_scripts', [$this, 'add_scripts_editor']);

        add_action('widgets_init', array($this, 'register_wp_widgets'));

        add_filter('upload_mimes', array($this, 'allow_svg_upload'), 100, 1);
   }

    /**
     *  Enqueue Script úing for admin editor
     *
     * @var avoid
     * @return avoid 
     */
    public function register_style_frontend() {
        wp_register_style('magnific-popup', trailingslashit(OE_PLUGIN_URI) . 'assets/css/magnific-popup.css');
        wp_enqueue_style('magnific-popup');
        
        $load = apply_filters( 'osf_elementor_load_frontend_style', true );
        if( $load ){
            wp_register_style('opal-elementor-frontend', trailingslashit(OE_PLUGIN_URI) . 'assets/css/elementor-frontend.css');
            wp_enqueue_style( 'opal-elementor-frontend' );
        }
       
    }

    /**
     *  Enqueue Script úing for admin editor
     *
     * @var avoid
     * @return avoid 
     */
    public function regeister_scripts_frontend() { 
        wp_enqueue_script('smartmenus', trailingslashit(OE_PLUGIN_URI) . 'assets/js/libs/jquery.smartmenus.min.js', array('jquery'), false, true);
        wp_enqueue_script('jquery-magnific-popup', trailingslashit(OE_PLUGIN_URI) . 'assets/js/libs/jquery.magnific-popup.min.js', array('jquery'), false, true);

        wp_register_script( 'tooltipster', trailingslashit( OE_PLUGIN_URI ) . 'assets/js/libs/tooltipster.main.min.js', array( 'jquery' ), false, true );

        // 2. load isotope using for masory 
        wp_register_script(
            'jquery-isotope',
            trailingslashit(OE_PLUGIN_URI). '/assets/js/libs/isotope.pkgd.min.js',
            [
                'jquery',
            ],
            '4.4.3',
            true
        );

        wp_register_script( 'wpopal-coutdown', trailingslashit( OE_PLUGIN_URI ) . 'assets/js/libs/countdown.js', array(), false, true );
        wp_enqueue_script( 'wpopal-coutdown' );

        wp_register_script( 'wpopal-offcanvas', trailingslashit( OE_PLUGIN_URI ) . 'assets/js/libs/js-offcanvas.pkgd.min.js', array(), false, true );

        wp_register_script( 'infinitescroll', trailingslashit( OE_PLUGIN_URI ) . 'assets/js/libs/jquery.infinitescroll.min.js', array(), false, true );

        wp_register_script( 'countimator', trailingslashit( OE_PLUGIN_URI ) . 'assets/js/libs/jquery.countimator.min.js', array(), false, true );
        wp_register_script( 'handlebars', trailingslashit( OE_PLUGIN_URI ) . 'assets/js/libs/handlebars.min.js', array(), false, true );
 


        wp_register_script(
            'imagesloaded',
            trailingslashit( OE_PLUGIN_URI ). '/assets/js/libs/imagesloaded.pkgd.min.js',
            [
                'jquery',
            ],
            '4.4.3',
            true
        );
        

        wp_register_script(
            'jquery-slick',
            trailingslashit( OE_PLUGIN_URI ). '/assets/js/libs/slick.js',
            [
                'jquery',
            ],
            '1.8.1',
            true
        );
    }

    /**
     *  Enqueue Script úing for admin editor
     *
     * @var avoid
     * @return avoid 
     */
    public function add_scripts_editor() {
        wp_enqueue_script('opal-elementor-admin-editor', trailingslashit(OE_PLUGIN_URI) . 'assets/js/elementor/admin-editor.js', [], false, true);
    }

    /**
     * Register Catetegory
     *
     * @var avoid
     * @return avoid 
     */
    public function enqueue_scripts_frontend() {
        wp_enqueue_script('smartmenus');
        wp_enqueue_script('opal-elementor-frontend', trailingslashit(OE_PLUGIN_URI) . 'assets/js/elementor/frontend.js', ['jquery'], false, true);
    }
 

    /**
     * Register wordpress Widget
     *
     * @var avoid 
     */
    public function register_wp_widgets() {
 
        $this->_include( 'wp_template.php' );
        register_widget('Opal_WP_Template');
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function override_widgets($widgets_manager) {

        require_once OE_PLUGIN_WIDGET_DIR.'override/image-box.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Image_Box());

        require_once OE_PLUGIN_WIDGET_DIR.'override/icon-box.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Icon_Box());

        require_once OE_PLUGIN_WIDGET_DIR.'override/progress.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Progress());

        require_once OE_PLUGIN_WIDGET_DIR.'override/toggle.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Toggle());

        require_once OE_PLUGIN_WIDGET_DIR.'override/counter.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Counter());

        require_once OE_PLUGIN_WIDGET_DIR.'override/divider.php';
    }

    /**
     * Include file from widget folder 
     *
     * @var String $file
     */
    protected function _include( $file ){
        require_once( OE_PLUGIN_DIR. 'widgets/'.$file );
    }
    /**
     * Automatic load widget files in general folder, show warning if not exists
     *
     * @var Object $widgets_manager
     * @return avoid 
     */
    public function load_general_widgets( $widgets_manager ) {  
 
       $files = glob( OE_PLUGIN_WIDGET_DIR ."general/*.php");  


        if( $files ){ 
            foreach ( $files as $file ) {
                $name =  str_replace( "-", "_", basename( str_replace('.php','',$file) ) ); 
                $file = apply_filters( 'osf_elementor_load_' . $name, $file ); 

                if( file_exists( $file ) ){
                    require_once( $file );     
                    $class = "OSF_Elementor_".ucfirst( $name ).'_Widget';
                    if( class_exists($class) ){   
                        $widgets_manager->register_widget_type( new $class() );
                    } else {
                       // echo $file.'<missing:<br>' . $class;  die;
                    }
                } else {
                    
                }
            }
        }
    }

    /**
     * Include list of collection general widget, contact form 6, mailchilp.... 
     *
     * @var Object $widgets_manager
     * @return avoid 
     */
    public function include_widgets( $widgets_manager ) {


        $this->load_general_widgets( $widgets_manager ); 
 
        if (osf_elementor_is_contactform7_activated()) {
            require OE_PLUGIN_WIDGET_DIR.'button-contact-form.php';
            $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Button_Contact_Form());

            require OE_PLUGIN_WIDGET_DIR.'contactform7.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_ContactForm7());
        }

        if(osf_elementor_is_mailchimp_activated()){
            require_once  OE_PLUGIN_WIDGET_DIR.'mailchimp.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_Mailchimp());
        }
    }

    public function allow_svg_upload($mimes) {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        return $mimes;
    }
}

new OSF_Elementor_Addons();

