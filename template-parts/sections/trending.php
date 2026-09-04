<?php
/**
 * Trending section.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$trending_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 5,
		'ignore_sticky_posts' => true,
	)
);
?>

<aside class="trending-panel">

	<div class="trending-panel__heading">

		<div class="trending-panel__title">

			<span class="trending-panel__symbol" aria-hidden="true">
				↗
			</span>

			<div>
				<h2>Trending Now</h2>
				<span class="trending-panel__subtitle">
					What students are reading
				</span>
			</div>

		</div>

	</div>

	<?php if ( $trending_query->have_posts() ) : ?>

		<div class="trending-list">

			<?php $rank = 1; ?>

			<?php while ( $trending_query->have_posts() ) : ?>

				<?php $trending_query->the_post(); ?>

				<a
					class="trending-item"
					href="<?php the_permalink(); ?>"
				>

					<span class="trending-item__number">
						<?php echo esc_html( sprintf( '%02d', $rank ) ); ?>
					</span>

					<div class="trending-item__content">

						<h3>
							<?php the_title(); ?>
						</h3>

						<div class="trending-item__meta">

							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>

							<span aria-hidden="true">•</span>

							<span>
								<?php echo esc_html( get_comments_number() ); ?>
								<?php echo 1 === (int) get_comments_number() ? 'comment' : 'comments'; ?>
							</span>

						</div>

					</div>

					<span class="trending-item__arrow" aria-hidden="true">
						<?php echo gyad_icon( 'arrow-right' ); ?>
					</span>

				</a>

				<?php $rank++; ?>

			<?php endwhile; ?>

		</div>

	<?php else : ?>

		<div class="trending-empty">
			Publish posts to populate trending content.
		</div>

	<?php endif; ?>

</aside>

<?php wp_reset_postdata(); ?>