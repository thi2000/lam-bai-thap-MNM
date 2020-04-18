<?php if ( isset( $content ) ): ?>
	<?php echo $content; ?>
<?php endif; ?>

<div class="action-buttons text-right">
    <a href="#" class="button-secondary close-wpopal-modal"><?php esc_html_e( 'Close', 'wpopal' ); ?></a>
    <div class="pull-right">
        <a href="<?php echo get_site_url(); ?>" class="button-primary"><?php esc_html_e( 'Preview', 'wpopal' ); ?></a>
        <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button-primary"><?php esc_html_e( 'Custimize Theme Now', 'wpopal' ); ?></a>
    </div>
</div>
 
