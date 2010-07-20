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

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div class="post_nav_top">
		<div class="post_nav_prev"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bones' ) ); ?></div>
		<div class="post_nav_next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bones' ) ); ?></div>
	</div>
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div class="post error404">
		<h2><?php _e( 'Not Found', 'bones' ); ?></h2>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'bones' ); ?></p>
			<?php get_search_form(); ?>
		</div>
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

		<div <?php post_class(); ?>>
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bones' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>

			<div class="post_meta">
				<?php
					printf( __( '<span class="timestamp"><a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a></span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'bones' ),
						get_permalink(),
						esc_attr( get_the_time() ),
						get_the_date(),
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
						sprintf( esc_attr__( 'View all posts by %s', 'bones' ), get_the_author() ),
						get_the_author()
					);
				?>
				<span class="category"><?php the_category( ', ' ); ?></span>
				<span class="comments"><?php comments_popup_link( __( 'Leave a comment', 'bones' ), __( '1 Comment', 'bones' ), __( '% Comments', 'bones' ) ); ?></span>
			</div>

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
	<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bones' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bones' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
	<?php endif; ?>

			<div class="post_meta_footer clearfix">
				<?php the_tags( '<span class="tag">', '', '</span>' ); ?>
				<?php edit_post_link( __( 'Edit Post', 'blockhead' ), '<div class="edit">', '</div>' ); ?>
			</div><!-- #entry-utility -->
			
			
			<div class="hr"><hr /></div>

		<?php comments_template('', true); ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<div class="post_nav_bottom">
		<div class="post_nav_prev"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bones' ) ); ?></div>
		<div class="post_nav_next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bones' ) ); ?></div>
	</div>
<?php endif; ?>