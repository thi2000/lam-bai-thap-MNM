<?php

/**
 * Generate the CSS for the current primary color.
 */
function latehome_free_custom_colors_css()
{

    $primary_color = "";

    if ('default' !== get_theme_mod('primary_color', 'default')) {
        $primary_color = get_theme_mod('primary_color_hue', "");
    }

    $secondary_color = get_theme_mod('secondary_color_hue', "");

    $gradient_color_left = get_theme_mod('gradient_color_left', "");
    $gradient_color_right = get_theme_mod('gradient_color_right', "");


    $theme_css = '
		/*
		 * Set background for:
		 * - featured image :before
		 * - featured image :before
		 * - post thumbmail :before
		 * - post thumbmail :before
		 * - Submenu
		 * - Sticky Post
		 * - buttons
		 * - WP Block Button
		 * - Blocks
		 */
		.meta-post-categories .inner,
		.btn-primary, button[type="submit"], a.button, .wpcf7 .wpcf7-form input[type="submit"],
		.elementor-widget-opal-contactform7 .wpcf7 .wpcf7-form input[type="submit"], 
		.elementor-widget-opal-contactform7 button,button.disabled[type=submit],
		.widget_price_filter .ui-slider .ui-slider-range,
		.widget_price_filter .ui-slider .ui-slider-handle,
		.service-archive-services .service-box-icon,
		button:disabled[type=submit],
		.elementor-opal-slick-slider.elementor-slick-slider .slick-prev,
		.elementor-opal-slick-slider.elementor-slick-slider .slick-next,
		.elementor-widget-opal-button-contact7 a.elementor-button,
		#back-to-top,
		.service-grid_v3 .service-readmore::before
		{
			background-color: ' . $primary_color . '; /* base: #0073a8; */
		}
		table.compare-list .add-to-cart td a{
			background-color: ' . $primary_color . ' !important;
		}
		.btn-primary, button[type="submit"], a.button, .wpcf7 .wpcf7-form input[type="submit"],button.disabled[type=submit],
		button:disabled[type=submit],.page-item.active .page-link,select:focus{
			border-color:' . $primary_color . ';
		}
		/*
		 * Set Color for:
		 * - all links
		 * - main navigation links
		 * - Post navigation links
		 * - Post entry meta hover
		 * - Post entry header more-link hover
		 * - main navigation svg
		 * - comment navigation
		 * - Comment edit link hover
		 * - Site Footer Link hover
		 * - Widget links
		 */
		swiper-container [class*="swiper-button-"]:hover::before, .swiper-container-horizontal [class*="swiper-button-"]:hover::before,
	    .post-navigation .nav-links .nav-links-inner a:hover:before,
		.opalelementor-nav-menu > li > .opalelementor-item:focus,
		.elementor-widget-counter .elementor-counter-title,
		.elementor-widget-opal-team-box .elementor-team-name, .elementor-widget-opal-team-box .elementor-team-name a,
		.work-details h4, .work-details h4 a,
		.portfolio-details-list li label
		{
			color: ' . $primary_color . '; /* base: #0073a8; */
		}
		/*
		 * Set left border color for:
		 * wp block quote
		 */
		blockquote,
		.entry .entry-content blockquote,
		.entry .entry-content .wp-block-quote:not(.is-large),
		.entry .entry-content .wp-block-quote:not(.is-style-large) {
			border-left-color: ' . $primary_color . '; /* base: #0073a8; */
		}

		';
    if ('gradient' == get_theme_mod('button_style', 'gradient') && $gradient_color_left) {

        $theme_css .= '
				.btn-primary, input[type="button"], input[type="submit"], button[type="submit"], a.button, .elementor-button-default a.elementor-button, .elementor-widget-opal-price-table .elementor-price-table__button, .service-grid_v3 .service-title, .btn-primary:hover, input:hover[type="button"], input:hover[type="submit"], button:hover[type="submit"], a.button:hover, .elementor-button-default a.elementor-button:hover, .elementor-widget-opal-price-table .elementor-price-table__button:hover {
					background-image: linear-gradient(to right, ' . $gradient_color_left . ' 0% , ' . $gradient_color_right . ' 51%, ' . $gradient_color_left . ' 100%);
				}
			';
    } elseif ('default' == get_theme_mod('button_style') && $gradient_color_left) {
        $theme_css .= '
				.btn-primary, input[type="button"], input[type="submit"], button[type="submit"], a.button, .elementor-button-default a.elementor-button, .elementor-widget-opal-price-table .elementor-price-table__button, .service-grid_v3 .service-title {
					background: ' . $gradient_color_left . ';
				}
				.btn-primary:hover, input:hover[type="button"], input:hover[type="submit"], button:hover[type="submit"], a.button:hover, .elementor-button-default a.elementor-button:hover, .elementor-widget-opal-price-table .elementor-price-table__button:hover {
					background: ' . $gradient_color_right . ';
				}
			';
    }

    /**
     * Filters Twenty Nineteen custom colors CSS.
     *
     * @since Twenty Nineteen 1.0
     *
     * @param string $css Base theme colors CSS.
     * @param int $primary_color The user's selected color hue.
     * @param string $saturation Filtered theme color saturation level.
     */
    return apply_filters('latehome_free_custom_colors_css', $theme_css, $primary_color);
}