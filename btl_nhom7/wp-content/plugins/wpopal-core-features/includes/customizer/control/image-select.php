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

 
    class WpOpal_Customizer_Control_Style_Image_Select extends WpOpal_Customizer_Control_Style {

        public $template = '$selector { background-image:url("$value") ; }';

        protected $section;

        /**
         * Register item with $wp_customize
         */
        public function add_item() {

            global $wp_customize;

            $wp_customize->add_setting( $this->setting, $this->get_setting_args() );
            $args =  $this->get_control_args(); 

            $control = new WP_Customize_Image_Control(
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
                file_get_contents( WPOPAL_PLUGIN_DIR . '/assets/js/customize/post-message-part-image-select.js' )
            );

            return  $js . PHP_EOL;
        }

         public function get_css(){  
            $selector = $this->selector;
            $value = $this->get_element_setting_value();

            $css = '';
            if ( $value ) {
                $args = array(
                    'template' => $this->template,
                    'value' => $value,
                );
                $css = $this->apply_template( $args );
            }


            // Filter effects final CSS output, but not postMessage updates
            return apply_filters( 'styles_css_color', $css );
        }
    }
 