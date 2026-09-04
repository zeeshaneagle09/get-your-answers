<?php
/**
 * Custom metadata and admin fields.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
|--------------------------------------------------------------------------
| Configuration
|--------------------------------------------------------------------------
*/

function gyad_meta_field_config() {

	return array(

		'admission' => array(
			array(
				'key'   => 'institution_name',
				'label' => 'Institution / University',
				'type'  => 'text',
				'placeholder' => 'e.g. University of Punjab',
			),
			array(
				'key'   => 'application_deadline',
				'label' => 'Application Deadline',
				'type'  => 'date',
			),
			array(
				'key'   => 'application_fee',
				'label' => 'Application Fee',
				'type'  => 'text',
				'placeholder' => 'e.g. Rs. 1,500',
			),
			array(
				'key'   => 'location',
				'label' => 'Location',
				'type'  => 'text',
				'placeholder' => 'e.g. Lahore, Punjab',
			),
			array(
				'key'   => 'official_url',
				'label' => 'Official Website',
				'type'  => 'url',
				'placeholder' => 'https://example.com/',
			),
		),

		'job' => array(
			array(
				'key'   => 'institution_name',
				'label' => 'Organization',
				'type'  => 'text',
				'placeholder' => 'e.g. Punjab Public Service Commission',
			),
			array(
				'key'   => 'application_deadline',
				'label' => 'Application Deadline',
				'type'  => 'date',
			),
			array(
				'key'   => 'location',
				'label' => 'Location',
				'type'  => 'text',
				'placeholder' => 'e.g. Lahore, Punjab',
			),
			array(
				'key'   => 'salary',
				'label' => 'Salary',
				'type'  => 'text',
				'placeholder' => 'e.g. Rs. 60,000 - 80,000',
			),
			array(
				'key'   => 'official_url',
				'label' => 'Official Job Details',
				'type'  => 'url',
				'placeholder' => 'https://example.com/',
			),
		),

		'result' => array(
			array(
				'key'   => 'institution_name',
				'label' => 'Board / Organization',
				'type'  => 'text',
				'placeholder' => 'e.g. BISE Sargodha',
			),
			array(
				'key'   => 'result_class',
				'label' => 'Class / Examination',
				'type'  => 'text',
				'placeholder' => 'e.g. 10th Class Annual Result',
			),
			array(
				'key'   => 'result_date',
				'label' => 'Result Date',
				'type'  => 'date',
			),
			array(
				'key'   => 'official_url',
				'label' => 'Official Result Portal',
				'type'  => 'url',
				'placeholder' => 'https://example.com/',
			),
		),

		'exam' => array(
			array(
				'key'   => 'institution_name',
				'label' => 'Organization / Board',
				'type'  => 'text',
				'placeholder' => 'e.g. BISE Sargodha',
			),
			array(
				'key'   => 'exam_date',
				'label' => 'Exam Date',
				'type'  => 'date',
			),
			array(
				'key'   => 'application_deadline',
				'label' => 'Registration Deadline',
				'type'  => 'date',
			),
			array(
				'key'   => 'official_url',
				'label' => 'Official Exam Website',
				'type'  => 'url',
				'placeholder' => 'https://example.com/',
			),
		),

		'scholarship' => array(
			array(
				'key'   => 'institution_name',
				'label' => 'Organization',
				'type'  => 'text',
				'placeholder' => 'e.g. HEC',
			),
			array(
				'key'   => 'application_deadline',
				'label' => 'Application Deadline',
				'type'  => 'date',
			),
			array(
				'key'   => 'eligibility',
				'label' => 'Eligibility',
				'type'  => 'text',
				'placeholder' => 'e.g. Undergraduate students',
			),
			array(
				'key'   => 'official_url',
				'label' => 'Official Scholarship Website',
				'type'  => 'url',
				'placeholder' => 'https://example.com/',
			),
		),

		'course' => array(
			array(
				'key'   => 'institution_name',
				'label' => 'Provider',
				'type'  => 'text',
				'placeholder' => 'e.g. University of Lahore',
			),
			array(
				'key'   => 'course_duration',
				'label' => 'Duration',
				'type'  => 'text',
				'placeholder' => 'e.g. 4 Years',
			),
			array(
				'key'   => 'course_level',
				'label' => 'Level',
				'type'  => 'text',
				'placeholder' => 'e.g. Undergraduate',
			),
			array(
				'key'   => 'official_url',
				'label' => 'Official Course Website',
				'type'  => 'url',
				'placeholder' => 'https://example.com/',
			),
		),

	);

}


/*
|--------------------------------------------------------------------------
| REST meta
|--------------------------------------------------------------------------
*/

function gyad_register_meta_fields() {

	$post_types = array(
		'admission',
		'job',
		'result',
		'exam',
		'scholarship',
		'course',
	);

	$config = gyad_meta_field_config();

	foreach ( $post_types as $post_type ) {

		if ( empty( $config[ $post_type ] ) ) {
			continue;
		}

		foreach ( $config[ $post_type ] as $field ) {

			register_post_meta(
				$post_type,
				$field['key'],
				array(
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);

		}
	}
}

add_action(
	'init',
	'gyad_register_meta_fields'
);


/*
|--------------------------------------------------------------------------
| Admin meta boxes
|--------------------------------------------------------------------------
*/

function gyad_add_content_meta_boxes() {

	$config = gyad_meta_field_config();

	foreach ( array_keys( $config ) as $post_type ) {

		add_meta_box(
			'gyad_content_information',
			'Content Information',
			'gyad_render_content_meta_box',
			$post_type,
			'normal',
			'high'
		);

	}

}

add_action(
	'add_meta_boxes',
	'gyad_add_content_meta_boxes'
);


/*
|--------------------------------------------------------------------------
| Render fields
|--------------------------------------------------------------------------
*/

function gyad_render_content_meta_box( $post ) {

	$config = gyad_meta_field_config();

	$post_type = get_post_type( $post );

	if (
		! $post_type ||
		empty( $config[ $post_type ] )
	) {
		return;
	}

	wp_nonce_field(
		'gyad_save_content_information',
		'gyad_content_information_nonce'
	);
	?>

	<div class="gyad-meta-fields">

		<?php foreach ( $config[ $post_type ] as $field ) : ?>

			<?php
			$value = get_post_meta(
				$post->ID,
				$field['key'],
				true
			);
			?>

			<p>

				<label for="<?php echo esc_attr( 'gyad_' . $field['key'] ); ?>">

					<strong>
						<?php echo esc_html( $field['label'] ); ?>
					</strong>

				</label>

				<input
					type="<?php echo esc_attr( $field['type'] ); ?>"
					id="<?php echo esc_attr( 'gyad_' . $field['key'] ); ?>"
					name="<?php echo esc_attr( 'gyad_' . $field['key'] ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					class="widefat"
					<?php
					if ( ! empty( $field['placeholder'] ) ) {
						echo 'placeholder="' . esc_attr( $field['placeholder'] ) . '"';
					}
					?>
				>

			</p>

		<?php endforeach; ?>

		<p class="description">
			These fields are used automatically throughout the website.
		</p>

	</div>

	<?php
}


/*
|--------------------------------------------------------------------------
| Save fields
|--------------------------------------------------------------------------
*/

function gyad_save_content_meta( $post_id ) {

	if (
		! isset(
			$_POST['gyad_content_information_nonce']
		)
	) {
		return;
	}

	$nonce = sanitize_text_field(
		wp_unslash(
			$_POST['gyad_content_information_nonce']
		)
	);

	if (
		! wp_verify_nonce(
			$nonce,
			'gyad_save_content_information'
		)
	) {
		return;
	}

	if (
		defined( 'DOING_AUTOSAVE' ) &&
		DOING_AUTOSAVE
	) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if (
		! current_user_can(
			'edit_post',
			$post_id
		)
	) {
		return;
	}

	$post_type = get_post_type( $post_id );

	$config = gyad_meta_field_config();

	if (
		! $post_type ||
		empty( $config[ $post_type ] )
	) {
		return;
	}

	foreach ( $config[ $post_type ] as $field ) {

		$field_name = 'gyad_' . $field['key'];

		$value = isset( $_POST[ $field_name ] )
			? wp_unslash( $_POST[ $field_name ] )
			: '';

		if ( 'url' === $field['type'] ) {
			$value = esc_url_raw( $value );
		} elseif ( 'date' === $field['type'] ) {
			$value = sanitize_text_field( $value );

			if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $value ) ) {
				$value = '';
			}
		} else {
			$value = sanitize_text_field( $value );
		}

		if ( '' === $value ) {

			delete_post_meta(
				$post_id,
				$field['key']
			);

		} else {

			update_post_meta(
				$post_id,
				$field['key'],
				$value
			);

		}

	}

}

add_action(
	'save_post',
	'gyad_save_content_meta'
);


/*
|--------------------------------------------------------------------------
| Admin styling
|--------------------------------------------------------------------------
*/

function gyad_admin_meta_styles( $hook ) {

	if (
		'post.php' !== $hook &&
		'post-new.php' !== $hook
	) {
		return;
	}

	?>
	<style>
		.gyad-meta-fields {
			max-width: 900px;
		}

		.gyad-meta-fields p {
			margin: 0 0 18px;
		}

		.gyad-meta-fields label {
			display: block;
			margin-bottom: 7px;
		}

		.gyad-meta-fields input {
			min-height: 40px;
		}

		.gyad-meta-fields .description {
			margin-bottom: 0;
			color: #646970;
		}
	</style>
	<?php
}

add_action(
	'admin_enqueue_scripts',
	'gyad_admin_meta_styles'
);