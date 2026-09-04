<?php
/**
 * Homepage quick access.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = function_exists( 'gyad_homepage_quick_access_items' )
	? gyad_homepage_quick_access_items()
	: array();

$counts = function_exists( 'gyad_homepage_content_counts' )
	? gyad_homepage_content_counts()
	: array();

if ( empty( $items ) ) {
	return;
}
?>

<section class="homepage-quick-access">

	<div class="container">

		<div class="homepage-quick-access__header">

			<div>

				<span class="homepage-section-heading__eyebrow">
					Student Hub
				</span>

				<h2 class="homepage-section-heading__title">
					Find what you need
				</h2>

			</div>

		</div>


		<div class="homepage-quick-access__grid">

			<?php foreach ( $items as $item ) : ?>

				<?php
				$count = isset(
					$counts[ $item['type'] ]
				)
					? $counts[ $item['type'] ]
					: 0;
				?>

				<a
					class="homepage-quick-access__item homepage-quick-access__item--<?php echo esc_attr( $item['accent'] ); ?>"
					href="<?php echo esc_url( $item['url'] ); ?>"
				>

					<span class="homepage-quick-access__accent"></span>

					<span class="homepage-quick-access__content">

						<strong>
							<?php echo esc_html( $item['label'] ); ?>
						</strong>

						<span>
							<?php echo esc_html( $item['desc'] ); ?>
						</span>

					</span>

					<span class="homepage-quick-access__count">

						<?php if ( $count > 0 ) : ?>

							<?php echo esc_html( number_format_i18n( $count ) ); ?>

						<?php else : ?>

							—

						<?php endif; ?>

					</span>

					<span class="homepage-quick-access__arrow">

						<?php echo gyad_icon( 'arrow-right' ); ?>

					</span>

				</a>

			<?php endforeach; ?>

		</div>

	</div>

</section>