<?php
/**
 * Plugin Name: Opal Widgets For Elementor
 * Plugin URI: http://www.wpopal.com/
 * Version: 1.5.7
 * Description: This plugin provides your everything widgets suchs as header builder, footer builder, woocommerce widget, pricing table, blog, countdown and many more.
 * Author: WpOpal
 * Author URI:  http://www.wpopal.com/
 * License: GNU/GPLv3
 * Text Domain: opalelementor
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit();
/**
 *
 *
 *
 */
class OSF_Elementor_Loader {

	private $version = '1.5.7';

	/**
	 *
	 */
	public static $instance;

	/**
	 * instance
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * constructor
	 */
	public function __construct() {
		$this->set_constants();
		$this->includes();
		$this->init_hooks();

		add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ], 3 );

		do_action( 'opal_elementor_menu_loaded', $this );

		add_action('init', array($this, 'load') , 1 );

		add_action( 'woocommerce_loaded' , [$this,'load_woo'] );

		add_action('elementor/elements/categories_registered', array($this, 'add_category') );
	}

	/**
	 * set all constants
	 */
	private function set_constants() {
		$this->define( 'OE_PLUGIN_FILE', __FILE__ );
		$this->define( 'OE_VERSION', $this->version );
		$this->define( 'OE_PLUGIN_URI', plugin_dir_url( OE_PLUGIN_FILE ) );
		$this->define( 'OE_PLUGIN_DIR', plugin_dir_path( OE_PLUGIN_FILE ) );
		$this->define( 'OE_PLUGIN_ASSET_URI', trailingslashit( OE_PLUGIN_URI . 'assets' ) );
		$this->define( 'OE_PLUGIN_INC_DIR', trailingslashit( OE_PLUGIN_DIR . 'includes' ) );
		$this->define( 'OE_PLUGIN_TEMPLATE_DIR', trailingslashit( OE_PLUGIN_DIR . 'templates' ) );
		$this->define( 'OE_PLUGIN_WIDGET_DIR', trailingslashit( OE_PLUGIN_DIR . 'widgets' ) );
	}

	/**
	 * Load Element Widgets of woocommerce.
	 *
	 */
	public function load_woo() {
		$this->_include( 'includes/class-woo-elementor.php' );
	}


	/**
     * Register Widget Catetegory Showing Editor panel
     *
     * @var avoid
     * @return avoid
     */
    public function add_category() {

        Elementor\Plugin::instance()->elements_manager->add_category(
            'opal-addons',
            array(
                'title' => __('Theme General', 'opalelementor'),
                'icon'  => 'fa fa-plug',
            ),
        1);

        $this->_include( 'includes/module/class-fixed-header.php' );
    }
	/**
	 * Auto load and init footer and header builder
	 */
	public function load() {

		if( !function_exists("elementor_load_plugin_textdomain") ){
			return false;
		}
		$this->_include( 'includes/functions.php' );

		require_once OE_PLUGIN_INC_DIR.'abstract/carousel.php';
        require_once OE_PLUGIN_INC_DIR.'abstract/slick.php';

  		if( apply_filters("opalelementor_enable_header_footer", true) ) {
  			$this->_include( 'includes/customizer/class-customizer.php' );


  			$this->_include( 'includes/class-footer-builder.php' );
			$this->_include( 'includes/class-header-builder.php' );
			$this->_include( 'includes/class-multilingual.php' );


			$this->_include( 'includes/post-type/header.php' );
			$this->_include( 'includes/post-type/footer.php' );



  		}
		$this->_include( 'includes/class-elementor.php' );
	}

	/**
	 * set define
	 *
	 * @param string name
	 * @param string | boolean | anythings
	 * @since 1.0.0
	 */
	private function define( $name = '', $value = '' ) {
		defined( $name ) || define( $name, $value );
	}

	/**
	 * include all required files
	 */
	private function includes() {



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

	/**
	 * init main plugin hooks
	 */
	private function init_hooks() {
		// trigger init hooks
		// do_action( 'opal_elementor_menu_init', $this );
	}

	public function load_plugin_textdomain() {
		$lang_dir      = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
		$lang_dir      = apply_filters( 'osf_languages_directory', $lang_dir );
		$locale        = apply_filters( 'plugin_locale', get_locale(), 'opalelementor' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'opalelementor', $locale );
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/opalelementor/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
		load_textdomain( 'opalelementor', $mofile_global );
		} else {
			if ( file_exists( $mofile_local ) ) {
				load_textdomain( 'opalelementor', $mofile_local );
			} else {
				load_plugin_textdomain( 'opalelementor', false, $lang_dir );
			}
		}
	}
}

function osf_elementor() {
	return OSF_Elementor_Loader::instance();
}
osf_elementor();
