<?php
/**
 * The template used to display Comments
 */
?>

<div id="comments">

	<?php if ( post_password_required() ) : ?>
		<div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'bones' ); ?></div>
	<?php return; endif; ?>

	<?php if ( have_comments() ) : ?>
	
		<h2 class="post_title">
			<?php
	    		printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'bones' ),
				number_format_i18n( get_comments_number() ), '<strong>' . get_the_title() . '</strong>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 ) : ?>
			<div class="post_nav">
				<div class="post_nav_prev"><?php previous_comments_link( __( '&larr; Older Comments', 'bones' ) ); ?></div>
				<div class="post_nav_next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'bones' ) ); ?></div>
			</div>
		<?php endif; ?>

		<?php wp_list_comments( array( 'style' => 'div', 'callback' => 'blockhead_comment' ) ); ?>

		<?php if ( get_comment_pages_count() > 1 ) : ?>
			<div class="post_nav">
				<div class="post_nav_prev"><?php previous_comments_link( __( '&larr; Older Comments', 'bones' ) ); ?></div>
				<div class="post_nav_next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'bones' ) ); ?></div>
			</div>
		<?php endif; ?>

	<?php else : // this is displayed if there are no comments so far ?>

		<?php if ( comments_open() ) : // If comments are open, but there are no comments ?>
		
			<h2 class="post_title">No Comments Yet</h2>
		
		<?php else : // if comments are closed ?>

		<?php endif; ?>
	
	<?php endif; ?>

	<?php if (comments_open()) : ?>
	
	<h2 class="post_title leave_a_comment"><?php _e('Leave a Comment'); ?></h2>
	
	<div class="post">
	
	<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
	
		<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url( get_permalink() ) );?></p>
	
	<?php else : ?>

		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="clearfix">

		<?php if ( is_user_logged_in() ) : ?>

			<p><?php printf(__('Logged in as %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account') ?>"><?php _e('Log out &raquo;'); ?></a></p>

		<?php else : ?>

			<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" class="hint" title="<?php _e('Name'); ?>" />
			<label for="author"><small><?php if ($req) _e('(required)'); ?></small></label></p>

			<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" class="hint" title="<?php _e('Mail (will not be published)');?>" />
			<label for="email"><small><?php if ($req) _e('(required)'); ?></small></label></p>

			<p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" class="hint" title="<?php _e('Website'); ?>" />

		<?php endif; ?>

		<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4" class="hint" title="Comments"></textarea></p>

		<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_attr_e('Submit Comment'); ?>" />
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		</p>
		
		<?php do_action('comment_form', $post->ID); ?>

		</form>

	<?php endif; // If registration required and not logged in ?>

	<?php else : // Comments are closed ?>
	
		<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
	
	<?php endif; ?>
	
	</div>

</div>