<?php if ( $message ):
$form = OpalEstate()->html->render_form( $fields );
$id   = 'message-reply';
?>
<div class="opalestate-admin-box">
    <div class="opalestate-nav-bc opal-row">
        <div class="col-lg-12"><a href="<?php echo esc_url( opalestate_get_user_tab_uri( 'messages' ) ); ?>"><?php esc_html_e( 'Messages', 'opalestate-pro' ); ?></a> /
			<?php echo esc_html( $message->subject ); ?>
        </div>
    </div>
    <div class="opalestate-read-message">
        <div class="message-container">
            <div class="message-body">
                <div class="message-meta">
                    <div class="message-avatar">
                        <img src="<?php echo esc_url( OpalEstate_User::get_author_picture( $message->sender_id ) ); ?>" width="60" alt="<?php esc_attr_e( 'User Avatar', 'opalestate-pro' ); ?>"/>
                    </div>
                    <span class="message-date"><?php echo esc_html( $message->created ); ?></span>
                </div>
                <div class="message-content">
			        <p><?php echo esc_html( $message->message ); ?></p>
                </div>
            </div>
        </div>
		<?php if ( $replies ): ?>
			<?php foreach ( $replies as $reply ): ?>
                <div class="message-body">
                    <div class="message-avatar">
                        <img src="<?php echo OpalEstate_User::get_author_picture( $reply->sender_id ); ?>" width="60" alt="<?php esc_attr_e( 'User Avatar', 'opalestate-pro' ); ?>"/>
                    </div>
                    <div class="message-content">
                        <div><?php echo $reply->created; ?></div>
						<?php echo $reply->message; ?>
                    </div>
                </div>

			<?php endforeach; ?>
		<?php endif; ?>
    </div>
    <div class="opalestate-message-reply">
        <form class="opalestate-form-reply" method="post">
			<?php echo $form; ?>
			<?php wp_nonce_field( $id, 'message_action' ); ?>
            <div class="form-group">
                <input type="hidden" name="message_id" value="<?php echo $message->id; ?>">
                <button type="submit" class="button btn btn-primary btn-3d"><?php esc_html_e( 'Reply', 'opalestate-pro' ); ?></button>
            </div>
        </form>
    </div>
	<?php endif; ?>
</div>

