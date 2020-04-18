<?php 
$args = array(
		'cpage' => isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1,
		'items_per_page' => 10
); 
$messages = opalestate_get_message_by_user( $args );  
?>
<div class="opalestate-admin-box">
	<h3 class="page-title"><?php echo sprintf( esc_html__( 'Messages for you', 'opalestate-pro'), '' ); ?></h3>
	<div class="opalestate-messages-list">
		<div class="message-item">
			<table>
				<?php foreach( $messages['items'] as $message ): ?>
				<tr>
					<td width="220">
						<img src="<?php echo OpalEstate_User::get_author_picture( $message->sender_id ); ?>" width="60" alt="<?php esc_attr_e( 'User Avatar', 'opalestate-pro' ); ?>"/>
						<span><?php echo opalestate_user_fullname( $message->sender_id ); ?></span>
					</td>	
					<td>
						<a href="<?php echo opalestate_get_read_message_uri( $message->id ); ?>">
							<h6><?php echo esc_html( $message->subject ); ?></h6>
							<p><?php echo esc_html( $message->message ); ?></p>
						</a>
					</td>
					<td width="200"><?php echo esc_html( $message->created ); ?></td>
				</tr>
				<?php endforeach; ?>
	 
			</table>		
		</div>

		<div class="opalestate-pagination pagination-main">
			<?php 
			
			echo paginate_links( array(
                'base' 		=> add_query_arg( 'cpage', '%#%' ),
                'format' 	=> '',
                'prev_text' => esc_html__('&laquo;'),
                'next_text' => esc_html__('&raquo;'),
                'total' 	=> ceil( $messages['total'] / $args['items_per_page'] ),
                'current'   => $args['cpage']
            ));
			?>
		</div>
	</div>	
</div>	
