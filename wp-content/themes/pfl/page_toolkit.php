<?php /* Template name: Toolkit */ ?>
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<?php
				
		?>
		<!-- Added css -->
		<link rel="stylesheet" href="./wp.custom.css/brDefaults.css" type="text/css">
		<link rel="stylesheet" href="./wp.custom.css/defaulten.css" type="text/css">
		<link rel="stylesheet" href="./wp.custom.css/pfl.css" type="text/css">

<style>
#indicHeaders{padding:5px;color:white;background-color:#666666;}
#descTable{border-width: 1px; border-style: solid; border-collapse: collapse; padding: 7px;}
</style>		

		<!--div id="primary" -->
			<!-- div id="content" role="main"-->

				<?php while ( have_posts() ) : the_post(); ?>

					<?php 
						get_template_part( 'content', 'page' );
					?>

					
				<?php endwhile; // end of the loop. 
				?>

			<!-- /div --><!-- #content -->
		<!-- /div --> <!-- #primary -->

<?php get_footer(); ?>