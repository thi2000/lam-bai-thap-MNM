<?php
defined( 'ABSPATH' ) || exit();
/**
 * @Class Wpopal_Core_Setup
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class Wpopal_Core_Setup {

	public function __construct() { 
		//add_action( 'init', [ $this, 'theme_setup'] ); 
 
 		
 		$this->theme_setup();
 	
		add_action( 'wp_enqueue_scripts', [$this,'enqueue_scripts'] );
	}

	/**
	 * enqueue editor.js for edit mode
	 */
	public function enqueue_scripts() {

		global $wpopal_version;

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';


		wp_register_script( 'wpopal-coutdown', trailingslashit( WPOPAL_PLUGIN_URI ) . 'assets/js/countdown.js', array(), $wpopal_version, true );

		wp_register_script( 'imagesloaded', trailingslashit( WPOPAL_PLUGIN_URI ) . 'assets/3rd-party/imagesloaded.pkgd.min.js', array(), $wpopal_version, true , 99 );
		wp_register_script( 'jquery-isotope', trailingslashit( WPOPAL_PLUGIN_URI ) . 'assets/3rd-party/isotope.pkgd.min.js', array(), $wpopal_version, true , 99 );

		// wp_enqueue_script( 'imagesloaded' );
 

		// register using 3rd javascript libs
		wp_register_script( 'jquery-sticky-kit', trailingslashit( WPOPAL_PLUGIN_URI ) . 'assets/3rd-party/jquery.sticky-kit.min.js', array(), $wpopal_version, true );
		// 
	}

	/**
	 * Include all files from supported plugins.
	 *
	 * @var avoid
	 */
	public function theme_setup() {
		$this->includes( [
			'theme/class-template-loader.php',
			'theme/template-functions.php',
			'theme/implement-theme.php',
			'theme/extras.php',
			'theme/markup.php',
 			'customizer/class-style-customizer.php'
		] );
		
		/// 
		if( wpopal_is_opalelementor_actived() ){
			$this->_include( 'vendors/opalelementor.php' );
		}

		// 
		if( wpopal_is_easy_google_fonts_actived() ){
			$this->_include( 'vendors/opalelementor.php' );
		}
		$this->woocommerce_setup();

		if( class_exists("bcn_breadcrumb") ){
			$this->_include( 'vendors/breadcrumb-navxt.php' );
		}
		
	}

	/**
	 * list of files will be used if woocommerce actived.
	 *
	 * @var avoid
	 */
	public function woocommerce_setup(){ 
		if( class_exists("WooCommerce") ) {
			$this->includes( [
				'vendors/woocommerce/class-woo.php'
			] );
		}
	}

	/**
	 * Include list of collection files
	 *
	 * @var array $files
	 */
	public function includes ( $files ) {
		foreach ( $files as $file ) {
			$this->_include( $file );
		}
	}
	/**
	 * include single file if found 
	 * 
	 * @var string $file
	 */
	private function _include( $file = '' ) {
		$file = WPOPAL_PLUGIN_INC_DIR  . $file; 
		if ( file_exists( $file ) ) {
			include_once $file;
		}
	}
}

new Wpopal_Core_Setup();