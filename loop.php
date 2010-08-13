<?php
/**
 * PRETTY MUCH LIFTED ENTIRELY FROM bones
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	
	<div class="post error404">
		<h2 class="post_title"><?php _e( 'Not Found', 'bones' ); ?></h2>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'bones' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
	
<?php else : ?>

	<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="post_nav">
			<div class="post_nav_prev"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bones' ) ); ?></div>
			<div class="post_nav_next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bones' ) ); ?></div>
		</div>
	<?php endif; ?>

	<?php
		/* Start the Loop.
		 *
		 * We sometimes check for whether we are on an
		 * archive page, a search page, etc., allowing for small differences
		 * in the loop on each template without actually duplicating
		 * the rest of the loop that is shared.
		 *
		 * Without further ado, the loop:
		 */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

			<div <?php post_class('post'); ?>>
				<h2 class="post_title<?php if (is_single()) { echo ' post_title_single'; } ?>">
					<?php if (!is_single() && !is_page()) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bones' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php endif; ?>
						<?php the_title(); ?>
					<?php if (!is_single() && !is_page()) : ?>
						</a>
					<?php endif; ?>
				</h2>
				
				<?php if (!is_page()) : // Let's only show meta info if it's not a page ?>
				
					<?php get_template_part( 'parts/post_meta', 'index' ); ?>
					
				<?php endif; ?>
				
				<div class="post_body">
	
			<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
		
					<?php the_excerpt(); ?>
					
			<?php else : ?>
		
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bones' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bones' ), 'after' => '</div>' ) ); ?>
					
			<?php endif; ?>
			
				</div>

				<?php get_template_part( 'parts/post_footer', 'index' ); ?>
		
			</div>
		
		<?php comments_template('', true); ?>
		
	<?php endwhile; // End the loop. Whew. ?>
	
<?php endif; ?>