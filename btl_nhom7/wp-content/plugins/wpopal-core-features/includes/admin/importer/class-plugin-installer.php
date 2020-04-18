<?php 
defined( 'ABSPATH' ) || exit();

/**
 * @Class WpOpal_Core_Admin_Plugins_Installer
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class WpOpal_Core_Admin_Plugins_Installer {

	/**
     * set imported path of revolution slider
     *
     *  @var     String
     */
	public $plugins; 
	
	/**
     * set and store instance of Tgmpa object
     *
     *  @var     Array
     */
	public $tgmpa; 

	/**
     * Status about automatic active after installed , updated a plugin
     *
     *  @var     Boolean
     */
 
	public $strings; 
 
	public $is_automatic = true; 

	/**
	 * Construct
	 */
	public function __construct(){
		$this->tgmpa = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$this->plugins = $this->tgmpa->plugins;
	}
 	
	public function get_needed_plugins (){
		 
		$plugins = array(
			'all'      => array(), // Meaning: all plugins which still have open actions.
			'install'  => array(),
			'update'   => array(),
			'activate' => array(),
		);
		$plugins = array();

		foreach ( $this->tgmpa->plugins as $slug => $plugin ) {
			if ( $this->tgmpa->is_plugin_active( $slug ) && false === $this->tgmpa->does_plugin_have_update( $slug ) ) {
				// No need to display plugins if they are installed, up-to-date and active.
				continue;
			} else {
				 
				if( isset($plugin['image_url']) ){
					$image = '<img src="'.$plugin['image_url'].'">';
				} else {
					$img = wpopal_get_plugin_icon_uri( $slug );
					$image = '<img src="'.$img.'">';
					
				}
				$plugin['image'] = $image ; 
				if ( ! $this->tgmpa->is_plugin_installed( $slug ) ) {
					$plugin['action'] = 'install';
					$plugins[ $slug ] = $plugin;
				} else {
					if ( false !== $this->tgmpa->does_plugin_have_update( $slug ) ) {
						$plugin['action'] = 'update';
						$plugins[ $slug ] = $plugin;
					}

					if ( $this->tgmpa->can_plugin_activate( $slug ) ) {
						$plugin['action'] = 'activate';
						$plugins[ $slug ] = $plugin;
					}
				}
			}
		}

		return $plugins; 
	}
 

	/**
	 * Try to grab information from WordPress API.
	 *
	 * @param string $slug Plugin slug.
	 * @return object Plugins_api response object on success, WP_Error on failure.
	 */
	protected function get_plugins_api( $slug ) {
		static $api = array(); // Cache received responses.

		if ( ! isset( $api[ $slug ] ) ) {
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}

			$response = plugins_api( 'plugin_information', array( 'slug' => $slug, 'fields' => array( 'sections' => false ) ) );

			$api[ $slug ] = false;

			if ( is_wp_error( $response ) ) {
				wp_die( esc_html( $this->strings['oops'] ) );
			} else {
				$api[ $slug ] = $response;
			}
		}

		return $api[ $slug ];
	}
 
	/**
	 * 
	 *
	 */
	public function do_plugin_install( $slug, $install_type ) {
		
		if( $install_type == "install" || $install_type == "update" ){

			// Prep variables for Plugin_Installer_Skin class.
			$extra         = array();
			$extra['slug'] = $slug; // Needed for potentially renaming of directory name.
			$source        = $this->tgmpa->get_download_url( $slug );
			$api           = ( 'repo' === $this->plugins[ $slug ]['source_type'] ) ? $this->get_plugins_api( $slug ) : null;
			$api           = ( false !== $api ) ? $api : null;


			$url = add_query_arg(
				array(
					'action' => $install_type . '-plugin',
					'plugin' => urlencode( $slug ),
				),
				'update.php'
			);
			

			if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			}

			$title     = ( 'update' === $install_type ) ? $this->strings['updating'] : $this->strings['installing'];
			$skin_args = array(
				'type'   => ( 'bundled' !== $this->plugins[ $slug ]['source_type'] ) ? 'web' : 'upload',
				'title'  => sprintf( $title, $this->plugins[ $slug ]['name'] ),
				'url'    => esc_url_raw( $url ),
				'nonce'  => $install_type . '-plugin_' . $slug,
				'plugin' => '',
				'api'    => $api,
				'extra'  => $extra,
			);
			unset( $title );

			if ( 'update' === $install_type ) {
				$skin_args['plugin'] = $this->plugins[ $slug ]['file_path'];
				$skin                = new Plugin_Upgrader_Skin( $skin_args );
			} else {
				$skin = new Plugin_Installer_Skin( $skin_args );
			}

			// Create a new instance of Plugin_Upgrader.
			$upgrader = new Plugin_Upgrader( $skin );

			// Perform the action and install the plugin from the $source urldecode().
			add_filter( 'upgrader_source_selection', array( $this->tgmpa, 'maybe_adjust_source_dir' ), 1, 3 );

			if ( 'update' === $install_type ) {
				// Inject our info into the update transient.
				$to_inject                    = array( $slug => $this->plugins[ $slug ] );
				$to_inject[ $slug ]['source'] = $source;
				$this->tgmpa->inject_update_info( $to_inject );

				$upgrader->upgrade( $this->plugins[ $slug ]['file_path'] );
			} else {
				$upgrader->install( $source );
			}
			
			add_filter( 'upgrader_source_selection', array( $this->tgmpa, 'maybe_adjust_source_dir' ), 1, 3 );

			// Make sure we have the correct file path now the plugin is installed/updated.
			$this->tgmpa->populate_file_path( $slug );

			// Only activate plugins if the config option is set to true and the plugin isn't
			// already active (upgrade).
			if ( $this->is_automatic && ! $this->tgmpa->is_plugin_active( $slug ) ) {
				$plugin_activate = $upgrader->plugin_info(); // Grab the plugin info from the Plugin_Upgrader method.
				if ( false === $this->activate_single_plugin( $plugin_activate, $slug, true ) ) {
					return true; // Finish execution of the function early as we encountered an error.
				}
			}
			$this->tgmpa->show_tgmpa_version();
			return true;
		} else {
			 $this->activate_single_plugin( $this->plugins[ $slug ]['file_path'], $slug );
		}
	}

	/**
	 * Activate a single plugin and send feedback about the result to the screen.
	 *
	 * @param string $file_path Path within wp-plugins/ to main plugin file.
	 * @param string $slug      Plugin slug.
	 * @param bool   $automatic Whether this is an automatic activation after an install. Defaults to false.
	 *                          This determines the styling of the output messages.
	 * @return bool False if an error was encountered, true otherwise.
	 */
	protected function activate_single_plugin( $file_path, $slug, $automatic = false ) {
		if ( $this->tgmpa->can_plugin_activate( $slug ) ) {
			$activate = activate_plugin( $file_path );

			if ( is_wp_error( $activate ) ) {
				echo '<div id="message" class="error"><p>', wp_kses_post( $activate->get_error_message() ), '</p></div>',
					'<p><a href="', esc_url($this->tgmpa->get_tgmpa_url() ), '" target="_parent">', esc_html( $this->strings['return'] ), '</a></p>';

				return false; // End it here if there is an error with activation.
			} else {
				if ( ! $automatic ) {
					// Make sure message doesn't display again if bulk activation is performed
					// immediately after a single activation.
					if ( ! isset( $_POST['action'] ) ) { // WPCS: CSRF OK.
						echo '<div id="message" class="updated"><p>', esc_html( $this->strings['activated_successfully'] ), ' <strong>', esc_html( $this->plugins[ $slug ]['name'] ), '.</strong></p></div>';
					}
				} else {
					// Simpler message layout for use on the plugin install page.
					echo '<p>', esc_html( $this->strings['plugin_activated'] ), '</p>';
				}
			}
		} elseif ( $this->tgmpa->is_plugin_active( $slug ) ) {
			// No simpler message format provided as this message should never be encountered
			// on the plugin install page.
			echo '<div id="message" class="error"><p>',
				sprintf(
					esc_html( $this->strings['plugin_already_active'] ),
					'<strong>' . esc_html( $this->plugins[ $slug ]['name'] ) . '</strong>'
				),
				'</p></div>';
		} elseif ( $this->tgmpa->does_plugin_require_update( $slug ) ) {
			if ( ! $automatic ) {
				// Make sure message doesn't display again if bulk activation is performed
				// immediately after a single activation.
				if ( ! isset( $_POST['action'] ) ) { // WPCS: CSRF OK.
					echo '<div id="message" class="error"><p>',
						sprintf(
							esc_html( $this->strings['plugin_needs_higher_version'] ),
							'<strong>' . esc_html( $this->plugins[ $slug ]['name'] ) . '</strong>'
						),
						'</p></div>';
				}
			} else {
				// Simpler message layout for use on the plugin install page.
				echo '<p>', sprintf( esc_html( $this->strings['plugin_needs_higher_version'] ), esc_html( $this->plugins[ $slug ]['name'] ) ), '</p>';
			}
		}

		return true;
	}
}

?>