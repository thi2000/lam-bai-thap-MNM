<div class="inner">
    <h2><?php echo $heading; ?></h2>
	<?php if ( empty( $content ) ) : ?>
        <p><?php esc_html_e( "For better and faster result, it's recommended to install the demo on a clean WordPress website.", "wpopal" ); ?></p>
        <p><?php esc_html_e( "The installation will be take more time to complete", "wpopal" ); ?></p>
        <p><?php esc_html_e( "After completed your site get the look and like as demo", "wpopal" ); ?></p>
	<?php else : ?>
        <div class="import-content-msg <?php if ( isset( $error ) ): ?> alert alert-warning <?php endif; ?>">
			<?php echo $content; ?>
        </div>
	<?php endif; ?>
</div>

<?php // if( isset($done) && $done == 1 ) : ?>
<div class="action-buttons text-right">

    <a href="<?php echo get_site_url(); ?>" class="button-primary"><?php esc_html_e( 'Preview', 'wpopal' ); ?></a>
    <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button-primary"><?php esc_html_e( 'Custimize Theme Now', 'wpopal' ); ?></a>

    <a href="#" class="button-secondary close-wpopal-modal pull-right"><?php esc_html_e( 'Close', 'wpopal' ); ?></a>
</div>
<?php // endif; 	?> 
