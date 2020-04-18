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

if( class_exists("WP_Customize_Control") ) {
    class WpOpal_Customizer_Control_Sidebars extends WP_Customize_Control {
        public $type = 'wpopal-sidebar';

        /**
         * @return array
         */
        public function get_sidebars() {
            global $wp_registered_sidebars;
            $output = array();
            $output[''] = esc_html__( '-- Select Sidebar --', 'wpopal' );

            if (!empty( $wp_registered_sidebars )) {
                foreach ($wp_registered_sidebars as $sidebar) {
                    $output[$sidebar['id']] = $sidebar['name'];
                }
            }

            return $output;
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
            $sidebars = $this->get_sidebars();
            ?>
            <select class="wpopal-switch-sidebar" id="<?php echo esc_attr( $this->id ) ?>" <?php $this->link(); ?>>
                <?php foreach ($sidebars as $id => $sidebar): ?>
                    <option value="<?php echo esc_attr($id) ?>" <?php selected($this->value(), $id) ?>><?php echo esc_html($sidebar) ?></option>
                <?php endforeach; ?>
            </select>

            <?php

            echo '<div class="change-image"><button type="button" wpopal-button-move class="button button-primary" data-id="sidebar-widgets-'.esc_attr($this->value()).'" data-type="section">Go to Sidebar</button></div>';
        }
    }
}
