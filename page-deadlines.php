<?php
/**
 * Deadlines page.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged = max(
	1,
	(int) get_query_var( 'paged' )
);

$deadline_query = new WP_Query(
	array(
		'post_type'           => array(
			'admission',
			'job',
			'scholarship',
			'exam',
		),
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
		'meta_key'            => 'application_deadline',
		'orderby'             => 'meta_value',
		'meta_type'           => 'DATE',
		'order'               => 'ASC',
		'meta_query'          => array(
			array(
				'key'     => 'application_deadline',
				'value'   => current_time( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	)
);

$category_map = array(
	'admission'   => array(
		'label'  => 'Admissions',
		'accent' => 'blue',
	),
	'job' => array(
		'label'  => 'Jobs',
		'accent' => 'green',
	),
	'scholarship' => array(
		'label'  => 'Scholarships',
		'accent' => 'teal',
	),
	'exam' => array(
		'label'  => 'Exams',
		'accent' => 'orange',
	),
);
?>

<main class="deadline-page">

	<div class="container">

		<header class="portal-page-header">

			<span class="portal-page-header__eyebrow">
				Stay Ahead
			</span>

			<h1 class="portal-page-header__title">
				Important Deadlines
			</h1>

			<p class="portal-page-header__description">
				Keep track of upcoming admission, job, scholarship
				and examination deadlines in one place.
			</p>

		</header>


		<?php if ( $deadline_query->have_posts() ) : ?>

			<div class="deadline-page__bar">

				<p>
					<?php
					printf(
						esc_html(
							_n(
								'%s upcoming deadline',
								'%s upcoming deadlines',
								(int) $deadline_query->found_posts,
								'get-your-answers-daily'
							)
						),
						number_format_i18n(
							$deadline_query->found_posts
						)
					);
					?>
				</p>

			</div>


			<div class="deadline-page__grid">

				<?php while ( $deadline_query->have_posts() ) : ?>

					<?php $deadline_query->the_post(); ?>

					<?php
					$post_type = get_post_type();

					$deadline = gyad_get_deadline();

					$map = $category_map[ $post_type ]
						?? array(
							'label'  => 'Education',
							'accent' => 'blue',
						);

					$card = array(
						'title'     => get_the_title(),
						'category'  => $map['label'],
						'date'      => gyad_format_deadline( $deadline ),
						'month'     => gyad_deadline_month( $deadline ),
						'day'       => gyad_deadline_day( $deadline ),
						'days_left' => gyad_get_deadline_remaining( $deadline ),
						'url'       => get_permalink(),
						'accent'    => $map['accent'],
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


			<?php
			echo paginate_links(
				array(
					'total'     => $deadline_query->max_num_pages,
					'current'   => $paged,
					'mid_size'  => 1,
					'prev_text' => 'Previous',
					'next_text' => 'Next',
					'type'      => 'list',
				)
			);
			?>

		<?php else : ?>

			<div class="portal-empty">

				<div class="portal-empty__icon">
					<?php echo gyad_icon( 'calendar' ); ?>
				</div>

				<h2>
					No upcoming deadlines
				</h2>

				<p>
					New deadlines will appear here when they are
					added to admissions, jobs, scholarships or exams.
				</p>

			</div>

		<?php endif; ?>

	</div>

</main>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>