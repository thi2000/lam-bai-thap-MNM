<?php 
defined( 'ABSPATH' ) || exit();

/**
 * @Class Wpopal_Core_Admin_Menu
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class Wpopal_Core_Admin_Importer_Steps {

    /**
     * @object WpOpal_Core_Admin_Importer $importer
     *
     *  @var      object
     */
    public $importer;

    /**
     * set imported path of revolution slider
     *
     *  @var     String
     */
    protected $path_rev; 

    protected $data_file = '';

    protected $data_file_zip = '';
    /**
     *  Constructor
     */
    public function __construct(){

        $this->importer = new WpOpal_Core_Admin_Content_Importer();
        $this->data_file = trim(wp_upload_dir()['basedir'] ).'/data.json'; 
        $this->data_file_zip = trim(wp_upload_dir()['basedir'] ).'/data.zip'; 
    }
    
    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Return an instance of this class.
     *
     * @return   object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Return collection of steps and theirs information
     *
     * @return   Array
     */
    public function get_steps(){
        return array(
            'set_confirmation'      => __( 'Confirmed to install the sample ', 'wpopal' ),
            'install_plugins'       => __( 'Install required plugins ', 'wpopal' ),
            'import_media'          => __( 'Install required plugins ', 'wpopal' ),
            'import_content'        => __( 'Install required plugins ', 'wpopal' ),
            'import_widgets'        => __( 'Install required plugins ', 'wpopal' ),
            'import_customizer'     => __( 'Install required plugins ', 'wpopal' ),
            'import_theme_options'  => __( 'Install required plugins ', 'wpopal' ),
            'import_menu'           => __( 'Install required plugins ', 'wpopal' ),
            'import_sliders'        => __( 'Install required plugins ', 'wpopal' ),
            'import_other'        => __( 'Install required plugins ', 'wpopal' ),
        );
    }

    /**
     * Magic function to automatic call defined method to start that step
     *
     * @return   Array data having information about heading, content, ajax status, and next step
     */
    public function exec( $method, $data=array() ){
 
        if( method_exists($this, $method) ){

            do_action("wpopal_import_step_".$method."_before", $data );

            return $this->$method( $data );

            do_action("wpopal_import_step_".$method."_after", $data );
        }

        return false;
    }


    /**
     * @param $link
     *
     * @return object|boolean
     */
    private function get_remote_json($url , $isarray=null ) {
         //Get JSON
        $request    = wp_remote_get( $url,
            array(
                'timeout'     => 30,
                'user-agent'  => 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0'
            )
        );
        //If the remote request fails, wp_remote_get() will return a WP_Error
        if( is_wp_error( $request ) || ! current_user_can( 'import' ) ){
            wp_send_json_error( array( 'message' => __( 'Remote Request Fails', 'auxin-elements' ) ) );
        }

        //proceed to retrieving the data
        $body       = wp_remote_retrieve_body( $request );
        // Check for error
        if ( is_wp_error( $body ) ) {
            wp_send_json_error( array( 'message' => __( 'Retrieve Body Fails', 'auxin-elements' ) ) );
        }

        //translate the JSON into Array
        return json_decode( $body, $isarray );
    }

    /**
     * @param $link
     *
     * @return object|boolean
     */
    public function get_data_options(){
        return get_option( 'wpopal_sample_data' );
    }

    /**
     * @param $link
     *
     * @return object|boolean
     */
    public function get_data(){
        if( file_exists($this->data_file) ){
            return json_decode( file_get_contents( $this->data_file ), true );
        }
        return array();
    }

    /**
     *  Save stream data into local file
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    private function output_file_content( $file_path, $output ) {
        $fp = fopen( $file_path, 'w' );
        fwrite( $fp, $output );
        fclose( $fp );
    }

    /**
     *  get content of file from remote server
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    private function curl_get_content( $URL ){

        if( is_callable('curl_init') ){

              $ch = curl_init();
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_URL, $URL);
              $data = curl_exec($ch);
              curl_close($ch);
              return $data;
        } else {
            return file_get_contents( $URL );
        }      
    }


    /**
     *  set confirmation Step: 
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function set_confirmation ( $post ){

        $step    = $post['next'];
        $index   = isset( $post['sample'] ) ? $post['sample'] : '';
        $index   = $index === '' ? 0 : $index;

 
        $data = Wpopal_Core_Admin_Project::get_instance()->get_samples();
 
        if( isset($data[$index]) ) {

            $niche = $data[$index]; 
            $file  = $niche['sample'];

            $status = true; 
            $importdata = null; 
            
            // clean dirty file before installing
            if( file_exists($this->data_file) ){
                @unlink( $this->data_file );
            }

            if( file_exists($this->data_file_zip) ){
                @unlink( $this->data_file_zip );
            }

            // check if use zip file 
            if( preg_match( "#\.zip#", $file ) ) {
                
                $data = $this->curl_get_content( $file );
                $file = fopen( $this->data_file_zip, "w+");
                fputs($file, $data);
                fclose( $file );

                if( file_exists( $this->data_file_zip ) ){
                    WP_Filesystem();
                    unzip_file( $this->data_file_zip,  trim(wp_upload_dir()['basedir'] ) );
                   
                } else {
                    $status = false; 
                }     

            } else {
                //
                $importdata = $this->get_remote_json( $file, true ); 
                if( $importdata ){         
                   // update_option( 'wpopal_sample_data', $importdata );
                    // save to file 
                    $this->output_file_content(  $this->data_file, json_encode($importdata) ); 
                    $this->global_options();
                    if( isset($importdata['plugins']) ) {
                        update_option( 'wpopal_sample_data_plugins', $importdata['plugins'] ); 
                    }
                } else {
                    $status = false;
                }
            }   

        
            if( $status == false ){
                return(  
                    array( 
                        "heading" => __( 'The installation was not complete', 'wpopal' ),
                        "content" => __( 'Could not fetch data for the installation, Please try again or contact our developer. Thanks!!!', 'wpopal' ),
                        "ajax"    => "", 
                        "error"   => true,
                        "done"=> "0",
                        "process" => "1|11"
                    ) 
                ); 
            }
        }    

        $content = __( 'It is getting data from live server for comming installation!' , 'wpopal' );
        return(  
            array( 
                "heading" => __( 'Starting to import required plugins', 'wpopal' ),
                "content" => $content,
                "ajax" => array( 'next' =>'install_plugins' ), 
                "done"=> "0",
                "process" => "1|11"
            ) 
        );  
    }

    /**
     * Return an instance of this class.
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function install_plugins(){

        $data = $this->get_data();  
        
        $args = array( 'plugins' => array() );
        
        $done = 0;  

        $content = '';
        $action = array(
            "heading" => __( 'Starting to download attachments then import', 'wpopal' ),
            "content" => $content,
            "ajax"    => array('next' => 'import_media'), 
            "done"    => 0,
            "stay"    => 0, 
            "process" => "2|11"
        ) ;

        if( function_exists("tgmpa") ){
            $plugins = array();
            foreach( $data['plugins'] as $name => $plugin ){
                $plugins[] =  array(
                    'name'      => $name,
                    'slug'      => $plugin,
                    'required'  => true,
                );
            }

            /*
             * Array of configuration settings. Amend each line as needed.
             *
             * TGMPA will start providing localized text strings soon. If you already have translations of our standard
             * strings available, please help us make TGMPA even better by giving us access to these translations or by
             * sending in a pull-request with .po file(s) with the translations.
             *
             * Only uncomment the strings in the config array if you want to customize the strings.
             */
            $config = array(
                'id'           => 'wpopalbootstrap-required',  // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to bundled plugins.
                'menu'         => 'tgmpa-install-plugins', // Menu slug.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,                   // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
            );

            tgmpa( $plugins, $config );

            $installer = new WpOpal_Core_Admin_Plugins_Installer();
            $plugins = $installer->get_needed_plugins(); 

            $args['plugins'] = $plugins; 
 

             
            $args['next'] = 'import_media';
            

            if( !empty($plugins) ){
               $action['stay'] = 1;
               $action['done'] = 1;
                $content =  Wpopal_Core_Template_Loader::get_template_part( 'admin/require-plugins', $args );
                $action['content'] = $content; 
            }
            else {
                $step        = 15; 
                $content = $this->download_counter( $step, count($data['attachments']) );
                $action['content'] = __('Starting to download media from live server : ' . $content , 'wpopal' );
            }

            if( isset($_POST['do']) && $_POST['do'] == 'plugins' && isset($_POST['pluign']) ){
                
                if( isset( $plugins[$_POST['pluign']] ) ){
                    $plugin = $plugins[$_POST['pluign']]; 
                    ob_start();
                    $content = $installer->do_plugin_install( $plugin['slug'], $plugin['action'] );
                    $content = ob_get_contents();
                    ob_end_clean();
                    $action['stay'] = 0; 

                    if( $_POST['index'] + 1 == $_POST['total'] ){
                        $action['done'] = 1; 
                        $next = 'import_media';
                    } else {
                        $next = 'install_plugins';
                    }
                    echo "--finished--"; die; 
                }
           
             //   
            } 
        } 
        return $action;  
    }
    
    private function download_counter( $downloaded, $total ){
        $content = '<div class="download-counter"><span>'
                    . __('Downloading:','wpopal').'</span>'. $downloaded . '/'. $total .'<div>';
        return $content;             
    }
    
    /**
     * Return an instance of this class.
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_media() {

        $data = $this->get_data(); 
        
        $step        = 15; 
        $attachments = array_chunk( $data['attachments'], $step );
        $total       = count( $attachments );
        $index       = isset($_POST['index']) ? $_POST['index'] : 0;
        $nindex      = $index+1; 
 
      

        if( !isset($attachments[$index]) ){
            $ajax = array('next' =>'import_content' ); 
            $next = array(
                    "heading" => __( 'Starting to import Content', 'wpopal' ),
                    "content" => __( 'Waiting for a while to download all attachment files!' , 'wpopal' ), 
                    "ajax"    => $ajax, 
                    "done"    => "0",
                    "process" => "3|11"
            ) ; 
        } else {

            $output = $this->importer->set_data( $data )->import_media( $attachments[$index] );

            $downloaded = $nindex >= $total ?  count($data['attachments']) : $step*($nindex) ; 

            $content = $this->download_counter( $downloaded, count($data['attachments']) );
            $content = __('Starting to download media from live server : ' . $content , 'wpopal' ) ;

            $ajax = array('next' =>'import_media' , 'index' => $nindex, 'total' => $total );
            $next = array(
                    "heading" => __( 'Starting to download attachments then import' . $nindex, 'wpopal' ),
                    "content" => $content, 
                    "ajax"    => $ajax, 
                    "done"    => "0",
                    "stay"    => 0, 
                    "process" => "3|11"
            ) ; 
        }

        return $next;  
    }

    /**
     * Return an instance of this class.
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_content(){
        
        
        $index = -1;
        $data = $this->get_data();
        
        $step = 20; 
        $count = count( $data['posts'] );
        $posts = array_chunk( $data['posts'], $step );

        $total = count( $posts );

        if( isset($_POST['index']) ){
            $index = $_POST['index']; 
            if( $index+1 > $total ){
                return( 
                    array(
                        "heading" => __( 'Starting to import other sample content', 'wpopal' ),
                        "content" => __( 'Starting to import Content', 'wpopal' ), 
                        "ajax"    => array( 'next' =>'import_other_sample' ), 
                        "done"    => "0", 
                        "process" => "4|11"
                    ) 
                );  
            }
        } else {
            $index = 0;
        }
        
        $next_posts = $posts[$index];

        $output  = $this->importer->set_data( $data )->import_content( $next_posts );

        $downloaded = ($index+1)>= $total ?  $count : $step*($index+1) ; 

        $content = $this->download_counter( $downloaded, $count );
        $content = __('Starting to download media from live server : ' . $content , 'wpopal' ) ;
 
        return( 
            array(
                "heading" => __( 'Starting to import Content', 'wpopal' ),
                "content" => $content, 
                "ajax"    => array( 'next' =>'import_content', 'index' => $index+1, 'total' => $total ), 
                "done"    => "0", 
                "process" => "4|11"
            ) 
        );  
    } 

    /**
     * Return an instance of this class.
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_other_sample(){
 
        $content = __( 'Waiting for a while to import content!' , 'wpopal' );
        
        $data = $this->get_data();
        // import sample data of post type
        $output = $this->importer->set_data( $data )->import_sample();
        $index = 1; 
        return( 
            array(
                "heading" => __( 'Starting to import required widgets', 'wpopal' ),
                "content" => $content, 
                "ajax"    => array( 'next' =>'import_widgets', 'index' => $index ), 
                "done"    => "0", 
                "process" => "5|11"
            ) 
        );  
    } 

    /**
     * Import widgets option configuration and import setting for widget sidebars
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_widgets(){

        $data = $this->get_data();

        // check to import widget setting
        if( isset($data['widgets']) && $data['widgets'] ) { 
            $options = $data['widgets'];
            foreach ( (array) $options as $id => $data ) {
                update_option( 'widget_' . $id, $data );
            }
        }

        // set widgets on sidebar 
        if (  isset($data['sidebars']) && $data['sidebars']  ) {

            $sidebars = get_option("sidebars_widgets");

            unset($sidebars['array_version']);

            $sidebars = array_merge( (array) $sidebars, (array) $data['sidebars'] );

            unset($sidebars['wp_inactive_widgets']);

            $sidebars = array_merge(array('wp_inactive_widgets' => array()), $sidebars);
            $sidebars['array_version'] = 2;
            wp_set_sidebars_widgets($sidebars);
        }
        
        /// import sample widget data with other format 
        if( isset($data['widget_data']) && !empty($data['widget_data']) ){
            require_once dirname( __FILE__ ).'/class-widget-importer.php';
            Wpopal_Core_Admin_Widget_Importer::get_instance()->import_data( $data['widget_data'], $this->importer );

        }


        /// 
        $content = __( 'The Installer is excuting to import menu, please waiting for a while!' , 'wpopal' );
        return(  
            array(

                "heading"  => __( 'Starting to import website menu', 'wpopal' ),
                "content"  => $content, 
                "ajax"     => array( 'next' =>'import_menu'), 
                "done"     => "0",
                "process" => "6|11"
            )
         );  
    }

   

    /**
     * Import list of menu and automatic set relationship menu items and pages
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_menu(){

        $content = __( 'All siders are downloading from live server then extract and install, please waiting for a while!' , 'wpopal' );

        $output = $this->importer->set_data( $this->get_data() )->import_menu( );
 
        return ( 
            array(
                "heading" => __( 'Starting to import required slider', 'wpopal' ),
                "content" => $content, 
                "ajax" => array('next' =>'import_sliders'), 
                "done"=> "0",
                "process" => "7|11"
            )
        );  
    }


	/**
	 * Download direct slider from live site and import data for revolution slider
	 *
	 * @return    Array data having information about heading, content, ajax status, and next step
	 */
	public function import_sliders(){


		$content = __( 'Please waiting for downloading sliders from live server', 'wpopal' );

		$this->path_rev = trailingslashit( wp_upload_dir()['basedir'] ) . 'rev_sliders_import/';

		$settings = $this->get_data();

		/// import slider
		if ( $sliders = $settings['sliders'] ) {
            if ( defined( 'RS_REVISION' ) ) {
                // fix import slider for latest version of revolution slider
                if ( class_exists( 'RevSliderSlider' ) ) {
                    if ( ! file_exists( $this->path_rev ) ) {
                        mkdir( $this->path_rev, 0777, true );
                    }
                    foreach ( $sliders as $slider ) {
                        $alias = str_replace( '.zip', '', basename( $slider ) );
                        if ( ! RevSliderSlider::alias_exists( $alias ) ) {
                            $upload = $this->fetch_remote_file( $slider );
                            if ( $upload && isset( $upload['file'] ) && is_string( $upload['file'] ) ) {
                                $this->add_revslider( $upload['file'] );
                                unlink( $upload['file'] );
                            }
                        }
                    }
                }
            } else {
                if ( class_exists( 'RevSliderAdmin' ) ) {
                    if ( ! file_exists( $this->path_rev ) ) {
                        mkdir( $this->path_rev, 0777, true );
                    }
                    $rs  = new RevSlider();
                    $all = $rs->getAllSliderAliases();
                    foreach ( $sliders as $slider ) {
                        $alias = str_replace( '.zip', '', basename( $slider ) );
                        if ( ! in_array( $alias, $all ) ) {
                            $upload = $this->fetch_remote_file( $slider );
                            if ( $upload && isset( $upload['file'] ) && is_string( $upload['file'] ) ) {
                                $this->add_revslider_old( $upload['file'] );
                                unlink( $upload['file'] );
                            }
                        }
                    }
                }
            }
		}
		return (
		array(
			"heading" => __( 'Starting to import customizer', 'wpopal' ),
			"content" => $content,
			"ajax" => array('next' =>'import_customizer'),
			"done"=> "0" ,
			"process" => "8|11"
		)
		);
	}

    protected function fetch_remote_file( $url ) {

        // extract the file name and extension from the url
        $file_name = basename( $url );

        // get placeholder file in the upload dir with a unique, sanitized filename
        $upload = wp_upload_bits( $file_name, 0, '' );

        if ( $upload['error'] ) {
            return  false;
        }
            
        // fetch the remote url and write it to the placeholder file
        $response = wp_remote_get( $url, array(
            'stream' => true,
            'filename' => $upload['file'],
            'timeout'  => apply_filters( 'wpopal_for_downloading_import_file', 200 ) 
        ) );

        // request failed
        if ( is_wp_error( $response ) ) {
            unlink( $upload['file'] );
            return false;
        }

        $code = (int) wp_remote_retrieve_response_code( $response );

        // make sure the fetch was successful
        if ( $code !== 200 ) {
            unlink( $upload['file'] );
            return  false;
        }

        $filesize = filesize( $upload['file'] );
        $headers = wp_remote_retrieve_headers( $response );
 
        if ( 0 === $filesize ) {
            unlink( $upload['file'] );
            return false;
        }

        return $upload;
    }

	private function add_revslider_old( $slider ) {
		$_FILES['import_file']['error']    = UPLOAD_ERR_OK;
		$_FILES['import_file']['tmp_name'] = $slider;
		$revslider = new RevSlider();
		$revslider->importSliderFromPost( true, 'none' );
	}

	/**
	 * Process download remoting slider
	 */
	private function add_revslider( $slider ) {

		$_FILES['import_file']['error']    = UPLOAD_ERR_OK;
		$_FILES['import_file']['tmp_name'] = $slider;
		$revslider = new RevSliderSlider();
		$revslider->importSliderFromPost( true, 'none' );
	}
    
    protected function fix_guid( $settings ){
        global $wpdb; 

        $oldurls = is_array( $settings['oldurl'] ) ?  $settings['oldurl'] : array(  $settings['oldurl'] ); 

        foreach( $oldurls as $oldurl ) {

            $old_site_url = str_replace("http://","", $oldurl ); 
            $new          = str_replace("http://","", get_site_url() );
            $query        = "SELECT * FROM wp_postmeta WHERE meta_key='_menu_item_url' and meta_value like '%".$old_site_url."%' ";
            $rs = $wpdb->get_results( $query );

            foreach( $rs as $r ){
                $newlink = str_replace( $old_site_url, $new, $r->meta_value ); 
                $wpdb->query( "UPDATE wp_postmeta set meta_value='".$newlink."'  WHERE  meta_id=".$r->meta_id );
            } 
        }
    
    }

    /**
     * Import option setting for current theme
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_customizer(){

        $settings = $this->get_data();
             //// import options
        if( isset($settings['thememods']) ){
            $thememods = $settings['thememods'];

            remove_theme_mods(); 
            
            foreach ( $thememods as $mod => $value ) {

                if( is_numeric($value)  &&  $value > 30 ) { 
                    $new = $this->importer->get_attachment_id( 'wpopal_import_id', $value ); 
                    if( $new ){
                        $value = $new; 
                    }
                }

                if( is_numeric($mod) ){
                    continue;
                }
            
                if( is_string($value) ){
                    $value = str_replace( "SITE_URL_HERE", get_site_url(), $value );
                    if( preg_match( "#\.jpg|\.png|\.gif|\.svg#", $value) ){
             
                        $new_image_id = $this->importer->get_attachment_id( 'wpopal_import_url', $value );
                        if( $new_image_id  ) {
                            $value = wp_get_attachment_url( $new_image_id );
                        }
                    }
                }

                if( $mod == 'custom_logo' ){
                    $new_image_id = $this->importer->get_attachment_id( 'wpopal_import_id', $value );
                    if( $new_image_id  ) {
                        $value = $new_image_id;
                    }
                }

                set_theme_mod( $mod, $value );
            }
        }
        
        do_action( 'wpopal_import_customizer_after' );
        
        $content = __( 'Import all settings for theme, please waiting for a while!' , 'wpopal' );

        return (  
            array(
                "heading" => __( 'Starting to theme Options', 'wpopal' ),
                "content" => $content, 
                "ajax" => array( 'next' =>'import_theme_options' ), 
                "done"=> "0",
                "process" => "9|11"
            ) 
        );  
    }

    public function global_options() {

        $settings = $this->get_data();
        update_option( 'show_on_front', 'page' );

        /// update site options
        if( isset($settings['options']) ){
            foreach ( $settings['options'] as $site_key => $site_value ) {

                if ( empty( $site_value ) ) continue;

                if( $site_key === 'page_on_front' || $site_key === 'page_for_posts' ) {

                    $page           = get_page_by_title( $site_value );
                    $site_value     = is_object( $page ) ? $page->ID : NULL;
                }

                if( is_numeric($site_value)  &&  $site_value > 1 ) { 
                    $new = $this->importer->get_attachment_id( 'wpopal_import_id', $site_value ); 
                    if( $new ){
                        $site_value = $new; 
                    }
                }
                
                if( function_exists( 'wp_update_custom_css_post' ) && $site_key == 'wp_css' &&  $site_value ) {
                    wp_update_custom_css_post( $site_value );
                }

                update_option( $site_key, $site_value );
            }
        }
    }

    /**
     * Import options setting as customizer , site options, auto set active page, header, home, footer...
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_theme_options(){

        $settings = $this->get_data();
        
        update_option( 'show_on_front', 'page' );

        /// update site options
        if( isset($settings['options']) ){
            foreach ( $settings['options'] as $site_key => $site_value ) {

                if ( empty( $site_value ) ) continue;

                if( $site_key === 'page_on_front' || $site_key === 'page_for_posts' ) {

                    $page           = get_page_by_title( $site_value );
                    $site_value     = is_object( $page ) ? $page->ID : NULL;
                }

                if( is_numeric($site_value)  &&  $site_value > 1 ) { 
                    $new = $this->importer->get_attachment_id( 'wpopal_import_id', $site_value ); 
                    if( $new ){
                        $site_value = $new; 
                    }
                }
                
                update_option( $site_key, $site_value );
            }
        }

        // custom set active header and home, footer 
        if( isset($settings['active']) ){
            $settings['active'] = (array)$settings['active'];

            foreach( $settings['active'] as $postype => $slug ){
                // set default home page 
                if ( $post = get_page_by_path( $slug, OBJECT, $postype ) ){
                    if( $postype == 'page' ){
                        update_option( 'page_on_front',  $post->ID );
                    }else if( $postype == 'header' ){  
                        set_theme_mod( 'osf_header_builder',  $slug ); 
                    }else if( $postype == 'footer' ){
                        set_theme_mod( 'osf_footer_layout',  $slug ); 
                    }
                }
            }
        }

        do_action( 'wpopal_import_theme_options_after' );

        $content = __( 'Import all setting, options, other contents, please waiting for a while!' , 'wpopal' );
        return (  
            array(
                "heading" => __( 'Starting to import other content and settings', 'wpopal' ),
                "content" => $content, 
                "ajax" => array('next' =>'import_other'),
                "done"=> "0",
                "process" => "10|11"
            ) 
        );  
    }

    /**
     * Return an instance of this class.
     *
     * @return    Array data having information about heading, content, ajax status, and next step
     */
    public function import_other(){
        $data = $this->get_data();
        $args = array();
        ///  delete temporary options and variables 
        delete_option( 'wpopal_sample_data' );
        
        // import other options
        if( isset($data['other_options']) ){
            foreach( $data['other_options'] as $others ) {
                foreach ( $others as $key => $value ) {

                    if( is_numeric($value)  &&  $value > 30 ) { 
                        $new = $this->importer->get_attachment_id( 'wpopal_import_id', $value ); 
                        if( $new ){
                            $value = $new; 
                        }
                    }

                    update_option( $key, $value );
                }
            }
        }

        // clear elementor css/ 
        if ( function_exists('elementor_load_plugin_textdomain') ) { 
            // clear all css to re-generate
            Elementor\Plugin::$instance->files_manager->clear_cache();
        }
        // fix main site url old by new.
        if( isset($data['oldurl']) ){
           $this->fix_guid( $data );
        }

        do_action( 'wpopal_import_sample_others' );  
        
        return (  
            array( 
                "heading" => __( 'Completed the installation', 'wpopal' ),
                'next' =>"", 
                "done"=> "1",
                "process" => "11|11"  
            ) 
        );  
    }
}
Wpopal_Core_Admin_Importer_Steps::get_instance();
?>
