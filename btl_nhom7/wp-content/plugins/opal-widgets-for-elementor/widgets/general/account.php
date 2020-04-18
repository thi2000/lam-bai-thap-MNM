<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class OSF_Elementor_Account_Widget extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-account';
    }

    public function get_title() {
        return __( 'Opal Account', 'opalelementor' );
    }

    public function get_icon() {
        return 'eicon-lock-user';
    }

    public function get_script_depends() {
        return [
            'wpopal-offcanvas'
        ];
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        return $options;
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'account_content',
            [
                'label' => __( 'Account', 'opalelementor' ),
            ]
        );


        $this->add_control(
            'style',
            [
                'label' => __( 'Style to Show Account Form', 'opalelementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'hover' => __( 'Hover', 'opalelementor' ),
                    'popup' => __( 'Popup', 'opalelementor' ),
                    'offcanvas' => __( 'Offcanvas', 'opalelementor' ),
                ],
                'default' => 'hover',
                'prefix_class' => 'elementor-countdown--label-',
            ]
        );


        $menus = $this->get_available_menus();

        if (!empty($menus)) {
             $this->add_control(
                'enable_custom_menu',
                [
                    'label' => __( 'Use Custom Dashboard Menu', 'elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                ]
            );


            $this->add_control(
                'menu',
                [
                    'label'        => __('Menu', 'opalelementor'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => 'my-account',
                    'save_default' => true,
                    'separator'    => 'after',
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'opalelementor'), admin_url('nav-menus.php')),
                    'condition'    => array( 'enable_custom_menu' => 'yes' )
                ]
            );
        }

        $this->add_control(
            'icon',
            [
                'label' => __( 'Choose Icon', 'opalelementor' ),
                'type' => Controls_Manager::ICON,
                'default' => 'opal-icon-user',
            ]
        );

        $this->add_control(
            'enable_label',
            [
                'label' => __( 'Enable Label', 'elementor' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );  

        $this->add_control(
            'toggle_align',
            [
                'label' => __( 'Alignment', 'opalelementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'opalelementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'opalelementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'opalelementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}}',
                ],
                
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_label_style_content',
            [
                'label' => __( 'Label', 'opalelementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .site-header-account .label' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .site-header-account .label',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style_content',
            [
                'label' => __( 'Icon', 'opalelementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'tabs_icon_style' );

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => __( 'Normal', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .site-header-account i' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .site-header-account i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_fontsize',
            [
                'label' => __( 'Icon Font Size', 'opalelementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-header-account i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .site-header-account i',
                'separator' => 'before',
                
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => __( 'Border Radius', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .site-header-account i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => __( 'Padding', 'opalelementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .site-header-account i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => __( 'Hover', 'opalelementor' ),
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => __( 'Icon Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .site-header-account i:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color_hover',
            [
                'label' => __( 'Background Color', 'opalelementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .site-header-account i:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border_hover',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .site-header-account i:hover',
                'separator' => 'before',
                
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render(){

        $settings = $this->get_settings();

        if( isset($settings['style'])  && $settings['style'] == 'offcanvas') {
            $this->show_offcanvas_form( $settings );
        }else {
            $this->show_poup_hover_form( $settings );
            
        }
    }

    protected function show_poup_hover_form( $settings ) {
      
        $settings = wp_parse_args( $settings, array(
                'enable_label' => false,
                'icon'         => '',
                'style'        => ''
            ) );
        if (osf_elementor_is_woocommerce_activated()) {
            $account_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
        } else {
            $account_link = wp_login_url();
        }
        $id = rand(2,9).rand(0 , 9 );

        //$settings['style'] = 'popup'; 
        ?>
        <?php if( !is_user_logged_in() && $settings['style'] == 'popup' ): ?>
        <div class="elementor-dropdown site-header-account">
            <div class="elementor-dropdown-header">
            <?php
                echo '<a data-effect="mfp-zoom-in" href="#elementor-account-'.esc_attr($id).'" class="opal-account-popup-btn">
                        <i class="'. esc_attr($settings['icon']) .'"></i>
                        '.( $settings['enable_label'] ? '<span class="label">'.__( 'Account', 'opalelementor' ).'</span>' : '' ).'
                      </a>';
            ?>
            </div>
            <div class="mfp-hide elementor-popup-content loginbox-popup account-popup" id="elementor-account-<?php echo esc_attr($id); ?>">
                <?php $this->render_form_login( ); ?>
            </div>
        </div>   
        <?php else : ?>    
        <div class="elementor-dropdown site-header-account">
            <div class="elementor-dropdown-header">
           
            <?php
                echo '<a href="' . esc_html($account_link) . '">
                    <i class="'. esc_attr($settings['icon']) .'"></i>
                    '.( $settings['enable_label'] ? '<span class="label">'.__( 'Account', 'opalelementor' ).'</span>' : '' ).'
                  </a>';
            ?>
            </div>

            <div class="elementor-dropdown-menu" id="elementor-account-<?php echo esc_attr($id); ?>">
                <div class="account-wrap">
                    <div class="account-inner <?php if (is_user_logged_in()): echo "dashboard"; endif; ?>">
                        <?php if (!is_user_logged_in()) {
                            $this->render_form_login( );
                        } else {
                            $this->render_dashboard( $settings );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php
    }


    private function show_offcanvas_form( $settings ){
          $settings = wp_parse_args( $settings, array(
                'enable_label' => false,
                'icon'         => '',
                'style'        => ''
            ) );
        if (osf_elementor_is_woocommerce_activated()) {
            $account_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
        } else {
            $account_link = wp_login_url();
        }
        $id = rand(2,9).rand(0 , 9 );
        ?>
          
        <div class="elementor-dropdown-fixed-right site-header-account">
            <div class="elementor-dropdown-header">
           
            <?php
                echo '<a href="' . esc_html($account_link) . '" data-appear="right,overlay"  id="button-account-'. esc_attr($id).'" data-container="account-content-'.esc_attr($id).'">
                    <i class="'. esc_attr($settings['icon']) .'"></i>
                    '.( $settings['enable_label'] ? '<span class="label">'.__( 'Account', 'opalelementor' ).'</span>' : '' ).'
                  </a>';
            ?>
            </div>

            <div class="elementor-dropdown-menu-fixed-right text-left" id="account-content-<?php echo esc_attr($id); ?>">
                <h3 class="text-center"><?php _e( 'My Account' ,'opalelementor'); ?></h3>
                <div class="account-wrap">
                    <div class="account-inner <?php if (is_user_logged_in()): echo "dashboard"; endif; ?>">
                        <?php if (!is_user_logged_in()) {
                            $this->render_form_login( );
                        } else {
                            $this->render_dashboard( $settings );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
 
    <?php }

    protected function render_form_login( ){ 
        $url = otf_is_woocommerce_activated() ? get_permalink( wc_get_page_id( 'myaccount' ) ) : wp_registration_url();  
    ?>

        <div class="login-form-head">
            <span class="login-form-title"><?php esc_attr_e('Sign in', 'opalelementor') ?></span>
            <span class="pull-right">
                <a class="register-link" href="<?php echo esc_url( $url ); ?>"
                   title="<?php esc_attr_e('Register', 'opalelementor'); ?>"><?php esc_attr_e('Create an Account', 'opalelementor'); ?></a>
            </span>
        </div>

        <form class="opal-login-form-ajax" action="<?php echo esc_url( $url ); ?>" data-toggle="validator" method="post">
            <p>
                <label><?php esc_attr_e('Username or email', 'opalelementor'); ?> <span class="required">*</span></label>
                <input name="username" type="text" required placeholder="<?php esc_attr_e('Username', 'opalelementor') ?>">
            </p>
            <p>
                <label><?php esc_attr_e('Password', 'opalelementor'); ?> <span class="required">*</span></label>
                <input name="password" type="password" required placeholder="<?php esc_attr_e('Password', 'opalelementor') ?>">
            </p>
            <button type="submit" name="login" data-button-action class="btn btn-primary btn-block w-100 mt-1" value="<?php esc_html_e('Login', 'opalelementor') ?>"><?php esc_html_e('Login', 'opalelementor') ?></button>
            <input type="hidden" name="action" value="opalelementor_login">
            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
            <?php wp_nonce_field('ajax-opalementor-login-nonce', 'security-login'); ?>
        </form>

        <?php do_action( 'opalelementor_after_render_login_form' ); ?>
        <div class="login-form-bottom">
            <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>" class="lostpass-link" title="<?php esc_attr_e('Lost your password?', 'opalelementor'); ?>"><?php esc_attr_e('Lost your password?', 'opalelementor'); ?></a>
        </div>
 
<?php

    }

    protected function render_dashboard( $settings ){ ?>
        <?php if ( isset($settings['enable_custom_menu'])  && $settings['enable_custom_menu'] == 'yes' ) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e('Dashboard', 'opalelementor'); ?>">
                <?php
                wp_nav_menu(array(
	                'menu'       => $settings['menu'],
	                'menu_class' => 'account-links-menu',
	                'depth'      => 1,
                ));
                ?>
            </nav><!-- .social-navigation -->
        <?php else: ?>
            <ul class="account-dashboard">
                <?php if (osf_elementor_is_woocommerce_activated()): ?>
                <li>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" title="<?php esc_html_e('Dashboard', 'opalelementor'); ?>"><?php esc_html_e('Dashboard', 'opalelementor'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" title="<?php esc_html_e('Orders', 'opalelementor'); ?>"><?php esc_html_e('Orders', 'opalelementor'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>" title="<?php esc_html_e('Downloads', 'opalelementor'); ?>"><?php esc_html_e('Downloads', 'opalelementor'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>" title="<?php esc_html_e('Edit Address', 'opalelementor'); ?>"><?php esc_html_e('Edit Address', 'opalelementor'); ?></a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" title="<?php esc_html_e('Account Details', 'opalelementor'); ?>"><?php esc_html_e('Account Details', 'opalelementor'); ?></a>
                </li>
                <?php else: ?>
                <li>
                    <a href="<?php echo esc_url(get_dashboard_url(get_current_user_id())); ?>" title="<?php esc_html_e('Dashboard', 'opalelementor'); ?>"><?php esc_html_e('Dashboard', 'opalelementor'); ?></a>
                </li>
                <?php endif; ?>
                <li>
                    <a title="<?php esc_html_e('Log out', 'opalelementor'); ?>" class="tips" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log Out', 'opalelementor'); ?></a>
                </li>
            </ul>
        <?php endif;

    }
}
