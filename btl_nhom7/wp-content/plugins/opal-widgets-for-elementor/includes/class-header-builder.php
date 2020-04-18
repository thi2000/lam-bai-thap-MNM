<?php
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * @Class OSF_Footer_builder
 * 
 * Auto setup header with selected header option from customizer and having some funtions to render html
 */
class OSF_Header_builder {
    
    public static $instance;

    protected $content_html; 

    public static function get_instance() {
        if (!isset(self::$instance) && !(self::$instance instanceof OSF_Header_builder)) {
            self::$instance = new OSF_Header_builder();
        }

        return self::$instance;
    }

    public function __construct() {
        add_action( 'wp', array($this, 'setup_header'), 10   );
        add_action('admin_bar_menu', array($this, 'custom_button_header_builder'), 50);
        add_filter('body_class', array($this, 'add_body_class'));
    }

    public function get_multilingual() {
	    $multilingual = new OSF_Multilingual();

	    return $multilingual;
    }

    /**
     * Show quick edit button all WP Admin Bar
     *
     * @var Object wp_admin_bar
     * @return avoid 
     */
    public function custom_button_header_builder($wp_admin_bar) {
        global $osf_header;
        if ($osf_header && $osf_header instanceof WP_Post) {
            $args = array(
                'id'    => 'header-builder-button',
                'title' => __('Edit Header', 'opalelementor'),
                'href'  => add_query_arg('action', 'elementor', remove_query_arg('action', get_edit_post_link($osf_header->ID))),
            );
            $wp_admin_bar->add_node($args);
        }
    }

    /**
     * Add body class follow options as set header ticky, floating right/left....
     *
     * @var Array $classes
     * @return avoid 
     */
    public function add_body_class( $classes ) {
        global $osf_header;
        
        if ($osf_header && $osf_header instanceof WP_Post ) {
            
            $data = osf_elementor_get_metabox( $osf_header->ID , 'wpopal_header_style', true );
            if( $data ) {
                $classes[] = $data;
            }
        }
        return $classes;
    }

    /**
     *  Check setting enable/disable header and set header as global.
     *
     * @var avoid
     * @return avoid 
     */
    public function setup_header() {  
        global $osf_header;

        $osf_header = apply_filters( "opalelementor_get_header_builder", $osf_header );
        if( !$osf_header ) { 
            if ( (bool)osf_elementor_get_metabox( get_the_ID(), 'osf_enable_custom_header', false) ) {
                if (($header_slug = osf_elementor_get_metabox(get_the_ID(), 'osf_header_layout', 'default')) !== 'default') {
                    $osf_header = get_page_by_path($header_slug, OBJECT, 'header');
                }
            } else { 
                if ( ($header_slug = get_theme_mod('osf_header_builder', '')) ) {
                    $osf_header = get_page_by_path($header_slug, OBJECT, 'header');
                }
            }
        }

        if ($osf_header && $osf_header instanceof WP_Post) {
            if ( OSF_Multilingual::is_polylang() || OSF_Multilingual::is_wpml() ) {
	            $multilingual = $this->get_multilingual();
	            $osf_header_id = $multilingual->get_current_object( $osf_header->ID, 'header' );
	            $osf_header = get_post( $osf_header_id );
            }

            $this->content_html = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $osf_header->ID );  
        }
    }
    
    /**
     *  Output header html with own wrapper 
     *
     * @var avoid
     * @return avoid 
     */
    public function render_html() {
      
        if ( false == apply_filters( 'opalelementor_render_header', true ) ) {
            return;
        }
    ?>
        <header id="masthead" itemscope="itemscope" class="header-builder" itemtype="https://schema.org/WPHeader">
            <div class="<?php echo apply_filters( 'opalelementor_render_header_container_class','container' ); ?>">
                <?php echo  $this->content_html;?>
            </div>
        </header>

    <?php
    }
}
OSF_Header_builder::get_instance();
