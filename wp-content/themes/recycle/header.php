<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
</head> 

<body <?php body_class(); orion_get_passepartout(); orion_site_content_bg();?> >
		<?php get_template_part( 'templates/header/header', 'search' ); ?>
		<?php orion_get_stickyHeader(); ?>
		<?php orion_is_boxed('start');?>
		<?php orion_get_top_bar();?>
	<div class="site">
		<?php 
		orion_get_header();