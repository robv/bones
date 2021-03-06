<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

$radio_options = array(
	'image' => array(
		'value' => 'image',
		'label' => __( 'Image' )
	),
	'text' => array(
		'value' => 'text',
		'label' => __( 'Text' )
	)
);

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
	global $radio_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	
	<script type="text/javascript" charset="utf-8">
		jQuery(function() {
			jQuery('.header_type').bind('change', function() {
				update_header_type();
			});
			update_header_type();
			function update_header_type()
			{
				if (jQuery('.header_type:checked').val() == 'text')
				{
					jQuery('.header_image_row').css('display', 'none');
					jQuery('.header_title_row').css('display', 'table-row');
				}
				else if (jQuery('.header_type:checked').val() == 'image')
				{
					jQuery('.header_title_row').css('display', 'none');
					jQuery('.header_image_row').css('display', 'table-row');
				}
				else
				{
					jQuery('.header_title_row').css('display', 'table-row');
					jQuery('.header_image_row').css('display', 'table-row');
				}
			}
		});
	</script>
	
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
				
				<tr valign="top"><th scope="row"><?php _e( 'Header Type' ); ?><div></div></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e('Header Type'); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $radio_options as $option ) {
								$radio_setting = $options['header_type'];

								if ( '' != $radio_setting ) {
									if ( $options['header_type'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="bones_theme_options[header_type]" class="header_type" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>

				<tr class="header_image_row" valign="top"><th scope="row"><?php _e('Header Image Width'); ?></th>
					<td>
						<input id="bones_theme_options[header_width]" class="regular-text" type="text" name="bones_theme_options[header_width]" value="<?php esc_attr_e( $options['header_width'] ); ?>" />
						<label class="description" for="bones_theme_options[header_width]"><?php _e( 'width for header image' ); ?></label>
					</td>
				</tr>
				
				<tr class="header_image_row" valign="top"><th scope="row"><?php _e('Header Image Height'); ?></th>
					<td>
						<input id="bones_theme_options[header_height]" class="regular-text" type="text" name="bones_theme_options[header_height]" value="<?php esc_attr_e( $options['header_height'] ); ?>" />
						<label class="description" for="bones_theme_options[header_height]"><?php _e( 'height for header image' ); ?></label>
					</td>
				</tr>

				<tr class="header_title_row" valign="top"><th scope="row"><?php _e('Header Title'); ?></th>
					<td>
						<input id="bones_theme_options[header_title]" class="regular-text" type="text" name="bones_theme_options[header_title]" value="<?php esc_attr_e( $options['header_title'] ); ?>" />
						<label class="description" for="bones_theme_options[header_title]"><?php _e( 'text for header title' ); ?></label>
					</td>
				</tr>
				
				<tr class="header_title_row" valign="top"><th scope="row"><?php _e('Header Sub Title'); ?></th>
					<td>
						<input id="bones_theme_options[header_subtitle]" class="regular-text" type="text" name="bones_theme_options[header_subtitle]" value="<?php esc_attr_e( $options['header_subtitle'] ); ?>" />
						<label class="description" for="bones_theme_options[header_subtitle]"><?php _e( 'text for header subtitle' ); ?></label>
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
	global $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['header_type'] ) )
		$input['header_type'] = null;
	if ( ! array_key_exists( $input['header_type'], $radio_options ) )
		$input['header_type'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/