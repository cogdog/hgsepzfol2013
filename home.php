<?php
/**
 * Template for displaying the flow on a blog type page (replicating front blog type page).
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">
			
			<?php
			// let's get the number of posts
			$post_count = wp_count_posts()->publish;		
			?>
			
			<?php if ( have_posts() ) : ?>
			
			
				<?php if ( function_exists( 'page_navi' ) ) page_navi(); ?>					
					
				<?php if (  $post_count > 0) : ?>
					<div class="pcount">collecting <strong><?php echo $post_count?></strong> items in the <strong>site flow</strong></div>
				<?php endif?>

				
				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php edit_post_link( __( 'Edit/Categorize', 'twentyeleven' ), '<div class="edit-link" style="text-align:right">', '</div>' ); ?>
					
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>
				
				
				<?php if ( function_exists( 'page_navi' ) ) page_navi(); ?>					
					
				<?php if (  $post_count > 0) : ?>
					<div class="pcount">collecting <strong><?php echo $post_count?></strong> items in the <strong>site flow</strong></div>
				<?php endif?>



				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
