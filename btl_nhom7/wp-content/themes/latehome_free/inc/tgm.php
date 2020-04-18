<?php

/**
 * Get plugin icon
 */
function latehome_free_get_plugin_icon_image($slug)
{

    switch ($slug) {
        case 'revslider':
            $img = get_template_directory_uri() . '/assets/plugins/logo-rv.png';
            break;
        default:
            $img = 'https://ps.w.org/' . $slug . '/assets/icon-128x128.png';
            break;
    }

    return '<img src="' . $img . '"/>';
}

/**
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */
function latehome_free_register_required_plugins()
{

    $plugins = apply_filters('tgmpa_plugins', array(

        array(
            'name' => 'WpOpal Framework Features',
            'slug' => 'wpopal-core-features',
            'required' => true
        ),

        array(
            'name' => 'Opal Widgets For Elementor',
            'slug' => 'opal-widgets-for-elementor',
            'required' => true,
        ),

        array(
            'name' => 'Elementor',
            'slug' => 'elementor',
            'required' => true,
        ),

         array(
            'name' => 'Opal Estate Pro',
            'slug' => 'opal-estate-pro',
            'required' => true,

        ),

        array(
            'name' => 'Opal Membership',
            'slug' => 'opal-membership',
            'required' => true
        ),
        array(
            'name' => 'Slider Revolution',
            'slug' => 'revslider',
            'required' => true,
            'source' => esc_url('http://source.wpopal.com/plugins/revslider611.zip'),

        ),
        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => false

        ),
        array(
            'name' => 'MailChimp',
            'slug' => 'mailchimp-for-wp',
            'required' => false
        ),
        // array(
        //     'name' => 'CMB2',
        //     'slug' => 'cmb2',
        //     'required' => true,
        // ),
        array(
            'name' => 'Breadcrumb Navxt',
            'slug' => 'breadcrumb-navxt',
            'required' => true,
        ),
    ));

    /*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
    $config = array(
        'id' => 'latehome_free-required',  // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true,                    // Show admin notices or not.
        'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message' => '',                      // Message to output right before the plugins table.
    );

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'latehome_free_register_required_plugins');
