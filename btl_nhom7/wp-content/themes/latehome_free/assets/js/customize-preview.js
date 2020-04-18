/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {

    gradient_color_left = '#0494f4';
    gradient_color_right = '#2de3bb';

    // Primary color.
    wp.customize('primary_color', function (value) {
        value.bind(function (to) {
            // Update custom color CSS.
            var style = $('#custom-theme-colors'),
                hue = style.data('hue'),
                css = style.html(),
                color;

            if ('custom' === to) {
                // If a custom primary color is selected, use the currently set primary_color_hue
                color = wp.customize.get().primary_color_hue;
            } else {
                // If the "default" option is selected, get the default primary_color_hue
                color = 199;
            }

            // Equivalent to css.replaceAll, with hue followed by comma to prevent values with units from being changed.
            css = css.split(hue + ',').join(color + ',');
            style.html(css).data('hue', color);
        });
    });

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find, 'g'), replace);
    }

    // Primary color hue.
    wp.customize('primary_color_hue', function (value) {

        value.bind(function (to) {

            // Update custom color CSS.
            var style = $('#custom-theme-colors'),
                hue = style.data('hue'),
                css = style.html();

            // Equivalent to css.replaceAll, with hue followed by comma to prevent values with units from being changed.
            css = replaceAll(css, hue, to);
            style.html(css).data('hue', to);
        });
    });


    // Primary color hue.
    wp.customize('secondary_color_hue', function (value) {

        value.bind(function (to) {

            // Update custom color CSS.
            var style = $('#custom-theme-colors'),
                hue = style.data('secondary'),
                css = style.html();

            // Equivalent to css.replaceAll, with hue followed by comma to prevent values with units from being changed.
            css = replaceAll(css, hue, to);
            style.html(css).data('secondary', to);
        });
    });

    // gradient_color.

    wp.customize('gradient_color_left', function (value) {
        value.bind(function (to) {
            gradient_color_left = to;
            $('.btn-primary, input[type="button"], input[type="submit"], button[type="submit"], a.button, .elementor-button-default a.elementor-button, .elementor-widget-opal-price-table .elementor-price-table__button, .btn-primary:hover, input:hover[type="button"], input:hover[type="submit"], button:hover[type="submit"], a.button:hover, .elementor-button-default a.elementor-button:hover, .elementor-widget-opal-price-table .elementor-price-table__button:hover, .service-grid_v3 .service-title').css({
                'background-image': 'linear-gradient( to right, '
                    .concat(gradient_color_left).concat(' 0%, ')
                    .concat(gradient_color_right).concat(' 51%, ')
                    .concat(gradient_color_left).concat(' 100% )')
            });
        });
    });
    wp.customize('gradient_color_right', function (value) {
        value.bind(function (to) {
            gradient_color_right = to;
            $('.btn-primary, input[type="button"], input[type="submit"], button[type="submit"], a.button, .elementor-button-default a.elementor-button, .elementor-widget-opal-price-table .elementor-price-table__button, .btn-primary:hover, input:hover[type="button"], input:hover[type="submit"], button:hover[type="submit"], a.button:hover, .elementor-button-default a.elementor-button:hover, .elementor-widget-opal-price-table .elementor-price-table__button:hover, .service-grid_v3 .service-title').css({
                'background-image': 'linear-gradient( to right, '
                    .concat(gradient_color_left).concat(' 0%, ')
                    .concat(gradient_color_right).concat(' 51%, ')
                    .concat(gradient_color_left).concat(' 100% )')
            });
        });
    });

    // Image filter.
    wp.customize('image_filter', function (value) {
        value.bind(function (to) {
            if (to) {
                $('body').addClass('image-filters-enabled');
            } else {
                $('body').removeClass('image-filters-enabled');
            }
        });
    });

})(jQuery);
