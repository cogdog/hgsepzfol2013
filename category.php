<?php
/**
 * The template for displaying Category Archive pages, added features for hgsepzfol categories
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">


			<?php
			
			$current_category = single_cat_title( "", false );  // current category name
			$current_category_id = get_cat_ID( $current_category ); // current category id
			$post_count = get_post_count($current_category_id); // number of posts in this category
					
			?>
			
			<?php if ( have_posts() ) : ?>
			
				<!-- use paged navigation -->
				<?php if ( function_exists( 'page_navi' ) ) page_navi(); ?>					
					
					
				<!-- echo a label for categories, this is ugly to hardcode categories to exclude, those are aggregation ones -->
				<?php if (  $post_count > 0) : ?>
					<div class="pcount">collecting <strong><?php echo $post_count?></strong> items in the <strong><?php echo $current_category ?></strong>   <?php if ( !( in_array( $current_category_id, array( 1, 4, 5, 6, 11 ) ) ) ) echo ' Category';?></div>
				<?php endif?>
				
				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					
					<!-- edit link for admins so they cane categorize syndicated posts -->
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
					<div class="pcount">collecting <strong><?php echo $post_count?></strong> items in the <strong><?php echo $current_category ?></strong>   <?php if ( !( in_array( $current_category_id, array( 1, 4, 5, 6, 11 ) ) ) ) echo ' Category';?></div>
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
