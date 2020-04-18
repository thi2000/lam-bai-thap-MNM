<?php
/**
 * Comment layout.
 *
 * @package wpopal
 */

add_action( 'customize_register', 'wpopal_remove_customize_register', 11 );
function wpopal_remove_customize_register() {     
	global $wp_customize;
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_section( 'header_image');
} 


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
 