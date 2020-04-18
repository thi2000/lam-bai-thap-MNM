<?php 
/**
 * @class Wpopal_Core_Opal_Elementor
 *
 * Wpopal_Core_Opal_Elementor is responsible for check header and footer builder were actived to display html.
 *  
 *
 * @since 1.0.0
 */
class Wpopal_Core_Navxt {

	public function __construct(){
	//	add_action( 'customize_register', array( $this, 'page_customizer' ), 10 );
	//	add_action( 'customize_register', array( $this, 'woocommerce_customizer' ), 10 );
		add_filter( 'wpopal_customizer_json_files', [$this,'add_customizer_setting'], 50, 2 );
	}	

	public function add_customizer_setting( $files ){

		$files['breadcrumb'] = WPOPAL_PLUGIN_DIR . 'includes/customizer/settings/breadcrumb.json';

		
		// echo '<pre>' . print_r( $files , 1 ); die;

		return $files; 
	} 
}

new Wpopal_Core_Navxt();
?>