<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Bambino Theme
 */

get_header(); ?>

	<div class="row content-wrapper" >

		<?php while ( have_posts() ) : the_post(); ?>
		<div class="medium-12 columns page-heading">
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->
		</div>

		<!-- Main Blog Content -->
		<div class="medium-9 columns content" role="content">

				<?php get_template_part( 'parts/content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) {
						comments_template();
					}
				?>

			<?php endwhile; // end of the loop. ?>

	</div>
	<!-- End Main Content -->

<?php get_sidebar( 'page' ); ?>
<?php get_footer(); ?>
