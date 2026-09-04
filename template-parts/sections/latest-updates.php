<?php
/**
 * Latest education updates.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$latest_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
	)
);
?>

<section class="home-latest">

	<div class="container">

		<div class="section-heading section-heading--clean">

			<h2>Latest Education Updates</h2>

			<a
				class="section-heading__link"
				href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"
			>
				<span>View All</span>
				<?php echo gyad_icon( 'arrow-right' ); ?>
			</a>

		</div>

		<?php if ( $latest_query->have_posts() ) : ?>

			<div class="latest-layout">

				<div class="latest-news-grid">

					<?php while ( $latest_query->have_posts() ) : ?>

						<?php $latest_query->the_post(); ?>

						<?php
						get_template_part(
							'template-parts/cards/news-card'
						);
						?>

					<?php endwhile; ?>

				</div>

				<?php
				get_template_part(
					'template-parts/sections/trending'
				);
				?>

			</div>

		<?php else : ?>

			<div class="empty-state">

				<div class="empty-state__icon">
					<?php echo gyad_icon( 'search' ); ?>
				</div>

				<h3>
					Your latest education updates will appear here.
				</h3>

				<p>
					Publish your first WordPress post to start populating this section.
				</p>

			</div>

		<?php endif; ?>

	</div>

</section>

<?php wp_reset_postdata(); ?>