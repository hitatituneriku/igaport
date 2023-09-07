<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package igaport
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'igaport'); ?></a>

		<header id="masthead" class="site-header">
			<div class="site-branding">
				<?php
				the_custom_logo();
				if (is_front_page() && is_home()) :
				?>
					<div class="header header-box">
						<a class="top-title" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<h1><?php bloginfo('name'); ?></h1>
						</a>
					</div>

					<nav id="site-navigation" class="main-navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->

				<?php
			 	else :
				?>
					<div class="header header-box header-box-page">
						<a class="top-title" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<h1><?php bloginfo('name'); ?></h1>
						</a>
					</div>
				<?php
				endif;
				$igaport_description = get_bloginfo('description', 'display');
				if ($igaport_description || is_customize_preview()) :
				?>
					<p class="site-description">
						<?php echo $igaport_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->
		</header><!-- #masthead -->