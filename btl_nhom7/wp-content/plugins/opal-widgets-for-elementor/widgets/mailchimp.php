<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class OSF_Elementor_Mailchimp extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-mailchmip';
    }

    public function get_title() {
        return __('Opal MailChimp Sign-Up Form', 'opalelementor');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'mailchmip',
            [
                'label' => __('General', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_style',
            [
                'label' => __( 'Style', 'opalelementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Style 1', 'opalelementor'),
                    'style2' => __('Style 2', 'opalelementor'),
                    'style3' => __('Style 3', 'opalelementor'),
                    'style4' => __('Style 4', 'opalelementor'),
                ],
                'default' => 'style1',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        echo '<div class="form-style '. $settings['form_style'].'">';
            mc4wp_show_form();
        echo '</div>';
    }
}