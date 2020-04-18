<?php
defined( 'ABSPATH' ) || exit();

/**
 * @Class WpOpal_Core_Admin_Image_Helper
 *
 * Create image placehold for type are png, jpg in a folder using GB libs
 */
class WpOpal_Core_Admin_Image_Helper {

	/**
	 * Check folder  and sub folder existed or not then create
	 */
	public static function create_dir( $basedir, $dirs ) {

		$dir = $basedir;
		$tmp = explode( "/", $dirs );
		foreach ( $tmp as $tdir ) {
			if ( ! is_dir( $dir . '/' . $tdir ) ) {
				mkdir( $dir . '/' . $tdir, 0777 );
			}
			$dir = $dir . '/' . $tdir;
		}
	}

	/**
	 * Function that has all the magic create jpg, png placehold
	 */
	public static function create_image( $width, $height, $bg_color, $txt_color, $folder ) {
		//Define the text to show
		$text = "$width X $height";
		//Create the image resource
		$image = ImageCreate( $width, $height );

		//We are making two colors one for BackGround and one for ForGround
		$bg_color = ImageColorAllocate( $image, base_convert( substr( $bg_color, 0, 2 ), 16, 10 ),
			base_convert( substr( $bg_color, 2, 2 ), 16, 10 ),
			base_convert( substr( $bg_color, 4, 2 ), 16, 10 ) );

		$txt_color = ImageColorAllocate( $image, base_convert( substr( $txt_color, 0, 2 ), 16, 10 ),
			base_convert( substr( $txt_color, 2, 2 ), 16, 10 ),
			base_convert( substr( $txt_color, 4, 2 ), 16, 10 ) );

		//Fill the background color
		ImageFill( $image, 0, 0, $bg_color );

		//Calculating (Actually astimationg :) ) font size
		$fontsize = ( $width > $height ) ? ( $height / 10 ) : ( $width / 10 );

		//Write the text .. with some alignment astimations
		//	imagettftext($image,$fontsize, 0, ($width/2) - ($fontsize * 2.75), ($height/2) + ($fontsize* 0.2), $txt_color, 'Crysta.ttf', $text);

		//Tell the browser what kind of file is come in
		// header("Content-Type: image/png");
		if ( preg_match( "#.png#", $folder ) ) {
			//Output the newly created image in png format
			imagepng( $image, $folder );
		}

		if ( preg_match( "#.jpg#", $folder ) || preg_match( "#.jpeg#", $folder ) ) {
			//Output the newly created image in png format
			imagejpeg( $image, $folder );
		}

		//Free up resources
		ImageDestroy( $image );
	}
}


/**
 * @Class WpOpal_Core_Admin_Content_Importer
 *
 * Import post data and download all attachments
 */
class WpOpal_Core_Admin_Content_Importer {

	/**
	 * Regular expression for checking if a post references an attachment
	 *
	 * Note: This is a quick, weak check just to exclude text-only posts. More
	 * vigorous checking is done later to verify.
	 */
	const REGEX_HAS_ATTACHMENT_REFS = '!
		(
			# Match anything with an image or attachment class
			class=[\'"].*?\b(wp-image-\d+|attachment-[\w\-]+)\b
		|
			# Match anything that looks like an upload URL
			src=[\'"][^\'"]*(
				[0-9]{4}/[0-9]{2}/[^\'"]+\.(jpg|jpeg|png|gif)
			|
				content/uploads[^\'"]+
			)[\'"]
		)!ix';

	/**
	 * @protected $exists
	 */
	protected $exists;

	/**
	 * @var String $base_url
	 */
	protected $base_url = '';

	/**
	 * @protected $url_remap
	 */
	protected $url_remap = [];

	/**
	 * @protected  Array $data
	 */
	protected $data;

	/**
	 * Set import data and load all existed posts
	 */
	public function set_data( $data ) {
		$this->prefill_existing_posts();
		$this->base_url = $data['oldurl'];
		$this->data     = $data;

		return $this;
	}

	/**
	 * Load all posts in database store in existed collection using for checking new item imported or not.
	 */
	protected function prefill_existing_posts() {
		global $wpdb;
		$posts = $wpdb->get_results( "SELECT ID, guid, post_name FROM {$wpdb->posts}" );

		$this->exists['post'] = [];
		foreach ( $posts as $item ) {
			$this->exists['post'][ $item->post_name ] = $item->ID;
		}
	}

	/**
	 * Has post existed in flag collection.
	 */
	public function is_post_existed( $item ) {
		return isset( $this->exists['post'][ $item['post_name'] ] ) ? $this->exists['post'][ $item['post_name'] ] : 0;

	}

	/**
	 * Add to flag post to fix duplicating post
	 */
	public function add_post_existed( $item ) {
		$this->exists['post'][ $item['post_name'] ] = true;

		return true;
	}

	/**
	 * Find any relate to image, link to replace by new
	 */
	protected function process_in_content( $content ) {

		return $content;
	}

	/**
	 * import content
	 */
	public function import_content( $data = [] ) {

		if ( empty( $data ) ) {
			$data = $this->data['posts'];
		}

		if ( $data ) {

			foreach ( $data as $post ) {
				/// check if post is existed /// // /////
				$post['post']['post_author'] = get_current_user_id();
				// // // // //
				if ( ! $this->is_post_existed( $post['post'] ) ) {

					$post['post']['post_content'] = $this->process_in_content( $post['post']['post_content'] );

					$old_id = $post['post']['ID'];
					unset( $post['post']['ID'] );

					$post_id = wp_insert_post( $post['post'], true );

					add_post_meta( $post_id, 'wpopal_import_id', $old_id );

					if ( isset( $post['postmeta'] ) && $post['postmeta'] ) {
						$this->import_post_meta( $post_id, $post );
					}

					if ( isset( $post['thumbnail_id'] ) && $post['thumbnail_id'] ) {
						$attachment_id = $this->get_attachment_id( 'wpopal_import_id', $post['thumbnail_id'] );
						set_post_thumbnail( $post_id, $attachment_id );
					}

					if ( isset( $post['taxonomy'] ) ) {
						$this->create_terms( $post_id, $post['taxonomy'] );
					}
					$this->maybe_flush_post( $post_id );
					$this->add_post_existed( $post['post'] );
				}
			}
		}

		// import term meta
		if ( isset( $this->data['taxonomy_meta'] ) && ! empty( $this->data['taxonomy_meta'] ) ) {
			$term_metas = $this->data['taxonomy_meta'];
			$this->create_terms_metas( $term_metas );
		}
	}

	/**
	 * Import post metadata and fix old to new ids, and fix issue with meta data of elementor....
	 */
	protected function import_post_meta( $post_id, $post ) {
		foreach ( $post['postmeta'] as $key => $value ) {
			$value = maybe_unserialize( $value );

			switch ( $key ) {
				case '_thumbnail_id' :
				case '_thumbnail_id2':
				case '_format_audio_attachment':
				case '_format_video_attachment':
				case '_format_video_attachment_poster':
				case '_format_gallery_type':
				case '_product_image_gallery':
					$value = $this->update_gallery_ids( $value );
					break;
				case '_elementor_data':
					$value = $this->update_elementor_data( $value );
					$value = wp_slash( $value );
					break;

				default:
					# code...
					break;
			}

			update_post_meta( $post_id, $key, $value );
		}
	}

	protected function create_terms_metas( $post_terms ) {
		foreach ( $post_terms as $tax => $term ) {
			if ( ! taxonomy_exists( $tax ) ) {
				continue;
			}

			foreach ( $term as $key => $metas ) {
				$term = term_exists( $key, $tax );
				if ( $term && ! empty( $metas ) ) {
					$term_id    = intval( $term['term_id'] );
					$image_keys = apply_filters( 'wpopal_term_meta_key_imported', [
						'image_id',
						'avatar_id',
						'banner_id',
					] );

					foreach ( $metas as $meta_key => $meta_value ) {
						// check key images to replace news
						if ( preg_match( "#" . implode( "|", $image_keys ) . "#", $meta_key ) ) {
							$new_value = $this->get_attachment_id( 'wpopal_import_id', $meta_value );
							if ( $new_value ) {
								update_term_meta( $term_id, $meta_key, $new_value );

								$tmp = str_replace( '_id', '', $meta_key );
								update_term_meta( $term_id, $tmp, wp_get_attachment_url( $new_value ) );
							}
						} else {
							update_term_meta( $term_id, $meta_key, $meta_value );
						}
					}
				}
			}
		}
	}

	/**
	 * Create taxomnomies and set relationshop with post
	 */
	protected function create_terms( $post_id = 0, $post_terms ) {

		foreach ( $post_terms as $tax => $term ) {


			if ( ! taxonomy_exists( $tax ) ) {
				continue;
			}

			$add_terms = [];
			foreach ( $term as $key => $value ) {
				$term = term_exists( $value, $tax );


				/// $add_terms[]  = intval($term['term_id']);
				if ( ! $term ) {
					$parent_term    = $value != "0" ? get_term_by( 'name', $key, $tax ) : (object) [ 'term_id' => "0" ];
					$parent_term_ID = isset( $parent_term->term_id ) ? (int) $parent_term->term_id : 0;
					$term_args      = $parent_term_ID ? [ 'parent' => $parent_term_ID ] : [];

					$term = wp_insert_term(
						$value,
						$tax,
						$term_args
					);

					if ( is_wp_error( $term ) ) {
						continue;
					}
				}
				$add_terms[] = intval( $term['term_id'] );
			}

			if ( $add_terms && $post_id ) {
				wp_set_post_terms( $post_id, $add_terms, $tax, true );
			}
		}
	}

	/**
	 * Start import data sample
	 */
	public function import_sample() {

		if ( isset( $this->data['sample'] ) ) {
			$samples = $this->data['sample'];

			foreach ( $samples as $post ) {
				if ( isset( $post['post'] ) ) {
					$repeat   = isset( $post['repeat'] ) ? (int) $post['repeat'] : 1;
					$title    = $post['post']['post_title'];
					$post_ids = [];

					// import repeat post item
					for ( $i = 1; $i <= $repeat; $i++ ) {
						$slug                        = $post['prefix'] . '-' . $i;
						$post['post']['post_title']  = $title . " " . $i;
						$post['post']['post_name']   = $slug;
						$post['post']['post_author'] = get_current_user_id();
						$post['post']['post_status'] = "publish";
						$post_id                     = $this->is_post_existed( $post['post'] );


						if ( ! $post_id ) {
							$post_id = wp_insert_post( $post['post'], true );
						}


						if ( isset( $post['taxonomy'] ) ) {
							$this->create_terms( $post_id, $post['taxonomy'] );
						}
						//// import post meta
						if ( isset( $post['postmeta'] ) ) {
							$this->import_post_meta( $post_id, $post );
						}
						$post_ids[] = $post_id;
					}

					///
					$attachment_ids = [];
					if ( isset( $post['images'] ) ) {
						foreach ( $post['images'] as $image ) {
							$slug  = str_replace( ".", "-", basename( $image ) );
							$_post = [
								"guid"      => $image,
								"post_name" => $slug,
								"post_date" => "2018-11-08 01:40:34",
							];

							$attachment_id = $this->is_post_existed( $_post );

							if ( ! $attachment_id ) {
								$attachment_id = $this->process_attachment( $_post, $_post['guid'] );
							}

							$attachment_ids[] = $attachment_id;
						}
						if ( $attachment_ids ) {
							foreach ( $post_ids as $post_id ) {
								set_post_thumbnail( $post_id, $attachment_ids[0] );
							}
							if ( isset( $post['gallery_meta'] ) && is_string( $post['gallery_meta'] ) && is_array( $attachment_ids ) ) {
								update_post_meta( $post_id, $post['gallery_meta'], implode( ",", $attachment_ids ) );
							}
						}
					}
					///
				}
			}
		}

		return true;
	}

	/**
	 * update old ids to new ids for gallery type.
	 */
	public function update_gallery_ids( $value ) {

		if ( strpos( $value, ',' ) !== false ) {
			$value   = explode( ",", $value );
			$gallery = [];
			foreach ( $value as $gallery_key => $gallery_value ) {
				if ( $get_new_attachment = $this->get_attachment_id( 'wpopal_import_id', $gallery_value ) ) {
					$gallery[] = $get_new_attachment;
				}
			}

			return implode( ",", $gallery );
		} else {
			return $this->get_attachment_id( 'wpopal_import_id', $value );
		}

	}

	/**
	 * Get the attachment ID
	 */
	public function get_attachment_id( $key, $value ) {

		global $wpdb;

		$meta = $wpdb->get_results( "
                            SELECT *
                            FROM $wpdb->postmeta
                            WHERE
                            meta_key='" . $key . "'
                            AND
                            meta_value='" . $value . "'
                        " );

		if ( is_array( $meta ) && ! empty( $meta ) && isset( $meta[0] ) ) {
			$meta = $meta[0];
		}

		if ( is_object( $meta ) ) {
			return $meta->post_id;
		} else {
			return null;
		}
	}

	/**
	 * Process to import attachment with download files from live server and flag old in metadata using for fixing IDs
	 */
	public function import_media( $attachments = [] ) {

		$attachments = $attachments ? $attachments : $this->data['attachments'];

		if ( $attachments ) {

			foreach ( $attachments as $import_id => $data ) {
				if ( ! $this->is_post_existed( $data ) ) {
					$post_id = $this->process_attachment( $data, $data['guid'] );

					if ( $post_id ) {

						update_post_meta( $post_id, 'wpopal_import_id', $data['id'] );
						update_post_meta( $post_id, 'wpopal_import_url', $data['guid'] );
						$this->add_post_existed( $data );
					} else {

					}
				}
			}

			// replace all url in post contents
			$this->replace_attachment_urls_in_content();

			return true;
		}

		return false;
	}

	/**
	 * Update _thumbnail_id meta to new, imported attachment IDs
	 */
	public function remap_featured_images() {


	}

	/**
	 * try to use _wp_attached file for upload folder placement to ensure the same location as the export site
	 */
	public function process_attachment( $post, $remote_url ) {

		// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
		// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
		$post['upload_date'] = $post['post_date'];

		// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
		if ( preg_match( '|^/[\w\W]+$|', $remote_url ) ) {
			$remote_url = rtrim( $this->base_url, '/' ) . $remote_url;
		}

		$upload = $this->fetch_remote_file( $remote_url, $post );

		$file_name = basename( $remote_url );
		if ( is_wp_error( $upload ) ) {
			return $upload;
		}

		$info = wp_check_filetype( $upload['file'] );
		if ( ! $info ) {
			return new \WP_Error( 'attachment_processing_error', __( 'Invalid file type', 'fw-core' ) );
		}

		$post['post_mime_type'] = $info['type'];

		// WP really likes using the GUID for display. Allow updating it.
		// See https://core.trac.wordpress.org/ticket/33386

		$post['guid'] = $upload['url'];
		if ( empty( $post['post_name'] ) ) {
			$post['post_name'] = str_replace( ".", "-", $file_name );
		}
		// as per wp-admin/includes/upload.php
		$post_id = wp_insert_attachment( $post, $upload['file'] );
		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		$attachment_metadata = wp_generate_attachment_metadata( $post_id, $upload['file'] );
		wp_update_attachment_metadata( $post_id, $attachment_metadata );

		// Map this image URL later if we need to
		$this->url_remap[ $remote_url ] = $upload['url'];

		// If we have a HTTPS URL, ensure the HTTP URL gets replaced too
		if ( substr( $remote_url, 0, 8 ) === 'https://' ) {
			$insecure_url                     = 'http' . substr( $remote_url, 5 );
			$this->url_remap[ $insecure_url ] = $upload['url'];
		}

		return $post_id;
	}

	/**
	 * Create a image placehold of post in default folder 2018/05
	 */
	protected function create_placehold_image( $data ) {

		if ( ! empty( $data ) && isset( $data['allowed'] ) && $data['allowed'] && function_exists( "ImageCreate" ) ) {

			$image_folder  = '2018/05/';
			$wp_upload_dir = wp_upload_dir();
			$dir_up        = $wp_upload_dir['basedir'] . '/' . $image_folder;

			if ( ! is_dir( $dir_up ) ) {
				WpOpal_Core_Admin_Image_Helper::create_dir( $wp_upload_dir['basedir'], $image_folder );
			}

			$default = [
				'allowed'   => 0,
				'height'    => 900,
				'width'     => 900,
				'file_name' => '',
			];

			$data = array_merge( $default, $data );

			if ( $data['file_name'] ) {
				$file_name = $data['file_name'];
			}

			$upp = $dir_up . $file_name;
			if ( ! is_file( $upp ) ) {
				WpOpal_Core_Admin_Image_Helper::create_image( $data['width'], $data['height'], 'CCCCCC', 'DDDDDD', $upp );
			}
			$wp_filetype = wp_check_filetype( $file_name, null );

			$upload = [
				'file'  => $upp,
				'url'   => $wp_upload_dir['baseurl'] . '/' . $image_folder . $file_name,
				'type'  => $wp_filetype['type'],
				'error' => false,
			];

			return $upload;
		}

		return false;
	}

	/**
	 * Attempt to download a remote file attachment
	 */
	protected function fetch_remote_file( $url, $post ) {

		// extract the file name and extension from the url
		$file_name = basename( $url );

		if ( preg_match( "#.png#", $file_name ) || preg_match( "#.jpg#", $file_name ) || preg_match( "#.jpeg#", $file_name ) ) {
			$data   = apply_filters( 'wpopal_import_attachment_image_size', $url );
			$upload = $this->create_placehold_image( $data );
			if ( $upload ) {
				return $upload;
			}
		}

		// get placeholder file in the upload dir with a unique, sanitized filename
		$upload = wp_upload_bits( $file_name, 0, '', $post['upload_date'] );

		if ( $upload['error'] ) {
			return new \WP_Error( 'upload_dir_error', $upload['error'] );
		}

		// fetch the remote url and write it to the placeholder file
		$response = wp_remote_get( $url, [
			'stream'   => true,
			'filename' => $upload['file'],
			'timeout'  => apply_filters( 'wpopal_for_downloading_import_media_file', 30 ),
		] );

		// request failed
		if ( is_wp_error( $response ) ) {
			unlink( $upload['file'] );

			return $response;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );

		// make sure the fetch was successful
		if ( $code !== 200 ) {
			unlink( $upload['file'] );

			return new \WP_Error(
				'import_file_error',
				sprintf(
					__( 'Remote server returned %1$d %2$s for %3$s', 'fw-core' ),
					$code,
					get_status_header_desc( $code ),
					$url
				)
			);
		}

		$filesize = filesize( $upload['file'] );
		$headers  = wp_remote_retrieve_headers( $response );

		if ( 0 === $filesize ) {
			unlink( $upload['file'] );

			return new \WP_Error( 'import_file_error', __( 'Zero size file downloaded', 'fw-core' ) );
		}

		$max_size = (int) $this->max_attachment_size();
		if ( ! empty( $max_size ) && $filesize > $max_size ) {
			unlink( $upload['file'] );
			$message = sprintf( __( 'Remote file is too large, limit is %s', 'fw-core' ), size_format( $max_size ) );

			return new \WP_Error( 'import_file_error', $message );
		}

		return $upload;
	}

	/**
	 * Decide what the maximum file size for downloaded attachments is.
	 * Default is 0 (unlimited), can be filtered via import_attachment_size_limit
	 */
	protected function max_attachment_size() {
		return apply_filters( 'import_attachment_size_limit', 0 );
	}

	/**
	 * Use stored mapping information to update old attachment URLs
	 */
	protected function replace_attachment_urls_in_content() {
		global $wpdb;
		// make sure we do the longest urls first, in case one is a substring of another
		uksort( $this->url_remap, [ $this, 'cmpr_strlen' ] );

		foreach ( $this->url_remap as $from_url => $to_url ) {
			// remap urls in post_content
			$query = $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url );
			$wpdb->query( $query );

			// remap enclosure urls
			$query  = $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url );
			$result = $wpdb->query( $query );
		}
	}

	/*
	 * return the difference in length between two strings
	 */
	public function cmpr_strlen( $a, $b ) {
		return strlen( $b ) - strlen( $a );
	}


	/**
	 * Flush post data
	 */
	private function maybe_flush_post( $post_id ) {
		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) && get_post_meta( $post_id, '_elementor_version', true ) ) {
			$post_css_file = new \Elementor\Core\Files\CSS\Post( $post_id );
			$post_css_file->update();
		}
	}

	/**
	 * Using regular express find image id and url and then update new id, url of image.
	 * and replace all in json string format.
	 */
	public function update_elementor_data( $meta ) {

		$matches     = [];
		$attach_keys = apply_filters( "wpopal_content_elementor_importer",
			[ 'image', 'staff_img', 'customer_img', 'poster', 'media', 'src', 'bg_image', 'image_logo', 'background_image', 'background_overlay_image', 'background_a1_image', 'image_overlay' ] );

		foreach ( $attach_keys as $attach_key ) {
			preg_match_all( '/\s*"' . $attach_key . '"\s*:\s*(.+?)\s*\}/', $meta, $images, PREG_SET_ORDER );
			if ( ! empty( $images ) ) {
				$matches = array_merge( $matches, $images );
			}
		}

		preg_match_all( '/\{\s*"wp_gallery"\s*:\s*(.+?)\s*\}\]/', $meta, $wp_gallery, PREG_SET_ORDER );
		if ( isset( $wp_gallery[0][0] ) ) {
			preg_match_all( '/\{\"id":.*?\}/', $wp_gallery[0][0], $gallery );
			$matches[] = $gallery[0];
		}

		foreach ( $matches as $image ) {

			if ( ! isset( $image[0] ) ) {
				continue;
			}

			$image = $image[0];

			preg_match( '/\"id":(\d*)/', $image, $image_id );

			$image_id = isset( $image_id[1] ) ? strval( $image_id[1] ) : 0;
			if ( $image_id ) {

				preg_match( '/\"url":\"(.*?)\"/', $image, $image_url );
				$image_url = $image_url[1];

				$new_image_id = $this->get_attachment_id( 'wpopal_import_id', $image_id );
				if ( $new_image_id ) {
					$new_image_url = wp_get_attachment_url( $new_image_id );
					if ( $new_image_url ) {
						$new_image = str_replace( '"id":' . $image_id, '"id":' . $new_image_id, $image );
						$new_image = str_replace( '"url":"' . $image_url, '"url":"' . str_replace( '/', '\/', $new_image_url ), $new_image );
						$meta      = str_replace( $image, $new_image, $meta );
					}
				}
			}
		}

		// fix contact form
		preg_match( '#\"cf_id\":\"(\d+)\"#', $meta, $matches );
		if ( ! empty( $matches ) && count( $matches ) == 2 ) {
			$new_id = $this->get_attachment_id( 'wpopal_import_id', $matches[1] );
			if ( $new_id ) {
				$meta = str_replace( '"cf_id":"' . $matches[1] . '"', '"cf_id":"' . $new_id . '"', $meta );
			}
		}

		return $meta;
	}

	/**
	 * Convert Array to object
	 */
	public function convert_to_object( $array ) {
		$object = new stdClass();
		foreach ( $array as $key => $value ) {
			$object->{$key} = $value;
		}

		return $object;
	}

	/**
	 * Import menu structures
	 *
	 */
	public function import_menu( $mode = 'append', $missing = 'skip', $default = null ) {

		if ( $this->data['menu'] ) {

			$json_menus = $this->data['menu'];

			set_theme_mod( 'nav_menu_locations', [] );

			// $json object may contain a single menu definition object or array of menu objects
			if ( ! is_array( $json_menus ) ) {
				$json_menus = [ $json_menus ];
			}


			$locations = get_nav_menu_locations();

			foreach ( $json_menus as $menu ) :

				$menu = $this->convert_to_object( $menu );

				if ( isset( $menu->location ) && isset( $locations[ $menu->location ] ) ) :
					$menu_id = $locations[ $menu->location ];
				elseif ( isset( $menu->name ) ) :
					// If we can't find a menu by this name, create one.
					if ( $menu_object = wp_get_nav_menu_object( $menu->name ) ) :
						$menu_id = $menu_object->term_id;
					else :
						$menu_object_id = wp_create_nav_menu( $menu->name );
						if ( (int) $menu_object_id ) {
							$menu_id = $menu_object_id;
						} else {
							continue;
						}
					endif;
				else : // if no location or name is supplied, we have nowhere to put any additional info in this object.
					//	echo  '<pre> ha cont tien' . '-' . print_r( $menu ,1 ); die;
					continue;
				endif;

				$new_menu = [];

				if ( isset ( $menu->items ) && is_array( $menu->items ) ) : foreach ( $menu->items as $item ) :

					// merge in existing items here
					$item = $this->convert_to_object( $item );

					$old_id = $item->id;

					// Build $item_array from supplied data
					$item_array = [
						'menu-item-title'  => ( isset( $item->title ) ? $item->title : false ),
						'menu-item-status' => 'publish',
					];

					if ( isset( $item->page ) && $page = get_page_by_path( $item->page ) ) { // @todo support lookup by title

						$item_array['menu-item-type']      = 'post_type';
						$item_array['menu-item-object']    = 'page';
						$item_array['menu-item-object-id'] = $page->ID;
						$item_array['menu-item-title']     = ( $item_array['menu-item-title'] ) ?: $page->post_title;
					} elseif ( isset ( $item->taxonomy ) && isset( $item->term ) && $term = get_term_by( 'name', $item->term, $item->taxonomy ) ) {
						$item_array['menu-item-type']      = 'taxonomy';
						$item_array['menu-item-object']    = $term->taxonomy;
						$item_array['menu-item-object-id'] = $term->term_id;
						$item_array['menu-item-title']     = ( $item_array['menu-item-title'] ) ?: $term->name;
					} elseif ( isset( $item->url ) ) {
						$item_array['menu-item-url']   = ( 'http' == substr( $item->url, 0, 4 ) ) ? esc_url( $item->url ) : "#";
						$item_array['menu-item-title'] = ( $item_array['menu-item-title'] ) ?: $item->url;
					} else {
						$item_array['menu-item-url']   = "#";
						$item_array['menu-item-title'] = ( $item_array['menu-item-title'] ) ?: $item->url;
					}

					$slug              = isset( $item->slug ) ? $item->slug : sanitize_title_with_dashes( $item_array['menu-item-title'] );
					$new_menu[ $slug ] = [];

					if ( isset( $item->parent ) && $item->parent ) {

						$new_id       = $this->get_attachment_id( 'wpopal_imported_menu_id', $item->parent );
						$item->parent = $new_id ? $new_id : $item->parent;
						if ( $new_id ) {
							$item_array['menu-item-parent-id'] = $item->parent;
						} else {
							$item_array['menu-item-parent-id'] = isset( $new_menu[ $item->parent ]['id'] ) ? $new_menu[ $item->parent ]['id'] : 0;
						}
						$new_menu[ $slug ]['parent'] = $item->parent;
					}

					$post = [
						'post_name' => $slug,
					];

					if ( $this->is_post_existed( $post ) ) {
					} else {

						$new_menu[ $slug ]['id'] = wp_update_nav_menu_item( $menu_id, 0, $item_array );

						$post = [
							'ID'        => $new_menu[ $slug ]['id'],
							'post_name' => $slug,
						];
						wp_update_post( $post );
						add_post_meta( $post['ID'], 'wpopal_imported_menu_id', $old_id );
						wp_set_object_terms( $new_menu[ $slug ]['id'], [ (int) $menu_id ], 'nav_menu' );
						$this->add_post_existed( $post );
					}
				endforeach; endif;
			endforeach;
		}

		if ( isset( $this->data['megamenu'] ) ) {
			if ( function_exists( "wpopal_update_item_data" ) ) {
				foreach ( $this->data['megamenu'] as $menu_id => $data ) {
					$new_id = $this->get_attachment_id( 'wpopal_imported_menu_id', $menu_id );
					if ( $new_id ) {
						if ( isset( $data['item_data'] ) && $data['item_data'] ) {
							wpopal_update_item_data( $new_id, $data['item_data'] );
						}
						if ( isset( $data['item_data'] ) && $data['item_data'] ) {
							update_post_meta( $new_id, 'opal_elementor_post_name', $data['related'] );
						}
					}
				}
			}
		}
	}
}
