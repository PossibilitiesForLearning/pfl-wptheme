<?php /* Template name: Blank */ ?>
<?php
/**
 * For display of blank text *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'content', 'page' );?>
<?php endwhile; // end of the loop. 
?>

