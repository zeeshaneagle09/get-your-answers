<?php
/**
 * Education news page.
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

$news_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
	)
);
?>

<main class="news-page">

	<div class="container">

		<header class="portal-page-header">

			<span class="portal-page-header__eyebrow">
				Latest Updates
			</span>

			<h1 class="portal-page-header__title">
				Education News
			</h1>

			<p class="portal-page-header__description">
				Latest education news, announcements, policy updates,
				exams and important developments for students.
			</p>

		</header>


		<?php if ( $news_query->have_posts() ) : ?>

			<div class="news-page__bar">

				<p>
					<?php
					printf(
						esc_html(
							_n(
								'%s article',
								'%s articles',
								(int) $news_query->found_posts,
								'get-your-answers-daily'
							)
						),
						number_format_i18n(
							$news_query->found_posts
						)
					);
					?>
				</p>

			</div>


			<div class="news-page__grid">

				<?php while ( $news_query->have_posts() ) : ?>

					<?php $news_query->the_post(); ?>

					<?php
					get_template_part(
						'template-parts/archive/archive-card'
					);
					?>

				<?php endwhile; ?>

			</div>


			<?php
			echo paginate_links(
				array(
					'total'     => $news_query->max_num_pages,
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
					<?php echo gyad_icon( 'search' ); ?>
				</div>

				<h2>
					No education news yet
				</h2>

				<p>
					Publish your first WordPress post to start
					populating Education News.
				</p>

			</div>

		<?php endif; ?>

	</div>

</main>

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>