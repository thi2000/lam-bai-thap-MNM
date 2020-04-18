<?php
if ( ! function_exists( 'wpopal_is_theme_layout_customizate_support' ) ) {
	function wpopal_is_theme_layout_customizate_support() {
		$folder = get_template_directory() . '/inc/vendor/woocommerce';

		return is_dir( $folder );
	}
}

/**
 *
 */
if ( ! function_exists( 'wpopal_woocommerce_template_loop_product_title' ) ) {
	function wpopal_woocommerce_template_loop_product_title() {
		echo '<h3 class="woocommerce-loop-product__title"><a href="' . esc_url_raw( get_the_permalink() ) . '">' . get_the_title() . '</a></h3>';
	}
}

/**
 *
 */
if ( ! function_exists( 'wpopal_woocommerce_horizontal_filters' ) ) {
	function wpopal_woocommerce_horizontal_filters() { ?>
		<?php if ( is_active_sidebar( 'sidebar-filter' ) ): ?>
            <div class="sidebar-filter">
                <a href="#sidebar-filter" class="wpopal-filter-top-button"><?php esc_html_e( "Filter", "wpopal" ); ?></a>
            </div>
            <div class="sidebar-filter-content">
				<?php dynamic_sidebar( 'sidebar-filter' ); ?>
            </div>

		<?php endif; ?>
	<?php }
}
/**
 * ------------------------------------------------------------------------------------------------
 * Clear all filters button
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'wpopal_woocommerce_clear_filters_selected' ) ) {
	function wpopal_woocommerce_clear_filters_selected() {

		$url     = $_SERVER['REQUEST_URI'];
		$filters = [ 'filter_', 'min_price', 'max_price', 'product_visibility', 'stock', 'onsales' ];
		$clear   = false;

		foreach ( $filters as $filter ) {
			if ( strpos( $url, $filter ) ) {
				$clear = true;
			}
		}

		if ( $clear ) {
			$reset_url = strtok( $url, '?' );
			if ( isset( $_GET['post_type'] ) ) {
				$reset_url = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $reset_url );
			}
			?>
            <div class="wpopal-selected-filters">
                <a class="wpopal-clear-filters" href="<?php echo esc_url( $reset_url ); ?>"><?php echo esc_html__( 'Clear filters', 'wpopal' ); ?></a>
				<?php the_widget( 'WC_Widget_Layered_Nav_Filters', [], [] ); ?>
            </div>
			<?php
		}
	}
}

/**
 *
 *
 */
if ( ! function_exists( 'wpopal_woocommerce_load_more_button' ) ) {
	function wpopal_woocommerce_load_more_button() {

		if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
			return;
		}

		$base = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
		$args = [
			'total'   => wc_get_loop_prop( 'total_pages' ),
			'current' => wc_get_loop_prop( 'current_page' ),
			'base'    => $base,
			'format'  => '?product-page=%#%',
			'next'    => 1,
			'done'    => 0,
		];

		$args['next'] = $args['current'] + 1;

		if ( $args['next'] > $args['total'] ) {
			$args['next'] = $args['total'];
			$args['done'] = 1;
		}

		$option = get_theme_mod( 'woocommerce_catalog_pagination_mode' );
		$class  = $option ? " has-" . $option . ' ' : "";

		$url = str_replace( "%#%", $args['next'], $base );
		echo '<div class="load-more-wrap ' . $class . ( $args['done'] ? "load-done" : "" ) . '"> <a href="' . $url . '">' . __( 'Load More', 'wpopal' ) . '</a></div>';
	}
}

/**
 *
 */

if ( ! function_exists( 'wpopal_woocommerce_addition_nav' ) ) {
	function wpopal_woocommerce_addition_nav() { ?>

		<?php

		$modes = [
			'1' => __( 'List', 'wpopal' ),
			'2' => __( 'Two Column', 'wpopal' ),
			'3' => __( 'Three Column', 'wpopal' ),
			'4' => __( 'Four Column', 'wpopal' ),
		];

		$show_limited = apply_filters( 'wpopal_woocommerce_addition_nav_limited', [
			'9',
			'12',
			'18',
			'24',
		] );

		$cols = wpopal_woocommerce_get_loop_columns();

		?>
        <div class="woo-show-perpage">
            <span><?php esc_html_e( "Show", 'wpopal' ); ?></span>
			<?php foreach ( $show_limited as $value ):
				$url = add_query_arg( 'show_per_page', $value );
				?>
                <a href="<?php echo esc_attr( $url ); ?>" title="<?php echo esc_attr( $value ); ?>" class="per-page-<?php echo esc_attr( $value ); ?>">
                    <span><?php echo esc_attr( $value ); ?></span>
                </a>
			<?php endforeach; ?>
        </div>

        <div class="woo-display-mode">
			<?php foreach ( $modes as $mode => $label ):
				$url = add_query_arg( 'view_cols', $mode );
				$classes = [];
				$classes[] = 'hint--top view-cols-' . esc_attr( $mode );

				if ( $mode == $cols ) {
					$classes[] = 'active';
				}
				?>
                <a aria-label="<?php echo esc_attr( $label ); ?>" href="<?php echo esc_attr( $url ); ?>" title="<?php echo esc_attr( $label ); ?>" class="<?php echo implode( ' ', $classes ); ?>">
                    <span><?php echo wpopal_get_svg( 'column-' . $mode, '#CCC' ); ?></span>
                </a>
			<?php endforeach; ?>
        </div>


	<?php }
}

?>
