<?php 
    /**
     * Single product layout
     */	     
if ( ! function_exists( 'wpopal_woocommerce_get_loop_columns' ) ) {
	function wpopal_woocommerce_get_loop_columns (){
		if( !get_theme_mod("woocommerce_disable_addition_nav") ) {
			if( class_exists('WC_Session_Handler')) {
				$session = WC()->session;
				$col =  $session->get('view_cols'); 
				if( $col ) {
    		 		return $col; 
    		 	}
			} 
		} else {
			return wc_get_loop_prop( 'columns' );
		}
	}
}
	
	/**
	 * Check if a product is a deal
	 *
	 * @param int|object $product
	 *
	 * @return bool
	 */
if ( ! function_exists( 'wpopal_woocommerce_is_deal_product' ) ) {
	function wpopal_woocommerce_is_deal_product($product) {
	    $product = is_numeric($product) ? wc_get_product($product) : $product;

	    // It must be a sale product first
	    if (!$product->is_on_sale()) {
	        return false;
	    }

	    if (!$product->is_in_stock()) {
	        return false;
	    }

	    // Only support product type "simple" and "external"
	    if (!$product->is_type('simple') && !$product->is_type('external')) {
	        return false;
	    }

	    $deal_quantity = get_post_meta($product->get_id(), '_deal_quantity', true);

	    if ($deal_quantity > 0) {
	        return true;
	    }

	    return false;
	}

} 
	/**
     * print product category name inside the loop
     */
if ( ! function_exists( 'wpopal_woocommerce_product_loop_category' ) ) {
    function wpopal_woocommerce_product_loop_category() {
        global $product;
        $cat_ids = $product->get_category_ids();
        $first = isset($cat_ids[0]) ? $cat_ids[0] : false;
        if ( $first ) {
            $term = get_term( $first );
            $cate_name = $term->name;
            echo '<div class="product-cats">'.$cate_name.'</div>';
        }
    }
}

if ( ! function_exists( 'wpopal_fnc_get_review_counting' ) ) {

	function wpopal_fnc_get_review_counting() {

	    global $post;
	    $output = array();

	    for ($i = 1; $i <= 5; $i++) {
	        $args = array(
	            'post_id' => ( $post->ID ),
	            'meta_query' => array(
	                array(
	                    'key' => 'rating',
	                    'value' => $i
	                )
	            ),
	            'count' => true
	        );
	        $output[$i] = get_comments( $args );
	    }
	    return $output;
	}
}

if ( ! function_exists( 'wpopal_woocommerce_single_product_images' ) ) {
	function wpopal_woocommerce_single_product_images(){
		global $product;
		$attachment_ids = $product->get_gallery_image_ids();
		$html = '';


		foreach( $attachment_ids as $post_thumbnail_id  ){
			$html .= wc_get_gallery_image_html( $post_thumbnail_id, true );
		}

		echo $html;
	}
}

/**
 * Define Gallery Swiper
 */
if( !function_exists("wpopal_woocommerce_single_product_gallery_swiper") ) {

	function wpopal_woocommerce_single_product_gallery_swiper(){  
		global $product;

		$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$post_thumbnail_id = $product->get_image_id();
		$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );

		$data = array( 
	        'slidesPerView'  =>  1, 
	        'spaceBetween'   =>  0,
	        'loop'			 => true,
	        'effect' 		 => 'slide',
	        'thumbnails_nav' => "#swiper-pagination-products"
	    );


		// navigation setting
		$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
		$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
		
		$image_size        = apply_filters( 'woocommerce_gallery_image_size',  $thumbnail_size );
		$style = apply_filters( "wpopal_product_layout_style", get_theme_mod( 'wpopal_product_layout_style') );
		$stylecss = '';
		$datanav = array( 
	        'slidesPerView'  =>  $columns, 
	        'spaceBetween'   =>  10,
	        'effect' 		 => 'slide',
	        'watchSlidesProgress'=> true,
	        'watchSlidesVisibility'=> true,
	        'freeMode' => true,
	        'loop'			 => false
	    );
	 	if( $style == 'thumb_left_slider' || $style == 'thumb_right_slider' ) {
			$datanav['direction'] = 'vertical';
			$datanav['spaceBetween'] = 10;
		//	$stylecss = 'style="width:'.$image_size[0] .'px;"';
			$wrapper_classes[] = 'swiper-has-nav-thumbs';
			$wrapper_classes[] = 'swiper-'.str_replace( '_', '-', $style );
	 	}

		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"  data-columns="<?php echo esc_attr( $columns ); ?>"  >
			<div style="width: 100%; overflow: hidden;" class="swiper-slider-inner">
						<figure class="woocommerce-product-gallery__wrapper swiper-container wpopal-swiper-play" data-swiper="<?php echo esc_attr( wp_json_encode( $data ) ); ?>" >
								<div class="swiper-wrapper">
									<div class="swiper-slide">
										<?php
										if ( $product->get_image_id() ) {
											$html = wc_get_gallery_image_html( $product->get_image_id(), true );
										} else {
											$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
											$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'wpopalbootstrap' ) );
											$html .= '</div>';
										} 
										echo trim($html); 
										?>
									</div>	
									<?php 	
									$attachment_ids = $product->get_gallery_image_ids();
									$html = '';
									foreach( $attachment_ids as $post_thumbnail_id  ){
										$html .= '<div class="swiper-slide">'.wc_get_gallery_image_html( $post_thumbnail_id, true ).'</div>';
									}
									echo trim($html);
									?>
							</div>
							<div class="swiper-pagination"></div>
						</figure>
			<div class="swiper-pagination-images swiper-container" id="swiper-pagination-products"  data-swiper="<?php echo esc_attr( wp_json_encode( $datanav ) ); ?>" <?php echo trim( $stylecss ); ?>>
				<div class="swiper-wrapper ">
						<?php 
							$attachment_ids = $product->get_gallery_image_ids();
							$attachment_ids = array_merge( array( $product->get_image_id() ), $attachment_ids );

							if ( $attachment_ids && $product->get_image_id() ) {
								foreach ( $attachment_ids as $attachment_id ) {
									echo '<div class="swiper-slide">';
											$image   = wp_get_attachment_image(
												$attachment_id,
												$image_size ,
												false
											); 
											echo $image;
									echo '</div>';
								}
							}
						?>
				</div>	

				</div>	
			</div>			
	</div>
	<?php 	
	}
}

if ( ! function_exists( 'wpopal_woocommerce_loop_product_images_slider' ) ) {
	function wpopal_woocommerce_loop_product_images_slider(){  

		global $product;

		$post_thumbnail_id = $product->get_image_id();
		$data = array( 
	        'slidesPerView' =>  1, 
	        'spaceBetween'  =>  0,
	        'effect' => 'slide',
	        'loop'	=> 1
	    );

		?>
		 
			<figure class="woocommerce-product-gallery__wrapper swiper-container wpopal-swiper-play" data-swiper="<?php echo esc_attr( wp_json_encode( $data ) ); ?>" >
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<?php echo woocommerce_template_loop_product_thumbnail(); ?>
					</div>	
					<?php 	
					$attachment_ids = $product->get_gallery_image_ids();
		 
					$html = '';
					$size = 'shop_catalog';
					$classes          = 'attachment-' . $size . ' product-img-slider';
					foreach( $attachment_ids as $post_thumbnail_id  ){
						$html .= '<div class="swiper-slide">'.wp_get_attachment_image( $post_thumbnail_id, $size, false, array( 'class' => $classes ) ).'</div>';
					}

					echo $html;
					?>
			</div>
			<div class="swiper-pagination"></div>
		</figure>
 
	<?php 	
	}
}

if ( ! function_exists( 'wpopal_woocommerce_single_product_images_slider' ) ) {
	function wpopal_woocommerce_single_product_images_slider(){  

		global $product;

		$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$post_thumbnail_id = $product->get_image_id();
		$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );

		$data = array( 
	        'slidesPerView' =>  1, 
	        'spaceBetween'  =>  0,
	        'effect' => 'slide'
	    );

		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"  data-columns="<?php echo esc_attr( $columns ); ?>"  >
			<figure class="woocommerce-product-gallery__wrapper swiper-container wpopal-swiper-play" data-swiper="<?php echo esc_attr( wp_json_encode( $data ) ); ?>" >
				<div class="swiper-wrapper">

					<div class="swiper-slide">
						<?php
						if ( $product->get_image_id() ) {
							$html = wc_get_gallery_image_html( $product->get_image_id(), true );
						} else {
							$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
							$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
							$html .= '</div>';
						} echo $html ; ?>
					</div>	
					<?php 	
					$attachment_ids = $product->get_gallery_image_ids();
		 
					$html = '';

					foreach( $attachment_ids as $post_thumbnail_id  ){
						$html .= '<div class="swiper-slide">'.wc_get_gallery_image_html( $post_thumbnail_id, true ).'</div>';
					}

					echo $html;
					?>
			</div>
			<div class="swiper-pagination"></div>
		</figure>
		</div>
	<?php 	
	}
}


if( !function_exists("wpopal_woocommerce_single_product__gallery_sliders") ) {
	function wpopal_woocommerce_single_product__gallery_sliders(){  

		global $product;

		$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		$post_thumbnail_id = $product->get_image_id();
		$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		) );

		$data = array( 
	        'slidesPerView' =>  1, 
	        'spaceBetween'  =>  0,
	        'effect' => 'slide'
	    );

		?>
		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>"  data-columns="<?php echo esc_attr( $columns ); ?>"  >
			<figure class="woocommerce-product-gallery__wrapper swiper-container wpopal-swiper-play" data-swiper="<?php echo esc_attr( wp_json_encode( $data ) ); ?>" >
					<div class="swiper-wrapper">

						<div class="swiper-slide">
							<?php
							if ( $product->get_image_id() ) {
								$html = wc_get_gallery_image_html( $product->get_image_id(), true );
							} else {
								$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
								$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'wpopalbootstrap' ) );
								$html .= '</div>';
							} 
							echo trim($html); 
							?>
						</div>	
						<?php 	
						$attachment_ids = $product->get_gallery_image_ids();
			 
						$html = '';

						foreach( $attachment_ids as $post_thumbnail_id  ){
							$html .= '<div class="swiper-slide">'.wc_get_gallery_image_html( $post_thumbnail_id, true ).'</div>';
						}

						echo trim($html);
						?>
				</div>
				<div class="swiper-pagination"></div>
			</figure>
		</div>
	<?php 	
	}

}
?>