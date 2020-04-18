<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

defined( 'ABSPATH' ) || exit();

class OSF_Elementor_Heading_Animated_widget extends Widget_Base {

	public function get_name() {
		return 'heading-animated';
	}

	public function get_title() {
		return __( 'Opal Heading Animated', 'opalelementor' );
	}

	public function get_icon() {
		return 'eicon-animated-headline';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'text_elements',
			[
				'label' => __( 'Headline', 'opalelementor' ),
			]
		);

		$this->add_control(
			'headline_style',
			[
				'label' => __( 'Style', 'opalelementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'highlight',
				'options' => [
					'highlight' => __( 'Highlighted', 'opalelementor' ),
					'rotate' => __( 'Rotating', 'opalelementor' ),
				],
				'prefix_class' => 'opal-heading-animated--style-',
				'render_type' => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'animation_type',
			[
				'label' => __( 'Animation', 'opalelementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'typing' => 'Typing',
					'clip' => 'Clip',
					'flip' => 'Flip',
					'swirl' => 'Swirl',
					'blinds' => 'Blinds',
					'drop-in' => 'Drop-in',
					'wave' => 'Wave',
					'slide' => 'Slide',
					'slide-down' => 'Slide Down',
				],
				'default' => 'typing',
				'condition' => [
					'headline_style' => 'rotate',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'marker',
			[
				'label' => __( 'Shape', 'opalelementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => _x( 'Circle', 'Shapes', 'opalelementor' ),
					'curly' => _x( 'Curly', 'Shapes', 'opalelementor' ),
					'underline' => _x( 'Underline', 'Shapes', 'opalelementor' ),
					'double' => _x( 'Double', 'Shapes', 'opalelementor' ),
					'double_underline' => _x( 'Double Underline', 'Shapes', 'opalelementor' ),
					'underline_zigzag' => _x( 'Underline Zigzag', 'Shapes', 'opalelementor' ),
					'diagonal' => _x( 'Diagonal', 'Shapes', 'opalelementor' ),
					'strikethrough' => _x( 'Strikethrough', 'Shapes', 'opalelementor' ),
					'x' => 'X',
				],
				'render_type' => 'template',
				'condition' => [
					'headline_style' => 'highlight',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'before_text',
			[
				'label' => __( 'Before Text', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Opal Heading', 'opalelementor' ),
				'placeholder' => __( 'Enter your headline', 'opalelementor' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'highlighted_text',
			[
				'label' => __( 'Highlighted Text', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Aminated', 'opalelementor' ),
				'label_block' => true,
				'condition' => [
					'headline_style' => 'highlight',
				],
				'separator' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'rotating_text',
			[
				'label' => __( 'Rotating Text', 'opalelementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter each word in a separate line', 'opalelementor' ),
				'separator' => 'none',
				'default' => "Better\nBigger\nFaster",
				'rows' => 5,
				'condition' => [
					'headline_style' => 'rotate',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'after_text',
			[
				'label' => __( 'After Text', 'opalelementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your headline', 'opalelementor' ),
				'label_block' => true,
				'separator' => 'none',
				'default' => __( 'is Awesome!', 'opalelementor' ),
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'opalelementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'opalelementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'opalelementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'opalelementor' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .opal-heading-animated' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tag',
			[
				'label' => __( 'HTML Tag', 'opalelementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_marker',
			[
				'label' => __( 'Shape', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'headline_style' => 'highlight',
				],
			]
		);

		$this->add_control(
			'marker_color',
			[
				'label' => __( 'Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .opal-heading-animated-dynamic-wrapper path' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'stroke_width',
			[
				'label' => __( 'Width', 'opalelementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .opal-heading-animated-dynamic-wrapper path' => 'stroke-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'above_content',
			[
				'label' => __( 'Bring to Front', 'opalelementor' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					"{{WRAPPER}} .opal-heading-animated-dynamic-wrapper svg" => 'z-index: 2',
					"{{WRAPPER}} .opal-heading-animated-dynamic-text" => 'z-index: auto',
				],
			]
		);

		$this->add_control(
			'rounded_edges',
			[
				'label' => __( 'Rounded Edges', 'opalelementor' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					"{{WRAPPER}} .opal-heading-animated-dynamic-wrapper path" => 'stroke-linecap: round; stroke-linejoin: round',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => __( 'Headline', 'opalelementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .opal-heading-animated-plain-text' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .opal-heading-animated',
			]
		);

		$this->add_control(
			'heading_words_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Animated Text', 'opalelementor' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'words_color',
			[
				'label' => __( 'Text Color', 'opalelementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .opal-heading-animated-dynamic-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'words_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .opal-heading-animated-dynamic-text',
				'exclude' => ['font_size'],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$tag = $settings['tag'];

		$this->add_render_attribute( 'headline', 'class', 'opal-heading-animated' );

		if ( 'rotate' === $settings['headline_style'] ) {
			$this->add_render_attribute( 'headline', 'class', 'opal-heading-animated-animation-type-' . $settings['animation_type'] );

			$is_letter_animation = in_array( $settings['animation_type'], [ 'typing', 'swirl', 'blinds', 'wave' ] );

			if ( $is_letter_animation ) {
				$this->add_render_attribute( 'headline', 'class', 'opal-heading-animated-letters' );
			}
		}

		?>
		<<?php echo $tag; ?> <?php echo $this->get_render_attribute_string( 'headline' ); ?>>
			<?php if ( ! empty( $settings['before_text'] ) ) : ?>
				<span class="opal-heading-animated-plain-text opal-heading-animated-text-wrapper"><?php echo $settings['before_text']; ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $settings['rotating_text'] ) ) : ?>
				<span class="opal-heading-animated-dynamic-wrapper opal-heading-animated-text-wrapper"></span>
			<?php endif; ?>

			<?php if ( ! empty( $settings['after_text'] ) ) : ?>
				<span class="opal-heading-animated-plain-text opal-heading-animated-text-wrapper"><?php echo $settings['after_text']; ?></span>
			<?php endif; ?>
		</<?php echo $tag; ?>>
		<?php
	}

	protected function _content_template() {
		?>
		<#
		var headlineClasses = 'opal-heading-animated';

		if ( 'rotate' === settings.headline_style ) {
			headlineClasses += ' opal-heading-animated-animation-type-' + settings.animation_type;

			var isLetterAnimation = -1 !== [ 'typing', 'swirl', 'blinds', 'wave' ].indexOf( settings.animation_type );

			if ( isLetterAnimation ) {
				headlineClasses += ' opal-heading-animated-letters';
			}
		}
		#>
		<{{{ settings.tag }}} class="{{{ headlineClasses }}}">
			<# if ( settings.before_text ) { #>
				<span class="opal-heading-animated-plain-text opal-heading-animated-text-wrapper">{{{ settings.before_text }}}</span>
			<# } #>

			<# if ( settings.rotating_text ) { #>
				<span class="opal-heading-animated-dynamic-wrapper opal-heading-animated-text-wrapper"></span>
			<# } #>

			<# if ( settings.after_text ) { #>
				<span class="opal-heading-animated-plain-text opal-heading-animated-text-wrapper">{{{ settings.after_text }}}</span>
			<# } #>
		</{{{ settings.tag }}}>
		<?php
	}
}
