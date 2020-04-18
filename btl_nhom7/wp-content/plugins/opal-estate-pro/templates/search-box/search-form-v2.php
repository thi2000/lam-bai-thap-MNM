<?php
/**
 * The template for vertival search
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$GLOBALS['group-info-column'] = 1;

$display_more_options = isset( $display_more_options ) ? $display_more_options : true;

$form_classes = [
	'opalestate-search-form',
	'opalestate-search-form--vertical-2',
	isset( $hidden_labels ) && $hidden_labels ? 'hidden-labels' : '',
];

?>

<form class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $form_classes ) ) ); ?>" action="<?php echo esc_url( opalestate_get_search_link() ); ?>" method="GET">
    <div class="opal-form-content">
        <div class="form-item form-item--location-text">
			<?php echo opalestate_load_template_path( 'search-box/fields/search-city-text' ); ?>
        </div>

        <div class="form-item form-item--types">
            <h6> <?php esc_html_e( 'Types', 'opalestate-pro' ); ?></h6>
			<?php echo opalestate_load_template_path( 'search-box/fields/types', [ 'ismultiple' => true ] ); ?>
        </div>

        <div class="form-item form-item--information">
            <h6> <?php esc_html_e( 'Information', 'opalestate-pro' ); ?></h6>
			<?php echo opalestate_load_template_path( 'search-box/fields/group-info', [ 'type' => 'input' ] ); ?>
        </div>

		<?php if ( opalestate_is_enable_price_field() ) : ?>
            <div class="form-item form-item--price">
                <h6> <?php esc_html_e( 'Price', 'opalestate-pro' ); ?></h6>
				<?php echo opalestate_load_template_path( 'search-box/fields/price' ); ?>
            </div>
		<?php endif; ?>

		<?php if ( opalestate_is_enable_areasize_field() ) : ?>
            <div class="form-item form-item--area">
                <h6> <?php esc_html_e( 'Area', 'opalestate-pro' ); ?></h6>
				<?php echo opalestate_load_template_path( 'search-box/fields/areasize' ); ?>
            </div>
		<?php endif; ?>

		<?php
		if ( $display_more_options ) {
			echo opalestate_load_template_path( 'search-box/fields/more-options' );
		}
		?>

		<?php if ( ! isset( $nobutton ) || ! $nobutton ) : ?>
            <div class="form-item form-item--submit">
				<?php echo opalestate_load_template_path( 'search-box/fields/submit-button' ); ?>
            </div>
		<?php endif; ?>
    </div>

	<?php do_action( 'opalestate_after_search_properties_form' ); ?>
</form>

