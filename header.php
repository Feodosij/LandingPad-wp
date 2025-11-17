<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LandingPadTheme
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

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'landingpadtheme' ); ?></a>

	<header id="masthead" class="site-header header">
		<div class="header__container container">
			<div class="header__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="header__logo-link">
					<?php echo landingpad_get_inline_logo(); 
                    
                    if ( ! get_theme_mod( 'custom_logo' ) ) {
                        bloginfo( 'name' ); 
                    }
                    ?>
				</a>
			</div>

			<nav id="site-navigation" class="header__nav main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'landingpadtheme' ); ?>">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'header_menu',
							'menu_id'        => 'primary-menu',
							'menu_class'	 => 'header__menu menu',
							'container'		 => false,
						)
					);
				?>
			</nav>

			<button class="burger" id="burger" aria-label="Toggle menu" aria-expanded="false">
					<span class="burger__line"></span>
					<span class="burger__line"></span>
					<span class="burger__line"></span>
			</button>
		</div>
		<nav class="mobile-menu " id="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile menu', 'landingpadtheme' ); ?>">
			<div class="mobile-menu__container container">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'header_menu',
							'menu_class'	 => 'mobile-menu__list',
							'container'		 => false,
						)
					);
				?>
			</div>
		</nav>
		<div class="mobile-menu-overlay" id="js-menu-overlay"></div>
		
	</header><!-- #masthead -->
