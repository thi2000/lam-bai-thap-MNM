<?php
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * @Class WpOpal_Customizer_Control_Style_Background_Color
 * 
 * 
 */
if( class_exists("WP_Customize_Control") ) {
    /**
     * Class WpOpal_Customizer_Control_Button_Switch
     */
    class WpOpal_Customizer_Control_Button_Switch extends WP_Customize_Control {
        public $type    = 'wpopal-button-switch';

        /**
         * Render the control.
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
            ?>
                <input class="wpopal-switch wpopal-switch-ios" id="<?php echo esc_attr($this->id); ?>" type="checkbox" <?php $this->link(); ?>>
                <label class="wpopal-switch-btn" for="<?php echo esc_attr($this->id); ?>"></label>
            <?php
        }
    }
}