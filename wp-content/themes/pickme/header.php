<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package WordPress
 * @subpackage PickME
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<nav class="navbar navbar-default background_px_header header_menu_top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#toggle_menu" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar top-bar"></span>
				<span class="icon-bar middle-bar"></span>
				<span class="icon-bar bottom-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="LOGO" title=""></a>
			<a class="navbar-brand sticky" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo('template_url'); ?>/images/logo_scroll.png" alt="LOGO" title=""></a>			
		</div>
		<div class="collapse navbar-collapse" id="toggle_menu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-primary',
					'menu_class'     => 'nav navbar-nav navbar-right',
					'items_wrap'     => '<ul id="%1$s" class="%2$s" tabindex="0">%3$s</ul>',
				)
			);
			?>
		</div>
		<div class="lang_select">
			<ul>
				<?php pll_the_languages();?>
			</ul>
		</div>
	</div>
</nav>

<?php
	if(is_home()){		
		echo do_shortcode('[metaslider id="40"]'); 
	}
?>
