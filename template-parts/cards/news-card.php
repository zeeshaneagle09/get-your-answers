<?php
/**
 * News card.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title       = get_the_title();
$url         = get_permalink();
$date        = get_the_date();
$excerpt     = get_the_excerpt();
$thumbnail   = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
$placeholder = GYAD_URI . '/assets/images/news-placeholder.svg';
?>

<article class="news-card">

	<a
		class="news-card__image"
		href="<?php echo esc_url( $url ); ?>"
		aria-label="<?php echo esc_attr( $title ); ?>"
	>

		<?php if ( $thumbnail ) : ?>

			<img
				src="<?php echo esc_url( $thumbnail ); ?>"
				alt="<?php echo esc_attr( $title ); ?>"
				loading="lazy"
				decoding="async"
			>

		<?php else : ?>

			<div
				class="news-card__placeholder"
				aria-hidden="true"
			>
				<span>EDUCATION</span>
			</div>

		<?php endif; ?>

	</a>

	<div class="news-card__body">

		<div class="news-card__meta">

			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( $date ); ?>
			</time>

			<span>•</span>

			<span>
				Education
			</span>

		</div>

		<h3 class="news-card__title">

			<a href="<?php echo esc_url( $url ); ?>">
				<?php echo esc_html( $title ); ?>
			</a>

		</h3>

		<?php if ( $excerpt ) : ?>

			<p class="news-card__excerpt">
				<?php echo esc_html( wp_trim_words( $excerpt, 14 ) ); ?>
			</p>

		<?php endif; ?>

	</div>

</article>