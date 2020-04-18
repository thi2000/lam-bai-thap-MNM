<div id="opal-import-content">
    <div class="arow">
        <div class="preview-image">
            <img src="<?php echo $preview; ?>">
            <div><h3><?php echo $sample_name; ?></h3></div>
        </div>
        <div class="import-main-action">
            <div class="inner">
                <ul class="notice">
                    <li>1. <?php esc_html_e( "For better and faster result, it's recommended to install the demo on a clean WordPress website.", "wpopal" ); ?></li>
                    <li>2. <?php esc_html_e( "The installation will be take more time to complete", "wpopal" ); ?></li>
                    <li>3. <?php esc_html_e( "After completed your site get the look and like as demo", "wpopal" ); ?></li>
                </ul>
                <hr>
                <p class="notice">
					<?php esc_html_e( "Please make sure your wp-content/uploads folder is existed and having writeable", "wpopal" ); ?>
                </p>
                <hr>
                <p class="notice">
					<?php esc_html_e( "Press button Continue to start your installation", "wpopal" ); ?>
                </p>
                <div class="action-buttons text-right">
                    <a href="#" class="button button-secondary opal-canel-import close-wpopal-modal"><?php esc_html_e( 'Cancel', 'wpopal' ); ?></a>
                    <a href="#" class="button button-primary opal-continue-import" data-sample="<?php echo $key; ?>" data-next="set_confirmation"><?php esc_html_e( 'Continue', 'wpopal' ); ?></a>
                </div>
            </div>
            <div class="processbar-wrap"></div>

        </div>
    </div>
</div>
