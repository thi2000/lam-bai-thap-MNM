<?php
/**
 * @package  wpopal-core
 * @category Plugins
 * @author   Wpopal
 * Plugin Name: Wpopal Core Features
 * Plugin URI: http://www.wpopal.com/
 * Version: 1.4.13
 * Description: Implement rich functions for themes base on Wpopal. Wordpress framework and load widgets for theme used, this is required.
 * Author: Wpopal
 * Author URI:  http://www.wpopal.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: wpopal
 * Domain Path: /languages
 */
defined( 'ABSPATH' ) || exit();


class Wpopal_Core {

	private $version = '1.4.13';

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

		do_action( 'opal_elementor_menu_loaded', $this );

		//Register widget
		add_action( 'widgets_init', array($this, 'register_widget' ) );

		// Load textdomain.
		add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ], 3 );
	}

	/**
	 * set all constants
	 */
	private function set_constants() {

		$this->define( 'WPOPAL_PREFIX', 'osf_' );

		$this->define( 'WPOPAL_PLUGIN_FILE', __FILE__ );
		$this->define( 'WPOPAL_VERSION', $this->version );
		$this->define( 'WPOPAL_PLUGIN_URI', plugin_dir_url( WPOPAL_PLUGIN_FILE ) );
		$this->define( 'WPOPAL_PLUGIN_DIR', plugin_dir_path( WPOPAL_PLUGIN_FILE ) );
		$this->define( 'WPOPAL_PLUGIN_ASSET_URI', trailingslashit( WPOPAL_PLUGIN_URI . 'assets' ) );
		$this->define( 'WPOPAL_PLUGIN_INC_DIR', trailingslashit( WPOPAL_PLUGIN_DIR . 'includes' ) );
		$this->define( 'WPOPAL_PLUGIN_TEMPLATE_DIR', trailingslashit( WPOPAL_PLUGIN_DIR . 'templates' ) );

		$this->define( 'WPOPAL_THEMER_TEMPLATES_DIR', get_template_directory().'/' );
		$this->define( 'WPOPAL_THEMER_TEMPLATES_URL', get_bloginfo('template_url').'/' );
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

		if ( is_admin() && $this->allowed_use() ) {
			$this->_include( 'includes/admin/class-admin.php' );
		}
		
		$this->_include( 'includes/functions.php' );
		$this->_include( 'includes/class-fw-setup.php' );
		
		// add widgets
		$this->_include( 'includes/widgets/recent_post.php' ); 
		$this->_include( 'includes/widgets/wc_layered-nav.php' ); 
	}

	public function register_widget(){
        register_widget( 'Wpopal_Widget_Recent_Post' );
        if (class_exists('WooCommerce')):
	        register_widget( 'Wpopal_Widget_Layered_Nav' );
	    endif;
    }

	/**
	 * Include list of collection files
	 *
	 * @var array $files
	 */
	public function include_files ( $files ) {
		foreach ( $files as $file ) {
			$this->_include( $file );
		}
	}

	/**
	 * include single file
	 */
	private function _include( $file = '' ) {
		$file = WPOPAL_PLUGIN_DIR . $file;
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

	public function get_samples(){
		$file = WPOPAL_PLUGIN_DIR.'/sample/samples.json';
		$data = json_decode( file_get_contents( $file ) , true );
		return isset( $data['samples'] ) ? $data['samples'] : array(); 
	}

	public function allowed_use(){
		$file = get_template_directory().'/project.json';
		return file_exists( $file ); 
	}

	public function load_plugin_textdomain() {
		$lang_dir      = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
		$lang_dir      = apply_filters( 'osf_languages_directory', $lang_dir );
		$locale        = apply_filters( 'plugin_locale', get_locale(), 'wpopal' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'wpopal', $locale );
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/wpopal/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			load_textdomain( 'wpopal', $mofile_global );
		} else {
			if ( file_exists( $mofile_local ) ) {
				load_textdomain( 'wpopal', $mofile_local );
			} else {
				load_plugin_textdomain( 'wpopal', false, $lang_dir );
			}
		}
	}
}

function wpopal_core_func() {
	return Wpopal_Core::instance();
}
wpopal_core_func();
