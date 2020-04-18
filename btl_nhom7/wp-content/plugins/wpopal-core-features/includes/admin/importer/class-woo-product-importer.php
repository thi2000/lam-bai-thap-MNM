<?php
/**
 * WooCommerce API Products Class
 *
 * Handles requests to the /products endpoint
 *
 * @author      WooThemes
 * @category    API
 * @package     WooCommerce/API
 * @since       2.1
 * @version     3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WpOpal_Core_Admin_Woo_Product_Importer {

	/** @var string $base the route base */
	protected $base = '/products';

	 
	/**
	 * Create a new product.
	 *
	 * @since 2.2
	 *
	 * @param array $data posted data
	 *
	 * @return array|WP_Error
	 */
	public function create_product( $data ) {
		$id = 0;

		try {
			if ( ! isset( $data['product'] ) ) {
				throw new WC_API_Exception( 'woocommerce_api_missing_product_data', sprintf( __( 'No %1$s data specified to create %1$s', 'wpopal' ), 'product' ), 400 );
			}

			$data = $data['product'];

			// Check permissions.
			if ( ! current_user_can( 'publish_products' ) ) {
				throw new WC_API_Exception( 'woocommerce_api_user_cannot_create_product', __( 'You do not have permission to create products', 'wpopal' ), 401 );
			}

			$data = apply_filters( 'woocommerce_api_create_product_data', $data, $this );

			// Check if product title is specified.
			if ( ! isset( $data['title'] ) ) {
				throw new WC_API_Exception( 'woocommerce_api_missing_product_title', sprintf( __( 'Missing parameter %s', 'wpopal' ), 'title' ), 400 );
			}

			// Check product type.
			if ( ! isset( $data['type'] ) ) {
				$data['type'] = 'simple';
			}

			// Set visible visibility when not sent.
			if ( ! isset( $data['catalog_visibility'] ) ) {
				$data['catalog_visibility'] = 'visible';
			}

			// Validate the product type.
			if ( ! in_array( wc_clean( $data['type'] ), array_keys( wc_get_product_types() ) ) ) {
				throw new WC_API_Exception( 'woocommerce_api_invalid_product_type', sprintf( __( 'Invalid product type - the product type must be any of these: %s', 'wpopal' ), implode( ', ', array_keys( wc_get_product_types() ) ) ), 400 );
			}

			// Enable description html tags.
			$post_content = isset( $data['description'] ) ? wc_clean( $data['description'] ) : '';
			if ( $post_content && isset( $data['enable_html_description'] ) && true === $data['enable_html_description'] ) {

				$post_content = wp_filter_post_kses( $data['description'] );
			}

			// Enable short description html tags.
			$post_excerpt = isset( $data['short_description'] ) ? wc_clean( $data['short_description'] ) : '';
			if ( $post_excerpt && isset( $data['enable_html_short_description'] ) && true === $data['enable_html_short_description'] ) {
				$post_excerpt = wp_filter_post_kses( $data['short_description'] );
			}

			$classname = WC_Product_Factory::get_classname_from_product_type( $data['type'] );
			if ( ! class_exists( $classname ) ) {
				$classname = 'WC_Product_Simple';
			}
			$product = new $classname();

			$product->set_name( wc_clean( $data['title'] ) );
			$product->set_status( isset( $data['status'] ) ? wc_clean( $data['status'] ) : 'publish' );
			$product->set_short_description( isset( $data['short_description'] ) ? $post_excerpt : '' );
			$product->set_description( isset( $data['description'] ) ? $post_content : '' );
			$product->set_menu_order( isset( $data['menu_order'] ) ? intval( $data['menu_order'] ) : 0 );

			if ( ! empty( $data['name'] ) ) {
				$product->set_slug( sanitize_title( $data['name'] ) );
			}

			// Attempts to create the new product.
			$product->save();
			$id = $product->get_id();

			// Checks for an error in the product creation.
			if ( 0 >= $id ) {
				throw new WC_API_Exception( 'woocommerce_api_cannot_create_product', $id->get_error_message(), 400 );
			}

			// Check for featured/gallery images, upload it and set it.
			if ( isset( $data['images'] ) ) {
				$product = $this->save_product_images( $product, $data['images'] );
			}

			// Save product meta fields.
			$product = $this->save_product_meta( $product, $data );
			$product->save();

			// Save variations.
			if ( isset( $data['type'] ) && 'variable' == $data['type'] && isset( $data['variations'] ) && is_array( $data['variations'] ) ) {
				$this->save_variations( $product, $data );
			}

			do_action( 'woocommerce_api_create_product', $id, $data );

			// Clear cache/transients.
			wc_delete_product_transients( $id );

			$this->server->send_status( 201 );

			return $this->get_product( $id );
		} catch ( WC_Data_Exception $e ) {
			$this->clear_product( $id );
			return new WP_Error( $e->getErrorCode(), $e->getMessage(), array( 'status' => $e->getCode() ) );
		} catch ( WC_API_Exception $e ) {
			$this->clear_product( $id );
			return new WP_Error( $e->getErrorCode(), $e->getMessage(), array( 'status' => $e->getCode() ) );
		}
	}

		/**
	 * Save product meta.
	 *
	 * @since  2.2
	 * @param  WC_Product $product
	 * @param  array $data
	 * @return WC_Product
	 * @throws WC_API_Exception
	 */
	protected function save_product_meta( $product, $data ) {
		global $wpdb;

		// Virtual.
		if ( isset( $data['virtual'] ) ) {
			$product->set_virtual( $data['virtual'] );
		}

		// Tax status.
		if ( isset( $data['tax_status'] ) ) {
			$product->set_tax_status( wc_clean( $data['tax_status'] ) );
		}

		// Tax Class.
		if ( isset( $data['tax_class'] ) ) {
			$product->set_tax_class( wc_clean( $data['tax_class'] ) );
		}

		// Catalog Visibility.
		if ( isset( $data['catalog_visibility'] ) ) {
			$product->set_catalog_visibility( wc_clean( $data['catalog_visibility'] ) );
		}

		// Purchase Note.
		if ( isset( $data['purchase_note'] ) ) {
			$product->set_purchase_note( wc_clean( $data['purchase_note'] ) );
		}

		// Featured Product.
		if ( isset( $data['featured'] ) ) {
			$product->set_featured( $data['featured'] );
		}

		// Shipping data.
		$product = $this->save_product_shipping_data( $product, $data );

		// SKU.
		if ( isset( $data['sku'] ) ) {
			$sku     = $product->get_sku();
			$new_sku = wc_clean( $data['sku'] );

			if ( '' == $new_sku ) {
				$product->set_sku( '' );
			} elseif ( $new_sku !== $sku ) {
				if ( ! empty( $new_sku ) ) {
					$unique_sku = wc_product_has_unique_sku( $product->get_id(), $new_sku );
					if ( ! $unique_sku ) {
						throw new WC_API_Exception( 'woocommerce_api_product_sku_already_exists', __( 'The SKU already exists on another product.', 'wpopal' ), 400 );
					} else {
						$product->set_sku( $new_sku );
					}
				} else {
					$product->set_sku( '' );
				}
			}
		}

		// Attributes.
		if ( isset( $data['attributes'] ) ) {
			$attributes = array();

			foreach ( $data['attributes'] as $attribute ) {
				$is_taxonomy = 0;
				$taxonomy    = 0;

				if ( ! isset( $attribute['name'] ) ) {
					continue;
				}

				$attribute_slug = sanitize_title( $attribute['name'] );

				if ( isset( $attribute['slug'] ) ) {
					$taxonomy       = $this->get_attribute_taxonomy_by_slug( $attribute['slug'] );
					$attribute_slug = sanitize_title( $attribute['slug'] );
				}

				if ( $taxonomy ) {
					$is_taxonomy = 1;
				}

				if ( $is_taxonomy ) {

					$attribute_id = wc_attribute_taxonomy_id_by_name( $attribute['name'] );

					if ( isset( $attribute['options'] ) ) {
						$options = $attribute['options'];

						if ( ! is_array( $attribute['options'] ) ) {
							// Text based attributes - Posted values are term names.
							$options = explode( WC_DELIMITER, $options );
						}

						$values = array_map( 'wc_sanitize_term_text_based', $options );
						$values = array_filter( $values, 'strlen' );
					} else {
						$values = array();
					}

					// Update post terms
					if ( taxonomy_exists( $taxonomy ) ) {
						wp_set_object_terms( $product->get_id(), $values, $taxonomy );
					}

					if ( ! empty( $values ) ) {
						// Add attribute to array, but don't set values.
						$attribute_object = new WC_Product_Attribute();
						$attribute_object->set_id( $attribute_id );
						$attribute_object->set_name( $taxonomy );
						$attribute_object->set_options( $values );
						$attribute_object->set_position( isset( $attribute['position'] ) ? absint( $attribute['position'] ) : 0 );
						$attribute_object->set_visible( ( isset( $attribute['visible'] ) && $attribute['visible'] ) ? 1 : 0 );
						$attribute_object->set_variation( ( isset( $attribute['variation'] ) && $attribute['variation'] ) ? 1 : 0 );
						$attributes[] = $attribute_object;
					}
				} elseif ( isset( $attribute['options'] ) ) {
					// Array based.
					if ( is_array( $attribute['options'] ) ) {
						$values = $attribute['options'];

					// Text based, separate by pipe.
					} else {
						$values = array_map( 'wc_clean', explode( WC_DELIMITER, $attribute['options'] ) );
					}

					// Custom attribute - Add attribute to array and set the values.
					$attribute_object = new WC_Product_Attribute();
					$attribute_object->set_name( $attribute['name'] );
					$attribute_object->set_options( $values );
					$attribute_object->set_position( isset( $attribute['position'] ) ? absint( $attribute['position'] ) : 0 );
					$attribute_object->set_visible( ( isset( $attribute['visible'] ) && $attribute['visible'] ) ? 1 : 0 );
					$attribute_object->set_variation( ( isset( $attribute['variation'] ) && $attribute['variation'] ) ? 1 : 0 );
					$attributes[] = $attribute_object;
				}
			}

			uasort( $attributes, 'wc_product_attribute_uasort_comparison' );

			$product->set_attributes( $attributes );
		}

		// Sales and prices.
		if ( in_array( $product->get_type(), array( 'variable', 'grouped' ) ) ) {

			// Variable and grouped products have no prices.
			$product->set_regular_price( '' );
			$product->set_sale_price( '' );
			$product->set_date_on_sale_to( '' );
			$product->set_date_on_sale_from( '' );
			$product->set_price( '' );

		} else {

			// Regular Price.
			if ( isset( $data['regular_price'] ) ) {
				$regular_price = ( '' === $data['regular_price'] ) ? '' : $data['regular_price'];
				$product->set_regular_price( $regular_price );
			}

			// Sale Price.
			if ( isset( $data['sale_price'] ) ) {
				$sale_price = ( '' === $data['sale_price'] ) ? '' : $data['sale_price'];
				$product->set_sale_price( $sale_price );
			}

			if ( isset( $data['sale_price_dates_from'] ) ) {
				$date_from = $data['sale_price_dates_from'];
			} else {
				$date_from = $product->get_date_on_sale_from() ? date( 'Y-m-d', $product->get_date_on_sale_from()->getTimestamp() ) : '';
			}

			if ( isset( $data['sale_price_dates_to'] ) ) {
				$date_to = $data['sale_price_dates_to'];
			} else {
				$date_to = $product->get_date_on_sale_to() ? date( 'Y-m-d', $product->get_date_on_sale_to()->getTimestamp() ) : '';
			}

			if ( $date_to && ! $date_from ) {
				$date_from = strtotime( 'NOW', current_time( 'timestamp', true ) );
			}

			$product->set_date_on_sale_to( $date_to );
			$product->set_date_on_sale_from( $date_from );

			if ( $product->is_on_sale( 'edit' ) ) {
				$product->set_price( $product->get_sale_price( 'edit' ) );
			} else {
				$product->set_price( $product->get_regular_price( 'edit' ) );
			}
		}

		// Product parent ID for groups.
		if ( isset( $data['parent_id'] ) ) {
			$product->set_parent_id( absint( $data['parent_id'] ) );
		}

		// Sold Individually.
		if ( isset( $data['sold_individually'] ) ) {
			$product->set_sold_individually( true === $data['sold_individually'] ? 'yes' : '' );
		}

		// Stock status.
		if ( isset( $data['in_stock'] ) ) {
			$stock_status = ( true === $data['in_stock'] ) ? 'instock' : 'outofstock';
		} else {
			$stock_status = $product->get_stock_status();

			if ( '' === $stock_status ) {
				$stock_status = 'instock';
			}
		}

		// Stock Data.
		if ( 'yes' == get_option( 'woocommerce_manage_stock' ) ) {
			// Manage stock.
			if ( isset( $data['managing_stock'] ) ) {
				$managing_stock = ( true === $data['managing_stock'] ) ? 'yes' : 'no';
				$product->set_manage_stock( $managing_stock );
			} else {
				$managing_stock = $product->get_manage_stock() ? 'yes' : 'no';
			}

			// Backorders.
			if ( isset( $data['backorders'] ) ) {
				if ( 'notify' === $data['backorders'] ) {
					$backorders = 'notify';
				} else {
					$backorders = ( true === $data['backorders'] ) ? 'yes' : 'no';
				}

				$product->set_backorders( $backorders );
			} else {
				$backorders = $product->get_backorders();
			}

			if ( $product->is_type( 'grouped' ) ) {
				$product->set_manage_stock( 'no' );
				$product->set_backorders( 'no' );
				$product->set_stock_quantity( '' );
				$product->set_stock_status( $stock_status );
			} elseif ( $product->is_type( 'external' ) ) {
				$product->set_manage_stock( 'no' );
				$product->set_backorders( 'no' );
				$product->set_stock_quantity( '' );
				$product->set_stock_status( 'instock' );
			} elseif ( 'yes' == $managing_stock ) {
				$product->set_backorders( $backorders );

				// Stock status is always determined by children so sync later.
				if ( ! $product->is_type( 'variable' ) ) {
					$product->set_stock_status( $stock_status );
				}

				// Stock quantity.
				if ( isset( $data['stock_quantity'] ) ) {
					$product->set_stock_quantity( wc_stock_amount( $data['stock_quantity'] ) );
				} elseif ( isset( $data['inventory_delta'] ) ) {
					$stock_quantity  = wc_stock_amount( $product->get_stock_quantity() );
					$stock_quantity += wc_stock_amount( $data['inventory_delta'] );
					$product->set_stock_quantity( wc_stock_amount( $stock_quantity ) );
				}
			} else {
				// Don't manage stock.
				$product->set_manage_stock( 'no' );
				$product->set_backorders( $backorders );
				$product->set_stock_quantity( '' );
				$product->set_stock_status( $stock_status );
			}
		} elseif ( ! $product->is_type( 'variable' ) ) {
			$product->set_stock_status( $stock_status );
		}

		// Upsells.
		if ( isset( $data['upsell_ids'] ) ) {
			$upsells = array();
			$ids     = $data['upsell_ids'];

			if ( ! empty( $ids ) ) {
				foreach ( $ids as $id ) {
					if ( $id && $id > 0 ) {
						$upsells[] = $id;
					}
				}

				$product->set_upsell_ids( $upsells );
			} else {
				$product->set_upsell_ids( array() );
			}
		}

		// Cross sells.
		if ( isset( $data['cross_sell_ids'] ) ) {
			$crosssells = array();
			$ids        = $data['cross_sell_ids'];

			if ( ! empty( $ids ) ) {
				foreach ( $ids as $id ) {
					if ( $id && $id > 0 ) {
						$crosssells[] = $id;
					}
				}

				$product->set_cross_sell_ids( $crosssells );
			} else {
				$product->set_cross_sell_ids( array() );
			}
		}

		// Product categories.
		if ( isset( $data['categories'] ) && is_array( $data['categories'] ) ) {
			$product->set_category_ids( $data['categories'] );
		}

		// Product tags.
		if ( isset( $data['tags'] ) && is_array( $data['tags'] ) ) {
			$product->set_tag_ids( $data['tags'] );
		}

		// Downloadable.
		if ( isset( $data['downloadable'] ) ) {
			$is_downloadable = ( true === $data['downloadable'] ) ? 'yes' : 'no';
			$product->set_downloadable( $is_downloadable );
		} else {
			$is_downloadable = $product->get_downloadable() ? 'yes' : 'no';
		}

		// Downloadable options.
		if ( 'yes' == $is_downloadable ) {

			// Downloadable files.
			if ( isset( $data['downloads'] ) && is_array( $data['downloads'] ) ) {
				$product = $this->save_downloadable_files( $product, $data['downloads'] );
			}

			// Download limit.
			if ( isset( $data['download_limit'] ) ) {
				$product->set_download_limit( $data['download_limit'] );
			}

			// Download expiry.
			if ( isset( $data['download_expiry'] ) ) {
				$product->set_download_expiry( $data['download_expiry'] );
			}
		}

		// Product url.
		if ( $product->is_type( 'external' ) ) {
			if ( isset( $data['product_url'] ) ) {
				$product->set_product_url( $data['product_url'] );
			}

			if ( isset( $data['button_text'] ) ) {
				$product->set_button_text( $data['button_text'] );
			}
		}

		// Reviews allowed.
		if ( isset( $data['reviews_allowed'] ) ) {
			$product->set_reviews_allowed( $data['reviews_allowed'] );
		}

		// Save default attributes for variable products.
		if ( $product->is_type( 'variable' ) ) {
			$product = $this->save_default_attributes( $product, $data );
		}

		// Do action for product type
		do_action( 'woocommerce_api_process_product_meta_' . $product->get_type(), $product->get_id(), $data );

		return $product;
	}

	/**
	 * Save product shipping data
	 *
	 * @since 2.2
	 * @param WC_Product $product
	 * @param array $data
	 * @return WC_Product
	 */
	private function save_product_shipping_data( $product, $data ) {
		if ( isset( $data['weight'] ) ) {
			$product->set_weight( '' === $data['weight'] ? '' : wc_format_decimal( $data['weight'] ) );
		}

		// Product dimensions
		if ( isset( $data['dimensions'] ) ) {
			// Height
			if ( isset( $data['dimensions']['height'] ) ) {
				$product->set_height( '' === $data['dimensions']['height'] ? '' : wc_format_decimal( $data['dimensions']['height'] ) );
			}

			// Width
			if ( isset( $data['dimensions']['width'] ) ) {
				$product->set_width( '' === $data['dimensions']['width'] ? '' : wc_format_decimal( $data['dimensions']['width'] ) );
			}

			// Length
			if ( isset( $data['dimensions']['length'] ) ) {
				$product->set_length( '' === $data['dimensions']['length'] ? '' : wc_format_decimal( $data['dimensions']['length'] ) );
			}
		}

		// Virtual
		if ( isset( $data['virtual'] ) ) {
			$virtual = ( true === $data['virtual'] ) ? 'yes' : 'no';

			if ( 'yes' == $virtual ) {
				$product->set_weight( '' );
				$product->set_height( '' );
				$product->set_length( '' );
				$product->set_width( '' );
			}
		}

		// Shipping class
		if ( isset( $data['shipping_class'] ) ) {
			$data_store        = $product->get_data_store();
			$shipping_class_id = $data_store->get_shipping_class_id_by_slug( wc_clean( $data['shipping_class'] ) );
			$product->set_shipping_class_id( $shipping_class_id );
		}

		return $product;
	}

	/**
	 * Upload image from URL
	 *
	 * @since 2.2
	 * @param string $image_url
	 * @return int|WP_Error attachment id
	 */
	public function upload_product_image( $image_url ) {
		return $this->upload_image_from_url( $image_url, 'product_image' );
	}

	/**
	 * Upload product category image from URL.
	 *
	 * @since 2.5.0
	 * @param string $image_url
	 * @return int|WP_Error attachment id
	 */
	public function upload_product_category_image( $image_url ) {
		return $this->upload_image_from_url( $image_url, 'product_category_image' );
	}

	/**
	 * Upload image from URL.
	 *
	 * @throws WC_API_Exception
	 *
	 * @since 2.5.0
	 * @param string $image_url
	 * @param string $upload_for
	 * @return array|WP_Error
	 */
	protected function upload_image_from_url( $image_url, $upload_for = 'product_image' ) {
		$file_name = basename( current( explode( '?', $image_url ) ) );
		$parsed_url = @parse_url( $image_url );

		// Check parsed URL.
		if ( ! $parsed_url || ! is_array( $parsed_url ) ) {
			throw new WC_API_Exception( 'woocommerce_api_invalid_' . $upload_for, sprintf( __( 'Invalid URL %s.', 'wpopal' ), $image_url ), 400 );
		}

		// Ensure url is valid.
		$image_url = str_replace( ' ', '%20', $image_url );

		// Get the file.
		$response = wp_safe_remote_get( $image_url, array(
			'timeout' => 10,
		) );

		if ( is_wp_error( $response ) ) {
			throw new WC_API_Exception( 'woocommerce_api_invalid_remote_' . $upload_for, sprintf( __( 'Error getting remote image %s.', 'wpopal' ), $image_url ) . ' ' . sprintf( __( 'Error: %s.', 'wpopal' ), $response->get_error_message() ), 400 );
		} elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			throw new WC_API_Exception( 'woocommerce_api_invalid_remote_' . $upload_for, sprintf( __( 'Error getting remote image %s.', 'wpopal' ), $image_url ), 400 );
		}

		// Ensure we have a file name and type.
		$wp_filetype = wp_check_filetype( $file_name, wc_rest_allowed_image_mime_types() );

		if ( ! $wp_filetype['type'] ) {
			$headers = wp_remote_retrieve_headers( $response );
			if ( isset( $headers['content-disposition'] ) && strstr( $headers['content-disposition'], 'filename=' ) ) {
				$disposition = end( explode( 'filename=', $headers['content-disposition'] ) );
				$disposition = sanitize_file_name( $disposition );
				$file_name   = $disposition;
			} elseif ( isset( $headers['content-type'] ) && strstr( $headers['content-type'], 'image/' ) ) {
				$file_name = 'image.' . str_replace( 'image/', '', $headers['content-type'] );
			}
			unset( $headers );

			// Recheck filetype
			$wp_filetype = wp_check_filetype( $file_name, wc_rest_allowed_image_mime_types() );

			if ( ! $wp_filetype['type'] ) {
				throw new WC_API_Exception( 'woocommerce_api_invalid_' . $upload_for, __( 'Invalid image type.', 'wpopal' ), 400 );
			}
		}

		// Upload the file.
		$upload = wp_upload_bits( $file_name, '', wp_remote_retrieve_body( $response ) );

		if ( $upload['error'] ) {
			throw new WC_API_Exception( 'woocommerce_api_' . $upload_for . '_upload_error', $upload['error'], 400 );
		}

		// Get filesize.
		$filesize = filesize( $upload['file'] );

		if ( 0 == $filesize ) {
			@unlink( $upload['file'] );
			unset( $upload );
			throw new WC_API_Exception( 'woocommerce_api_' . $upload_for . '_upload_file_error', __( 'Zero size file downloaded.', 'wpopal' ), 400 );
		}

		unset( $response );

		do_action( 'woocommerce_api_uploaded_image_from_url', $upload, $image_url, $upload_for );

		return $upload;
	}
	/**
	 * Save product images.
	 *
	 * @since  2.2
	 * @param  WC_Product $product
	 * @param  array $images
	 * @throws WC_API_Exception
	 * @return WC_Product
	 */
	protected function save_product_images( $product, $images ) {
		if ( is_array( $images ) ) {
			$gallery = array();

			foreach ( $images as $image ) {
				if ( isset( $image['position'] ) && 0 == $image['position'] ) {
					$attachment_id = isset( $image['id'] ) ? absint( $image['id'] ) : 0;

					if ( 0 === $attachment_id && isset( $image['src'] ) ) {
						$upload = $this->upload_product_image( esc_url_raw( $image['src'] ) );

						if ( is_wp_error( $upload ) ) {
							throw new WC_API_Exception( 'woocommerce_api_cannot_upload_product_image', $upload->get_error_message(), 400 );
						}

						$attachment_id = $this->set_product_image_as_attachment( $upload, $product->get_id() );
					}

					$product->set_image_id( $attachment_id );
				} else {
					$attachment_id = isset( $image['id'] ) ? absint( $image['id'] ) : 0;

					if ( 0 === $attachment_id && isset( $image['src'] ) ) {
						$upload = $this->upload_product_image( esc_url_raw( $image['src'] ) );

						if ( is_wp_error( $upload ) ) {
							throw new WC_API_Exception( 'woocommerce_api_cannot_upload_product_image', $upload->get_error_message(), 400 );
						}

						$attachment_id = $this->set_product_image_as_attachment( $upload, $product->get_id() );
					}

					$gallery[] = $attachment_id;
				}

				// Set the image alt if present.
				if ( ! empty( $image['alt'] ) && $attachment_id ) {
					update_post_meta( $attachment_id, '_wp_attachment_image_alt', wc_clean( $image['alt'] ) );
				}

				// Set the image title if present.
				if ( ! empty( $image['title'] ) && $attachment_id ) {
					wp_update_post( array( 'ID' => $attachment_id, 'post_title' => $image['title'] ) );
				}
			}

			if ( ! empty( $gallery ) ) {
				$product->set_gallery_image_ids( $gallery );
			}
		} else {
			$product->set_image_id( '' );
			$product->set_gallery_image_ids( array() );
		}

		return $product;
	}

	/**
	 * Sets product image as attachment and returns the attachment ID.
	 *
	 * @since 2.2
	 * @param array $upload
	 * @param int $id
	 * @return int
	 */
	protected function set_product_image_as_attachment( $upload, $id ) {
		return $this->set_uploaded_image_as_attachment( $upload, $id );
	}

	/**
	 * Sets uploaded category image as attachment and returns the attachment ID.
	 *
	 * @since  2.5.0
	 * @param  integer $upload Upload information from wp_upload_bits
	 * @return int             Attachment ID
	 */
	protected function set_product_category_image_as_attachment( $upload ) {
		return $this->set_uploaded_image_as_attachment( $upload );
	}

	/**
	 * Set uploaded image as attachment.
	 *
	 * @since  2.5.0
	 * @param  array $upload Upload information from wp_upload_bits
	 * @param  int   $id     Post ID. Default to 0.
	 * @return int           Attachment ID
	 */
	protected function set_uploaded_image_as_attachment( $upload, $id = 0 ) {
		$info    = wp_check_filetype( $upload['file'] );
		$title   = '';
		$content = '';

		if ( $image_meta = @wp_read_image_metadata( $upload['file'] ) ) {
			if ( trim( $image_meta['title'] ) && ! is_numeric( sanitize_title( $image_meta['title'] ) ) ) {
				$title = wc_clean( $image_meta['title'] );
			}
			if ( trim( $image_meta['caption'] ) ) {
				$content = wc_clean( $image_meta['caption'] );
			}
		}

		$attachment = array(
			'post_mime_type' => $info['type'],
			'guid'           => $upload['url'],
			'post_parent'    => $id,
			'post_title'     => $title,
			'post_content'   => $content,
		);

		$attachment_id = wp_insert_attachment( $attachment, $upload['file'], $id );
		if ( ! is_wp_error( $attachment_id ) ) {
			wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );
		}

		return $attachment_id;
	}
}
