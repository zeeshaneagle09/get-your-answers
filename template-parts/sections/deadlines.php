<?php
/**
 * Important deadlines section.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$deadline_post_types = array(
	'admission',
	'job',
	'scholarship',
	'exam',
);

$deadline_query = new WP_Query(
	array(
		'post_type'           => $deadline_post_types,
		'post_status'         => 'publish',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'meta_key'            => 'application_deadline',
		'orderby'             => 'meta_value',
		'order'               => 'ASC',
		'meta_type'           => 'DATE',
	)
);
?>

<section class="deadlines-section">

	<div class="container">

		<div class="section-heading section-heading--clean">

			<h2>Important Deadlines</h2>

			<a
				class="section-heading__link"
				href="<?php echo esc_url( home_url( '/deadlines/' ) ); ?>"
			>
				<span>View All</span>
				<?php echo gyad_icon( 'arrow-right' ); ?>
			</a>

		</div>

		<?php if ( $deadline_query->have_posts() ) : ?>

			<div class="deadlines-list">

				<?php while ( $deadline_query->have_posts() ) : ?>

					<?php $deadline_query->the_post(); ?>

					<?php

					$post_type = get_post_type();

					$category_map = array(
						'admission'   => 'Admissions',
						'job'         => 'Jobs',
						'scholarship' => 'Scholarships',
						'exam'        => 'Exams',
					);

					$accent_map = array(
						'admission'   => 'blue',
						'job'         => 'green',
						'scholarship' => 'teal',
						'exam'        => 'orange',
					);

					$deadline = gyad_get_deadline();

					$card = array(
						'title'     => get_the_title(),
						'category'  => $category_map[ $post_type ] ?? 'Education',
						'date'      => gyad_format_deadline( $deadline ),
						'month'     => gyad_deadline_month( $deadline ),
						'day'       => gyad_deadline_day( $deadline ),
						'days_left' => gyad_get_deadline_remaining( $deadline ),
						'url'       => get_permalink(),
						'accent'    => $accent_map[ $post_type ] ?? 'blue',
					);

					get_template_part(
						'template-parts/cards/deadline-card',
						null,
						array(
							'deadline' => $card,
						)
					);

					?>

				<?php endwhile; ?>

			</div>

		<?php else : ?>

			<div class="empty-state">

				<div class="empty-state__icon">
					<?php echo gyad_icon( 'calendar' ); ?>
				</div>

				<h3>
					No upcoming deadlines yet.
				</h3>

				<p>
					Add an application deadline to an Admission, Job,
					Scholarship, or Exam to display it here.
				</p>

			</div>

		<?php endif; ?>

	</div>

</section>

<?php wp_reset_postdata(); ?>