<?php
/**
 * Header template for the theme
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 * @package WordPress
 * @subpackage PFL
 * @since Twenty Eleven 1.0
 */
?>
	<!DOCTYPE html>
	<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
	<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
	<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
	<!--[if !(IE 6) & !(IE 7) & !(IE 8)]><!-->
	<html <?php language_attributes(); ?>>
	<!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<title>
			<?php the_title() ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
		    crossorigin="anonymous">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
			crossorigin="anonymous">			
		<link rel="stylesheet" href="<?=getThemePath()?>/matrixApp/libs/jquery-ui.css">
		<link rel="stylesheet" href="<?=getThemePath()?>/matrixApp/libs/angularPrint.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	</head>
