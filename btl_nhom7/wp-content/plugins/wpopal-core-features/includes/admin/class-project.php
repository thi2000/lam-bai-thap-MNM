<?php
defined( 'ABSPATH' ) || exit();

if( !class_exists("Wpopal_Core_Admin_Project") ) {
    /**
     * @Class Wpopal_Core_Admin_Project
     * 
     * Entry point class to setup load all files and init working on frontend and process something logic in admin
     */

    class Wpopal_Core_Admin_Project {
        public $data ;  

        static $instance; 

        public function __construct(){
            $file = get_template_directory().'/project.json';

            $default = array(
                'name'         => 'sample project',
                'author'       => 'wpopal',
                'version'      => '1.0',
                'link'         => '',
                'description'  => '',
                'sample_link'  => ''
            );
            $this->data = array_merge( $default, json_decode( file_get_contents($file), 1 ) );
        }

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

        public function get_name(){
            return $this->data['name'];
        }

        public function get_author(){
            return $this->data['author'];
        }

        public function get_version() {
            return $this->data['version'];
        }

        public function get_description() {
            return $this->data['description'];
        }

        public function get_sample_link(){
            return $this->data['sample_link'];
        }
        
        /**
         *
         */
        public function get_samples(){
            
            $data = $this->parse_json( $this->get_sample_link( ) );
            
            if( isset($data['samples']) ){
                return $data['samples'];
            }

            return array();
        }

        public function parse_json( $url ) {

            $key = sanitize_key('wpopal_available_demos');

            if ( ! get_transient( $key ) || isset( $_GET['remove_transient'] ) ) {
                //Get JSON
                $request    = wp_remote_get( $url );
                //If the remote request fails, wp_remote_get() will return a WP_Error
                if( is_wp_error( $request ) || ! current_user_can( 'import' ) ) wp_die();
                //proceed to retrieving the data
                $body       = wp_remote_retrieve_body( $request );
                //translate the JSON into Array
                $data       = json_decode( $body, true );
                //Add transient
                set_transient( $key, $data, 24 * HOUR_IN_SECONDS );
            }

            return get_transient( $key );

        }

        public function system_check(){ 

            $data = array(
                'memory_limit'   => wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) ),
                'time_limit'     => ini_get( 'max_execution_time' ),
                'max_input_vars' => ini_get( 'max_input_vars' ),
            );

            $status = array(
                'fs'              => ( WP_Filesystem() ) ? true : false,
                'zip'             => class_exists( 'ZipArchive' ),
                'suhosin'         => extension_loaded( 'suhosin' ),
                'memory_limit'    => $data['memory_limit'] >= 268435456,
                'time_limit'      => ( ( $data['time_limit'] >= 180 ) || ( $data['time_limit'] == 0 ) ) ? true : false,
                'max_input_vars'  => $data['max_input_vars'] >= 5000
            );

        ?>
            <h2 class="medium-title pb-3 mt-lg-0"><?php esc_html_e( 'System Status', 'strollik' ) ?></h2>
            <table class="table-check-status">
                <tbody>
                <tr>
                    <td>WP File System</td>
                    <td><span class="<?php echo( $status['fs'] ? 'pass' : 'fail' ) ?>"></span></td>
                    <td></td>
                </tr>
                <tr>
                    <td>ZipArchive</td>
                    <td><span class="<?php echo( $status['zip'] ? 'pass' : 'fail' ) ?>"></span></td>
                </tr>
                <tr>
                    <td>
                        PHP Memory Limit
                    </td>
                    <td>
                        <span class="<?php echo( $status['memory_limit'] ? 'pass' : 'fail' ) ?>"></span>
                    </td>
                    <td><?php echo size_format( $data['memory_limit'] ); ?></td>
                </tr>
                <?php if ( $status['memory_limit'] ) { ?>
                    <tr>
                        <td colspan="3" class="status-messenger">
                            <span class="status-rerequired">Current memory limit is OK, however <u>256 MB</u> is recommended.</span>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="3" class="status-messenger">
                            <span class="status-rerequired">Minimum <u>128 MB</u> is required, <u>256 MB</u> is recommended. </span>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>
                        PHP Time Limit
                    </td>
                    <td>
                        <span class="<?php echo( $status['time_limit'] ? 'pass' : ( $data['time_limit'] >= 60 ) ? 'warning' : 'fail' ); ?>"></span>
                    </td>
                    <td><?php echo esc_html( $data['time_limit'] ); ?></td>
                </tr>
                <?php if ( $data['time_limit'] < 60 ) { ?>
                    <tr>
                        <td colspan="3" class="status-messenger">
                            <span class="status-rerequired">Minimum <u>60</u> is required, <u>180</u> is recommended.</span>
                        </td>
                    </tr>
                <?php } elseif ( $data['time_limit'] < 180 ) { ?>
                    <tr>
                        <td colspan="3" class="status-messenger">
                            <span class="status-rerequired">Current time limit is OK, however <u>180</u> is recommended. </span>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>PHP Max Input Vars</td>
                    <td>
                        <span class="<?php echo( $status['max_input_vars'] ? 'pass' : 'fail' ) ?>"></span>
                    </td>
                    <td><?php echo esc_html( $data['max_input_vars'] ) ?></td>
                </tr>
                </tbody>
            </table>
                                     
       <?php }
    }
}