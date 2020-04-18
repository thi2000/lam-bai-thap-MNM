<?php 
/**
 * Header
 *
 * @see wpopal_product_search()
 * @see wpopal_header_cart()
 */
#add_action( 'wpopal_header', 'wpopal_product_search', 40 );
#add_action( 'wpopal_header', 'wpopal_header_cart',    60 );

if ( ! function_exists( 'wpopal_woocommerce_widgets_init' ) ) {
	/**
	 * Add WooCommerce support
	 *
	 * @package wpopal
	 */
	 add_action('widgets_init',  'wpopal_woocommerce_widgets_init', 9);
	 
	 function wpopal_woocommerce_widgets_init() {
	    register_sidebar(array(
	        'name'          => __('Sidebar Left Shop', 'wpopal'),
	        'id'            => 'sidebar-left-shop',
	        'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'wpopal'),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h2 class="widget-title">',
	        'after_title'   => '</h2>',
	    ));
	    register_sidebar(array(
	        'name'          => __('Sidebar Single Shop', 'wpopal'),
	        'id'            => 'sidebar-single-shop',
	        'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'wpopal'),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h2 class="widget-title">',
	        'after_title'   => '</h2>',
	    ));
	    register_sidebar(array(
	        'name'          => __('Sidebar Right Shop', 'wpopal'),
	        'id'            => 'sidebar-right-shop',
	        'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'wpopal'),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h2 class="widget-title">',
	        'after_title'   => '</h2>',
	    ));


	    register_sidebar(array(
	        'name'          => __('Catalog Top Filter', 'wpopal'),
	        'id'            => 'sidebar-filter',
	        'description'   => __('Add widgets here appear in top of product link.', 'wpopal'),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h2 class="widget-title">',
	        'after_title'   => '</h2>',
	    ));
	}
}

/**
 * Product Catalog Page 
 *
 */
if ( ! function_exists( 'wpopal_woocommerce_layout_hooks' ) ) {
	function wpopal_woocommerce_layout_hooks(){  
		$theme = wp_get_theme(); 
		if( is_shop() || is_product_category() || is_product_tag() || is_tax() ){   
			add_filter( $theme.'_left_sidebar'      , 'wpopal_woocommerce_catalog_left_sidebar' );
			add_filter( $theme.'_right_sidebar' 	, 'wpopal_woocommerce_catalog_right_sidebar' );
			add_filter( $theme.'_sidebar_position'  , 'wpopal_woocommerce_catalog_sidebar_position' );
		}

		if( is_product() ){ 
			add_filter( $theme.'_left_sidebar'      , 'wpopal_woocommerce_single_left_sidebar' );
			add_filter( $theme.'_right_sidebar' 	, 'wpopal_woocommerce_single_right_sidebar' );
			add_filter( $theme.'_sidebar_position'  , 'wpopal_woocommerce_single_sidebar_position' );
		}
	}

	add_action( "woocommerce_before_main_content" , 'wpopal_woocommerce_layout_hooks', 1 );
}

if ( ! function_exists( 'wpopal_woocommerce_catalog_right_sidebar' ) ) {
	// catalog product
	function wpopal_woocommerce_catalog_right_sidebar(){
		return  'sidebar-right-shop';
	}
}

if ( ! function_exists( 'wpopal_woocommerce_catalog_left_sidebar' ) ) {
	function wpopal_woocommerce_catalog_left_sidebar(){
		return  'sidebar-left-shop';
	}
}

if ( ! function_exists( 'wpopal_woocommerce_catalog_sidebar_position' ) ) {
	function wpopal_woocommerce_catalog_sidebar_position(){
		return get_theme_mod( 'woocommerce_sidebar_shop_position' );
	}
}

/// single product ///// 
if ( ! function_exists( 'wpopal_woocommerce_single_right_sidebar' ) ) {
	function wpopal_woocommerce_single_right_sidebar(){
		return  'sidebar-single-shop';
	}
}

if ( ! function_exists( 'wpopal_woocommerce_single_left_sidebar' ) ) {
	function wpopal_woocommerce_single_left_sidebar(){
		return  'sidebar-single-shop';
	}
}

if ( ! function_exists( 'wpopal_woocommerce_single_sidebar_position' ) ) {
	function wpopal_woocommerce_single_sidebar_position(){
		return get_theme_mod( 'woocommerce_sidebar_shop_single_position' );
	}
}

/***
**/
if ( ! function_exists( 'woocommerce_layered_nav_term_html' ) ) {
	function woocommerce_layered_nav_term_html( $term_html, $term, $link, $count ) {

		$swatch_style = '';
		$swatch_color = get_term_meta( $term->term_id, 'product_attribute_color', true );
		$swatch_image = get_term_meta( $term->term_id, 'product_attribute_image', true );

		$class = '';
		if( ! empty( $swatch_color ) ) {
			$class .= ' with-swatch-color';
			$swatch_style = 'background-color: ' . $swatch_color .';';
		}

		if( ! empty( $swatch_image ) ) {
			$class .= ' with-swatch-image';
			$swatch_style = 'background-image: url(' . $swatch_image .');';
		}
		$s = '';
		if( $swatch_style ) {
			$s = '<span class="filter-swatch" style="'.$swatch_style.'"></span>';
		}
		return $s.$term_html;
	}

	add_filter( "woocommerce_layered_nav_term_html", "woocommerce_layered_nav_term_html", 4 , 4 );
}




$product_deal = Wpopal_Core_Woo_Deal::get_instance();
add_action('woocommerce_single_product_summary', [$product_deal,'render_single_counter'], 20 );

/**
 * WooCommerce Template Functions.
 *
 * @package wpopal
 */

if ( ! function_exists( 'wpopal_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function wpopal_before_content() { return 
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php
	}
}

if ( ! function_exists( 'wpopal_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function wpopal_after_content() { return ;
		?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php do_action( 'wpopal_sidebar' );
	}
}

if ( ! function_exists( 'wpopal_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function wpopal_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		wpopal_cart_link();
		$fragments['a.cart-contents'] =  ob_get_clean();

		ob_start();
		wpopal_handheld_footer_bar_cart_link();
		$fragments['a.footer-cart-contents'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Filter hook function monkey patching form classes
	 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
	 *
	 * @param string $args Form attributes.
	 * @param string $key Not in use.
	 * @param null   $value Not in use.
	 *
	 * @return mixed
	 */

	/**
	 * Cart fragment
	 *
	 * @see wpopal_cart_link_fragment()
	 */
	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
		add_filter( 'woocommerce_add_to_cart_fragments', 'wpopal_cart_link_fragment' );
	} else {
		add_filter( 'add_to_cart_fragments', 'wpopal_cart_link_fragment' );
	}    
}

if ( ! function_exists( 'wpopal_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function wpopal_cart_link() {
		?>
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wpopal' ); ?>">
				<?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wpopal' ), WC()->cart->get_cart_contents_count() ) );?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'wpopal_product_search' ) ) {
	/**
	 * Display Product Search
	 *
	 * @since  1.0.0
	 * @uses  wpopal_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function wpopal_product_search() {
		if ( wpopal_is_woocommerce_activated() ) { ?>
			<div class="site-search">
				<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
			</div>
		<?php
		}
	}
}

if ( ! function_exists( 'wpopal_header_cart' ) ) {
	/**
	 * Display Header Cart
	 *
	 * @since  1.0.0
	 * @uses  wpopal_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function wpopal_header_cart() {
		if ( wpopal_is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
		?>
		<ul id="site-header-cart" class="site-header-cart menu">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php wpopal_cart_link(); ?>
			</li>
			<li>
				<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
			</li>
		</ul>
		<?php
		}
	}
}

if ( ! function_exists( 'wpopal_upsell_display' ) ) {
	/**
	 * Upsells
	 * Replace the default upsell function with our own which displays the correct number product columns
	 *
	 * @since   1.0.0
	 * @return  void
	 * @uses    woocommerce_upsell_display()
	 */
	function wpopal_upsell_display() {
		$columns = apply_filters( 'wpopal_upsells_columns', 3 );
		woocommerce_upsell_display( -1, $columns );
	}
}

if ( ! function_exists( 'wpopal_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @since   1.4.3
	 * @return  void
	 */
	function wpopal_sorting_wrapper() {
		echo '<div class="wpopal-sorting">';
	}
}

if ( ! function_exists( 'wpopal_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @since   1.4.3
	 * @return  void
	 */
	function wpopal_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'wpopal_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper
	 *
	 * @since   2.2.0
	 * @return  void
	 */
	function wpopal_product_columns_wrapper() {
		$columns = wpopal_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}

if ( ! function_exists( 'wpopal_loop_columns' ) ) {
	/**
	 * Default loop columns on product archives
	 *
	 * @return integer products per row
	 * @since  1.0.0
	 */
	function wpopal_loop_columns() {
		$columns = 3; // 3 products per row

		if ( function_exists( 'wc_get_default_products_per_row' ) ) {
			$columns = wc_get_default_products_per_row();
		}

		return apply_filters( 'wpopal_loop_columns', $columns );
	}
}

if ( ! function_exists( 'wpopal_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close
	 *
	 * @since   2.2.0
	 * @return  void
	 */
	function wpopal_product_columns_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'wpopal_shop_messages' ) ) {
	/**
	 * Wpopal_Core shop messages
	 *
	 * @since   1.4.4
	 * @uses    wpopal_do_shortcode
	 */
	function wpopal_shop_messages() {
		if ( ! is_checkout() ) {
			echo wp_kses_post( wpopal_do_shortcode( 'woocommerce_messages' ) );
		}
	}
}

if ( ! function_exists( 'wpopal_woocommerce_pagination' ) ) {
	/**
	 * Wpopal_Core WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
	 * but since Wpopal_Core adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 *
	 * @since 1.4.4
	 */
	function wpopal_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) {
			woocommerce_pagination();
		}
	}
}

if ( ! function_exists( 'wpopal_promoted_products' ) ) {
	/**
	 * Featured and On-Sale Products
	 * Check for featured products then on-sale products and use the appropiate shortcode.
	 * If neither exist, it can fallback to show recently added products.
	 *
	 * @since  1.5.1
	 * @param integer $per_page total products to display.
	 * @param integer $columns columns to arrange products in to.
	 * @param boolean $recent_fallback Should the function display recent products as a fallback when there are no featured or on-sale products?.
	 * @uses  wpopal_is_woocommerce_activated()
	 * @uses  wc_get_featured_product_ids()
	 * @uses  wc_get_product_ids_on_sale()
	 * @uses  wpopal_do_shortcode()
	 * @return void
	 */
	function wpopal_promoted_products( $per_page = '2', $columns = '2', $recent_fallback = true ) {
		if ( wpopal_is_woocommerce_activated() ) {

			if ( wc_get_featured_product_ids() ) {

				echo '<h2>' . esc_html__( 'Featured Products', 'wpopal' ) . '</h2>';

				echo wpopal_do_shortcode( 'featured_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( wc_get_product_ids_on_sale() ) {

				echo '<h2>' . esc_html__( 'On Sale Now', 'wpopal' ) . '</h2>';

				echo wpopal_do_shortcode( 'sale_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( $recent_fallback ) {

				echo '<h2>' . esc_html__( 'New In Store', 'wpopal' ) . '</h2>';

				echo wpopal_do_shortcode( 'recent_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			}
		}
	}
}

if ( ! function_exists( 'wpopal_handheld_footer_bar' ) ) {
	/**
	 * Display a menu intended for use on handheld devices
	 *
	 * @since 2.0.0
	 */
	function wpopal_handheld_footer_bar() {
		$links = array(
			'my-account' => array(
				'priority' => 10,
				'callback' => 'wpopal_handheld_footer_bar_account_link',
			),
			'search'     => array(
				'priority' => 20,
				'callback' => 'wpopal_handheld_footer_bar_search',
			),
			'cart'       => array(
				'priority' => 30,
				'callback' => 'wpopal_handheld_footer_bar_cart_link',
			),
		);

		if ( wc_get_page_id( 'myaccount' ) === -1 ) {
			unset( $links['my-account'] );
		}

		if ( wc_get_page_id( 'cart' ) === -1 ) {
			unset( $links['cart'] );
		}

		$links = apply_filters( 'wpopal_handheld_footer_bar_links', $links );
		?>
		<div class="wpopal-handheld-footer-bar">
			<ul class="columns-<?php echo count( $links ); ?>">
				<?php foreach ( $links as $key => $link ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>">
						<?php
						if ( $link['callback'] ) {
							call_user_func( $link['callback'], $key, $link );
						}
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'wpopal_handheld_footer_bar_search' ) ) {
	/**
	 * The search callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function wpopal_handheld_footer_bar_search() {
		echo '<a href="">' . esc_attr__( 'Search', 'wpopal' ) . '</a>';
		wpopal_product_search();
	}
}

if ( ! function_exists( 'wpopal_handheld_footer_bar_cart_link' ) ) {
	/**
	 * The cart callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function wpopal_handheld_footer_bar_cart_link() {
		?>
			<a class="footer-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wpopal' ); ?>">
				<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'wpopal_handheld_footer_bar_account_link' ) ) {
	/**
	 * The account callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function wpopal_handheld_footer_bar_account_link() {
		echo '<a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_attr__( 'My Account', 'wpopal' ) . '</a>';
	}
}

if ( ! function_exists( 'wpopal_single_product_navigation' ) ) {
	/**
	 * Single Product Navigation
	 *
	 * @since 2.3.0
	 */
	function wpopal_single_product_navigation() {
		if ( class_exists( 'Wpopal_Core_Product_Pagination' ) || true !== get_theme_mod( 'wpopal_product_navigation' ) ) {
			return;
		}

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
		<nav class="wpopal-core" aria-label="<?php esc_attr_e( 'More products', 'wpopal' ); ?>">
			<?php if ( $previous_product && $previous_product->is_visible() ) : ?>
				<?php previous_post_link( '%link', wp_kses_post( $previous_product->get_image() ) . '<span class="wpopal-core__title">%title</span>', $in_same_term, $excluded_terms, $taxonomy ); ?>
			<?php endif; ?>

			<?php if ( $next_product && $next_product->is_visible() ) : ?>
				<?php next_post_link( '%link', wp_kses_post( $next_product->get_image() ) . '<span class="wpopal-core__title">%title</span>', $in_same_term, $excluded_terms, $taxonomy ); ?>
			<?php endif; ?>
		</nav><!-- .wpopal-core -->
		<?php
	}
}

if ( ! function_exists( 'wpopal_sticky_single_add_to_cart' ) ) {
	/**
	 * Sticky Add to Cart
	 *
	 * @since 2.3.0
	 */
	function wpopal_sticky_single_add_to_cart() {
		global $product;

		if ( class_exists( 'Wpopal_Core_Sticky_Add_to_Cart' ) || true !== get_theme_mod( 'wpopal_sticky_add_to_cart' ) ) {
			return;
		}

		if ( ! is_product() ) {
			return;
		}

		$params = apply_filters( 'wpopal_sticky_add_to_cart_params', array(
			'trigger_class' => 'entry-summary'
		) );

		wp_localize_script( 'wpopal-sticky-add-to-cart', 'wpopal_sticky_add_to_cart_params', $params );

		wp_enqueue_script( 'wpopal-sticky-add-to-cart' );
		?>
			<section class="wpopal-sticky-add-to-cart">
				<div class="col-full">
					<div class="wpopal-sticky-add-to-cart__content">
						<?php echo wp_kses_post( woocommerce_get_product_thumbnail() ); ?>
						<div class="wpopal-sticky-add-to-cart__content-product-info">
							<span class="wpopal-sticky-add-to-cart__content-title"><?php esc_attr_e( 'You\'re viewing:', 'wpopal' ); ?> <strong><?php the_title(); ?></strong></span>
							<span class="wpopal-sticky-add-to-cart__content-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
							<?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
						</div>
						<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="wpopal-sticky-add-to-cart__content-button button alt">
							<?php echo esc_attr( $product->add_to_cart_text() ); ?>
						</a>
					</div>
				</div>
			</section><!-- .wpopal-sticky-add-to-cart -->
		<?php
	}
}

if ( ! function_exists( 'wpopal_woocommerce_brands_homepage_section' ) ) {
	/**
	 * Display WooCommerce Brands
	 * Hooked into the `homepage` action in the homepage template.
	 * Requires WooCommerce Brands.
	 *
	 * @since  2.3.0
	 * @link   https://woocommerce.com/products/brands/
	 * @uses   apply_filters()
	 * @uses   wpopal_do_shortcode()
	 * @uses   wp_kses_post()
	 * @uses   do_action()
	 * @return void
	 */
	function wpopal_woocommerce_brands_homepage_section() {
		$args = apply_filters( 'wpopal_woocommerce_brands_args', array(
			'number'     => 6,
			'columns'    => 4,
			'orderby'    => 'name',
			'show_empty' => false,
			'title'      => __( 'Shop by Brand', 'wpopal' ),
		) );

		$shortcode_content = wpopal_do_shortcode( 'product_brand_thumbnails', apply_filters( 'wpopal_woocommerce_brands_shortcode_args', array(
			'number'     => absint( $args['number'] ),
			'columns'    => absint( $args['columns'] ),
			'orderby'    => esc_attr( $args['orderby'] ),
			'show_empty' => (bool) $args['show_empty'],
		) ) );

		echo '<section class="wpopal-product-section wpopal-woocommerce-brands" aria-label="' . esc_attr__( 'Product Brands', 'wpopal' ) . '">';

		do_action( 'wpopal_homepage_before_woocommerce_brands' );

		echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

		do_action( 'wpopal_homepage_after_woocommerce_brands_title' );

		echo $shortcode_content;

		do_action( 'wpopal_homepage_after_woocommerce_brands' );

		echo '</section>';
	}
}

if ( ! function_exists( 'wpopal_woocommerce_brands_archive' ) ) {
	/**
	 * Display brand image on brand archives
	 * Requires WooCommerce Brands.
	 *
	 * @since  2.3.0
	 * @link   https://woocommerce.com/products/brands/
	 * @uses   is_tax()
	 * @uses   wp_kses_post()
	 * @uses   get_brand_thumbnail_image()
	 * @uses   get_queried_object()
	 * @return void
	 */
	function wpopal_woocommerce_brands_archive() {
		if ( is_tax( 'product_brand' ) ) {
			echo wp_kses_post( get_brand_thumbnail_image( get_queried_object() ) );
		}
	}
}

if ( ! function_exists( 'wpopal_woocommerce_brands_single' ) ) {
	/**
	 * Output product brand image for use on single product pages
	 * Requires WooCommerce Brands.
	 *
	 * @since  2.3.0
	 * @link   https://woocommerce.com/products/brands/
	 * @uses   wpopal_do_shortcode()
	 * @uses   wp_kses_post()
	 * @return void
	 */
	function wpopal_woocommerce_brands_single() {
		$brand = wpopal_do_shortcode( 'product_brand', array(
			'class' => ''
		) );

		if ( empty( $brand ) ) {
			return;
		}

		?>
		<div class="wpopal-wc-brands-single-product">
			<?php echo wp_kses_post( $brand ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'wpopal_woocommerce_before_customer_login_form' ) ) {
	function wpopal_woocommerce_before_customer_login_form(){ ?>
		<div class="woocommerce-account-form">
			<div class="account-heading-tab text-center">
				<a class="#" data-target=".u-column1" class="active"><?php echo esc_html__( 'Login', 'wpopal' ); ?></a>
				<a class="#" data-target=".u-column2"><?php echo esc_html__( 'Register', 'wpopal' ); ?></a>
			</div>
	<?php }

	add_action( 'woocommerce_before_customer_login_form', 'wpopal_woocommerce_before_customer_login_form' );
}

if ( ! function_exists( 'wpopal_woocommerce_after_customer_login_form' ) ) {
	function wpopal_woocommerce_after_customer_login_form(){
		echo '	</div>	';
	}

	add_action( 'woocommerce_after_customer_login_form', 'wpopal_woocommerce_after_customer_login_form' );
}
 
?>
