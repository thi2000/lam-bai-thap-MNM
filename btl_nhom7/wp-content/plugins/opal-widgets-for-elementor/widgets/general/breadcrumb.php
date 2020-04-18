<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class OSF_Elementor_Breadcrumb_Widget extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-breadcrumb';
	}

	public function get_title() {
		return __( 'Opal Breadcrumb', 'opalelementor' );
	}

	public function get_icon() {
		return 'eicon-navigation-horizontal';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'breadcrumb_settings',
			[
				'label' => __( 'Settings', 'opalelementor' ),
			]
		);


		$this->add_control(
			'background_image',
			[
				'label'         => esc_html__( 'Background', 'opalelementor' ),
				'description'   => esc_html__( 'Select an image for the background image', 'opalelementor' ),
				'type'          => Controls_Manager::MEDIA,
				'show_external' => true,
			]
		);

		$this->add_control(
			'toggle_align',
			[
				'label'     => __( 'Alignment', 'opalelementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'opalelementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'opalelementor' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'opalelementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs' => 'text-align: {{VALUE}}',
				],
				'default'   => 'center',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_style_content',
			[
				'label' => __( 'Label', 'opalelementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'opalelementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs_title .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .breadcrumbs_title .title',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings         = $this->get_settings();
		$background_image = '';
		if ( isset( $settings['background_image'] ) && isset( $settings['background_image']['url'] ) && $settings['background_image']['url'] ) {
			$background_image = 'style="background-image: url(' . $settings['background_image']['url'] . ');"';
		}

		if ( function_exists( 'bcn_display' ) ) { ?>
            <div class="elementor-breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                <div class="breadcrumbs" <?php print $background_image; ?>>
                    <div class="container">
                        <div class="breadcrumbs_title">
							<?php $this->render_breadcrumb_title(); ?>
                        </div>
						<?php bcn_display(); ?>
                    </div>
                </div>
            </div>
			<?php
		} else { ?>
            <div class="elementor-breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                <div class="breadcrumbs" <?php print $background_image; ?>>
                    <div class="container">
                        <div class="breadcrumbs_title">
							<?php $this->render_breadcrumb_title(); ?>
                        </div>
						<?php get_template_part( 'partials/common/breadcrumb' ); ?>
                    </div>
                </div>
            </div>

		<?php }

	}

	protected function render_breadcrumb_title() {
		global $post;
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop() ) {
				$shop_page_id = wc_get_page_id( 'shop' );
				$wbt_title    = get_the_title( $shop_page_id );
			}
		}
		//$wbt_title  = __( 'Blog', 'wpopalbootstrap' );
		if ( ! is_front_page() ) {
			if ( is_home() ) {
				$wbt_title = __( 'Blog', 'opalelementor' );
			} else {
				if ( is_single() ) {
					$wbt_title = get_the_title();
				} else {
					if ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {
						$tax_object = get_queried_object();
						if ( ! empty( $tax_object ) ) {
							$wbt_title = esc_html( $tax_object->name );
						}
					} else {
						if ( is_category() ) {
							$wbt_title = single_cat_title( '', false );
						} else {
							if ( is_page() ) {
								$wbt_title = get_the_title();
							}
							if ( is_tag() ) {

								// Get tag information
								$wbt_term_id  = get_query_var( 'tag_id' );
								$wbt_taxonomy = 'post_tag';
								$wbt_args     = 'include=' . $wbt_term_id;
								$wbt_terms    = get_terms( $wbt_taxonomy, $otf_args );

								// Display the tag name
								if ( isset( $wbt_terms[0]->name ) ) {
									$wbt_title = $wbt_terms[0]->name;
								}
							}
							if ( is_day() ) {
								$wbt_title = __( 'Day', 'opalelementor' );
							} else {
								if ( is_month() ) {
									$wbt_title = __( 'Month', 'opalelementor' );
								} else {
									if ( is_year() ) {
										$wbt_title = __( 'Year', 'opalelementor' );
									} else {
										if ( is_author() ) {
											global $author;
											if ( ! empty( $author->ID ) ) {
												$wbt_title = __( 'Author', 'opalelementor' );
											}
										} else {
											if ( is_search() ) {
												$wbt_title = __( 'Search', 'opalelementor' );
											} elseif ( is_404() ) {
												$wbt_title = __( 'Error 404', 'opalelementor' );
											}
										}
									}
								}
							}

						}
					}
				}
			} ?>

            <h1 class="title"><?php if ( ! empty( $wbt_title ) && $wbt_title ) {
					echo esc_html( $wbt_title );
				} ?></h1>
			<?php
		}

	}
}
