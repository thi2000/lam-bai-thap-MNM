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

class WpOpal_Customizer_Control_Style_Slider extends WpOpal_Customizer_Control_Style {

    protected $section;

    protected $property = 'font-size';
    protected $unit = 'px';
    public $template = '$selector { $property: $value; }';

    public function __construct( $group, $element ) {
        parent::__construct( $group, $element );

        
        if( isset($element['choices']) ){
            $this->unit = isset($element['choices']['unit'])?$element['choices']['unit']:"px";
        }
        if( isset($element['property']) ){
            $this->property = $element['property'];
        }
        // Replace $property in $template for child classes
        $this->template = str_replace( '$property', $this->property, $this->template );
    }

    /**
     * Return CSS based on setting value
     */
    public function get_css(){
        $value = $this->get_element_setting_value();

        $css = '';
        if ( $value ) {
            $args = array(
                'template' => $this->template,
                'value' => $value.  $this->unit,
            );
            $css = $this->apply_template( $args );
        }

        // Filter effects final CSS output, but not postMessage updates
        return apply_filters( 'wpopal_css_slider', $css );
    }
    /**
     * Register item with $wp_customize
     */
    public function add_item() {

        global $wp_customize;

        $wp_customize->add_setting( $this->setting, $this->get_setting_args() );
        $args =  $this->get_control_args(); 
        $args['choices'] = isset($this->element['choices'])?$this->element['choices']:array();
        
        $control = new WpOpal_Customizer_Control_Slider(
            $wp_customize,
            $this->id,
            $args
        );
        $wp_customize->add_control( $control );

      // echo '<pre>' . print_r( $args,  1 );die;
     //   echo "fsda".get_option('wpopal_typography_general_body_font_size');die;
     //   echo '<Pre>' . print_r( $this, 1 ); die;
    } 

    public function post_message( $js='' ) {
        $selector = str_replace( "'", "\'", $this->selector );

        $js .= str_replace(
            array( '@setting@', '@setting_unit@', '@setting_property@', '@selector@' ),
            array( $this->setting, $this->unit, $this->property, $selector ),
            file_get_contents( WPOPAL_PLUGIN_DIR . '/assets/js/customize/post-message-part-slider.js' )
        );

        return $js . PHP_EOL;
    }
}

if( class_exists("WP_Customize_Control") ) {


    /**
     * Class WpOpal_Customizer_Control_Slider
     */
    class WpOpal_Customizer_Control_Slider extends WP_Customize_Control {
        public $type = 'wpopal-slider';

        /**
         * @var array
         */
        public $choices;

        /**
         * Enqueue control related scripts/styles.
         *
         * @return  void
         */
        public function enqueue() { 
            // Load jQuery UI
            wp_enqueue_style( 'jquery-ui-slider' );
            wp_enqueue_script( 'jquery-ui-slider' );
        }

        /**
         * Render the control's content.
         *
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
            ?>
            <div class="customize-control-content wpopal-customize-slider"
                 id="<?php echo esc_attr( $this->type ); ?>-<?php echo esc_attr( $this->id ); ?>">
                <div class="wpopal-slider wp-slider"
                     data-min="<?php echo( isset( $this->choices['min'] ) ? esc_attr( $this->choices['min'] ) : '0' ); ?>"
                     data-max="<?php echo( isset( $this->choices['max'] ) ? esc_attr( $this->choices['max'] ) : '300' ); ?>"
                     data-step="<?php echo( isset( $this->choices['step'] ) ? esc_attr( $this->choices['step'] ) : '1' ); ?>"
                     data-unit="<?php echo( isset( $this->choices['unit'] ) ? esc_attr( $this->choices['unit'] ) : '' ); ?>"
                     data-default-value="<?php echo( isset( $this->choices['default'] ) ? esc_attr( $this->choices['default'] ) : '' ); ?>"
                     data-value="<?php echo esc_attr( $this->value() ) ?>"
                     data-id="<?php echo esc_attr( $this->id ) ?>"
                     data-highlight="true">
                </div>
                <a href="#" class="wpopal-reset dashicons dashicons-image-rotate"></a>
                <a href="#" class="wpopal-remove dashicons dashicons-no-alt"></a>
            </div>
            <?php
        }
    }
}