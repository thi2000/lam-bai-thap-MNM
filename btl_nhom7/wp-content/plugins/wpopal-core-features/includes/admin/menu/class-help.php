<?php 
defined( 'ABSPATH' ) || exit();

/**
 * @Class Wpopal_Core_Admin_Menu
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class Wpopal_Core_Admin_Menu_Help extends Wpopal_Core_Admin_Menu { 
 
    /**
     * Retrieves the admin menu args
     *
     * @return array  Admin menu args
     */
    public function get_admin_menu_args() {

        $menu_name =  __( 'Help', 'wpopal');
        $menus = add_filter('wpopal_admin_menu_navigator', array($this,'add_submenu') );

        if( isset($menus['help']) ){
             return apply_filters( 'wpopal_admin_menu_args', array(
                'name'          => $menu_name,
                'title'         => __('Help', 'wpopal'),
                'compatibility' =>    'manage_options',
            ) );
        }
    }
    public function add_submenu( $menus ){
        
        $menus['help'] = array(
                 'url' => admin_url( "admin.php?page=help" ),
                 'title' => __( 'Help', 'wpopal' ),
        );
        
        return $menus; 
    }

 

    public function the_content () { ?>
      
         <?php do_action( 'wpopal_importer_help_tabs' ); ?>
   <?php }
    /**
     * Register the admin menu
     *
     * @return void
     */
    public function register_admin_menu() { 

        $menu_args = $this->get_admin_menu_args();
 
        /*  Register welcome submenu
        /*---------------------------*/
        add_submenu_page( $this->page_slug,
			$menu_args['title'],
			$menu_args['name'],
			$menu_args['compatibility'],
            'help',
            array( $this, 'render' )
        );
    }

}

new Wpopal_Core_Admin_Menu_Help();
?>