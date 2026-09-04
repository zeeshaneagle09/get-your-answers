<?php
/**
 * Latest education updates.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$latest_posts = function_exists( 'gyad_homepage_latest_news' )
	? gyad_homepage_latest_news( 6 )
	: array();

$news_url = get_post_type_archive_link( 'post' );

if ( ! $news_url ) {
	$news_url = get_permalink( get_option( 'page_for_posts' ) );
}
?>

<section class="home-latest">

	<div class="container">

		<div class="section-heading section-heading--clean">

			<h2>Latest Education Updates</h2>

			<?php if ( $news_url ) : ?>
				<a
					class="section-heading__link"
					href="<?php echo esc_url( $news_url ); ?>"
				>
					<span>View All</span>
					<?php echo gyad_icon( 'arrow-right' ); ?>
				</a>
			<?php endif; ?>

		</div>

		<?php if ( ! empty( $latest_posts ) ) : ?>

			<div class="latest-layout">

				<div class="latest-news-grid">

					<?php foreach ( $latest_posts as $latest_post ) : ?>

						<?php
						if ( ! $latest_post instanceof WP_Post ) {
							continue;
						}

						global $post;
						$post = $latest_post;
						setup_postdata( $post );
						?>

						<?php get_template_part( 'template-parts/cards/news-card' ); ?>

					<?php endforeach; ?>

				</div>

				<?php get_template_part( 'template-parts/sections/trending' ); ?>

			</div>

		<?php else : ?>

			<div class="empty-state">

				<div class="empty-state__icon">
					<?php echo gyad_icon( 'search' ); ?>
				</div>

				<h3>Your latest education updates will appear here.</h3>

				<p>
					Publish your first WordPress post to start populating this section.
				</p>

			</div>

		<?php endif; ?>

	</div>

</section>

<?php wp_reset_postdata(); ?>
