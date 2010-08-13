<div class="post_meta">
	<?php
		printf(__('<span class="timestamp"><a href="%1$s" title="%2$s" rel="bookmark"><span class="entry_date">%3$s</span></a></span> <span class="author">by <a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'bones'),
			get_permalink(),
			esc_attr(get_the_time()),
			get_the_date(),
			get_author_posts_url(get_the_author_meta( 'ID' )),
			sprintf(esc_attr__('View all posts by %s', 'bones'), get_the_author()),
			get_the_author()
		);
	?>
	<span class="category">in <?php the_category( ', ' ); ?></span> - 
	<span class="comments"><?php comments_popup_link( __( 'Leave a comment', 'bones' ), __( '1 Comment', 'bones' ), __( '% Comments', 'bones' ) ); ?></span>
</div>