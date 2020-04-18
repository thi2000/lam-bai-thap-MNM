<?php 
if (!function_exists('osf_elementor_is_vc_activated')) {
    function osf_elementor_is_vc_activated() {
        return class_exists('Vc_Manager') ? true : false;
    }
}

if (!function_exists('osf_elementor_is_one_click_import_activated')) {
    function osf_elementor_is_one_click_import_activated() {
        return class_exists('OCDI_Plugin') ? true : false;
    }
}

if( !function_exists('osf_elementor_is_elementor_activated')){
    function osf_elementor_is_elementor_activated(){
        return function_exists('elementor_load_plugin_textdomain');
    }
}

if( !function_exists('osf_elementor_is_contactform7_activated')){
    function osf_elementor_is_contactform7_activated(){
        return class_exists('WPCF7');
    }
}

if (!function_exists('otf_is_woocommerce_activated')) {
    /**
     * Query WooCommerce activation
     */
    function otf_is_woocommerce_activated() {
        return class_exists('WooCommerce') ? true : false;
    }
}


if (!function_exists('otf_is_woocommerce_extension_activated')) {
    function otf_is_woocommerce_extension_activated($extension = 'WC_Bookings') {
        return class_exists($extension) ? true : false;
    }
}

if( !function_exists('osf_elementor_is_mailchimp_activated')){
    function osf_elementor_is_mailchimp_activated(){
        return function_exists('_mc4wp_load_plugin');
    }
}

if (!function_exists('osf_elementor_is_woocommerce_activated')) {
    /**
     * Query WooCommerce activation
     */
    function osf_elementor_is_woocommerce_activated() {
        return class_exists('WooCommerce') ? true : false;
    }
}

function osf_elementor_get_icon_svg($path, $color = '', $width = '') {
    $content = osf_elementor_get_file_contents( $path );
    if ( $content ) {
        $re = '/<svg(([^\n]*\n)+)<\/svg>/';
        preg_match_all( $re, $content, $matches, PREG_SET_ORDER, 0 );
        if ( count( $matches ) > 0 ) {
            $content = $matches[0][0];
            $css     = '';
            if ( $color ) {
                $content = preg_replace( '/stroke="[^"]*"/', 'stroke="' . $color . '"', $content );
                $css     .= 'fill:' . $color . ';';
            }
            if ( $width ) {
                $css .= 'width:' . $width . '; height: auto;';
            }
            $content = preg_replace( "/(<svg[^>]*)(style=(\"|')([^(\"|')]*)('|\"))/m", '$1 style="' . $css . '$4"', $content );
        }
    }
    return $content;
}

if( !function_exists("osf_do_shortcode") ) {
    function osf_do_shortcode($tag, array $atts = array(), $content = null) {
        global $shortcode_tags;

        if (!isset($shortcode_tags[$tag])) {
            return false;
        }

        return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
    }
}

function osf_elementor_get_file_contents($path) {
    if (is_file($path)) {
        return file_get_contents($path);
    }
    return false;
}

if (!function_exists('osf_elementor_get_metabox')) {

    /**
     * @param int    $id
     * @param string $key
     * @param bool   $default
     *
     * @return bool|mixed
     */
    function osf_elementor_get_metabox($id, $key, $default = false) {
        $value = get_post_meta($id, $key, true);
        if (false === $value) {
            return $default;
        } else {
            return $value;
        }
    }
}


function osf_elementor_get_option($option_key, $key = '', $default = false) {
    if (function_exists('cmb2_get_option')) {
        // Use cmb2_get_option as it passes through some key filters.
        return cmb2_get_option($option_key, $key, $default);
    }
    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option($option_key, $default);
    $val  = $default;
    if ('all' == $key) {
        $val = $opts;
    } elseif (is_array($opts) && array_key_exists($key, $opts) && false !== $opts[$key]) {
        $val = $opts[$key];
    }
    return $val;
}

function opalelementor_render_footer () {
    OSF_Footer_builder::get_instance()->render_html();
}

function opalelementor_render_header () {   
    OSF_Header_builder::get_instance()->render_html();
}



?>