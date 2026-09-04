<?php
/**
 * Compact content item card.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$item = isset( $args['item'] ) && is_array( $args['item'] )
	? $args['item']
	: array();

if ( empty( $item ) ) {
	return;
}

$title  = isset( $item['title'] ) ? $item['title'] : '';
$date   = isset( $item['date'] ) ? $item['date'] : '';
$meta   = isset( $item['meta'] ) ? $item['meta'] : '';
$image  = isset( $item['image'] ) ? $item['image'] : '';
$url    = isset( $item['url'] ) ? $item['url'] : '#';
$accent = isset( $item['accent'] ) ? $item['accent'] : 'blue';

if ( ! $title ) {
	return;
}
?>

<article class="compact-item compact-item--<?php echo esc_attr( $accent ); ?>">

	<a
		class="compact-item__image"
		href="<?php echo esc_url( $url ); ?>"
		aria-label="<?php echo esc_attr( $title ); ?>"
	>

		<?php if ( $image ) : ?>

			<img
				src="<?php echo esc_url( $image ); ?>"
				alt="<?php echo esc_attr( $title ); ?>"
				loading="lazy"
				decoding="async"
			>

		<?php else : ?>

			<div class="compact-item__image-placeholder">
				<span>
					<?php echo esc_html( strtoupper( $accent ) ); ?>
				</span>
			</div>

		<?php endif; ?>

	</a>

	<div class="compact-item__content">

		<div class="compact-item__meta">

			<?php if ( $date ) : ?>

				<time>
					<?php echo esc_html( $date ); ?>
				</time>

			<?php endif; ?>

			<?php if ( $date && $meta ) : ?>

				<span aria-hidden="true">•</span>

			<?php endif; ?>

			<?php if ( $meta ) : ?>

				<span>
					<?php echo esc_html( $meta ); ?>
				</span>

			<?php endif; ?>

		</div>

		<h3 class="compact-item__title">

			<a href="<?php echo esc_url( $url ); ?>">
				<?php echo esc_html( $title ); ?>
			</a>

		</h3>

	</div>

</article>