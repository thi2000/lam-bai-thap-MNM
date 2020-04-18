<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wpopal_Widget_Recent_Post extends WP_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'opal_recent_post',
            // Widget name will appear in UI
            __('Opal Recent Posts Widget', 'wpopal'),
            // Widget description
            array( 'description' => __( 'Show list of recent post', 'wpopal' ), )
        );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        $title      = apply_filters( 'widget_title', $title );
        $show_date  = $instance[ 'show_date' ] ? 'true' : 'false';
        $show_admin = $instance[ 'show_admin' ] ? 'true' : 'false';
        //Check

        $tpl = WPOPAL_THEMER_TEMPLATES_DIR .'widgets/recent_post/default.php'; 
        $tpl_default = WPOPAL_PLUGIN_DIR .'templates/widgets/recent_post/default.php';
  
        if(  is_file($tpl) ) { 
            $tpl_default = $tpl;
        }
        require $tpl_default;
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']          = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_post']    = ( ! empty( $new_instance['number_post'] ) ) ? strip_tags( $new_instance['number_post'] ) : '';
        $instance['show_date']      = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['show_admin']     = isset( $new_instance['show_admin'] ) ? (bool) $new_instance['show_admin'] : false;
        return $instance;

    }

    // Widget Backend
    public function form( $instance ) {
        $defaults = array(  'title' => 'Latest Post',
            'number_post' => '4',
            'post_type' =>  'post',
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); 

        $show_date  = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        $show_admin = isset( $instance['show_admin'] ) ? (bool) $instance['show_admin'] : false;

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'wpopal' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number_post' )); ?>"><?php esc_html_e( 'Num Posts:', 'wpopal' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number_post' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number_post' )); ?>" type="text" value="<?php echo esc_attr($instance['number_post']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e('Show Date', 'wpopal'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" type="checkbox" <?php checked( $show_date ); ?> />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_admin')); ?>"><?php esc_html_e('Show Admin', 'wpopal'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('show_admin')); ?>" name="<?php echo esc_attr($this->get_field_name('show_admin')); ?>" type="checkbox" <?php checked( $show_admin ); ?> />
        </p>
    <?php }

}

    add_action('widgets_init','WpopalRegisterWidget');
    function WpopalRegisterWidget() {
        register_widget('Wpopal_Widget_Recent_Post');
    }

?>
