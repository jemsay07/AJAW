<?php
/**
 * AJAW Theme Customizer
 *
 * @package AJAW
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ajaw_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport 				= 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport 			= 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport 		= 'postMessage';
	$wp_customize->remove_control('display_header_text');	// Remove the default site title & tag.
	$wp_customize->get_section( 'colors' )->title =  'Default Colors';
	$wp_customize->get_section( 'colors' )->panel =  'ajaw_style_options';

	/*if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'ajaw_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'ajaw_customize_partial_blogdescription',
		) );
	}*/

 	// Load custom controls.
	require_once( trailingslashit( get_template_directory() ) . 'inc/customizer/customizer_controls.php' );

	// Register the radio image control class as a JS control type.
    $wp_customize->register_control_type( 'Ajaw_Customize_Radio_Image' );

	/**
	 * # Header Panel
	 *----------------------------*/

	$wp_customize->add_panel( 'ajaw_heading_panel', 
		array(
			'priority' 	=> 20,
			'title'		=> __( 'Header Settings', 'ajaw' ),
			'description'	=> __( 'Use this panel to set your header settings.', 'ajaw' )
		)
	);

		/**
		 * ## Logo Settings
		 *----------------------------*/
		$wp_customize->add_setting( 'site_logo',
			array(
				'type'			=> 'theme_mod',
				'transport'		=> 'refresh',
				'sanitize_callback' => 'absint'
			)
		);

			$wp_customize->add_control(
				new WP_Customize_Cropped_Image_Control( $wp_customize, 'site_logo',
					array(
						'label'		=> __( 'Site Logo', 'ajaw' ),
						'section'	=> 'title_tagline',
						'setting'	=> 'site_logo',
						'description' => __( 'Upload a logo for your website. Recommended height for your logo is 135px.', 'ajaw' ),
						'flex_width'  => false, // Allow any width, making the specified value recommended. False by default.
						'flex_height' => false,
						'width'       => 135,
						'height'      => 135,				
					)
				)
			);

		/**
		 * ## Logo, Title & tagline chooser
		 *----------------------------*/
		$wp_customize->add_setting( 'site_title_option',
			array(
				'default'			=> 'text-only',
				'sanitize_callback'	=> 'ajaw_sanitize_logo_title_select',
				'transport'			=> 'refresh'
			)
		);
			$wp_customize->add_control( 'site_title_option',
				array(
		            'label'     	=> __( 'Display site title / logo.', 'ajaw' ),
		            'section'   	=> 'title_tagline',
		            'type'      	=> 'radio',
		            'description'	=> __( 'Choose your preferred option.', 'ajaw' ),
		            'choices'   => array (
		                'text-only' 	=> __( 'Display site title and description only.', 'ajaw' ),
		                'logo-only'     => __( 'Display site logo image only.', 'ajaw' ),
		                'text-logo'		=> __( 'Display both site title and logo image.', 'ajaw' ),
		                'display-none'	=> __( 'Display none', 'ajaw' )
		            )
				)
			);

	/**
	 * # General Settings
	 *-------------------------------------*/

	$wp_customize->add_panel(
		'ajaw_theme_options',
		array(
			'priority'		=> 21,
			'capability' 	=> 'edit_theme_options',
			'theme_support'	=> '',
			'title'			=> __( 'Theme Settings',  'ajaw' ),
			'description'	=> esc_html__( 'Use this section to set Theme options/settings of the site.', 'ajaw' ),
		)
	);
		/**
		 * ## Theme Layout Section
		 *-------------------------------------*/
		$wp_customize->add_section(
			'ajaw_blog_options',
			array(
				'priority'	=> 4,
				'title'		=> esc_html__( 'Theme Layout Settings', 'ajaw' ),
				'panel'		=> 'ajaw_theme_options'
			)
		);
			//Theme layout Setting
			$wp_customize->add_setting( 'ajaw_theme_wrap',
				array(
					'default' => 'full',
					'transport' => 'refresh',
					'sanitize_callback' => 'ajaw_sanitize_radio',
				)
			);

			$wp_customize->add_control( 'ajaw_theme_wrap',
				array(
					'label'			=> __( 'Theme Default', 'ajaw' ),
					'description'	=> __( '...', 'ajaw' ),
					'section'		=> 'ajaw_blog_options',
					'panel'			=> 'ajaw_theme_options',
					'priority'		=> 10,
					'type'			=> 'radio',
					'capability'	=> 'edit_theme_options',
					'choices'		=> array(
							'box'	=> __( 'Box', 'ajaw' ),
							'full'	=> __( 'Full', 'ajaw' )
					)
				)
			);

	/**
	 * # Site Style
	 *-------------------------------------*/
	$wp_customize->add_panel( 'ajaw_style_options',
		array(
			'priority' 		=> 22,
			'title'			=> esc_html__( 'Color Styling', 'ajaw' ),
			'description' 	=> esc_html__( 'Use this section to setup / edit your site design.', 'ajaw' )
		)
	);

			//Primary Colors Settings
			$wp_customize->add_setting( 'ajaw_wrap_color',
				array(
					'default'			=> '#f7f8f9',
					'type'				=> 'theme_mod',
					'capability'		=> 'edit_theme_options',
					'sanitize_callback'	=> 'ajaw_sanitize_hex_color'
				)
			);

			//Primary Colors Control
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( $wp_customize, 'ajaw_wrap_color',
					array(
						'label'			=> __( 'Theme Wrap Color', 'ajaw' ),
						'section'		=> 'colors',
						'setting'		=> 'ajaw_wrap_color'
					)
				)
			);

			//Theme Text Colors Settings
			$wp_customize->add_setting( 'ajaw_theme_text_color',
				array(
					'default'			=> '#222',
					'type'				=> 'theme_mod',
					'capability'		=> 'edit_theme_options',
					'sanitize_callback'	=> 'ajaw_sanitize_hex_color'
				)
			);

			//Theme Text Colors Control
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( $wp_customize, 'ajaw_theme_text_color',
					array(
						'label'			=> __( 'Theme Primary Color', 'ajaw' ),
						'section'		=> 'colors',
						'setting'		=> 'ajaw_theme_text_color'
					)
				)
			);

		$wp_customize->add_section( 'ajaw_nav_options',
			array( 
				'title'		=> __( 'Menu Colors', 'ajaw' ),
				'panel'		=> 'ajaw_style_options',
				'priority'		=> 50
			)
		);

			//Theme BG Menu Colors Settings
			$wp_customize->add_setting( 'ajaw_theme_bg_menu_color',
				array(
					'default'			=> '#02849c',
					'type'				=> 'theme_mod',
					'capability'		=> 'edit_theme_options',
					'sanitize_callback'	=> 'ajaw_sanitize_hex_color'
				)
			);

			//Theme BG Menu Colors Control
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( $wp_customize, 'ajaw_theme_bg_menu_color',
					array(
						'label'			=> __( 'BG Menu Color', 'ajaw' ),
						'section'		=> 'ajaw_nav_options',
						'setting'		=> 'ajaw_theme_bg_menu_color'
					)
				)
			);

			//Theme Menu Colors Settings
			$wp_customize->add_setting( 'ajaw_theme_menu_link_color',
				array(
					'default'			=> '#02849c',
					'type'				=> 'theme_mod',
					'capability'		=> 'edit_theme_options',
					'sanitize_callback'	=> 'ajaw_sanitize_hex_color'
				)
			);

			//Theme Menu Colors Control
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( $wp_customize, 'ajaw_theme_menu_link_color',
					array(
						'label'			=> __( 'Menu Link Color', 'ajaw' ),
						'section'		=> 'ajaw_nav_options',
						'setting'		=> 'ajaw_theme_menu_link_color'
					)
				)
			);

			//Theme Menu Colors Hover Settings
			$wp_customize->add_setting( 'ajaw_theme_menu_link_hover_color',
				array(
					'default'			=> '#02849c',
					'type'				=> 'theme_mod',
					'capability'		=> 'edit_theme_options',
					'sanitize_callback'	=> 'ajaw_sanitize_hex_color'
				)
			);

			//Theme Menu Colors Hover Control
			$wp_customize->add_control( 
				new WP_Customize_Color_Control( $wp_customize, 'ajaw_theme_menu_link_hover_color',
					array(
						'label'			=> __( 'Menu Link Hover', 'ajaw' ),
						'section'		=> 'ajaw_nav_options',
						'setting'		=> 'ajaw_theme_menu_link_hover_color'
					)
				)
			);


}
add_action( 'customize_register', 'ajaw_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ajaw_customize_preview_js() {
	wp_enqueue_script( 'ajaw-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ajaw_customize_preview_js' );
