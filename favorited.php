<?php
/**
 * Template Name: Show Favorites
 * Description: Shows only favorited content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php the_post(); ?>


				<?php get_template_part( 'content', 'page' ); ?>

			<?php if (function_exists('get_highest_rated')): ?>
		
			
			<ol>
				<?php get_highest_rated('post', 1, 30); ?>
			</ol>
			<?php endif; ?>


			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>