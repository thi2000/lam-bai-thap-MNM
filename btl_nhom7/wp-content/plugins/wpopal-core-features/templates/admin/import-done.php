<div class="inner">
    <h2><?php esc_html_e( "The installation is successful.", "wpopal" ); ?></h2>
    <p><?php esc_html_e( "Thank you so much for choosing the theme!.", "wpopal" ); ?></p>
    <p><?php esc_html_e( "if you need any help please keep contact us!.", "wpopal" ); ?></p>

</div>

<?php if ( isset( $content ) ): ?>
	<?php echo $content; ?>
<?php endif; ?>

<div class="action-buttons text-right">
    <a href="#" class="button-secondary close-wpopal-modal"><?php echo __( 'Close', 'wpopal' ); ?></a>
    <div class="pull-right">
        <a href="<?php echo get_site_url(); ?>" class="button-primary"><?php echo __( 'Preview', 'wpopal' ); ?></a>
        <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button-primary"><?php echo __( 'Custimize Theme Now', 'wpopal' ); ?></a>
    </div>
</div>
 
