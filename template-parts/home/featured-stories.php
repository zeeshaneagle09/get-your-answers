<?php
/**
 * Homepage featured stories.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stories = function_exists( 'gyad_homepage_featured_query' )
	? gyad_homepage_featured_query()
	: array();

if ( empty( $stories ) ) {
	return;
}

$lead_story = $stories[0];
$side_stories = array_slice(
	$stories,
	1,
	4
);
?>

<section class="homepage-featured">

	<div class="container">

		<div class="homepage-section-heading">

			<div>

				<span class="homepage-section-heading__eyebrow">
					Editor's Pick
				</span>

				<h2 class="homepage-section-heading__title">
					What's happening in education
				</h2>

			</div>

			<a
				class="homepage-section-heading__link"
				href="<?php echo esc_url( home_url( '/education-news/' ) ); ?>"
			>
				View all news
				<?php echo gyad_icon( 'arrow-right' ); ?>
			</a>

		</div>


		<div class="homepage-featured__grid">


			<article class="homepage-featured__lead">

				<a
					class="homepage-featured__lead-media"
					href="<?php echo esc_url( get_permalink( $lead_story->ID ) ); ?>"
					aria-label="<?php echo esc_attr( get_the_title( $lead_story->ID ) ); ?>"
				>

					<?php if ( has_post_thumbnail( $lead_story->ID ) ) : ?>

						<?php
						echo get_the_post_thumbnail(
							$lead_story->ID,
							'gyad-archive',
							array(
								'loading'  => 'eager',
								'decoding' => 'async',
								'fetchpriority' => 'high',
							)
						);
						?>

					<?php else : ?>

						<div class="homepage-featured__placeholder">
							Education News
						</div>

					<?php endif; ?>

					<span class="homepage-featured__lead-overlay"></span>

					<span class="homepage-featured__lead-copy">

						<span class="homepage-featured__category">
							<?php
							echo esc_html(
								gyad_homepage_post_category(
									$lead_story->ID
								)
							);
							?>
						</span>

						<strong class="homepage-featured__lead-title">
							<?php echo esc_html( get_the_title( $lead_story->ID ) ); ?>
						</strong>

						<span class="homepage-featured__lead-meta">

							<?php
							echo esc_html(
								get_the_date(
									get_option( 'date_format' ),
									$lead_story->ID
								)
							);
							?>

							<span aria-hidden="true">•</span>

							<?php
							echo esc_html(
								gyad_homepage_post_reading_time(
									$lead_story->ID
								)
							);
							?>
							min read

						</span>

					</span>

				</a>

			</article>


			<?php if ( ! empty( $side_stories ) ) : ?>

				<div class="homepage-featured__side">

					<?php foreach ( $side_stories as $story ) : ?>

						<article class="homepage-featured__side-item">

							<a
								class="homepage-featured__side-image"
								href="<?php echo esc_url( get_permalink( $story->ID ) ); ?>"
								aria-label="<?php echo esc_attr( get_the_title( $story->ID ) ); ?>"
							>

								<?php if ( has_post_thumbnail( $story->ID ) ) : ?>

									<?php
									echo get_the_post_thumbnail(
										$story->ID,
										'gyad-card-small',
										array(
											'loading'  => 'lazy',
											'decoding' => 'async',
										)
									);
									?>

								<?php else : ?>

									<div class="homepage-featured__side-placeholder">
										News
									</div>

								<?php endif; ?>

							</a>


							<div class="homepage-featured__side-content">

								<span class="homepage-featured__side-category">
									<?php
									echo esc_html(
										gyad_homepage_post_category(
											$story->ID
										)
									);
									?>
								</span>

								<h3>
									<a
										href="<?php echo esc_url( get_permalink( $story->ID ) ); ?>"
									>
										<?php echo esc_html( get_the_title( $story->ID ) ); ?>
									</a>
								</h3>

								<span class="homepage-featured__side-date">
									<?php echo esc_html( get_the_date( get_option( 'date_format' ), $story->ID ) ); ?>
								</span>

							</div>

						</article>

					<?php endforeach; ?>

				</div>

			<?php endif; ?>


		</div>

	</div>

</section>