<div class="theme-plugins-required">
	<?php esc_html_e( 'Checking some required plugins and automatic download from live server!', 'wpopal' ); ?>
    <div id="install-plugins-required">
		<?php
		if ( $plugins ):
			?>
            <p class="msg"><?php esc_html_e( 'Please wait a moment to download, upgrade and active following plugins!', 'wpopal' ); ?></p>
            <ul class="install-plugins">
				<?php foreach ( $plugins as $plugin ): ?>
                    <li class="pluign-item plugin-<?php echo $plugin['slug']; ?>" data-plugin="<?php echo $plugin['slug']; ?>">
						<?php echo $plugin['image']; ?><span class="plugin-name"><?php echo $plugin['name']; ?></span><span class="plugin-action"></span></li>
				<?php endforeach; ?>
            </ul>
		<?php endif; ?>

        <p class="msg"><?php esc_html_e( 'If there have any problem, please click to button Manually below to install themes', 'wpopal' ); ?></p>
    </div>
</div>

<?php if ( $plugins ) : ?>
    <div class="install-actions action-buttons">
        <a href="<?php echo admin_url( "admin.php?page=tgmpa-install-plugins" ); ?>" class="button button-primary"><?php esc_html_e( 'Manually', 'wpopal' ); ?></a>
        <a href="#" class="button-secondary close-wpopal-modal"><?php esc_html_e( 'Close', 'wpopal' ); ?></a>
        <div class="pull-right">
            <a href="#" class="button button-primary install-plugin-button"><?php esc_html_e( 'Install Plugins Now', 'wpopal' ); ?></a>
            <a href="#" class="button button-primary opal-continue-import hide" data-next="<?php echo $next; ?>"><?php echo __( 'Continue', 'wpopal' ); ?></a>
        </div>
    </div>
<?php endif; ?>
