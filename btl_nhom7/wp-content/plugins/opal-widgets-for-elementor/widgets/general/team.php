<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class OSF_Elementor_Team_Widget extends OSF_Elementor_Slick_Widget {

	/**
	 * Get widget name.
	 *
	 * Retrieve testimonial widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'opal-teams';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve testimonial widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Opal Teams', 'opalelementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve testimonial widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
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
				'label' => __( 'Teams', 'opalelementor' ),
			]
		);


		$this->add_control(
			'options',
			[
				'label' => __( 'Additional Options', 'opalelementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'team_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
			]
		);


		$this->add_responsive_control(
			'column',
			[
				'label'   => __( 'Columns', 'opalelementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 1,
				'options' => [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6 ],
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => __( 'Style', 'opalelementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => esc_html__( 'Style 1', 'opalelementor' ),
					'style-2' => esc_html__( 'Style 2', 'opalelementor' ),
					'style-3' => esc_html__( 'Style 3', 'opalelementor' ),
				],
			]
		);


		$this->add_control(
			'teams',
			[
				'label'       => __( 'Team Item', 'opalelementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => [
					[
						'name'    => 'name',
						'label'   => __( 'Name', 'opalelementor' ),
						'default' => 'John Doe',
						'type'    => Controls_Manager::TEXT,
					],
					[
						'name'       => 'image',
						'label'      => __( 'Choose Image', 'opalelementor' ),
						'default'    => [
							'url' => Elementor\Utils::get_placeholder_image_src(),
						],
						'type'       => Controls_Manager::MEDIA,
						'show_label' => false,
					],
					[
						'name'    => 'job',
						'label'   => __( 'Job', 'opalelementor' ),
						'default' => 'Designer',
						'type'    => Controls_Manager::TEXT,
					],
					[
						'name'        => 'link',
						'label'       => __( 'Link to', 'opalelementor' ),
						'placeholder' => __( 'https://your-link.com', 'opalelementor' ),
						'type'        => Controls_Manager::URL,
					],
					[
						'name'    => 'facebook',
						'label'   => __( 'Facebook', 'opalelementor' ),
						'default' => 'www.facebook.com/opalwordpress',
						'type'    => Controls_Manager::TEXT,
					],
					[
						'name'    => 'twitter',
						'label'   => __( 'Twitter', 'opalelementor' ),
						'default' => 'https://twitter.com/opalwordpress',
						'type'    => Controls_Manager::TEXT,
					],
					[
						'name'    => 'youtube',
						'label'   => __( 'Youtube', 'opalelementor' ),
						'default' => 'https://www.youtube.com/user/WPOpalTheme',
						'type'    => Controls_Manager::TEXT,
					],
					[
						'name'    => 'google',
						'label'   => __( 'Google', 'opalelementor' ),
						'default' => 'https://plus.google.com/u/0/+WPOpal',
						'type'    => Controls_Manager::TEXT,
					],
					[
						'name'    => 'pinterest',
						'label'   => __( 'Pinterest', 'opalelementor' ),
						'default' => 'https://www.pinterest.com/',
						'type'    => Controls_Manager::TEXT,
					],
					[
						'name'  => 'description',
						'label' => __( 'Description', 'opalelementor' ),
						'type'  => Controls_Manager::TEXTAREA,
					],

				],
				'title_field' => '{{{name}}}',
			]
		);
		$this->add_control(
			'enable_carousel',
			[
				'label' => __( 'Enable', 'opalelementor' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();


		$this->add_slick_controls( [ 'enable_carousel' => 'yes' ], ' .product-slick-carousel ' );

		// Name.
		$this->start_controls_section(
			'section_style_team_name',
			[
				'label' => __( 'Name', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_text_color',
			[
				'label'     => __( 'Text Color', 'opalelementor' ),
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
				'label' => __( 'Job', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'job_text_color',
			[
				'label'     => __( 'Text Color', 'opalelementor' ),
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

		// Information.
		$this->start_controls_section(
			'section_style_team_information',
			[
				'label' => __( 'Information', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'information_text_color',
			[
				'label'     => __( 'Text Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-team-infomation' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'information_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-team-infomation',
			]
		);

		$this->end_controls_section();

		// Information.
		$this->start_controls_section(
			'section_style_team_social',
			[
				'label' => __( 'Social', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'social_color',
			[
				'label'     => __( 'Social Color', 'opalelementor' ),
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

		$this->end_controls_section();

		// Information.
		$this->start_controls_section(
			'section_style_team_description',
			[
				'label' => __( 'Description', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => __( 'Description Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-team-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_hover_color',
			[
				'label'     => __( 'Description Hover Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-team-description:hover' => 'color: {{VALUE}};',
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
		if ( ! empty( $settings['teams'] ) && is_array( $settings['teams'] ) ) {

			$this->add_render_attribute( 'wrapper', 'class', 'elementor-teams-wrapper' );
			$this->add_render_attribute( 'wrapper', 'class', $settings['style'] );

			// Row
			$this->add_render_attribute( 'row', 'class', 'row' );
			$this->add_render_attribute( 'row', 'class', 'row-items' );


			$this->add_render_attribute( 'row', 'data-elementor-columns', $settings['column'] );
			if ( ! empty( $settings['column_tablet'] ) ) {
				$this->add_render_attribute( 'row', 'data-elementor-columns-tablet', $settings['column_tablet'] );
			}
			if ( ! empty( $settings['column_mobile'] ) ) {
				$this->add_render_attribute( 'row', 'data-elementor-columns-mobile', $settings['column_mobile'] );
			}

			// Item
			$this->add_render_attribute( 'item', 'class', 'elementor-team-item' );

			$this->add_render_attribute( 'meta', 'class', 'elementor-team-meta' );

			if ( $settings['enable_carousel'] === 'yes' ) {
				$data = $this->get_settings_json();
				$this->add_render_attribute( 'wrapper', 'data-settings', $data );
				$this->add_render_attribute( 'wrapper', 'class', "elementor-opal-slick-slider elementor-slick-slider" );
			}

			?>
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'row' ) ?>>
					<?php
					foreach ( $settings['teams'] as $team ): ?>
                        <div <?php echo $this->get_render_attribute_string( 'item' ); ?>>
							<?php call_user_func( [ $this, 'render_' . str_replace( '-', '_', $settings['style'] ) ], $team, $settings ) ?>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
			<?php
		}
	}

	protected function render_style_1( $team, $settings ) { ?>
        <div class="elementor-team-meta-inner">
			<?php $this->render_image( $settings, $team ); ?>
            <div class="elementor-team-details">
				<?php
				$team_name_html = $team['name'];
				if ( ! empty( $team['link']['url'] ) ) :
					$team_name_html = '<a href="' . esc_url( $team['link']['url'] ) . '">' . $team_name_html . '</a>';
				endif;
				$description = $team['description'] ? $team['description'] : '';
				?>
                <div class="elementor-team-name"><?php echo $team_name_html; ?></div>
                <div class="elementor-team-job"><?php echo $team['job']; ?></div>
                <div class="elementor-team-description">
					<?php echo sprintf( '%1$s', $description ); ?>
                </div>
            </div>
        </div>
		<?php
	}

	protected function render_style_2( $team, $settings ) { ?>
        <div class="elementor-team-meta-inner">
			<?php $this->render_image( $settings, $team ); ?>
            <div class="elementor-team-details">
				<?php
				$team_name_html = $team['name'];
				if ( ! empty( $team['link']['url'] ) ) :
					$team_name_html = '<a href="' . esc_url( $team['link']['url'] ) . '">' . $team_name_html . '</a>';
				endif;
				$description = $team['description'] ? $team['description'] : '';
				?>
                <div class="elementor-team-name"><?php echo $team_name_html; ?></div>
                <div class="elementor-team-job"><?php echo $team['job']; ?></div>
                <div class="elementor-team-description">
					<?php echo sprintf( '%1$s', $description ); ?>
                </div>
            </div>
        </div>
		<?php
	}

	protected function render_style_3( $team, $settings ) { ?>
        <div class="elementor-team-meta-inner">
			<?php $this->render_image( $settings, $team ); ?>
            <div class="elementor-team-details">
				<?php
				$team_name_html = $team['name'];
				if ( ! empty( $team['link']['url'] ) ) :
					$team_name_html = '<a href="' . esc_url( $team['link']['url'] ) . '">' . $team_name_html . '</a>';
				endif;

				$description = $team['description'] ? $team['description'] : '';

				?>
                <div class="elementor-team-name"><?php echo $team_name_html; ?></div>
                <div class="elementor-team-job"><?php echo $team['job']; ?></div>
                <div class="elementor-team-socials">
                    <ul class="socials">
						<?php foreach ( $this->get_socials() as $key => $social ): ?>
							<?php if ( ! empty( $team[ $key ] ) ) : ?>
                                <li class="social">
                                    <a href="<?php echo esc_url( $team[ $key ] ) ?>">
                                        <i class="fa <?php echo esc_attr( $social ); ?>"></i>
                                    </a>
                                </li>
							<?php endif; ?>
						<?php endforeach; ?>
                    </ul>
                </div>
                <div class="elementor-team-description">
					<?php echo sprintf( '%1$s', $description ); ?>
                </div>
            </div>
        </div>
		<?php
	}

	private function get_socials() {
		return [
			'facebook'  => 'fa-facebook',
			'twitter'   => 'fa-twitter',
			'youtube'   => 'fa-youtube',
			'google'    => 'fa-google-plus',
			'pinterest' => 'fa-pinterest',
		];
	}

	private function render_image( $settings, $team ) { ?>
        <div class="elementor-team-image">
			<?php
			$team['image_size']             = $settings['team_image_size'];
			$team['image_custom_dimension'] = $settings['team_image_custom_dimension'];
			if ( ! empty( $team['image']['url'] ) ) :
				$image_html = Group_Control_Image_Size::get_attachment_image_html( $team, 'image' );
				echo $image_html;
			endif;
			?>
        </div>
		<?php
	}
}
