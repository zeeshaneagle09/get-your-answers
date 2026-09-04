<?php
/**
 * Archive card.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_type = get_post_type();

$config = array(
	'post' => array(
		'taxonomy' => '',
		'label'    => 'Education News',
		'accent'   => 'blue',
	),
	'admission' => array(
		'taxonomy' => 'admission_type',
		'label'    => 'Admission',
		'accent'   => 'blue',
	),
	'job' => array(
		'taxonomy' => 'job_type',
		'label'    => 'Job',
		'accent'   => 'green',
	),
	'result' => array(
		'taxonomy' => 'result_board',
		'label'    => 'Result',
		'accent'   => 'purple',
	),
	'exam' => array(
		'taxonomy' => 'exam_type',
		'label'    => 'Exam',
		'accent'   => 'orange',
	),
	'scholarship' => array(
		'taxonomy' => 'scholarship_type',
		'label'    => 'Scholarship',
		'accent'   => 'teal',
	),
	'course' => array(
		'taxonomy' => 'course_category',
		'label'    => 'Course',
		'accent'   => 'blue',
	),
);

$current = $config[ $post_type ] ?? array(
	'taxonomy' => '',
	'label'    => 'Education',
	'accent'   => 'blue',
);

$terms = false;

if ( $current['taxonomy'] ) {

	$terms = get_the_terms(
		get_the_ID(),
		$current['taxonomy']
	);
}

$term_name = '';

if ( $terms && ! is_wp_error( $terms ) ) {
	$term_name = $terms[0]->name;
}

$image = get_the_post_thumbnail_url(
	get_the_ID(),
	'gyad-archive'
);
?>

<article class="archive-card">

	<a
		class="archive-card__image"
		href="<?php the_permalink(); ?>"
		aria-label="<?php the_title_attribute(); ?>"
	>

		<?php if ( $image ) : ?>

			<img
				src="<?php echo esc_url( $image ); ?>"
				alt="<?php the_title_attribute(); ?>"
				loading="lazy"
				decoding="async"
			>

		<?php else : ?>

			<span
				class="archive-card__placeholder archive-card__placeholder--<?php echo esc_attr( $current['accent'] ); ?>"
			>
				<?php echo esc_html( strtoupper( $current['label'] ) ); ?>
			</span>

		<?php endif; ?>

	</a>

	<div class="archive-card__body">

		<div class="archive-card__meta">

			<span class="archive-card__type">
				<?php echo esc_html( $term_name ?: $current['label'] ); ?>
			</span>

			<span aria-hidden="true">•</span>

			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>

		</div>

		<h2 class="archive-card__title">

			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>

		</h2>

		<?php if ( has_excerpt() ) : ?>

			<p class="archive-card__excerpt">
				<?php echo esc_html( get_the_excerpt() ); ?>
			</p>

		<?php endif; ?>

		<a
			class="archive-card__link"
			href="<?php the_permalink(); ?>"
		>
			<span>Read More</span>
			<?php echo gyad_icon( 'arrow-right' ); ?>
		</a>

	</div>

</article>