<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tarsasnavigator_s
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'tarsasnavigator_s' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<div class="menu-container">
				<div class="menu-toggle">
					<button class="menu-toggle-button" aria-controls="primary-menu" aria-expanded="false"><i class="fas fa-bars"></i> <?php esc_html_e( 'Menu', 'tarsasnavigator_s' ); ?></button>
				</div>
			<?php
				// Logo
				$logo_html = '<a href="' . get_site_url() . '" alt="' . get_bloginfo( 'name' ) . '" class="menu-logo">';
				if ( has_custom_logo() ) { // If set, load the logo from the Admin
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					$logo = wp_get_attachment_image_src( $custom_logo_id , array(100, 100) );
					$logo_html .= '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="tarsasnavigator logo">';
				} else { // Else load default animaged SVG logo - PREFERRED
					$logo = return_get_template_part('assets/svg/inline-tarsasnavigator.svg');
					$logo = preg_replace(
						'/\<title\>.*?\<\/title\>/m',
						'<title>' . get_bloginfo( 'name' ) . '</title>',
						$logo
					);
					$logo_html .= $logo;
				}
				$logo_html .= '</a>';

				// Menu magic
				$menu = wp_nav_menu( array(
					'theme_location' => 'main-menu',
					'menu_id'        => 'primary-menu',
					'echo'=>false,
				) );
				$re = '/\<li.*?\>.*?logo.*?\<\/li\>/m';
				$main_menu = preg_replace($re, '</ul></div>' . $logo_html . '<ul id="personal-menu" class="menu">', $menu, 1);
				echo $main_menu;

			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
