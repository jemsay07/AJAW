<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AJAW
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'ajaw' ); ?>>
<div id="page" class="site container<?php echo ( get_theme_mod( 'ajaw_theme_wrap', 'full' ) === 'box'  ) ? '' : '-full'; ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ajaw' ); ?></a>
	<header id="masthead" class="site-header">
		<div id="topHeader" class="d-none d-md-block d-lg-block">
			<div class="container">
				<div class="row">
					<div id="informartion" class="col-md-6">
						Contact info here
					</div>
					<div id="socialMedia" class="col-md-6">
						Social Media here
					</div>
				</div>
			</div>
		</div>
		<div class="site-branding">
			<div class="container">
				<div class="row d-flex flex-column"><?php echo ajaw_custom_header(); ?></div>
			</div>	
		</div><!-- .site-branding -->
		<nav id="site-navigation" class="navbar navbar-expand-lg navbar-light py-md-0">
			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<?php
				wp_nav_menu( array(
					'theme_location'	=> 'primary',
					'container'			=> 'div',
					'container_id'		=> 'primary-menu',
					'container_class'	=> 'navbar-collapse collapse',
					'menu_class'		=> 'navbar-nav container',
					'fallback_cb'		=> 'ajaw_wp_navwalker::fallback',
					'walker'			=> new ajaw_wp_navwalker()
				) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content container">
		<div class="row">

