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
class WpOpal_Customizer_Control_Style_Button_move extends WpOpal_Customizer_Control_Style {

    protected $section;

    /**
     * Register item with $wp_customize
     */
    public function add_item() {

        global $wp_customize;

        // echo '<Pre>' . print_r( $this->get_control_args(), 1 );die;
        $wp_customize->add_setting( $this->setting, $this->get_setting_args() );
        $args =  $this->get_control_args(); 
        $args['buttons'] = isset($this->element['buttons'])?$this->element['buttons']:array();
    
        $control = new WpOpal_Customizer_Control_Button_Move(
            $wp_customize,
            $this->id,
            $args
        );
        $wp_customize->add_control( $control );
    } 
}
if( class_exists("WP_Customize_Control") ) {
    /**
     * Class WpOpal_Customizer_Control_Color
     */
    class WpOpal_Customizer_Control_Button_Move extends WP_Customize_Control {
        public $type    = 'wpopal-button-move';
        public $buttons = array();

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
            <?php
            foreach ($this->buttons as $id => $button) {
                $button = wp_parse_args( $button, array(
                    'type'  => '',
                    'label' => '',
                    'id'    => '',
                ) );
                $id = $button['id']; 
                echo '<button type="button" wpopal-button-move class="button" data-id="' . esc_attr( $id ) . '" data-type="' . esc_attr( $button['type'] ) . '">' . esc_html( $button['label'] ) . '</button>';
            }
        }
    }
}    