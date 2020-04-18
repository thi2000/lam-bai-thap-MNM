<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'product-loop-split' ); ?>>
	
	<div class="product-block elementor-grid-2">
		<?php do_action( 'woocommerce_split_product_item_start' ); ?>
		<div class="elementor-grid">
		    <div class="column-item">
		    	<?php do_action( 'woocommerce_loop_content_split_product_title_before' ); ?>
		    	<h3 class="woocommerce-loop-product__title">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
						<span class="product-title"><?php echo $product->get_name(); ?></span>
					</a>
				</h3> 
				<?php do_action( 'woocommerce_loop_content_split_product_title_after' ); ?>
				<?php woocommerce_template_single_excerpt(); ?>
				 
				<?php if ( ! empty( $show_rating ) ) : ?>
					<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
				<?php endif; ?>

                <?php echo osf_woocommerce_time_sale(); ?>

				<div class="product-price">
					<?php echo  woocommerce_template_loop_price(); ?>
				</div>

		 		<?php do_action( 'woocommerce_loop_content_split_product_bottom' ); ?>

		 		<div class="product-button-actions">
		 			<?php do_action( 'woocommerce_template_custom_loop_product_buttons' ); ?>
		    	</div>	

		    </div>
		    <div class="column-item">
		      	<?php do_action( 'woocommerce_template_custom_loop_product_thumbnail' ); ?>
		    </div>

		  </div>
		<?php do_action( 'woocommerce_split_product_item_end' ); ?>
	</div>	  
</li>
