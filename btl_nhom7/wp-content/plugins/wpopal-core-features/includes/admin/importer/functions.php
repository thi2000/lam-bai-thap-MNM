<?php 
	
	/**
	 * update item data
	 *
	 * @param $menu_id
	 * @param $data
	 */
	function wpopal_update_item_data( $menu_id = false, $data = array() ) {
		update_post_meta( $menu_id, 'osf_megamenu_item_data', $data );
		do_action( 'osf_menu_item_updated', $menu_id, $data );
	}

	function wpopal_get_plugin_icon_uri( $slug ){
		
		switch ( $slug ) {
	        case 'revslider':
	            $img = get_template_directory_uri() . '/assets/plugins/logo-rv.png';
	            break;
	        case 'yith-woocommerce-compare':    
	        case 'yith-woocommerce-wishlist':    
	        case 'yith-woocommerce-quick-view' : 
	            $img = 'https://ps.w.org/'.$slug.'/assets/icon-128x128.jpg';
	            break;
	        default:
	            $img = 'https://ps.w.org/'.$slug.'/assets/icon-128x128.png';
	            break;
		}

		return $img; 
	}

	function wpopal_unzip_file( $from , $to='' ){
		WP_Filesystem();
		$destination = wp_upload_dir();
		$destination_path = $to ? $to : $destination['path'];
		$unzipfile = unzip_file( $from, $to );
		   
	    if ( is_wp_error( $unzipfile ) ) {
        	return false;
	    } else {
		    return true;    
	    }
	}
?>