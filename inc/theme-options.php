<?php
/**
 * Theme options.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
|--------------------------------------------------------------------------
| Defaults
|--------------------------------------------------------------------------
*/

/**
 * Get theme option defaults.
 *
 * @return array
 */
function gyad_get_theme_option_defaults() {

	return array(

		'facebook_url'  => '',
		'instagram_url' => '',
		'youtube_url'   => '',

		'hec_url'       => '',
		'ppsc_url'      => '',
		'fpsc_url'      => '',
		'nts_url'       => '',
		'etea_url'      => '',
		'bise_url'      => '',
		'nacta_url'     => '',
		'pec_url'       => '',

	);
}


/*
|--------------------------------------------------------------------------
| Register settings
|--------------------------------------------------------------------------
*/

/**
 * Register theme settings.
 *
 * @return void
 */
function gyad_register_theme_options() {

	register_setting(
		'gyad_theme_options',
		'gyad_theme_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'gyad_sanitize_theme_options',
			'default'           => gyad_get_theme_option_defaults(),
		)
	);

}

add_action(
	'admin_init',
	'gyad_register_theme_options'
);


/*
|--------------------------------------------------------------------------
| Admin menu
|--------------------------------------------------------------------------
*/

/**
 * Add theme settings page.
 *
 * @return void
 */
function gyad_add_theme_options_page() {

	add_options_page(
		'GYAD Theme Settings',
		'GYAD Theme Settings',
		'manage_options',
		'gyad-theme-settings',
		'gyad_render_theme_options_page'
	);

}

add_action(
	'admin_menu',
	'gyad_add_theme_options_page'
);


/*
|--------------------------------------------------------------------------
| Sanitize
|--------------------------------------------------------------------------
*/

/**
 * Sanitize theme options.
 *
 * @param array $options Submitted options.
 * @return array
 */
function gyad_sanitize_theme_options( $options ) {

	$options  = is_array( $options ) ? $options : array();
	$defaults = gyad_get_theme_option_defaults();
	$clean    = array();

	foreach ( $defaults as $key => $default ) {

		$value = isset( $options[ $key ] )
			? wp_unslash( $options[ $key ] )
			: '';

		$clean[ $key ] = esc_url_raw( $value );
	}

	return $clean;
}


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

/**
 * Get a theme option.
 *
 * @param string $key Option key.
 * @return string
 */
function gyad_get_theme_option( $key ) {

	$options = get_option(
		'gyad_theme_options',
		gyad_get_theme_option_defaults()
	);

	if (
		! is_array( $options ) ||
		! array_key_exists( $key, $options )
	) {
		return '';
	}

	return $options[ $key ];
}


/*
|--------------------------------------------------------------------------
| Settings page
|--------------------------------------------------------------------------
*/

/**
 * Render theme settings page.
 *
 * @return void
 */
function gyad_render_theme_options_page() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = get_option(
		'gyad_theme_options',
		gyad_get_theme_option_defaults()
	);
	?>

	<div class="wrap">

		<h1>GYAD Theme Settings</h1>

		<p>
			Manage the official links and social profiles used throughout
			Get Your Answers Daily.
		</p>

		<form
			method="post"
			action="options.php"
		>

			<?php settings_fields( 'gyad_theme_options' ); ?>

			<h2 class="title">
				Social Profiles
			</h2>

			<table class="form-table" role="presentation">

				<tr>
					<th scope="row">
						<label for="gyad-facebook-url">
							Facebook
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-facebook-url"
							name="gyad_theme_options[facebook_url]"
							value="<?php echo esc_attr( $options['facebook_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="https://facebook.com/..."
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-instagram-url">
							Instagram
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-instagram-url"
							name="gyad_theme_options[instagram_url]"
							value="<?php echo esc_attr( $options['instagram_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="https://instagram.com/..."
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-youtube-url">
							YouTube
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-youtube-url"
							name="gyad_theme_options[youtube_url]"
							value="<?php echo esc_attr( $options['youtube_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="https://youtube.com/..."
						>
					</td>
				</tr>

			</table>


			<h2 class="title">
				Important Links
			</h2>

			<table class="form-table" role="presentation">

				<tr>
					<th scope="row">
						<label for="gyad-hec-url">
							HEC Portal
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-hec-url"
							name="gyad_theme_options[hec_url]"
							value="<?php echo esc_attr( $options['hec_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official HEC URL"
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-ppsc-url">
							PPSC
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-ppsc-url"
							name="gyad_theme_options[ppsc_url]"
							value="<?php echo esc_attr( $options['ppsc_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official PPSC URL"
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-fpsc-url">
							FPSC
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-fpsc-url"
							name="gyad_theme_options[fpsc_url]"
							value="<?php echo esc_attr( $options['fpsc_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official FPSC URL"
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-nts-url">
							NTS
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-nts-url"
							name="gyad_theme_options[nts_url]"
							value="<?php echo esc_attr( $options['nts_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official NTS URL"
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-etea-url">
							ETEA
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-etea-url"
							name="gyad_theme_options[etea_url]"
							value="<?php echo esc_attr( $options['etea_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official ETEA URL"
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-bise-url">
							BISE Boards
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-bise-url"
							name="gyad_theme_options[bise_url]"
							value="<?php echo esc_attr( $options['bise_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official BISE portal"
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-nacta-url">
							NACTA
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-nacta-url"
							name="gyad_theme_options[nacta_url]"
							value="<?php echo esc_attr( $options['nacta_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official NACTA URL"
						>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="gyad-pec-url">
							PEC
						</label>
					</th>

					<td>
						<input
							type="url"
							id="gyad-pec-url"
							name="gyad_theme_options[pec_url]"
							value="<?php echo esc_attr( $options['pec_url'] ?? '' ); ?>"
							class="regular-text"
							placeholder="Official PEC URL"
						>
					</td>
				</tr>

			</table>

			<?php submit_button( 'Save GYAD Settings' ); ?>

		</form>

	</div>

	<?php
}