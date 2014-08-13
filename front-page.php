<?php
/**
 * Template for site front page,  using static page
 *
 * Also designed to insert most recent post in Spotlight category
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php get_template_part( 'content', 'home' ); // just gets the static page content ?>
				
				<!-- begin spotlight output -->
				
				<div id="spotlight" class="entry-content">
				
				<h2>SPOTLIGHT: curated  relevant Institute information...</h2>
				
				<?php 
					// set up query to get most recent spotlight
					$spotlight_query = new WP_Query( array('posts_per_page' =>'1', 'category_name' => 'spotlight') );
					
					 while ( $spotlight_query->have_posts() ) : $spotlight_query->the_post(); ?>
				
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						
						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
						</div><!-- .entry-content -->

					<?php endwhile; ?>

					<p class="more"><a href="/info/spotlight/">See all Spotlights...</a></p>			
										
				</div>

				<?php wp_reset_query(); ?>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>