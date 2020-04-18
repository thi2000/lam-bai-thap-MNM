<?php 
defined( 'ABSPATH' ) || exit();

/**
 * @Class Wpopal_Core_Admin_Menu
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class Wpopal_Core_Admin_Menu_Import extends Wpopal_Core_Admin_Menu { 
    
    public function enqueue_scripts () {
        wp_enqueue_script(
                  'wpopal-admin-importer',
                  WPOPAL_PLUGIN_URI . 'assets/js/importer.js',
                  array('jquery'),
                  null,
                  true
        );
    }

    /**
     * Retrieves the admin menu args
     *
     * @return array  Admin menu args
     */
    public function get_admin_menu_args() {

        $menu_name =  __( 'Import Demos', 'wpopal');
        $menus = add_filter('wpopal_admin_menu_navigator', array($this,'add_submenu') );

        return apply_filters( 'wpopal_admin_menu_import_demos_args', array(
            'name'          => $menu_name,
            'title'         => __('Plugin', 'wpopal'),
            'compatibility' =>    'manage_options',
        ) );
    }


    public function add_submenu( $menus ){

        $menus['import'] = array(
            'url' => admin_url( "admin.php?page=import" ),
            'title' => __( 'Import Demos', 'wpopal' ),
        );
        
        return $menus; 
    }

    /**
     * Retrieves the admin menu args
     *
     * @return array  Admin menu args
     */  
    public function the_content () { 

        $this->project = Wpopal_Core_Admin_Project::get_instance();
        $samples = $this->project->get_samples(); 
    ?>
      <div class="theme-dashboard"><div class="row" id="page-importer">    
        <?php  if( $samples ) : ?>  
            <?php foreach( $samples as $key => $item ) : // echo '<Pre>'.print_r($item,1 ); die;

            $cls = $key > 0 && $key%3==0 ? "clear" : "";

            ?>
            <div class="wp-col-4 <?php echo esc_attr( $cls ); ?>">
                    <div class="card" >
                      <img class="card-img-top" src="<?php echo $item['preview']; ?>" alt="Card image cap">
                      <div class="card-body">
                        <h3 class="card-title"><?php echo $item['name']; ?></h3>
                        
                         <div class="text-right">
                          <a href="<?php echo $item['demo']; ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Preview','wpopal'); ?></a>
                          <a href="#" class="button button-primary button-import" data-key="<?php echo $key; ?>" data-sample="<?php echo $item['key']; ?>" data-download="<?php echo $item['sample']; ?>">
                            <i class="fa fa-gear"></i> <?php esc_html_e( 'Import','wpopal'); ?>
                          </a>  
                        </div>  
                      </div>
                    </div>
            </div>   
            <?php endforeach; ?> 
        <?php else : ?>
            <div class="col-12">
              <?php esc_html_e( 'Currently, we have not any sample data for this. Please take your time to keep update here.', 'wpopal' );?>
            </div>    
        <?php endif; ?>       
      </div></div> 
    
        <div class="wpopal-modal " id="wpopal-modal-name">
          <div class="wpopal-modal-sandbox"></div>
          <div class="wpopal-modal-box">
            
            <div class="wpopal-modal-body rounded box-shadow">
                <div class="inner"></div>
            </div>
          </div>
        </div>

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
            'import',
            array( $this, 'render' )
        );
    }

}

new Wpopal_Core_Admin_Menu_Import();
?>
