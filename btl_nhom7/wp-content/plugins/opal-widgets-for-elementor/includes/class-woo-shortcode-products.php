<?php 
class Opal_WC_Shortcode_products extends WC_Shortcode_Products {

	/**
	 * Initialize shortcode.
	 *
	 * @since 3.2.0
	 * @param array  $attributes Shortcode attributes.
	 * @param string $type       Shortcode type.
	 */
	public function __construct( $attributes = array(), $type = 'products' ) {  

		$this->type       = $type;
		$this->attributes = $this->parse_attributes( $attributes );
		$this->query_args = $this->parse_query_args();
	}

	/**
	 * Get shortcode content.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	public function get_content( $layout="content") {  
		return $this->product_loop( $layout );
	}

	/**
	 * Parse attributes.
	 *
	 * @since  3.2.0
	 * @param  array $attributes Shortcode attributes.
	 * @return array
	 */
	protected function parse_attributes( $attributes ) { 
      
		$attributes = $this->parse_legacy_attributes( $attributes );

		$attributes = shortcode_atts(
			array(
				'limit'          => '-1',      // Results limit.
				'columns'        => '',        // Number of columns.
				'rows'           => '',        // Number of rows. If defined, limit will be ignored.
				'orderby'        => 'title',   // menu_order, title, date, rand, price, popularity, rating, or id.
				'order'          => 'ASC',     // ASC or DESC.
				'ids'            => '',        // Comma separated IDs.
				'skus'           => '',        // Comma separated SKUs.
				'category'       => '',        // Comma separated category slugs or ids.
				'cat_operator'   => 'IN',      // Operator to compare categories. Possible values are 'IN', 'NOT IN', 'AND'.
				'attribute'      => '',        // Single attribute slug.
				'terms'          => '',        // Comma separated term slugs or ids.
				'terms_operator' => 'IN',      // Operator to compare terms. Possible values are 'IN', 'NOT IN', 'AND'.
				'tag'            => '',        // Comma separated tag slugs.
				'visibility'     => 'visible', // Possible values are 'visible', 'catalog', 'search', 'hidden'.
				'class'          => '',        // HTML class.
				'page'           => 1,         // Page for pagination.
				'paginate'       => false,     // Should results be paginated.
				'cache'          => true,      // Should shortcode output be cached.
				'isdeal'		 => false,
				'carousel'		 => '',
			), $attributes, $this->type
		);

		if ( ! absint( $attributes['columns'] ) ) {
			$attributes['columns'] = wc_get_default_products_per_row();
		}



		return $attributes;
	}

	protected function woocommerce_product_loop_start( $echo = true ) {
		ob_start();

		wc_set_loop_prop( 'loop', 0 );	
	 
		$grid = apply_filters( 'wpopal_woocommerce_loop_product_grid', 'columns-'. esc_attr( wc_get_loop_prop( 'columns' ) ) ); 
	 
		
	 	echo '<ul class="products '.$grid.'">';

		$loop_start = apply_filters( 'woocommerce_product_loop_start', ob_get_clean() );

		if ( $echo ) {
			echo $loop_start; // WPCS: XSS ok.
		} else {
			return $loop_start;
		}
	}

	/**
	 * Loop over found products.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	protected function product_loop( $layout="content" ) {
		
		if( $layout == 'grid' ) {
			$layout = "content";
		}


		$columns  = absint( $this->attributes['columns'] );
		$classes  = $this->get_wrapper_classes( $columns );
		$products = $this->get_query_results();

		if( $layout == "content-list" ){
			$classes[] = 'product_list_widget';
		}
		
		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $columns,
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}

			$this->woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.

				
					setup_postdata( $GLOBALS['post'] );
					
					// Set custom product visibility when quering hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					// Render product template.
					
					echo  wc_get_template_part( $layout, 'product' );


					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // WPCS: override ok.
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . ob_get_clean() . '</div>';
	}
}
?>