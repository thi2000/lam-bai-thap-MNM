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
     * Class WpOpal_Customizer_Control_Color
     */
    class WpOpal_Customizer_Control_Color2 extends WP_Customize_Control {
        public $type = 'wpopal-color';
        public $palette;
        public $show_opacity;

        public function enqueue() {
            wp_enqueue_style(
                'alpha-color-picker',
                WPOPAL_PLUGIN_URI . 'assets/3rd-party/alpha-color-picker/alpha-color-picker.css',
                array( 'wp-color-picker' ),
                '1.0.0'
            );
        }

        /**
         * Render the control.
         */
        public function render_content() {
            // Process the palette
            if (is_array( $this->palette )){
                $palette = implode( '|', $this->palette );
            } else{
                // Default to true.
                $palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
            }
            // Support passing show_opacity as string or boolean. Default to true.
            $show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';

            // Begin the output. ?>
            <label>
                <?php // Output the label and description if they were passed in.
                if (isset( $this->label ) && '' !== $this->label){
                    echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
                }
                if (isset( $this->description ) && '' !== $this->description){
                    echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
                } ?>
                <input class="alpha-color-control" type="text" data-show-opacity="<?php echo $show_opacity; ?>"
                       data-palette="<?php echo esc_attr( $palette ); ?>"
                       data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?> />
            </label>
            <?php
        }
    }
}    