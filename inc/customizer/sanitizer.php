<?php
/**
 * Here where all of the sanitation functions happens or called.
 *
 * @package AJAW
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ajaw_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ajaw_customize_partial_blogdescription() {
	bloginfo( 'description' );
}


/**
 * Image sanitization
 *
 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
 */

function ajaw_sanitize_image( $image, $setting ){
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );

    $file = wp_check_filetype( $image, $mimes );

    // If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}


/**
 * Header Sanitization
 */
function ajaw_sanitize_logo_title_select( $logo_opt ){
	if ( ! in_array( $logo_opt, array( 'text-only', 'logo-only', 'text-logo', 'display-none' ) ) )  $logo_opt;
	return $logo_opt;
}

/**
 * Checkbox sanitation function
 */
function ajaw_sanitize_checkbox( $input ){
	//return ( ( isset( $input ) && true == $input ) ? true : false );

   if ( $input === true || $input === 1 ) {
        return 1;
    }else{
        return '';
    }
}

/**
 * URL sanitization.
 * 
 * @see esc_url_raw() https://developer.wordpress.org/reference/functions/esc_url_raw/
 */
function ajaw_sanitize_url( $url ) { return esc_url_raw( $url); }

/**
 * HTML sanitization 
 */
function ajaw_sanitize_html( $html ) {
	return wp_filter_post_kses( $html );
}

/**
 * CSS sanitization.
 * 
 * @see wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
 *
 * @param string $css CSS to sanitize.
 * @return string Sanitized CSS.
 */
function ajaw_sanitize_css( $css ) {
	return wp_strip_all_tags( $css );
}

/**
 * Sanitize the site colors for the seclective refresh partial
 *
 * @link https://developer.wordpress.org/reference/functions/sanitize_hex_color/
 */
function ajaw_sanitize_hex_color( $hex_color, $settings ){
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color($hex_color);
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * This will check all of the multiple checkbox & return it to array
 * 
 * @return array
 */
function ajaw_sanitize_multiple_checkbox( $value ){
	$mv = ! is_array( $value ) ? explode(',', $value ) : $value ;
	return ! empty( $mv ) ? array_map('sanitize_text_field', $mv) : array();
}

/**
 * Sanitize the radio button
 * 
 * @return array
 */
function ajaw_sanitize_radio( $input, $setting ){

	//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
	$input = sanitize_key( $input );

	//get the list of possible radio box options 
	$choices = $setting->manager->get_control( $setting->id )->choices;

	//return input if valid or return default option
	return ( array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize the Select Tag
 * 
 * @return array
 */
function ajaw_sanitize_select( $input, $setting ){

	//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
	$input = sanitize_key( $input );

	//get the list of possible radio box options 
	$choices = $setting->manager->get_control( $setting->id )->choices;

	//return input if valid or return default option
	return ( array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * script input sanitization function
 */
function ajaw_sanitize_js_code( $input ){
	return base64_encode($input);
}

/**
 * output escape function
 */
function ajaw_sanitize_js_output( $input ){
	return esc_textarea( base64_decode($input) );
}
