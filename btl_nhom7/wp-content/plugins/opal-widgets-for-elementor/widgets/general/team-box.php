<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class OSF_Elementor_Team_box_Widget extends Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-team-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Team Box', 'opalelementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_team',
            [
                'label' => __('Team', 'opalelementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __('Style', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => array(
                    'style-1' => esc_html__('Style 1', 'opalelementor'),
                    'style-2' => esc_html__('Style 2', 'opalelementor'),
                    'style-3' => esc_html__('Style 3', 'opalelementor'),
                ),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'   => __('Layout', 'opalelementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default' => esc_html__('Default', 'opalelementor'),
                    'layout-1' => esc_html__('Layout 1', 'opalelementor'),
                ),
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __('View', 'opalelementor'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'teams',
            [
                'label'       => __('Team Item', 'opalelementor'),
                'type'        => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'name',
            [
                'label'   => __('Name', 'opalelementor'),
                'default' => 'John Doe',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'      => __('Choose Image', 'opalelementor'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'job',
            [
                'label'   => __('Job', 'opalelementor'),
                'default' => 'Designer',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link to', 'opalelementor'),
                'placeholder' => __('https://your-link.com', 'opalelementor'),
                'type'        => Controls_Manager::URL,
            ]
        );

        $this->add_control(
             'facebook',
            [
                'label'   => __('Facebook', 'opalelementor'),
                'default' => 'www.facebook.com/opalwordpress',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'twitter',
            [
                'label'   => __('Twitter', 'opalelementor'),
                'default' => 'https://twitter.com/opalwordpress',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'youtube',
            [
                'label'   => __('Youtube', 'opalelementor'),
                'default' => 'https://www.youtube.com/user/WPOpalTheme',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'google',
            [
                'label'   => __('Google', 'opalelementor'),
                'default' => 'https://plus.google.com/u/0/+WPOpal',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'pinterest',
            [
                'label'   => __('Pinterest', 'opalelementor'),
                'default' => 'https://www.pinterest.com/',
                'type'    => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'description',
            [
                'label'   => __('Description', 'opalelementor'),
                'type'    => Controls_Manager::TEXTAREA,
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_team_name',
            [
                'label' => __('Name', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label'     => __('Text Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-name, {{WRAPPER}} .elementor-team-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-team-name',
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_team_job',
            [
                'label' => __('Job', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => __('Text Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-team-job',
            ]
        );

        $this->end_controls_section();

        // Social.
        $this->start_controls_section(
            'section_style_team_social',
            [
                'label' => __('Social', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'social_color',
            [
                'label'     => __('Social Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social .fa' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_hover_color',
            [
                'label'     => __('Social Hover Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials li.social .fa:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Information.
        $this->start_controls_section(
            'section_style_team_description',
            [
                'label' => __('Description', 'opalelementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __('Description Color', 'opalelementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-team-description',
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-teams-wrapper');
        $this->add_render_attribute('wrapper', 'class', $settings['style']);


        // Item
        $this->add_render_attribute('item', 'class', 'elementor-team-item');

        $this->add_render_attribute('meta', 'class', 'elementor-team-meta');

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('item'); ?>>
                <?php $this->render_style( $settings)?>
            </div>
        </div>
    <?php
    }

    protected function render_style( $settings){ ?>
        <div class="elementor-team-meta-inner">
            <div class="elementor-team-image">
                <?php
                if (!empty($settings['image']['url'])) :
                    $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
                    echo $image_html;
                endif;

                if ($settings['link']['is_external']) {
                    $target = '_blank';
                }else {
                    $target = '';
                }
                ?>

                <?php if ($settings['layout'] === 'layout-1') : ?>
                    <div class="elementor-team-socials">
                        <ul class="socials">
                            <?php foreach ($this->get_socials() as $key => $social): ?>
                                <?php if (!empty($settings[$key])) : ?>
                                    <li class="social">
                                        <a target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($settings[$key]) ?>">
                                            <i class="fa <?php echo esc_attr($social); ?>"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
            <div class="elementor-team-details">
                <?php
                
                if ($settings['link']['is_external']) {
                    $target = '_blank';
                }else {
                    $target = '';
                }
                $team_name_html = $settings['name'];
                if (!empty($settings['link']['url'])) :
                    $team_name_html = '<a target="' .$target. '"  href="' . esc_url($settings['link']['url']) . '">' . $team_name_html . '</a>';
                endif;
                
                $description = $settings['description'] ? $settings['description'] : '';
               
                ?>
                <div class="elementor-team-name"><?php echo $team_name_html; ?></div>
                <div class="elementor-team-job"><?php echo $settings['job']; ?></div>
                <?php if ($settings['layout'] != 'layout-1') : ?>
                    <div class="elementor-team-socials">
                        <ul class="socials">
                            <?php foreach ($this->get_socials() as $key => $social): 
                                ?>
                                <?php if (!empty($settings[$key])) : ?>
                                    <li class="social">
                                        <a target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($settings[$key]) ?>">
                                            <i class="fa <?php echo esc_attr($social); ?>"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="elementor-team-description">
                    <?php echo sprintf( '%1$s', $description ); ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_socials(){
        return array(
            'facebook'  => 'fa-facebook',
            'twitter'   => 'fa-twitter',
            'youtube'   => 'fa-youtube',
            'google'    => 'fa-google-plus',
            'pinterest' => 'fa-pinterest'
        );
    }

}