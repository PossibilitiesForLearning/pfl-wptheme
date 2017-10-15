<?php /* Template name: Footnotes */ ?>
<?php
/**
 * For display of foot notes list (may also be used for other unformatted docs) *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php 
						get_template_part( 'content', 'page' );
					?>

					
				<?php endwhile; // end of the loop. 
				?>

