<?php 
defined( 'ABSPATH' ) || exit();

/**
 * @Class Wpopal_Core_Admin_Menu
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class Wpopal_Core_Admin_Sample_Importer {

    protected $server = 'https://demo1.wpopal.com/wpopal/data/';
	/**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     *
     */
    public function init_hooks() {
        add_action( 'wp_ajax_opal_show_confirmation',  [$this,'show_confirmation'] );
        add_action( "wp_ajax_opal_install_bysteps",    [$this,'install_bysteps']   );
    }

    /**
     *
     *
     */
    public function install_bysteps(){ 

        if ( ! isset( $_POST['next'] ) ) {
            wp_send_json_error( array( 'message' => __( 'Step Failed!', 'auxin-elements' ) ) );
        }

        if( !defined("FS_METHOD") ){
            define( "FS_METHOD", "direct" );
        }
         if( !defined("WP_MEMORY_LIMIT") ){
            define('WP_MEMORY_LIMIT', '350M');
        }
        ini_set( 'memory_limit', apply_filters( 'wpopal_import_memory_limit', '350M' ) );
        ini_set("default_socket_timeout", 6000); 
        set_time_limit( apply_filters( 'wpopal_import_time_limit', 0 ) );

        $importer = Wpopal_Core_Admin_Importer_Steps::get_instance();

        $result = $importer->exec( $_POST['next'], $_POST );  
        $args =  $result;

        if( isset($result['stay']) && $result['stay'] == 1 ) {
            $result['content'] =  Wpopal_Core_Template_Loader::get_template_part( 'admin/import-stay', $args ); 
        } else {
            if( $result['done'] == 1 ){
                $result['content'] =  Wpopal_Core_Template_Loader::get_template_part( 'admin/import-done', $args ); 
            } 
            else {
                $result['content'] =  Wpopal_Core_Template_Loader::get_template_part( 'admin/import-inprocess', $args ); 
            }  
        }
      
        
        wp_send_json_success( $result );

    }


    /**
     * @param $link
     *
     * @return object|boolean
     */
    private function get_remote_json($link , $isarray=null ) {
        $content = wp_remote_get($link);
        if ($content instanceof WP_Error) {
            return false;
        }
        return json_decode( $content['body'], $isarray );
    }
 

    /**
     *
     *
     */
    public function show_confirmation(){ 
        $args = array(); 
        $data =  Wpopal_Core_Admin_Project::get_instance()->get_samples();

        if( isset($_POST['key']) ){
            if( $data ){ 
                if( isset($data[$_POST['key']]) ){
                    $args = $data[$_POST['key']];
                    $args['sample_name'] = $args['name'];
                    $args['key'] = $_POST['key'];

                    $content =  Wpopal_Core_Template_Loader::get_template_part( 'admin/import-confirmation', $args );
                    wp_send_json_success(  array("content" => $content) ); exit; 
                }
            }
        }    
        $content = '';
        wp_send_json_success(  array("content" => $content) ); exit; 
    }
 
    /**
     *
     */
    public function get_sample_uri( $niche ){
        $url = WPOPAL_PLUGIN_URI . 'sample/'.$niche.'.json' ;   
    }
}

Wpopal_Core_Admin_Sample_Importer::get_instance()->init_hooks();

?>