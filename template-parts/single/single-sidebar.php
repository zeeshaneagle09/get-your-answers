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
	: get_post_meta( $post_id, 'institution_name', true );

$official_url = function_exists( 'gyad_get_single_official_url' )
	? gyad_get_single_official_url( $post_id )
	: get_post_meta( $post_id, 'official_url', true );

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

$archive_map = array(
	'admission'   => 'admissions',
	'job'         => 'jobs',
	'result'      => 'results',
	'exam'        => 'exams',
	'scholarship' => 'scholarships',
	'course'      => 'courses',
);

$archive_slug = isset( $archive_map[ $post_type ] ) ? $archive_map[ $post_type ] : '';
$archive_url  = $archive_slug ? home_url( '/' . $archive_slug . '/' ) : home_url( '/' );

$institution_label = in_array( $post_type, array( 'job', 'scholarship' ), true )
	? 'Organization'
	: ( 'course' === $post_type ? 'Provider' : 'Institution' );

$toc_items = function_exists( 'gyad_get_table_of_contents' )
	? gyad_get_table_of_contents( get_post_field( 'post_content', $post_id ) )
	: array();

$toc_items = array_slice( $toc_items, 0, 10 );

$latest_items = function_exists( 'gyad_get_related_posts' )
	? gyad_get_related_posts( get_post( $post_id ), 4 )
	: array();

$most_read_items = function_exists( 'gyad_get_discovery_posts' )
	? gyad_get_discovery_posts( 4, $post_type, $post_id )
	: array();
?>

<aside class="single-sidebar">
	<div class="single-sidebar__sticky">

		<a class="single-sidebar__back" href="<?php echo esc_url( $archive_url ); ?>">
			<span aria-hidden="true">←</span>
			<span>Back to <?php echo esc_html( $config['label'] ); ?>s</span>
		</a>

		<?php if ( count( $toc_items ) >= 3 ) : ?>
			<nav class="single-sidebar__block single-sidebar__toc" aria-label="Article contents">
				<div class="single-sidebar__label">On this page</div>
				<h2 class="single-sidebar__title">Contents</h2>
				<ol>
					<?php foreach ( $toc_items as $item ) : ?>
						<li class="<?php echo 3 === (int) $item['level'] ? 'single-sidebar__toc-sub' : ''; ?>">
							<a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ol>
			</nav>
		<?php endif; ?>

		<div class="single-sidebar__block">
			<div class="single-sidebar__label">Quick information</div>
			<h2 class="single-sidebar__title"><?php echo esc_html( $config['label'] ); ?> details</h2>

			<?php if ( $institution ) : ?>
				<div class="single-sidebar__meta-row">
					<span><?php echo esc_html( $institution_label ); ?></span>
					<strong><?php echo esc_html( $institution ); ?></strong>
				</div>
			<?php endif; ?>

			<?php if ( $primary_date && $date_label ) : ?>
				<div class="single-sidebar__meta-row single-sidebar__meta-row--deadline single-sidebar__meta-row--<?php echo esc_attr( $date_state ); ?>">
					<span><?php echo esc_html( $date_label ); ?></span>
					<strong>
						<?php
						$timestamp = strtotime( $primary_date );
						echo esc_html( $timestamp ? wp_date( get_option( 'date_format' ), $timestamp ) : $primary_date );
						?>
					</strong>
				</div>
				<?php if ( $date_status ) : ?>
					<div class="single-sidebar__deadline-status"><?php echo esc_html( $date_status ); ?></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<?php if ( $official_url ) : ?>
			<div class="single-sidebar__block single-sidebar__block--action">
				<div class="single-sidebar__label">Official action</div>
				<h2 class="single-sidebar__title">Ready to continue?</h2>
				<p class="single-sidebar__description">Use the official source for the latest application, result or course information.</p>
				<a class="single-sidebar__action" href="<?php echo esc_url( $official_url ); ?>" target="_blank" rel="noopener noreferrer">
					<span><?php echo esc_html( ! empty( $config['action_label'] ) ? $config['action_label'] : 'Visit Official Website' ); ?></span>
					<?php echo gyad_icon( 'arrow-right' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="single-sidebar__block single-sidebar__block--confidence">
			<div class="single-sidebar__label">GYAD guide</div>
			<h2 class="single-sidebar__title">Use official information</h2>
			<p class="single-sidebar__description">Details can change. Always verify deadlines, eligibility and requirements with the official source.</p>
		</div>

		<?php if ( ! empty( $latest_items ) ) : ?>
			<div class="single-sidebar__block single-sidebar__latest">
				<div class="single-sidebar__label">Keep exploring</div>
				<h2 class="single-sidebar__title">Related updates</h2>
				<ul>
					<?php foreach ( $latest_items as $latest ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $latest ) ); ?>">
								<strong><?php echo esc_html( get_the_title( $latest ) ); ?></strong>
								<small><?php echo esc_html( get_the_date( get_option( 'date_format' ), $latest ) ); ?></small>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $most_read_items ) ) : ?>
			<div class="single-sidebar__block single-sidebar__latest">
				<div class="single-sidebar__label">Popular now</div>
				<h2 class="single-sidebar__title">Most read</h2>
				<ul>
					<?php foreach ( $most_read_items as $popular ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $popular ) ); ?>">
								<strong><?php echo esc_html( get_the_title( $popular ) ); ?></strong>
								<small>
									<?php
									$views = function_exists( 'gyad_get_post_views' ) ? gyad_get_post_views( $popular ) : 0;
									echo esc_html( $views > 0 ? number_format_i18n( $views ) . ' reads' : 'Latest update' );
									?>
								</small>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="single-sidebar__block">
			<div class="single-sidebar__label">Explore more</div>
			<h2 class="single-sidebar__title">More <?php echo esc_html( strtolower( $config['label'] ) ); ?>s</h2>
			<a class="single-sidebar__action single-sidebar__action--secondary" href="<?php echo esc_url( $archive_url ); ?>">
				<span>View all <?php echo esc_html( strtolower( $config['label'] ) ); ?>s</span>
				<?php echo gyad_icon( 'arrow-right' ); ?>
			</a>
		</div>

	</div>
</aside>
