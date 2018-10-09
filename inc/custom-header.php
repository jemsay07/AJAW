<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package AJAW
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses ajaw_header_style()
 */
/*function ajaw_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ajaw_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'ajaw_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'ajaw_custom_header_setup' );*/

if ( ! function_exists( 'ajaw_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see ajaw_custom_header_setup().
	 */
	function ajaw_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

/*function ajaw_custom_header(){

	the_custom_logo();
	if ( is_front_page() && is_home() ) :
		?>
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php
	else :
		?>
		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php
	endif;
	$ajaw_description = get_bloginfo( 'description', 'display' );
	if ( $ajaw_description || is_customize_preview() ) :
		?>
		<p class="site-description"><?php echo $ajaw_description;  //WPCS: xss ok.  ?></p>
	<?php endif;

}
*/
function ajaw_custom_header(){
	//the_custom_logo();

	$site_branding_output = '';
	$title_option = get_theme_mod( 'site_title_option', 'text-only' );
	$logo_id = get_theme_mod( 'site_logo' );
	$logo =  wp_get_attachment_url( $logo_id );

	//check weather the page is front
	if ( is_front_page() || is_home() ) {
		$before_title = '<h1 class="site-title" itemprop="headline">';
		$after_title = '</h1>';
		$before_desc = '<h2 class="site-description" itemprop="description">';
		$after_desc = '</h2>';
	}else{
		$before_title = '<h2 class="site-title" itemprop="headline">';
		$after_title = '</h2>';
		$before_desc = '<h3 class="site-description" itemprop="description">';
		$after_desc = '</h3>';
	}

	if ( $title_option == 'logo-only' && ! empty( $logo ) || $title_option == 'logo-only' && $logo != 0 ) :
		$site_branding_output .= $before_title . '<a class="navbar-brand " href="' . esc_url( home_url( '/' ) ) . '" rel="home" itemprop="url"><img src="' . esc_url( $logo ) . '" alt="' . get_bloginfo( 'name' ) . '" itemprop="image"></a><span class="sr-only">' . get_bloginfo('name') . '</span>' . $after_title;
	endif;
	if ( $title_option == 'text-logo' && ! empty( $logo ) || $title_option == 'text-logo' && $logo != 0 ) :
		$site_branding_output .= '<div class="site-logo">';
			$site_branding_output .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" itemprop="url"><img src="' . esc_url( $logo ) . '" alt="' . get_bloginfo( 'name' ) .'" itemprop="image"></a>';
			$site_branding_output .= $before_title . '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" itemprop="url">' . get_bloginfo( 'name' ) . '</a>' . $after_desc;
			$site_branding_output .= $before_desc . get_bloginfo( 'description' ) . $after_desc;
		$site_branding_output .= '</div>';
	endif;
	if ( $title_option == 'text-only' ):
		$site_branding_output .= $before_title . '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" itemprop="url">' . get_bloginfo( 'name' ) . '</a>' . $after_desc;
		$site_branding_output .= $before_desc . get_bloginfo( 'description' ) . $after_desc;
	endif;
	return $site_branding_output;
}