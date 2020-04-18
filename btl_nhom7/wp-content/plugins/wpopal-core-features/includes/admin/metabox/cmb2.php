<?php
defined( 'ABSPATH' ) || exit();

/**
 * @Class Wpopal_Core_Admin_Menu
 *
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class Wpopal_Core_Cmb2 {

    protected $tab;

    public function __construct() {
        //  add_action( 'cmb2_admin_init', array( $this, 'load_fields' ) );
        add_action( 'cmb2_admin_init', [ $this, 'page_meta_box' ] );
    }

    /**
     *
     */
    public function load_fields() {

        global $pagenow;

        if ( ( $pagenow == 'post.php' ) || ( get_post_type() == 'page' ) || ( $pagenow == 'post-new.php' ) || ( get_post_type() == 'header' ) ) {
            require_once WPOPAL_PLUGIN_INC_DIR . '/admin/metabox/switch/switch.php';
            require_once WPOPAL_PLUGIN_INC_DIR . '/admin/metabox/slider/slider.php';
            require_once WPOPAL_PLUGIN_INC_DIR . '/admin/metabox/cmb2-tabs/CMB2-Tabs.php';

        }
    }

    /**
     *
     */
    public function page_meta_box() {

        $this->load_fields();

        $prefix = WPOPAL_PREFIX;

        /**
         * Sample metabox to demonstrate each field type included
         */
        $this->tab = new_cmb2_box( [
            'id'           => $prefix . 'metabox',
            'title'        => esc_html__( 'Page Metabox', 'wpopal' ),
            'object_types' => apply_filters( 'wpopal_page_meta_box_object_types_supported', [ 'page' ] ), // Post type
            'tabs'         => [
                'page_header' => [
                    'label' => __( 'Header', 'wpopal' ),
                ],
                'page_footer' => [
                    'label' => __( 'Footer', 'wpopal' ),
                    'icon'  => 'dashicons-share', // Dashicon
                ],
                'breadcrumb'  => [
                    'label' => __( 'Breadcrumb', 'wpopal' ),
                    'icon'  => 'dashicons-sos', // Custom icon, using image
                ],
            ],
            // 'show_on_cb' => 'cmb2_tabs_show_if_front_page', // function should return a bool value
            // 'context'    => 'normal',
            // 'priority'   => 'high',
            // 'show_names' => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // true to keep the metabox closed by default
            // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
        ] );

        //   $this->page_layout( $prefix );
        $this->page_header( $prefix );
        $this->page_breadcrumb( $prefix );
        $this->page_footer( $prefix );
        $this->header_builder( $prefix );

        $this->header_settings( $prefix );

        $this->post( $prefix );
    }


    protected function post( $prefix ) {
        $prefix = '_post';
        /**
         *  Video
         */
        $cmb = new_cmb2_box( [
            'id'           => 'wpopal-post-format-video',
            'title'        => esc_html__( 'Video Metabox', 'wpopal' ),
            'object_types' => apply_filters( 'wpopal_post_object_types_supported', [ 'post' ] ),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'post-format-video', // The option key and admin menu page slug.
        ] );

        $cmb->add_field( [
            'name'    => esc_html__( 'Video', 'wpopal' ),
            'id'      => $prefix . 'video',
            'desc'    => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'wpopal' ),
            'type'    => 'oembed',
            'default' => '',
        ] );

        /// Images // 

        $cmb = new_cmb2_box( [
            'id'           => 'wpopal-post-format-gallery',
            'title'        => esc_html__( 'Gallery Metabox', 'wpopal' ),
            'object_types' => apply_filters( 'wpopal_post_object_types_supported', [ 'post' ] ),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'post-format-image', // The option key and admin menu page slug.
        ] );

        $cmb->add_field( [
            'name'       => esc_html__( 'Gallery', 'wpopal' ),
            'id'         => $prefix . 'gallery',
            'desc'       => __( 'Attach images to show in gallery.', 'wpopal' ),
            'type'       => 'file_list',
            'query_args' => [ 'type' => 'image' ],
            'default'    => '',
        ] );

        /// Audio /// 
        $cmb = new_cmb2_box( [
            'id'           => 'wpopal-post-format-audio',
            'title'        => esc_html__( 'Audio Metabox', 'wpopal' ),
            'object_types' => apply_filters( 'wpopal_post_object_types_supported', [ 'post' ] ),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'post-format-audio', // The option key and admin menu page slug.
        ] );

        $cmb->add_field( [
            'name'    => esc_html__( 'Audio Link', 'wpopal' ),
            'id'      => $prefix . 'audio_link',
            'desc'    => __( 'Enter your audio link from soudcloud.', 'wpopal' ),
            'type'    => 'text',
            'default' => '',
        ] );


        /// Quotes ///
        $cmb = new_cmb2_box( [
            'id'           => 'wpopal-post-format-quote',
            'title'        => esc_html__( 'Quote Metabox', 'wpopal' ),
            'object_types' => apply_filters( 'wpopal_post_object_types_supported', [ 'post' ] ),
            /*
             * The following parameters are specific to the options-page box
             * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
             */
            'option_key'   => 'post-format-quote', // The option key and admin menu page slug.
        ] );

        $cmb->add_field( [
            'name'    => esc_html__( 'Author', 'wpopal' ),
            'id'      => $prefix . 'author',
            'desc'    => __( 'Enter your audio link from soudcloud.', 'wpopal' ),
            'type'    => 'text',
            'default' => '',
        ] );


        $cmb->add_field( [
            'name'    => esc_html__( 'Quote', 'wpopal' ),
            'id'      => $prefix . 'quote',
            'desc'    => __( 'Enter your audio link from soudcloud.', 'wpopal' ),
            'type'    => 'textarea',
            'default' => '',
        ] );
    }

    private function header_settings( $prefix = WPOPAL_PREFIX ) {


    }

    /**
     *
     */
    private function header_builder( $prefix = WPOPAL_PREFIX ) {


        $this->tab->add_field( [
            'name'          => __( 'Enable Custom Header', 'wpopal' ),
            'id'            => $prefix . 'enable_custom_header',
            'type'          => 'opal_switch',
            'default'       => '0',
            'show_fields'   => [
                $prefix . 'header_layout',
                //                $prefix . 'search_position',
                //                $prefix . 'cart_position',
                //                $prefix . 'cart_position',
                //                $prefix . 'enable_fullwidth',
                //                $prefix . 'header_layout',
                //                $prefix . 'header_padding_top',
                //                $prefix . 'header_padding_bottom',
            ],
            'tab'           => 'page_header',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );
        $headers = wp_parse_args( $this->get_post_type_data( 'header' ), [
            'default' => esc_html__( 'Default', 'wpopal' ),
        ] );
        $this->tab->add_field( [
            'name'             => __( 'Layout', 'wpopal' ),
            'id'               => $prefix . 'header_layout',
            'type'             => 'select',
            'show_option_none' => false,
            'default'          => 'default',
            'options'          => $headers,
            'tab'              => 'page_header',
            'render_row_cb'    => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );

    }

    /**
     *
     */
    private function page_footer( $prefix = WPOPAL_PREFIX ) {

        $this->tab->add_field( [
            'name'          => __( 'Enable Custom Footer', 'wpopal' ),
            'id'            => $prefix . 'enable_custom_footer',
            'type'          => 'opal_switch',
            'default'       => '0',
            'show_fields'   => [
                $prefix . 'footer_padding_top',
                $prefix . 'footer_layout',
            ],
            'tab'           => 'page_footer',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );

        $footers = wp_parse_args( $this->get_post_type_data( 'footer' ), [
            'default' => esc_html__( 'Default', 'wpopal' ),
        ] );

        $this->tab->add_field( [
            'name'          => __( 'Layout', 'wpopal' ),
            'id'            => $prefix . 'footer_layout',
            'type'          => 'select',
            'default'       => '',
            'options'       => $footers,
            'tab'           => 'page_footer',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );

        $this->tab->add_field( [
            'name'          => __( 'Enable Fixed Footer', 'wpopal' ),
            'id'            => $prefix . 'enable_fixed_footer',
            'type'          => 'opal_switch',
            'tab'           => 'page_footer',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
            'default'       => '0',

        ] );
    }

    private function page_header( $prefix = WPOPAL_PREFIX ) {


    }

    private function get_post_type_data( $post_type = 'post' ) {
        $args = [
            'post_type'      => $post_type,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];
        $data = [];
        if ( $posts = get_posts( $args ) ) {
            foreach ( $posts as $post ) {
                /**
                 * @var $post WP_Post
                 */
                $data[ $post->post_name ] = $post->post_title;
            }
        }

        return $data;
    }

    private function page_breadcrumb( $prefix = WPOPAL_PREFIX ) {

        $this->tab->add_field( [
            'name'          => __( 'Enable Breadcrumb', 'wpopal' ),
            'id'            => $prefix . 'hide_breadcrumb',
            'type'          => 'opal_switch',
            'default'       => '1',
            'show_fields'   => [
                $prefix . 'breadcrumb_text_color',
                $prefix . 'breadcrumb_bg_color',
                $prefix . 'breadcrumb_bg_image',
                $prefix . 'heading_color',
                $prefix . 'breadcrumb_pt',
                $prefix . 'breadcrumb_pb',
            ],
            'tab'           => 'breadcrumb',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );

        $this->tab->add_field( [
            'name'          => __( 'Heading Color', 'wpopal' ),
            'id'            => $prefix . 'heading_color',
            'type'          => 'colorpicker',
            'default'       => '',
            'tab'           => 'breadcrumb',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );

        $this->tab->add_field( [
            'name'          => __( 'Breadcrumb Text Color', 'wpopal' ),
            'id'            => $prefix . 'breadcrumb_text_color',
            'type'          => 'colorpicker',
            'default'       => '',
            'tab'           => 'breadcrumb',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );

        $this->tab->add_field( [
            'name'          => __( 'Breadcrumb Background Color', 'wpopal' ),
            'id'            => $prefix . 'breadcrumb_bg_color',
            'type'          => 'colorpicker',
            'default'       => '',
            'tab'           => 'breadcrumb',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );

        $this->tab->add_field( [
            'name'          => __( 'Breadcrumb Background', 'wpopal' ),
            'desc'          => 'Upload an image or enter an URL.',
            'id'            => $prefix . 'breadcrumb_bg_image',
            'type'          => 'file',
            'options'       => [
                'url' => false, // Hide the text input for the url
            ],
            'text'          => [
                'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
            ],
            'preview_size'  => 'large', // Image size to use when previewing in the admin.
            'tab'           => 'breadcrumb',
            'render_row_cb' => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
        ] );
        $this->tab->add_field( [
            'name'            => __( 'Breadcrumb Padding Top', 'wpopal' ),
            'id'              => $prefix . 'breadcrumb_pt',
            'type'            => 'text',
            'default'         => '',
            'tab'             => 'breadcrumb',
            'render_row_cb'   => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
            'attributes'      => [
                'type'    => 'number',
                'pattern' => '\d*',
            ],
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ] );
        $this->tab->add_field( [
            'name'            => __( 'Breadcrumb Padding Bottom', 'wpopal' ),
            'id'              => $prefix . 'breadcrumb_pb',
            'type'            => 'text',
            'default'         => '',
            'tab'             => 'breadcrumb',
            'render_row_cb'   => [ 'CMB2_Tabs', 'tabs_render_row_cb' ],
            'attributes'      => [
                'type'    => 'number',
                'pattern' => '\d*',
            ],
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ] );
    }

    private function page_layout( $prefix = WPOPAL_PREFIX ) {
        $cmb2 = new_cmb2_box( [
            'id'           => 'osf_page_layout',
            'title'        => __( 'Layout', 'wpopal' ),
            'object_types' => apply_filters( 'wpopal_page_layout_object_types_supported', [ 'page' ] ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ] );

        $this->tab->add_field( [
            'name'    => __( 'Layout', 'wpopal' ),
            'id'      => $prefix . 'layout',
            'type'    => 'opal_switch_layout',
            'default' => '1c',
        ] );

        $this->tab->add_field( [
            'name'    => __( 'Sidebar Width', 'wpopal' ),
            'id'      => $prefix . 'sidebar_width',
            'type'    => 'opal_slider',
            'default' => '320',
            'attrs'   => [
                'min'  => '0',
                'max'  => '400',
                'step' => '1',
                'unit' => 'px',
            ],
        ] );

        $this->tab->add_field( [
            'name'             => __( 'Sidebar', 'wpopal' ),
            'desc'             => 'Select sidebar',
            'id'               => $prefix . 'sidebar',
            'type'             => 'select',
            'show_option_none' => true,
            'options'          => $this->get_sidebars(),
        ] );

        $this->tab->add_field( [
            'name'    => __( 'Enable Page Title', 'wpopal' ),
            'id'      => $prefix . 'enable_page_heading',
            'type'    => 'opal_switch',
            'default' => '1',
        ] );

        $this->tab->add_field( [
            'name'    => __( 'Padding Top', 'wpopal' ),
            'id'      => $prefix . 'padding_top',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => [
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ],
        ] );

        $this->tab->add_field( [
            'name'    => __( 'Padding Bottom', 'wpopal' ),
            'id'      => $prefix . 'padding_bottom',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => [
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ],
        ] );
    }

    /**
     * @return array
     */
    private function get_sidebars() {
        global $wp_registered_sidebars;
        $output = [];

        if ( ! empty( $wp_registered_sidebars ) ) {
            foreach ( $wp_registered_sidebars as $sidebar ) {
                $output[ $sidebar['id'] ] = $sidebar['name'];
            }
        }

        return $output;
    }
}

new Wpopal_Core_Cmb2();
?>
