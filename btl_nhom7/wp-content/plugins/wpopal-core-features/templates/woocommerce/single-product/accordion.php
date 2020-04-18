<?php
/**
 * Single Product accordions
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/accordions/accordions.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter accordions and allow third parties to add their own.
 *
 * Each accordion is an array containing title, callback and priority.
 * @see woocommerce_default_product_accordions()
 */
$accordions = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $accordions ) ) : ?>

	<div class="woocommerce-tabs woocommerce-accordions wc-accordions-wrapper wpopal-accordion">
		<?php foreach ( $accordions as $key => $accordion ) : ?>
			<h3 class="<?php echo esc_attr( $key ); ?>_accordion" id="accordion-title-<?php echo esc_attr( $key ); ?>" role="accordion" aria-controls="accordion-<?php echo esc_attr( $key ); ?>">
				<a href="#accordion-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_accordion_title', esc_html( $accordion['title'] ), $key ); ?></a>
			</h3>
			<div class="woocommerce-accordions-panel woocommerce-accordions-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-accordion" id="accordion-<?php echo esc_attr( $key ); ?>" role="accordionpanel" aria-labelledby="accordion-title-<?php echo esc_attr( $key ); ?>">
				<?php if ( isset( $accordion['callback'] ) ) { call_user_func( $accordion['callback'], $key, $accordion ); } ?>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
