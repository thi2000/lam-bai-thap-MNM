<?php
defined( 'ABSPATH' ) || exit();

/**
 * @Class Wpopal_Core_Admin_Menu
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */

class Wpopal_Core_Admin {

	public function __construct() {

		// add_action('admin_init', array( $this, 'setup' ) , 1);
		$this->load();

		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 999);

		add_filter( 'tgmpa_plugins', array( $this, 'add_plugins') );

		add_action( 'init', array($this, 'after_active_theme') );
	}

	public function add_plugins ( $plugins ){

		//if( isset($_GET['page']) && $_GET['page'] == "tgmpa-install-plugins" ){
			
			$data = get_option( 'wpopal_sample_data_plugins' );
			if( $data ){
				$output = array();
				foreach( $data as $key => $plugin ){
					$output[] = array(
						'name' => $plugin,
						'required' => 1,
						'slug' => $key
					);
				}
				$plugins = array_merge_recursive( $output, $plugins );
				return $plugins ;
			}

			return $plugins;
		//}
		
	}

	public function enqueue_scripts () {
		wp_enqueue_script(
	            'wpopal-admin-js',
	            WPOPAL_PLUGIN_URI . 'assets/js/admin.js',
	            array('jquery'),
	            null,
	            true
        );
	}
	
	/**
	 * Load 
	 */
	public function load(){
		$this->includes( [
			'admin/metabox/cmb2.php',
			'admin/class-menu.php',
			'admin/class-project.php',

			'admin/importer/functions.php',
			'admin/importer/class-content-importer.php',
			'admin/importer/class-woo-product-importer.php',
			'admin/importer/class-import-steps.php',
			'admin/importer/class-sample-importer.php',
			'admin/importer/class-plugin-installer.php',
			
			'admin/menu/class-import.php',

 			'admin/menu/class-plugin.php',
 			// 'admin/menu/class-help.php',
			'admin/class-wizard.php',
		] );
		
	}


	public function after_active_theme(){
        global $pagenow;
        // Redirect to Opal welcome page after activating theme.
        if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) && $_GET['activated'] == 'true' ) {
            // Redirect
            $key = sanitize_key('wpopal_available_demos');
            delete_transient( $key );
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

new Wpopal_Core_Admin();
