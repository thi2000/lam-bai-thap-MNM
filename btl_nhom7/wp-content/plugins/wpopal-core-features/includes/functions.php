<?php 
    function wpopal_is_woocommerce_activated() {
        return true;
    }
    function wpopal_is_opalelementor_actived() {
        return class_exists('OSF_Elementor_Loader') ? true : false;
    }


    function wpopal_is_easy_google_fonts_actived() {
        return class_exists('Easy_Google_Fonts') ? true : false;
    }

    function  wpopal_get_google_fonts() {
        $content = get_transient('wpopal_list_google_fonts');
        if (!$content) {
            $content = file_get_contents(WPOPAL_PLUGIN_DIR . 'webfonts.json');
            set_transient('wpopal_list_google_fonts', $content, WEEK_IN_SECONDS);
        }

        return json_decode($content)->items;
    }

    function wpopal_get_tgmpa_plugins_page(){
        // Get instance
        $tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
        return $tgmpa_instance->_install_plugins_page();
    }
    
    function wpopal_do_shortcode( $tag, array $atts = array(), $content = null ) {
        global $shortcode_tags;

        if ( ! isset( $shortcode_tags[ $tag ] ) ) {
            return false;
        }

        return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
    }

    $a = wpopal_get_sidebars_options();

    function wpopal_get_sidebars_options() {
         global $wp_registered_sidebars;
        $output = array();
        $output[''] = esc_html__( '-- Select Sidebar --', 'smashbox-core' );

        if (!empty( $wp_registered_sidebars )) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $output[$sidebar['id']] = $sidebar['name'];
            }
        }
        return $output;
    }

    /**
     *
     */
    function wpopal_social_share_post() {
        echo Wpopal_Core_Template_Loader::get_template_part( "social-share" ); 
    }


    if( !function_exists("wpopal_get_svg") ) {
        function wpopal_get_svg( $name, $color, $custom_height='' ){

            $folder = trailingslashit(WPOPAL_PLUGIN_DIR) . 'assets/svg';
            $file = $folder . '/' . $name . '.svg';
            if (file_exists($file)) {
                $content = file_get_contents($file);

                if( $color ){
                    $style = 'fill:  ' . esc_html($color) . ';';
                }
                if ($name === 'grime-top') {
                    $style .= 'margin-top: -1px;';
                }

                if($name === 'half-circle2-top'){
                    $style .= 'margin-bottom: -1px;';
                }

                $style .= ($custom_height) ? 'height: ' . esc_html($custom_height) . ';' : '';
                return preg_replace("/<svg/", "<svg style=\"" . $style . "\"", $content);
            }
        }
    }
?>