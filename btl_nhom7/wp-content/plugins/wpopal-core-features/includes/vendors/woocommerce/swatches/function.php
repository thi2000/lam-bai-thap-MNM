<?php 


/**
 * Get attribute's properties
 *
 * @param string $taxonomy
 *
 * @return object
 */
function get_tax_attribute( $taxonomy ) {
    global $wpdb;

    $attr = substr( $taxonomy, 3 );
    $attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attr'" );

    return $attr;
}

/**
 *
 */
function wpopal_woocommerce_render_variable() {  
    /**
     * @var $product WC_Product_Variable
     */
 
    global $product;
    if ($product->is_type('variable')) {
        $attr_name = 'pa_color';
        $variables = $product->get_variation_attributes()[$attr_name];
        $attr      =  get_tax_attribute($attr_name);

        $options   = $product->get_available_variations();

        $html      = '<div class="woo-wrap-swatches"><div class="inner">';
        $terms     = wc_get_product_terms($product->get_id(), $attr_name, array('fields' => 'all'));
        foreach ($terms as $term) {
            if (in_array($term->slug, $variables)) {
                $html .= wpopal_woocommerce_get_swatch_html( $term, $attr, $options, $attr_name );
            }
        }

        $html .= '</div></div>';
        echo $html;
    }
}

/**
 *
 */
function wpopal_woocommerce_get_swatch_html( $term, $attr, $options, $attr_name ) { 

    $data      = '';
    $selected  = '';
    $attr_name = 'attribute_' . $attr_name;
    $name      = esc_html(apply_filters('woocommerce_variation_option_name', $term->name));
    $image     = array();
    foreach ($options as $option) {
        foreach ($option['attributes'] as $_k => $_v) {
            if ($_k === $attr_name && $_v === $term->slug) {
                $image = $option['image'];
                break;
            }
            if (count($image) > 0) {
                break;
            }
        }
    }

    $type = $attr->attribute_type; 
    
    switch ( $type ):
        case 'color':
            $color = sanitize_hex_color( get_term_meta( $term->term_id, 'product_attribute_color', true ) );
            $data  .= sprintf( '<span class="variable-item-span variable-item-span-%s" style="background-color:%s;"></span>', esc_attr( $type ), esc_attr( $color ) );
            break;
        
        case 'image':
            $attachment_id = absint( get_term_meta( $term->term_id, 'product_attribute_image', true ) );
            $image_size    = 'thumbnail';
            $image_url     = wp_get_attachment_image_url( $attachment_id, apply_filters( 'wpopal_product_attribute_image_size', $image_size ) );
            $data          .= sprintf( '<img alt="%s" src="%s" />', esc_attr( $term->name ), esc_url( $image_url ) );
            break;
        
        case 'button':
            $data .= sprintf( '<span class="variable-item-span variable-item-span-%s">%s</span>', esc_attr( $type ), esc_html( $term->name ) );
            break;
        
        case 'radio':
            $id   = uniqid( $term->slug );
            $data .= sprintf( '<input name="%1$s" id="%2$s" class="wvs-radio-variable-item" %3$s  type="radio" value="%4$s" data-value="%4$s" /><label for="%2$s">%5$s</label>', $name, $id, checked( sanitize_title( $args[ 'selected' ] ), $term->slug, false ), esc_attr( $term->slug ), esc_html( $term->name ) );
            break;
        
        default:
            $data .= apply_filters( 'wvs_variable_default_item_content', '', $term, $args, $saved_attribute );
            break;
    endswitch;
 
    return $data;
}
?>