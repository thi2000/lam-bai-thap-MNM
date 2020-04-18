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


    class WpOpal_Customizer_Control_Style_Heading extends WpOpal_Customizer_Control_Style {

        protected $section;

        /**
         * Register item with $wp_customize
         */
        public function add_item() {

            global $wp_customize;

            $wp_customize->add_setting( $this->setting, $this->get_setting_args() );
            $args =  $this->get_control_args(); 

            $control = new WpOpal_Customizer_Control_Heading(
                $wp_customize,
                $this->id,
                $args
            );
            $wp_customize->add_control( $control );
        } 
    }

if( class_exists("WP_Customize_Control") ) {
    /**
     * Class WpOpal_Customizer_Control_Heading
     */
    class WpOpal_Customizer_Control_Heading extends WP_Customize_Control {

        public $type = 'heading';

        /**
         * @return  void
         */
        public function render_content() {
            if ( ! empty( $this->label ) ) :
                ?>
                <h4><?php echo esc_html( $this->label ); ?></h4>
                <?php
            endif;

            if ( ! empty( $this->description ) ) :
                ?>
                <span class="description customize-control-description"><?php echo '' . $this->description ; ?></span>
            <?php endif;
        }
    }
}