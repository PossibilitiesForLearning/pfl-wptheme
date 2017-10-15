<?php /* Template name: Homepage */ ?>
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

<body class="body-index">
	<?php include 'nav.php';?>

	<div id="main">

	<div id="image-background">

	</div>

	<div id="index-background">
		<div class="color-block block1">

		</div>
		<div class="color-block block2">

		</div>
		<div class="color-block block3">

		</div>
	</div>

	<div id="primary" class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 hero">
				Planning <span class="secondary">for and with</span><br/>
				<em>Highly Able Learners</em>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-1 tagline">
				<p>Students with an <em>extraordinary capacity and craving for learning</em> need rich, challenging opportunities to learn
					that are tailored to their <em>passions, preferences and strengths</em>.</p>
				<p>The free tools and resources provided here enable <em>students, teachers and parents</em> to find or plan activities and differentiate curriculum that is worthy of their astonishing potential to <em>learn, create and grow</em>.</p>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-11 col-xs-offset-1 col-md-7 col-md-offset-3 image-block block1">
				<div class="white-block">
					<div class="feature">Which students are high ability learners?</div>
					<div class="description">These materials help you <strong>find students who need the nature or pace of their learning enhanced</strong> without testing—just observe, ask them and their peers.  They stand out when you know what to look for.</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-8 col-xs-offset-3 col-md-7 col-md-offset-4 image-block block2">
				<div class="white-block">
					<div class="feature">What and how to differentiate?</div>
					<div class="description">The areas in greatest need of differentiation are the students’ strengths and interests.  Use the interactive <strong>Guide for Selecting Differentiation Strategies</strong> to determine which are recommended each student in any subject.</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-8 col-xs-offset-3 col-md-7 col-md-offset-3 image-block block3">
				<div class="white-block">
					<div class="feature">How do they want to learn?</div>
					<div class="description">Students can complete the <strong>interactive survey to identify their favourite types of differentiation</strong>.  Students and their teachers can design activities, large and small, that involve them so their learning is personalized.</div>
				</div>
			</div>
		</div>

		<?php include 'footer_index.php' ?>
	</div>
	<!-- #primary -->

</div>



	<?php get_footer(); ?>



