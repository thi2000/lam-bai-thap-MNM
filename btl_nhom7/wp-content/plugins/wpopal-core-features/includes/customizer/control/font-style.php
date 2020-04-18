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

class WpOpal_Customizer_Control_Style_Font_style extends WpOpal_Customizer_Control_Style {

    public $template = '$selector { font-style:"$value" ;   }';

    protected $section;

    /**
     * Register item with $wp_customize
     */
    public function add_item() {

        global $wp_customize;

        $wp_customize->add_setting( $this->setting, $this->get_setting_args() );
        $args =  $this->get_control_args(); 

        $control = new WpOpal_Customizer_Control_Font_Style(
            $wp_customize,
            $this->id,
            $args
        );
        $wp_customize->add_control( $control );
    } 

    public function post_message( $js='' ) {
        $selector = str_replace( "'", "\'", $this->selector );

        $js .= str_replace(
            array( '@setting@', '@selector@' ),
            array( $this->setting, $selector ),
            file_get_contents( WPOPAL_PLUGIN_DIR . '/assets/js/customize/post-message-part-font-style.js' )
        );

        return  $js . PHP_EOL;
    }

     public function get_css(){
        $value = $this->get_element_setting_value();
        
        $css = '';
        if ( empty( $css ) ) {
            
            $css = $this->selector .' { ';
            if( isset($value['italic']) && $value['italic'] ){
                $css .= ' font-style:italic ;';
            }
            if( isset($value['fontWeight']) && $value['fontWeight'] ){
                $css .= ' font-weight:bold ;';
            }

            if( isset($value['underline']) && $value['underline'] ){
                $css .= ' text-decoration:underline ;';
            }

            if( isset($value['uppercase']) && $value['uppercase'] ){
                $css .= ' text-transform:uppercase ;';
            }
           $css .= ' }';
        }   
  
        return apply_filters( 'wpopal_css_font-style', $css );
    }

}

if( class_exists("WP_Customize_Control") ) {
    /**
     * Class WpOpal_Customizer_Control_Font_Style
     */
    class WpOpal_Customizer_Control_Font_Style extends WP_Customize_Control {
        public $type = 'wpopal-font-style';

        public $fonts;

        /**
         * @return  void
         */
        public function render_content() {
            if ($this->label){
                ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php
            }

            if ($this->description){
                ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php
            }

            $default = wp_parse_args( $this->settings['default']->default, array(
                'italic'     => '',
                'underline'  => '',
                'uppercase'  => '',
                'fontWeight' => '',
            ) );

            // Prepare current value.
            $value = wp_parse_args( $this->value(), array(
                'italic'     => '',
                'underline'  => '',
                'uppercase'  => '',
                'fontWeight' => '',
            ) );
            ?>
            <div wpopal-font-style-control data-id="<?php echo esc_attr( $this->id ) ?>">
                <div class="wpopal-font-style-group">
                    <label class="item">
                        <input class="wpopal-font-weight" type="checkbox" <?php echo checked( $value['fontWeight'], true ) ?>>
                        <div class="wpopal-box">
                            <span class="dashicons dashicons-editor-bold"></span>
                        </div>
                    </label>
                </div>
                <div class="wpopal-font-style-group">
                    <label class="item">
                        <input class="wpopal-italic" type="checkbox" <?php echo checked( $value['italic'], true ) ?>>
                        <div class="wpopal-box">
                            <span class="dashicons dashicons-editor-italic"></span>
                        </div>
                    </label>
                </div>
                <div class="wpopal-font-style-group">
                    <label class="item">
                        <input class="wpopal-underline" type="checkbox" <?php echo checked( $value['underline'], true ) ?>>
                        <div class="wpopal-box">
                            <span class="dashicons dashicons-editor-underline"></span>
                        </div>
                    </label>
                </div>
                <div class="wpopal-font-style-group">
                    <label class="item">
                        <input class="wpopal-uppercase" type="checkbox" <?php echo checked( $value['uppercase'], true ) ?>>
                        <div class="wpopal-box">
                            <span class="dashicons dashicons-editor-textcolor"></span>
                        </div>
                    </label>
                </div>
            </div>
            <?php
        }
    }
}    