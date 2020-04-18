<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class OSF_Elementor_Video_Widget extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-video-popup';
    }

    public function get_title() {
        return __('Opal Video', 'opalelementor');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-youtube';
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'section_videos',
            [
                'label' => __('General', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => __( 'Link to', 'opalelementor' ),
                'type' => Controls_Manager::TEXT,
                'description' => __('Support video from Youtube and Vimeo', 'opalelementor'),
                'placeholder' => __( 'https://your-link.com', 'opalelementor' ),
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label'     => __('Alignment', 'opalelementor'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => __('Left', 'opalelementor'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'opalelementor'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'opalelementor'),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'opalelementor'),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_font',
            [
                'label' => __( 'Icon Font', 'opalelementor' ),
                'type' => Controls_Manager::ICON,
                'label_block' => true,
                'default' => 'fa fa-play-circle-o',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if(empty($settings['video_link'])){
            return;
        }

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-video-wrapper' );
        $this->add_render_attribute( 'wrapper', 'class', 'opal-video-popup' );

        $this->add_render_attribute( 'button', 'class', 'elementor-video-popup' );
        $this->add_render_attribute( 'button', 'role', 'button' );
        $this->add_render_attribute( 'button', 'href',  esc_url( $settings['video_link']));
        $this->add_render_attribute( 'button', 'data-effect', 'mfp-zoom-in' );

        $contentHtml = '<i class="'. esc_attr( $settings['icon_font'] ).'"></i>';

        $titleHtml = !empty($settings['title']) ? '<div class="video-title">'.$settings['title'].'</div>' : '';


        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                <?php echo $contentHtml; ?>
            </a>
            <?php echo ($titleHtml);?>
        </div>
        <?php
    }

}