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
class OSF_Elementor_Woo {

    public $theme; 
	public function __construct (){  
        

        if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
            add_action( 'init', [ $this, 'register_wc_hooks' ], 5 );
        }

		$this->_include( 'includes/class-woo-shortcode-products.php' );   
        $this->_include( 'includes/function-woo-hook-templates.php' );   
        
		add_action('elementor/elements/categories_registered', array($this, 'add_category') );
    	add_action('elementor/widgets/widgets_registered', array($this, 'load_woo_widgets') );
        add_filter( 'osf_megamenu_load_frontend_style', array($this, 'disable_megamenu_scripts')  );
        add_filter( 'wc_get_template_part',        array( $this, 'get_template_parts' ), 10, 3 );
        $this->theme = wp_get_theme();
	}

    public function disable_megamenu_scripts (){
        return false; 
    }
    
    /**
     * Fix not load product layout template hooks in loop products while editing page.
     *
     * @return avoid
     */
    public function register_wc_hooks() {
        wc()->frontend_includes();
    }


	/**
     * Register Widget Catetegory Showing Editor panel
     *
     * @var avoid
     * @return avoid 
     */
    public function add_category() {

        Elementor\Plugin::instance()->elements_manager->add_category(
            'opal-woo',
            array(
                'title' => __('Widgets Woocommerce', 'opalelementor'),
                'icon'  => 'fa fa-plug',
            ),
        1);
    }

    /**
     * Automatic load widget files in Woo folder, show warning if not exists
     *
     * @var Object $widgets_manager
     * @return avoid 
     */
    public function load_woo_widgets( $widgets_manager ) {  
 
       $files = glob( OE_PLUGIN_WIDGET_DIR ."woo/*.php");  

        if( $files ){ 
            foreach ( $files as $file ) {
                $name =  str_replace( "-", "_", basename( str_replace('.php','',$file) ) ); 
                $file = apply_filters( 'osf_elementor_load_' . $name, $file ); 

                if( file_exists( $file ) ){
                    require_once( $file ); 
                    $class = "OSF_Elementor_".ucfirst( $name ).'_Widget';
                    if( class_exists($class) ){ 
                        $widgets_manager->register_widget_type( new $class() );
                    }
                } else {
                    echo $file.'<br>'; 
                }
            }
        }
    }

    /**
     * Get include supported files from this, just only display many layout styles of product in loop
     * 
     * @return String $template 
     */
    public function get_template_parts( $template, $slug, $name ) {

        $woo_path  = OE_PLUGIN_TEMPLATE_DIR. 'woocommerce/';  
        if ( file_exists( $woo_path . "{$slug}-{$name}.php" ) && !preg_match( "#".$this->theme."#", $template) ) {
            $template = $woo_path . "{$slug}-{$name}.php"; 
        }
        
        return $template;
    }

	/**
	 * include single file
	 */
	private function _include( $file = '' ) {
		$file = OE_PLUGIN_DIR . $file;
		if ( file_exists( $file ) ) {
			include_once $file;
		}
	}

}
new OSF_Elementor_Woo();
?>