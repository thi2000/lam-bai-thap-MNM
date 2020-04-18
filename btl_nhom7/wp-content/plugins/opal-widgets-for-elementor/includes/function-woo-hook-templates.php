<?php 

function osf_woocommerce_set_hooks(){
    add_action( 'woocommerce_template_custom_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail' );
    add_action( 'woocommerce_template_custom_loop_product_buttons', 'woocommerce_template_loop_add_to_cart' );
    
}

add_action( 'init', 'osf_woocommerce_set_hooks', 60 );


if (!function_exists('osf_woocommerce_time_sale')) {
    function osf_woocommerce_time_sale() {
        /**
         * @var $product WC_Product
         */
        global $product;
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        if ($time_sale) {
            wp_enqueue_script('otf-countdown');
            $time_sale += (get_option('gmt_offset') * 3600);
            echo '<div class="time">
                    <div class="opal-countdown clearfix"
                        data-countdown="countdown"
                        data-days="' . esc_html__("days", "coshyne-core") . '"
                        data-hours="' . esc_html__("hours", "coshyne-core") . '"
                        data-minutes="' . esc_html__("mins", "coshyne-core") . '"
                        data-seconds="' . esc_html__("secs", "coshyne-core") . '"
                        data-Message="' . esc_html__('Expired', 'coshyne-core') . '"
                        data-date="' . date('m', $time_sale) . '-' . date('d', $time_sale) . '-' . date('Y', $time_sale) . '-' . date('H', $time_sale) . '-' . date('i', $time_sale) . '-' . date('s', $time_sale) . '">
                    </div>
            </div>';
        }
    }
}

function osf_elementor_product_loop_layouts(){
	return apply_filters(
		'osf_elementor_product_loop_layouts', array(
			    'content'       => __( 'Grid By Current Theme', 'wpopal' ),
                'content-list'  => __( 'List Widget Style', 'wpopal' ),
                'content-split' => __( 'Split Widget Style', 'wpopal' ),
                'content-grid'  => __( 'Grid Widget Style', 'wpopal' ),
		)
	);
}

function osf_elementor_product_loop_deal_layouts(){
	return apply_filters(
		'osf_elementor_product_loop_deal_layouts', array(
                    'content'       => __( 'Grid By Current Theme', 'wpopal' ),
                    'content-list'  => __( 'List Widget Style', 'wpopal' ),
                    'content-split' => __( 'Split Widget Style', 'wpopal' ),
                    'content-grid'  => __( 'Grid Widget Style', 'wpopal' ),
        )
	);
}

function osf_handheld_footer_bar_cart_link() {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'opalelementor'); ?>">
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }

    


if (!function_exists('osf_elementor_amount')) {
    /**
     *
     * @return string
     *
     */
    function osf_elementor_amount() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="amount">' . wp_kses_data(WC()->cart->get_cart_subtotal()) . '</span>';
        }
        return '';
    }
}

if (!function_exists('osf_elementor_count')) {
    /**
     *
     * @return string
     *
     */
    function osf_elementor_count() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . ' </span>';
        }
        return '';
    }
}

if (!function_exists('osf_elementor_count_text')) {
    /**
     *
     * @return string
     *
     */
    function osf_elementor_count_text() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count-text">' . wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "opalelementor")) . '</span>';
        }
        return '';
    }
} 

if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'osf_elementor_link_fragment', 999 );
} else {
	add_filter( 'add_to_cart_fragments', 'osf_elementor_link_fragment', 999 );
}

	/**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     *
     * @return array            Fragments to refresh via AJAX
     */
    function osf_elementor_link_fragment($fragments) {
        global $woocommerce;
        ob_start();
   		  unset(  $fragments['a.cart-contents'] );
        $fragments['a.cart-contents .amount']     = osf_elementor_amount();
        $fragments['a.cart-contents .count']      = osf_elementor_count()  ;
        $fragments['a.cart-contents .count-text'] = osf_elementor_count_text() ;

        ob_start();
        osf_handheld_footer_bar_cart_link();
        $fragments['a.footer-cart-contents'] = ob_get_clean() ;

        return $fragments;
    }


function osf_product_dropdown_categories( $args = array(), $deprecated_hierarchical = 1, $deprecated_show_uncategorized = 1, $deprecated_orderby = '' ) { 
    global $wp_query; 
 
    if ( ! is_array( $args ) ) { 
        wc_deprecated_argument( 'osf_product_dropdown_categories()', '2.1', 'show_counts, hierarchical, show_uncategorized and orderby arguments are invalid - pass a single array of values instead.' ); 
 
        $args['show_count'] = $args; 
        $args['hierarchical'] = $deprecated_hierarchical; 
        $args['show_uncategorized'] = $deprecated_show_uncategorized; 
        $args['orderby'] = $deprecated_orderby; 
    } 
 
    $current_product_cat = isset( $wp_query->query_vars['product_cat'] ) ? $wp_query->query_vars['product_cat'] : ''; 
    $defaults = array( 
        'pad_counts' => 1,  
        'show_count' => 1,  
        'hierarchical' => 1,  
        'hide_empty' => 1,  
        'show_uncategorized' => 1,  
        'orderby' => 'name',  
        'selected' => $current_product_cat,  
        'menu_order' => false,  
 ); 
 
    $args = wp_parse_args( $args, $defaults ); 
 
    if ( 'order' === $args['orderby'] ) { 
        $args['menu_order'] = 'asc'; 
        $args['orderby'] = 'name'; 
    } 
 
    $terms = get_terms( 'product_cat', apply_filters( 'wc_product_dropdown_categories_get_terms_args', $args ) ); 
 
    if ( empty( $terms ) ) { 
        return; 
    } 
 
    $output = "<select name='product_cat' class='custom-select dropdown_product_cat' placeholder='Select a category'>"; 
    $output .= '<option value="" ' . selected( $current_product_cat, '', false ) . '>' . esc_html__( 'All category', 'opalelementor' ) . '</option>'; 
    $output .= wc_walk_category_dropdown_tree( $terms, 0, $args ); 
    if ( $args['show_uncategorized'] ) { 
        $output .= '<option value="0" ' . selected( $current_product_cat, '0', false ) . '>' . esc_html__( 'Uncategorized', 'opalelementor' ) . '</option>'; 
    } 
    $output .= "</select>"; 
 
    echo $output; 
} 

/**
 * add actions render list style in product loop
 */
// add_action ( 'init', 'osf_elementor_template_loop_list_hooks' );
function osf_elementor_template_loop_list_hooks( ) {
 
	/**
	 * Product Loop Items.
	 *
	 * @see woocommerce_template_loop_product_link_open()
	 * @see woocommerce_template_loop_product_link_close()
	 * @see woocommerce_template_loop_add_to_cart()
	 * @see woocommerce_template_loop_product_thumbnail()
	 * @see woocommerce_template_loop_product_title()
	 * @see woocommerce_template_loop_category_link_open()
	 * @see woocommerce_template_loop_category_title()
	 * @see woocommerce_template_loop_category_link_close()
	 * @see woocommerce_template_loop_price()
	 * @see woocommerce_template_loop_rating()
	 */
	add_action( 'woocommerce_before_shop_loop_list_item', 'woocommerce_template_loop_product_link_open', 10 );
	add_action( 'woocommerce_after_shop_loop_list_item', 'woocommerce_template_loop_product_link_close', 5 );
	add_action( 'woocommerce_after_shop_loop_list_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_action( 'woocommerce_before_shop_loop_list_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_shop_loop_list_item_title', 'woocommerce_template_loop_product_title', 10 );

	add_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
	add_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
	add_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

	add_action( 'woocommerce_after_shop_loop_list_item_title', 'woocommerce_template_loop_price', 10 );
	add_action( 'woocommerce_after_shop_loop_list_item_title', 'woocommerce_template_loop_rating', 5 );
}
?>