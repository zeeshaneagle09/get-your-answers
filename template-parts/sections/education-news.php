<?php
/**
 * Education news section.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$education_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
	)
);
?>

<section class="education-news-section">

	<div class="container">

		<div class="section-heading section-heading--clean">

			<h2>Education News</h2>

			<a
				class="section-heading__link"
				href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"
			>
				<span>View All</span>
				<?php echo gyad_icon( 'arrow-right' ); ?>
			</a>

		</div>

		<?php if ( $education_query->have_posts() ) : ?>

			<div class="education-news-grid">

				<?php while ( $education_query->have_posts() ) : ?>

					<?php $education_query->the_post(); ?>

					<?php
					get_template_part(
						'template-parts/cards/news-card'
					);
					?>

				<?php endwhile; ?>

			</div>

		<?php else : ?>

			<div class="news-empty">

				<div class="news-empty__icon">
					<?php echo gyad_icon( 'search' ); ?>
				</div>

				<h3>Education news will appear here.</h3>

				<p>
					Publish your first post from WordPress Admin
					to populate this section.
				</p>

			</div>

		<?php endif; ?>

	</div>

</section>

<?php wp_reset_postdata(); ?>