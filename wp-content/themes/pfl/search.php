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

		<!-- #primary -->	
		<div id="primary" class="container-fluid">

			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 hero">
					<em>Search Results</em>
				</div>
			</div>

			<div class="row content-row">

				<div class="container">
					<div class="col-xs-12 col-sm-10 col-sm-offset-1 content-body">
					<?php
                    $s=get_search_query();
                    $args = array(
                                    's' =>$s
                                );
                        // The Query
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) {
                            _e("<h2 style='color: #2f343b'>Matches for: '".get_query_var('s')."'</h2>");
                            while ( $the_query->have_posts() ) {
                               $the_query->the_post();
                                     ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </li>
                                     <?php
                            }
                        }else{
                    ?>
                            <h4 style="color: #2f343b">No results found. <a href="/">Click here</a> to return to home page.</h4>
                    <?php } ?>
					</div>
				</div>
			</div>

			<?php include 'footer_index.php' ?>

		</div>	

		<div class="container-fluid breadcrumb-container hidden-xs hidden-sm">
			<div class="row breadcrumb-row">				
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
					<?php custom_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php get_footer(); ?>



