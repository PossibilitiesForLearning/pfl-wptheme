<?php /* Template Name: General Content */ ?>

<?php
/**
 * Template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage PFL
 * @since PFL 2.0
 */

get_header(); ?>

<body class="body-content">
	<?php include 'nav.php';?>

	<div id="main">

		<div id="image-background" style="background-image: url('<?=bgRandom()?>');">

		</div>

		<div id="content-background">
			<div class="color-block block1">

			</div>
			<div class="color-block block2">

			</div>
			<div class="color-block block3">

			</div>
		</div>

		<div class="container-fluid breadcrumb-container hidden-xs hidden-sm">
			<div class="row breadcrumb-row">				
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
						<?php custom_breadcrumbs(); ?>
				</div>
			</div>
		</div>

		<div id="primary" class="container-fluid">

			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 hero">
					<em><?php the_title(); ?></em>
				</div>
			</div>

			<div class="row content-row">

				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 subtitle">
					<em><?php the_field('subtitle'); ?></em>
				</div>

				<div class="container">
					<div class="col-xs-12 col-sm-10 col-sm-offset-1 content-body">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php echo the_content();?>

					<?php endwhile; endif; ?>
					</div>
				</div>
			</div>

			<?php include 'footer_index.php' ?>

		</div>
		<!-- #primary -->
	</div>
	
	<?php get_footer(); ?>



