<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'bones_options', 'bones_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'bones_options' ); ?>
			<?php $options = get_option( 'bones_theme_options' ); ?>

			<table class="form-table">
				
				<tr valign="top"><th scope="row"><?php _e('Apple Touch Icon'); ?></th>
					<td>
						<input id="bones_theme_options[apple_touch]" class="regular-text" type="text" name="bones_theme_options[apple_touch]" value="<?php esc_attr_e( $options['apple_touch'] ); ?>" />
						<label class="description" for="bones_theme_options[apple_touch]"><?php _e( 'url / location for apple touch icon image' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e('Fav Icon'); ?></th>
					<td>
						<input id="bones_theme_options[favicon]" class="regular-text" type="text" name="bones_theme_options[favicon]" value="<?php esc_attr_e( $options['favicon'] ); ?>" />
						<label class="description" for="bones_theme_options[favicon]"><?php _e( 'url / location for favicon image' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e('Header Image Width'); ?></th>
					<td>
						<input id="bones_theme_options[header_width]" class="regular-text" type="text" name="bones_theme_options[header_width]" value="<?php esc_attr_e( $options['header_width'] ); ?>" />
						<label class="description" for="bones_theme_options[header_width]"><?php _e( 'width for header image' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e('Header Image Height'); ?></th>
					<td>
						<input id="bones_theme_options[header_height]" class="regular-text" type="text" name="bones_theme_options[header_height]" value="<?php esc_attr_e( $options['header_height'] ); ?>" />
						<label class="description" for="bones_theme_options[header_height]"><?php _e( 'height for header image' ); ?></label>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/