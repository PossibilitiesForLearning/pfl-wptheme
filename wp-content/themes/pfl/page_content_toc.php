<?php /* Template Name: General Content /w TOC*/ ?>

<?php
/**
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
					<em>Brilliant Behaviours</em>
				</div>
			</div>

			<div class="row content-row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 subtitle">
                    <em>Finding Bright and Gifted Students with Brilliant Behaviours</em>
                </div>
                <div class="col-xs-12">
				<div class="container">
                    <div class="row">
                        <div class="col-md-4 col-md-push-8 table-of-contents">
                            <ul>
                                <li><a href="#">Chapter 1 - Something Lorem Ipsum something something</a></li>
                                <li>Chapter 2 - Something Else</li>
                                <li>Chapter 3 - Bananas</li>
                                <li>Chapter 4 - Apples</li>
                            </ul>
                        </div>
                        <div class="col-md-8 col-md-pull-4 content-body">
                            <p>Historically, testing has been the most common lens used to inspect students’ potential. Today, concerns regarding the use of many tests with students from culturally and economically diverse backgrounds has reduced confidence and reliance on them.[112] More contemporary approaches that respect this diversity can be supported by using the Tools provided here.</p>
                            <p>Students indicate their need for more challenge in a variety of ways, some more direct than others. Some students demand, some ask and some have to be found.  This section provides guidance for stimulating students’ potentials during classroom activities.  It includes alternate formats of a tool, the Brilliant Behaviors checklist, for observing students to assess the nature and extent of those behaviors during that activity.</p>
                            <p>Students should be observed for signs of the Brilliant Behaviors while they are engaged in their strongest subject(s), their passions. Students’ greatest academic strengths are the areas in which there is the greatest need for curriculum differentiation.</p>
                        </div>
                        
                    </div>
					</div>
				</div>
            </div>


			<?php include 'footer_index.php' ?>
				
			</div>


		</div>
		<!-- #primary -->
	</div>
	
	<?php get_footer(); ?>



