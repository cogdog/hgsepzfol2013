<?php
/**
 * Template Name: Full Width Template
 * Description: A Page Template that uses all the space
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary" class="showcase">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php
					/**
					 * We are using a heading by rendering the_content
					 * If we have content for this page, let's display it.
					 */

					get_template_part( 'content', 'intro' );
				?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>