<?php
defined( 'ABSPATH' ) || exit();

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @Class OSF_Footer_builder
 *
 * Auto setup header with selected header option from customizer and having some funtions to render html
 */
class OSF_Footer_builder {

	public static $instance;

	protected $content;

	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof OSF_Footer_builder ) ) {
			self::$instance = new OSF_Footer_builder();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'wp', [ $this, 'setup_footer' ], 3 );
		add_action( 'admin_bar_menu', [ $this, 'custom_button_footer_builder' ], 50 );
	}

	public function get_multilingual() {
		$multilingual = new OSF_Multilingual();

		return $multilingual;
	}

	/**
	 * Show quick edit button all WP Admin Bar
	 *
	 * @return avoid
	 * @var Object wp_admin_bar
	 */
	public function custom_button_footer_builder( $wp_admin_bar ) {
		global $osf_footer;
		if ( $osf_footer && $osf_footer instanceof WP_Post ) {
			$args = [
				'id'    => 'footer-builder-button',
				'title' => __( 'Edit Footer', 'opalelementor' ),
				'href'  => add_query_arg( 'action', 'elementor', remove_query_arg( 'action', get_edit_post_link( $osf_footer->ID ) ) ),
			];
			$wp_admin_bar->add_node( $args );
		}
	}

	/**
	 *  Check setting enable/disable footer and set header as global.
	 *
	 * @return avoid
	 * @var avoid
	 */
	public function setup_footer() {
		global $osf_footer;

		if ( is_single() && in_array( get_post_type(), apply_filters( 'osf_single_footer_post_types', [ 'post' ] ) ) && get_theme_mod( 'post_footer_layout' ) != '' ) {
			$slug       = get_theme_mod( 'post_footer_layout' );
			$osf_footer = get_page_by_path( $slug, OBJECT, 'footer' );
		} else {
			if ( osf_elementor_get_metabox( get_the_ID(), 'osf_enable_custom_footer', false ) ) {
				$footer_slug = osf_elementor_get_metabox( get_the_ID(), 'osf_footer_layout', '' );
				if ( ! $footer_slug ) {
					$footer_slug = get_theme_mod( 'osf_footer_layout', '' );
				}
			} else {
				$footer_slug = get_theme_mod( 'osf_footer_layout', '' );
			}

			if ( $footer_slug ) {
				$osf_footer = get_page_by_path( $footer_slug, OBJECT, 'footer' );
			}
		}

		if ( isset( $osf_footer ) ) {
			if ( OSF_Multilingual::is_polylang() || OSF_Multilingual::is_wpml() ) {
				$multilingual = $this->get_multilingual();
				$osf_header_id = $multilingual->get_current_object( $osf_footer->ID, 'header' );
				$osf_footer = get_post( $osf_header_id );
			}
			$this->content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $osf_footer->ID );
		}
	}

	/**
	 *  Check footer active and return Content HTML
	 *
	 * @return Context
	 * @var avoid
	 */
	public function render() {
		return $this->content;
	}

	/**
	 *  Output footer html with own wrapper
	 *
	 * @return avoid
	 * @var avoid
	 */
	public function render_html() {
		if ( false == apply_filters( 'opalelementor_render_footer', true ) ) {
			return;
		}
		?>
        <footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" role="contentinfo">
			<?php echo $this->render(); ?>
        </footer>
		<?php
	}
}

OSF_Footer_builder::get_instance();
