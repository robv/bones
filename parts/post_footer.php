<div class="post_meta_footer clearfix">
	<?php if (!is_page()) : ?>
		<div class="tags"><strong>Tags:</strong> <?php the_tags( '<span class="tag">', ' ', '</span>' ); ?></div>
	<?php endif; ?>
	<?php edit_post_link( __( 'Edit Post', 'blockhead' ), '<div class="edit"><strong>', '</strong></div>' ); ?>
</div><!-- #entry-utility -->