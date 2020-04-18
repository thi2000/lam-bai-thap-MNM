<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalsingleproperty
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) $date$ wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class wpopal_Customizer_Google_Font {
    
    public $fonts = array();

    public static function instance() {
        static $_instance; 
        if( !$_instance ){
            $_instance = new wpopal_Customizer_Google_Font () ;
            $_instance->fonts = wpopal_get_google_fonts();
        }
        return $_instance;
    }

    public function getFonts(){
        return $this->fonts;
    }

}

class WpOpal_Customizer_Control_Style_Google_font extends WpOpal_Customizer_Control_Style {

    public $template = '$selector { font-family:"$value" ; }';

    protected $section;

    /**
     * Register item with $wp_customize
     */
    public function add_item() {

        global $wp_customize;

        $wp_customize->add_setting( $this->id, $this->get_setting_args() );

 
        $args =  $this->get_control_args(); 
        $args['fonts'] = wpopal_Customizer_Google_Font::instance()->getFonts();   
        $control_args['settings'] = array(
            'font_family'   => $this->setting.'[family]',
            'subsets'       => $this->setting.'[subsets]',
            'fontWeight'   => $this->setting.'[fontWeight]'
        );

        $control = new WpOpal_Customizer_Control_Google_Font(
            $wp_customize,
            $this->id,
            $args
        );
        $wp_customize->add_control( $control );
/*
         $wp_customize->selective_refresh->add_partial(  $this->id, array(
            'selector'        => '#' . get_template() . '-style-inline-css'
        ) ); */
      //  echo '<Pre>'.print_r( $this->get_setting_args()   , 1 ); die;
    //    echo '<pre>' . print_r( get_theme_mod( 'wpopal_typography_general_body_font' ) , 1 ); die;
    } 

    public function post_message( $js ) {
        $setting_font_family = $this->setting . '[family]';
        $setting_subsets = $this->setting . '[subsets]';
        $setting_fontWeight = $this->setting . '[fontWeight]';


        $setting_font = $this->setting; 

        $selector = str_replace( "'", "\'", $this->selector );

        $js .= str_replace(
            array( '@setting_font@', '@selector@' ),
            array( $setting_font, $selector ),
            file_get_contents( WPOPAL_PLUGIN_DIR . '/assets/js/customize/post-message-part-text.js' )
        );
  
        return $js . PHP_EOL;
    }

    public function get_css(){
        $value = $this->get_element_setting_value();

        $css = $this->get_css_font_family( $value );


        if ( !empty( $css ) ) {
            $args = array(
                'template' => $this->template,
                'value' => $css,
            );
            $css = $this->apply_template( $args );
        }

        // Filter effects final CSS output, but not postMessage updates
        return apply_filters( 'styles_css_text', $css );
    }


    public function get_css_font_family( $value = false ) {

        if( isset($value['family']) && $value['family'] ){

         
            $font = $value['family'];

            $css = $font ; 
            $font_weight = $value['fontWeight'];

     
            $styles = WpOpal_Style_Css::get_instance();

            if( !isset($styles->google_fonts[$font]) ) {  
                $styles->google_fonts[$font] = "@import url('//fonts.googleapis.com/css?family={$font}:{$font_weight}');\r";
            }
         
            // Filter effects final CSS output, but not postMessage updates
            return apply_filters( 'wpopal_css_font_family', $css );
        }    
    }
}

if( class_exists("WP_Customize_Control") ) {
    /**
     * Class WpOpal_Customizer_Control_Google_Fonts
     */
    class WpOpal_Customizer_Control_Google_Font extends WP_Customize_Control {

        public $type = 'wpopal-google-fonts';

        public $fonts;

        /**
         * @return  void
         */
        public function render_content() {
            if ($this->label) {
                ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php
            }

            if ($this->description) {
                ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php
            }

            $default = wp_parse_args( $this->settings['default']->default, array(
                'family'     => '',
                'subsets'    => 'latin',
                'fontWeight' => '400',
            ) );

            // Prepare current value.
            $value = wp_parse_args( $this->value(), array(
                'family'     => '',
                'subsets'    => 'latin',
                'fontWeight' => '400',
            ) );

            ?>
            <div wpopal-fonts-control data-id="<?php echo esc_attr( $this->id ) ?>">
                <select class="wpopal-customize-google-fonts" title="Google Fonts">
                    <option></option>
                    <?php
                    foreach ($this->fonts as $font) {
                        echo '<option data-info="' . esc_attr( json_encode( array( 'variants' => $font->variants, 'subsets' => $font->subsets ) ) ) . '" value="' . esc_attr( $font->family ) . '" ' . selected( $value['family'], $font->family, false ) . '>' . $font->family . '</option>';
                    }
                    ?>
                </select>
                <div class="google-font-extend">
                    <div class="select-control wpopal-font-weight">
                        <select data-value="<?php echo esc_attr($value['fontWeight']) ?>" title="Font Weight"></select>
                    </div>
                    <div class="select-control wpopal-font-subsets">
                        <select data-value="<?php echo esc_attr($value['subsets']) ?>" title="Subsets"></select>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}