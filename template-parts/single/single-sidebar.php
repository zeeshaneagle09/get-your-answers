<?php
/**
 * Smart single article sidebar.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id   = get_the_ID();
$post_type = get_post_type( $post_id );

$config = function_exists( 'gyad_get_single_config' )
	? gyad_get_single_config( $post_type )
	: array(
		'label'        => 'Education',
		'action_label' => '',
		'accent'       => 'blue',
	);

$institution = function_exists( 'gyad_get_single_institution' )
	? gyad_get_single_institution( $post_id )
	: get_post_meta(
		$post_id,
		'institution_name',
		true
	);

$official_url = function_exists( 'gyad_get_single_official_url' )
	? gyad_get_single_official_url( $post_id )
	: get_post_meta(
		$post_id,
		'official_url',
		true
	);

$primary_date = function_exists( 'gyad_get_single_primary_date' )
	? gyad_get_single_primary_date( $post_id )
	: '';

$date_state = $primary_date && function_exists( 'gyad_get_single_date_state' )
	? gyad_get_single_date_state( $primary_date )
	: '';

$date_status = $primary_date && function_exists( 'gyad_get_single_date_status_text' )
	? gyad_get_single_date_status_text( $primary_date )
	: '';

$date_label = '';

switch ( $post_type ) {

	case 'admission':
	case 'job':
	case 'scholarship':
		$date_label = 'Application Deadline';
		break;

	case 'result':
		$date_label = 'Result Date';
		break;

	case 'exam':
		$date_label = 'Exam Date';
		break;
}


/*
|--------------------------------------------------------------------------
| Browse destination
|--------------------------------------------------------------------------
*/

$archive_map = array(
	'admission'   => 'admissions',
	'job'         => 'jobs',
	'result'      => 'results',
	'exam'        => 'exams',
	'scholarship' => 'scholarships',
	'course'      => 'courses',
);

$archive_slug = isset(
	$archive_map[ $post_type ]
)
	? $archive_map[ $post_type ]
	: '';

$archive_url = $archive_slug
	? home_url( '/' . $archive_slug . '/' )
	: home_url( '/' );


/*
|--------------------------------------------------------------------------
| Contextual label
|--------------------------------------------------------------------------
*/

$institution_label = 'Institution';

if ( in_array(
	$post_type,
	array(
		'job',
		'scholarship',
	),
	true
) ) {
	$institution_label = 'Organization';
}

if ( 'course' === $post_type ) {
	$institution_label = 'Provider';
}
?>

<aside class="single-sidebar">


	<?php
	/*
	|--------------------------------------------------------------------------
	| Back link
	|--------------------------------------------------------------------------
	*/

	?>

	<a
		class="single-sidebar__back"
		href="<?php echo esc_url( $archive_url ); ?>"
	>

		<span aria-hidden="true">
			←
		</span>

		<span>
			Back to <?php echo esc_html( $config['label'] ); ?>s
		</span>

	</a>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Quick information
	|--------------------------------------------------------------------------
	*/

	?>

	<div class="single-sidebar__block">

		<div class="single-sidebar__label">
			Quick information
		</div>

		<h2 class="single-sidebar__title">
			<?php echo esc_html( $config['label'] ); ?> details
		</h2>


		<?php if ( $institution ) : ?>

			<div class="single-sidebar__meta-row">

				<span>
					<?php echo esc_html( $institution_label ); ?>
				</span>

				<strong>
					<?php echo esc_html( $institution ); ?>
				</strong>

			</div>

		<?php endif; ?>


		<?php if ( $primary_date && $date_label ) : ?>

			<div
				class="single-sidebar__meta-row single-sidebar__meta-row--deadline single-sidebar__meta-row--<?php echo esc_attr( $date_state ); ?>"
			>

				<span>
					<?php echo esc_html( $date_label ); ?>
				</span>

				<strong>
					<?php
					$timestamp = strtotime(
						$primary_date
					);

					echo esc_html(
						$timestamp
							? wp_date(
								get_option( 'date_format' ),
								$timestamp
							)
							: $primary_date
					);
					?>
				</strong>

			</div>

			<?php if ( $date_status ) : ?>

				<div class="single-sidebar__deadline-status">
					<?php echo esc_html( $date_status ); ?>
				</div>

			<?php endif; ?>

		<?php endif; ?>


	</div>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Official action
	|--------------------------------------------------------------------------
	*/

	if ( $official_url ) :
	?>

		<div class="single-sidebar__block single-sidebar__block--action">

			<div class="single-sidebar__label">
				Official action
			</div>

			<h2 class="single-sidebar__title">
				Ready to continue?
			</h2>

			<p class="single-sidebar__description">
				Use the official source for the latest application,
				result or course information.
			</p>

			<a
				class="single-sidebar__action"
				href="<?php echo esc_url( $official_url ); ?>"
				target="_blank"
				rel="noopener noreferrer"
			>

				<span>
					<?php
					echo esc_html(
						! empty( $config['action_label'] )
							? $config['action_label']
							: 'Visit Official Website'
					);
					?>
				</span>

				<?php echo gyad_icon( 'arrow-right' ); ?>

			</a>

		</div>

	<?php endif; ?>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Student confidence card
	|--------------------------------------------------------------------------
	*/

	?>

	<div class="single-sidebar__block single-sidebar__block--confidence">

		<div class="single-sidebar__label">
			GYAD guide
		</div>

		<h2 class="single-sidebar__title">
			Use official information
		</h2>

		<p class="single-sidebar__description">
			Details can change. Always verify deadlines,
			eligibility and requirements with the official source.
		</p>

	</div>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Browse more
	|--------------------------------------------------------------------------
	*/

	?>

	<div class="single-sidebar__block">

		<div class="single-sidebar__label">
			Explore more
		</div>

		<h2 class="single-sidebar__title">
			More <?php echo esc_html( strtolower( $config['label'] ) ); ?>s
		</h2>

		<a
			class="single-sidebar__action single-sidebar__action--secondary"
			href="<?php echo esc_url( $archive_url ); ?>"
		>

			<span>
				View all <?php echo esc_html( strtolower( $config['label'] ) ); ?>s
			</span>

			<?php echo gyad_icon( 'arrow-right' ); ?>

		</a>

	</div>


</aside>