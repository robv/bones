<?php
	$options = get_option('bones_theme_options');
?><!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '-', true, 'right' ); ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed (<?php bloginfo('language'); ?>)" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="icon" type="image/png" href="<?php echo $options['favicon']; ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/scripts/facebox/facebox.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/scripts/common.js"></script>
	 
<?php if (ereg('iPhone', $_SERVER['HTTP_USER_AGENT']) || ereg('iPod', $_SERVER['HTTP_USER_AGENT']) || ereg('iPad',$_SERVER['HTTP_USER_AGENT'])): ?>
	
	<meta name="viewport" content="width=device-width">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="apple-touch-fullscreen" content="yes" />
	<link rel="apple-touch-icon" href="<?php echo $options['apple_touch']; ?>" />
	
	<?php if (ereg('iPad', $_SERVER['HTTP_USER_AGENT'])): ?>
		<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ipad.css" />
	<?php else: ?>
		<link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/iphone.css" />	
	<?php endif; ?>
	
<?php endif ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="container">
		<div id="header">
			<h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
			<h2><?php bloginfo('description'); ?></h2>
			<div id="navigation">
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
			</div>
		</div>
		<div id="content">
			<?php // Content ?>
