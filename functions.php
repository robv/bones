<?php 
// Remove usless the_generator meta tag - whoops
add_filter( 'the_generator', create_function('$a', "return null;") );


// A little magic to let child themes overwrite the theme options page
if (is_file(get_stylesheet_directory() . '/theme-options.php')) {
	require_once(get_stylesheet_directory() . '/theme-options.php');
}
else {
	require_once('theme-options.php');
}


/** Tell WordPress to run bones_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'bones_setup' );

if ( ! function_exists( 'bones_setup' ) ):

function bones_setup() {
	
	$options = get_option('bones_theme_options');

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'bones' ),
	) );

	// This theme allows users to set a custom background
	// TODO: Add option to implement add_custom_background();
	
	if ($options['header_type'] == 'image')
	{
		// Your changeable header business starts here
		define( 'HEADER_TEXTCOLOR', '' );
		// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
		define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

		// The height and width of your custom header. You can hook into the theme's own filters to change these values.
		// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
		define( 'HEADER_IMAGE_WIDTH', apply_filters( 'bones_header_image_width', $options['header_width']) );
		define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'bones_header_image_height', $options['header_height']) );

		// Don't support text inside the header image.
		define( 'NO_HEADER_TEXT', true );

		// Add a way for the custom header to be styled in the admin panel that controls
		// custom headers. See twentyten_admin_header_style(), below.
		add_custom_image_header( '', 'bones_admin_header_style' );

		// ... and thus ends the changeable header business.
	}

}
endif;

if ( ! function_exists( 'bones_admin_header_style' ) ) :

function bones_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * LIFTED FROM TWENTYTEN THEME:
 * Makes some changes to the <title> tag, by filtering the output of wp_title().
 *
 * If we have a site description and we're viewing the home page or a blog posts
 * page (when using a static front page), then we will add the site description.
 *
 * If we're viewing a search result, then we're going to recreate the title entirely.
 * We're going to add page numbers to all titles as well, to the middle of a search
 * result title and the end of all other titles.
 *
 * The site title also gets added to all titles.
 *
 * @param string $title Title generated by wp_title()
 * @param string $separator The separator passed to wp_title().
 * @return string The new title, ready for the <title> tag.
 */
function bones_wp_title_filter( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'bones' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'bones' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'bones' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'bones_wp_title_filter', 10, 2 );

// Custom Login Logo
function custom_logo() { ?> 
	<style type="text/css">
		h1 a { background-image: url('<?php bloginfo('template_url'); ?>/images/logo-login.gif') !important; }
    </style>
<?php }

add_action('login_head', 'custom_logo');

function blockhead_comment( $comment, $args, $depth ) {
	$GLOBALS ['comment'] = $comment; 
?>
	<?php if ($comment->comment_type == '') : ?>
	
		<div <?php comment_class('clearfix'); ?> id="comment_<?php comment_ID(); ?>">	
		
			<div id="comment_<?php comment_ID(); ?>" class="clearfix comment_wrapper">
			
				<div class="comment_avatar">
					<?php echo get_avatar($comment, 45); ?>
				</div>

				<div class="comment_meta commentmetadata clearfix">
		
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>

					<?php printf( __( '<cite class="fn">%s</cite>', 'blockhead' ), get_comment_author_link() ); ?>

					<?php edit_comment_link( __( '(Edit)', 'blockhead' ), ' ' ); ?>

					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment_timestamp">
					<?php printf( __( '%1$s at %2$s', 'blockhead' ), get_comment_date(),  get_comment_time() ); ?>
					</a>

				</div>

				<div class="comment_body">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<p><em><?php _e( 'Your comment is awaiting moderation.', 'blockhead' ); ?></em></p>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>

			</div>
			
	<?php else : ?>
	
		<div class="comment_wrapper pingback">
			<p><?php _e( 'Pingback:', 'blockhead' ); ?> <?php comment_author_link(); ?><?php edit_comment_link ( __('(Edit)', 'blockhead'), ' ' ); ?></p>
	
	<?php endif;
	
}