<?php 
defined( 'ABSPATH' ) || exit();

if( ! class_exists("Wpopal_Core_Admin_Menu" ) ) {
    /**
     * @Class Wpopal_Core_Admin_Menu
     * 
     * Entry point class to setup load all files and init working on frontend and process something logic in admin
     */
    class Wpopal_Core_Admin_Menu {

        public $page_slug = 'wpopal_dashboard';

        public $project ; 

        public $theme_uri; 

        public function __construct () {
            add_action( 'admin_menu' , array( $this, 'register_admin_menu'  ) , 99);
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 999);
        }


        public function edit_tgmpa_notice_action_links( $action_links ) {
            $current_screen = get_current_screen();

            if ( 'opal-theme-plugins' == $current_screen->id ) {
                $link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="#opal-install-plugins">' . esc_attr__( 'Manage Plugins Below', 'wpopal' ) . '</a>';
            } else {
                $link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="' . esc_url( self_admin_url( 'admin.php?page=opal-theme-plugins' ) ) . '#opal-install-plugins">' . esc_attr__( 'Go Manage Plugins', 'wpopal' ) . '</a>';
            }

            $action_links = array( 'install' => $link_template, 'dismiss' => $action_links['dismiss'] );

            return $action_links;
        }

        public function enqueue_scripts(){
            wp_enqueue_style( 'wpopalbootstrap-admin', get_stylesheet_directory_uri() . '/assets/css/admin.css', array()  );
        }
        /**
         * Retrieves the admin menu args
         *
         * @return array  Admin menu args
         */
        public function get_admin_menu_args() {

            $menu_name =  __( 'Wpopal', 'wpopal');

            return apply_filters( 'wpopal_admin_menu_args', array(
                'name'          => $menu_name,
                'title'         => __('Welcome', 'wpopal'),
                'compatibility' =>    'manage_options',
            ) );
        }

        /**
         * Register the admin menu
         *
         * @return void
         */ 
        public function register_admin_menu() { 

            $menu_args = $this->get_admin_menu_args();
     
            /*  Register welcome submenu
            /*---------------------------*/

             
     
            /*  Register welcome submenu
            /*---------------------------*/
            $url = '';
            add_menu_page(
                $menu_args['title'],
                $menu_args['name'],
                'dashboard',
                $this->page_slug,
                array( $this, 'render' ),
                 get_theme_file_uri( 'inc/admin/assets/images/menu-icon-red.png' ),
                2
            );

            add_submenu_page( $this->page_slug,
                $menu_args['title'],
               esc_html__('Welcome', 'wpopal'),
                $menu_args['compatibility'],
                'dashboard',
                array( $this, 'render' )
            );


            $url = '';
            add_menu_page(
                $menu_args['title'],
                $menu_args['name'],
                'dashboard',
                $this->page_slug,
                array( $this, 'render' ),
                 get_theme_file_uri( 'inc/admin/assets/images/menu-icon-red.png' ),
                2
            );

          
            add_submenu_page( $this->page_slug,
                $menu_args['title'],
                __('Install Plugins', 'wpopal'),
                $menu_args['compatibility'],
                'tgmpa-install-plugins',
                array( $this, 'render' )
            );  

           // remove_submenu_page( 'themes.php', 'dashboard' );
        }

        public function get_header_title(){
            return __( 'Welcome to Use %s', 'wpopal' );
        }
        /**
         * Header section
         *
         * @param  string $type The current tab
         * @return void
         */
        protected function the_header( $type='' ){ 
            global $wpopal_version;
            $url = '';
            $this->project = Wpopal_Core_Admin_Project::get_instance();
            $this->theme_uri = get_template_directory_uri();
            $the_theme = wp_get_theme();
        ?>

            <section class="jumbotron text-center p-4">
                 <a class="theme-logo" href="#"><img src="<?php echo  $this->theme_uri.'/assets/images/theme-logo.png'; ?>"></a>


                <div class="container">
                  <h1 class="jumbotron-heading"><?php echo sprintf( 'Welcome, Thanks for installing : %s', $the_theme->get( 'Name' )  ); ?></h1>
                  <ul class="subtitle">
                    <li> <?php echo __( 'Version', 'wpopal' );?>:  <?php echo esc_html( $the_theme->get( 'Version' ) ) ; ?> </li>
                    <li> <?php echo __( 'Information', 'wpopal' );?>: <a class="theme-info-detail" href="<?php echo esc_attr( $the_theme->get( 'ThemeURI' ) );?>"><?php esc_html_e( 'Click here', 'wpopal' ) ?></a></li>
                  </ul>

                  <p class="lead text-muted"><?php echo esc_html( $the_theme->get( 'Description' )  ); ?></p>
                    
                   <div class="wpopal-navigation">
                       <?php echo $this->the_navigator(); ?>
                   </div> 
                </div>
            </section>
            <?php
        }

        public function get_menus(){
            $menu = array();
          
            $menus['dashboard'] = array(
                 'url' => admin_url( "admin.php?page=dashboard" ),
                 'title' => __( 'Dashboard', 'wpopal' ),
            );

           $menus['tgmpa-install-plugins'] = array(
                 'url' => admin_url( "admin.php?page=tgmpa-install-plugins" ),
                 'title' => __( 'Import Plugins', 'wpopal' ),
            );

            return apply_filters( "wpopal_admin_menu_navigator", $menus );
        }

        /**
         *
         */
        public function the_navigator() {   
            $menus = $this->get_menus();

            $active = isset($_GET['page'])?$_GET['page']:"";
        ?>
            <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary text-center rounded box-shadow">
           
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php foreach( $menus as $page => $menu ): ?> 
                      <li class="nav-item <?php if( $page == $active) :?>active<?php endif; ?>">
                        <a class="nav-link" href="<?php echo $menu['url'] ?>"><?php echo $menu['title'] ?> </a>
                      </li>
                    <?php endforeach; ?>
                 </ul>
              </div>
            </nav>
        <?php }

        public function the_footer(){

        }

        public function the_content(){ 
            $status = array();
            $status['plugin_required'] = 1;
            $theme = wp_get_theme();
        ?>
         
        <?php }

        public function render() { 
             $active = isset($_GET['page'])?$_GET['page']:"";
        ?>
            <div class="wpopal-admin-menu mr-4">
                   <?php echo $this->the_header(); ?> 
                   <?php  // echo $this->the_navigator(); ?>
                   <div class="page-menu-content"> 
                       <div class="page-inner">
                        
                        <?php if(  $active == 'tgmpa-install-plugins' ) : ?>
                        <div class="plugins-required">
                           <?php echo __( 'All plugin are installed as require, Click to the link and select demo for installation', 'wpopal' );?>
                           <a class="button-second" href="<?php echo  admin_url( "admin.php?page=import" ); ?>">
                                <?php echo __( 'Import Demo', 'wpopal' );?>
                           </a>
                        </div>
                        <?php endif; ?>

                        <?php echo $this->the_content(); ?>
                            

                        </div>
                   </div>
                   <?php echo $this->the_footer(); ?>
            </div>
        <?php }
    } 

    new Wpopal_Core_Admin_Menu();
}
?>
