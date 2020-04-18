<?php

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class OSF_Elementor_Dual_heading_Widget extends Elementor\Widget_Base {
    
    public function get_name() {
        return 'opal-dual-heading';
    }

    public function get_title() {
		return 'Opal Dual Heading';
	}
    
    public function get_icon() {
        return 'eicon-type-tool';
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    // Adding the controls fields for the opal dual header
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /*Start General Section*/
        $this->start_controls_section('opal_dual_header_general_settings',
            [
                'label'         => __('Dual Heading', 'opal-addons-for-elementor')
            ]
        );
        
        /*First Header*/
        $this->add_control('opal_dual_header_first_header_text',
            [
                'label'         => __('First Heading', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Heading', 'opal-addons-for-elementor'),
                'label_block'   => true,
            ]
        );

        /*Second Header*/
        $this->add_control('opal_dual_header_second_header_text',
            [
                'label'         => __('Second Heading', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Text', 'opal-addons-for-elementor'),
                'label_block'   => true,
            ]
        );
        
         /*Title Tag*/
        $this->add_control('opal_dual_header_first_header_tag',
            [
                'label'         => __('HTML Tag', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h2',
                'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'p'     => 'p',
                    'span'  => 'span',
                    ],
                'label_block'   =>  true,
            ]
        );
        
        /*Text Align*/
        $this->add_control('opal_dual_header_position',
            [
                'label'         => __( 'Display', 'opal-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'inline'=> __('Inline', 'opal-addons-for-elementor'),
                    'block' => __('Block', 'opal-addons-for-elementor'),
                ],
                'default'       => 'inline',
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-first-container span, {{WRAPPER}} .opal-dual-header-second-container' => 'display: {{VALUE}};',
                ],
                'label_block'   => true
            ]
        );
        
        $this->add_control('opal_dual_header_link_switcher',
            [
                'label'         => __('Link', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Enable or disable link','opal-addons-for-elementor'),
            ]
        );
        
        $this->add_control('opal_dual_heading_link',
            [
                'label'         => __('Link', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::URL,
                'default'       => [
                    'url'   => '#',
                ],
                'placeholder'   => 'https://www.wpopal.com/',
                'label_block'   => true,
                'separator'     => 'after',
                'condition'     => [
                    'opal_dual_header_link_switcher'     => 'yes',
                ]
            ]
        );
        
        /*Text Align*/
        $this->add_responsive_control('opal_dual_header_text_align',
            [
                'label'         => __( 'Alignment', 'opal-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'opal-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'opal-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'opal-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right'
                    ]
                ],
                'default'       => 'left',
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-container' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        /*End General Settings Section*/
        $this->end_controls_section();
        
        /*Start First Header Styling Section*/
        $this->start_controls_section('opal_dual_header_first_style',
            [
                'label'         => __('First Heading', 'opal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );
        
        /*First Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'first_header_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .opal-dual-header-first-span'
            ]
        );
        
        $this->add_control('opal_dual_header_first_animated',
            [
                'label'         => __('Animated Background', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );

        /*First Coloring Style*/
        $this->add_control('opal_dual_header_first_back_clip',
            [
                'label'         => __('Background Style', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'color',
                'description'   => __('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.','opal-addons-for-elementor'),
                'options'       => [
                    'color'         => __('Normal Background', 'opal-addons-for-elementor'),
                    'clipped'       => __('Clipped Background', 'opal-addons-for-elementor'),
                ],
                'label_block'   =>  true
            ]
        );

        /*First Color*/
        $this->add_control('opal_dual_header_first_color',
            [
                'label'         => __('Text Color', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'condition'     => [
                    'opal_dual_header_first_back_clip' => 'color'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-first-span'   => 'color: {{VALUE}};'
                ]
            ]
        );
        
        /*First Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'opal_dual_header_first_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'opal_dual_header_first_back_clip'  => 'color'
                ],
                'selector'          => '{{WRAPPER}} .opal-dual-header-first-span'
            ]
        );
        
        /*First Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'opal_dual_header_first_clipped_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'opal_dual_header_first_back_clip'  => 'clipped'
                ],
                'selector'          => '{{WRAPPER}} .opal-dual-header-first-span'
            ]
        );
        
        /*First Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'              => 'first_header_border',
                'selector'          => '{{WRAPPER}} .opal-dual-header-first-span'
            ]
        );
        
        /*First Border Radius*/
        $this->add_control('opal_dual_header_first_border_radius',
            [
                'label'         => __('Border Radius', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-first-span' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        /*First Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Shadow','opal-addons-for-elementor'),
                'name'          => 'opal_dual_header_first_text_shadow',
                'selector'      => '{{WRAPPER}} .opal-dual-header-first-span'
            ]
        );
        
        /*First Margin*/
        $this->add_responsive_control('opal_dual_header_first_margin',
            [
                'label'         => __('Margin', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-first-span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        /*First Padding*/
        $this->add_responsive_control('opal_dual_header_first_padding',
            [
                'label'         => __('Padding', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-first-span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        /*End First Header Styling Section*/
        $this->end_controls_section();
        
        /*Start First Header Styling Section*/
        $this->start_controls_section('opal_dual_header_second_style',
            [
                'label'         => __('Second Heading', 'opal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );
        
        /*Second Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'second_header_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .opal-dual-header-second-header'
            ]
        );
        
        $this->add_control('opal_dual_header_second_animated',
            [
                'label'         => __('Animated Background', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SWITCHER
            ]
        );
        
        /*Second Coloring Style*/
        $this->add_control('opal_dual_header_second_back_clip',
            [
                'label'         => __('Background Style', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'color',
                'description'   => __('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.','opal-addons-for-elementor'),
                'options'       => [
                    'color'         => __('Normal Background', 'opal-addons-for-elementor'),
                    'clipped'       => __('Clipped Background', 'opal-addons-for-elementor')
                ],
                'label_block'   =>  true
            ]
        );
        
        /*Second Color*/
        $this->add_control('opal_dual_header_second_color',
            [
                'label'         => __('Text Color', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1
                ],
                'condition'     => [
                    'opal_dual_header_second_back_clip' => 'color'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-second-header'   => 'color: {{VALUE}};'
                ]
            ]
        );
        
        /*Second Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'opal_dual_header_second_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'opal_dual_header_second_back_clip'  => 'color'
                ],
                'selector'          => '{{WRAPPER}} .opal-dual-header-second-header'
            ]
        );
        
        /*Second Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'opal_dual_header_second_clipped_background',
                'types'             => [ 'classic' , 'gradient' ],
                'condition'         => [
                    'opal_dual_header_second_back_clip'  => 'clipped'
                ],
                'selector'          => '{{WRAPPER}} .opal-dual-header-second-header'
            ]
        );
        
        /*Second Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'              => 'second_header_border',
                'selector'          => '{{WRAPPER}} .opal-dual-header-second-header'
            ]
        );
        
        /*Second Border Radius*/
        $this->add_control('opal_dual_header_second_border_radius',
            [
                'label'         => __('Border Radius', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-second-header' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        /*Second Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Shadow','opal-addons-for-elementor'),
                'name'          => 'opal_dual_header_second_text_shadow',
                'selector'      => '{{WRAPPER}} .opal-dual-header-second-header'
            ]
        );
        
        /*Second Margin*/
        $this->add_responsive_control('opal_dual_header_second_margin',
            [
                'label'         => __('Margin', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-second-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        /*Second Padding*/
        $this->add_responsive_control('opal_dual_header_second_padding',
            [
                'label'         => __('Padding', 'opal-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .opal-dual-header-second-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );
        
        /*End Second Header Styling Section*/
        $this->end_controls_section();
       
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('opal_dual_header_first_header_text');

        $this->add_inline_editing_attributes('opal_dual_header_second_header_text');

        $first_title_tag = $settings['opal_dual_header_first_header_tag'];

        $first_title_text = $settings['opal_dual_header_first_header_text'] . ' ';

        $second_title_text = $settings['opal_dual_header_second_header_text'];

        $first_clip = '';

        $second_clip = '';

        if( $settings['opal_dual_header_first_back_clip'] === 'clipped' ) : $first_clip = "opal-dual-header-first-clip"; endif; 

        if( $settings['opal_dual_header_second_back_clip'] === 'clipped' ) : $second_clip = "opal-dual-header-second-clip"; endif; 
        
        $first_grad = $settings['opal_dual_header_first_animated'] === 'yes' ? ' gradient' : '';
        
        $second_grad = $settings['opal_dual_header_second_animated'] === 'yes' ? ' gradient' : '';
        
        $full_first_title_tag = '<' . $first_title_tag . ' class="opal-dual-header-first-header ' . $first_clip . $first_grad . '"><span class="opal-dual-header-first-span">'. $first_title_text . '</span><span class="opal-dual-header-second-header ' . $second_clip . $second_grad . '">'. $second_title_text . '</span></' . $settings['opal_dual_header_first_header_tag'] . '> ';
        
        $link = '';
        if( $settings['opal_dual_header_link_switcher'] == 'yes' ) {
            $link = $settings['opal_dual_heading_link']['url'];
        }
        
    ?>
    
    <div class="opal-dual-header-container">
        <?php if( ! empty ( $link ) ) : ?>
            <a href="<?php echo esc_attr( $link ); ?>" <?php if( ! empty( $settings['opal_dual_heading_link']['is_external'] ) ) : ?> target="_blank" <?php endif; ?><?php if( ! empty( $settings['opal_dual_heading_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>>
            <?php endif; ?>
            <div class="opal-dual-header-first-container">
                <?php echo $full_first_title_tag; ?>
            </div>
        <?php if( ! empty ( $link ) ) : ?>
            </a>
        <?php endif; ?>
    </div>

    <?php
    }
    
    protected function _content_template()
    {
        ?>
        <#
        
            view.addInlineEditingAttributes('opal_dual_header_first_header_text');

            view.addInlineEditingAttributes('opal_dual_header_second_header_text');

            var firstTag = settings.opal_dual_header_first_header_tag,

            firstText = settings.opal_dual_header_first_header_text + ' ',

            secondText = settings.opal_dual_header_second_header_text,

            firstClip = '',

            secondClip = '';

            if( 'clipped' === settings.opal_dual_header_first_back_clip )
                firstClip = "opal-dual-header-first-clip"; 

            if( 'clipped' === settings.opal_dual_header_second_back_clip )
                secondClip = "opal-dual-header-second-clip";

            var firstGrad = 'yes' === settings.opal_dual_header_first_animated  ? ' gradient' : '',

                secondGrad = 'yes' === settings.opal_dual_header_second_animated ? ' gradient' : '';
            
                view.addRenderAttribute('first_title', 'class', ['opal-dual-header-first-header', firstClip, firstGrad ] );
                view.addRenderAttribute('second_title', 'class', ['opal-dual-header-second-header', secondClip, secondGrad ] );
        
            if( 'yes' == settings.opal_dual_header_link_switcher ) {
                var link = settings.opal_dual_heading_link.url;
            }
        
        #>
        
        <div class="opal-dual-header-container">
            <# if( 'yes' == settings.opal_dual_header_link_switcher && ( '' != settings.opal_dual_heading_link.url || '' != settings.opal_dual_heading_existing_link ) ) { #>
                <a href="{{ link }}">
            <# } #>
            <div class="opal-dual-header-first-container">
                <{{{firstTag}}} {{{ view.getRenderAttributeString('first_title') }}}>
                <span class="opal-dual-header-first-span">{{{ firstText }}}</span><span {{{ view.getRenderAttributeString('second_title') }}}>{{{ secondText }}}</span>
                </{{{firstTag}}}>
                
            </div>
            <# if( 'yes' == settings.opal_dual_header_link_switcher && ( '' != settings.opal_dual_heading_link.url || '' != settings.opal_dual_heading_existing_link ) ) { #>
                </a>
            <# } #>
        </div>
        
        <?php
    }
}