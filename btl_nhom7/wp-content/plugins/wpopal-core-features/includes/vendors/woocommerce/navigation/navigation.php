<?php
defined( 'ABSPATH' ) || exit();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Main Wpopal_Core_Product_Navigation Class
 *
 * @class Wpopal_Core_Product_Navigation
 * @version	1.0.0
 * @since 1.0.0
 * @package	Wpopal_Core_Product_Navigation
 */
class Wpopal_Core_Product_Navigation {

	/**
	 * Wpopal_Core_Product_Navigation The single instance of Wpopal_Core_Product_Navigation.
	 *
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The version number.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * Constructor function.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'setup' ) );
	}

	/**
	 * Main Wpopal_Core_Product_Navigation Instance
	 *
	 * Ensures only one instance of Wpopal_Core_Product_Navigation is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Wpopal_Core_Product_Navigation()
	 * @return Main Wpopal_Core_Product_Navigation instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // End instance()
 
	/**
	 * Setup all the things.
	 * Only executes if Wpopal_Core or a child theme using Wpopal_Core as a parent is active and the extension specific filter returns true.
	 * Child themes can disable this extension using the wpopal_extension_boilerplate_enabled filter
	 *
	 * @return void
	 */
	public function setup() { 
 
		// Hide the 'More' section in the customizer.
		add_filter( 'wpopal_customizer_more', '__return_false' );
	}

	/**
	 * Single product pagination
	 * Display links to the next/previous products on the single product page
	 *
	 * @since   1.0.0
	 * @return  void
	 * @uses    previous_post_link(), next_post_link()
	 */
	public function  single_product_navigation() {  
	
		// Show only products in the same category?
		$in_same_term   = apply_filters( 'wpopal_single_product_navigation_same_category', false );
		$excluded_terms = apply_filters( 'wpopal_single_product_navigation_excluded_terms', '' );
		$taxonomy       = apply_filters( 'wpopal_single_product_navigation_taxonomy', 'product_cat' );

		// Get previous and next products.
		$previous_product = get_previous_post( $in_same_term, $excluded_terms, $taxonomy );
		$next_product     = get_next_post( $in_same_term, $excluded_terms, $taxonomy );

		if ( ! $previous_product && ! $next_product ) {
			return;
		}

		if ( $previous_product ) {
			$previous_product = wc_get_product( $previous_product->ID );
		}

		if ( $next_product ) {
			$next_product = wc_get_product( $next_product->ID );
		}
		
		?>
		<nav class="wpopal-product-pagination" aria-label="<?php esc_attr_e( 'More products', 'wpopal' ); ?>">
			<?php if ( $previous_product && $previous_product->is_visible() ) : ?>
				<?php previous_post_link( '%link', wp_kses_post( $previous_product->get_image() ) . '<span class="wpopal-product-pagination__title">%title</span>', $in_same_term, $excluded_terms, $taxonomy ); ?>
			<?php endif; ?>

			<?php if ( $next_product && $next_product->is_visible() ) : ?>
				<?php next_post_link( '%link', wp_kses_post( $next_product->get_image() ) . '<span class="wpopal-product-pagination__title">%title</span>', $in_same_term, $excluded_terms, $taxonomy ); ?>
			<?php endif; ?>
		</nav><!-- .wpopal-product-pagination -->
		<?php
	}

} // End Class
Wpopal_Core_Product_Navigation::instance();