<?php
/**
 * Deadline card.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$deadline = isset( $args['deadline'] ) && is_array( $args['deadline'] )
	? $args['deadline']
	: array();

if ( empty( $deadline ) ) {
	return;
}

$title     = $deadline['title'] ?? '';
$category  = $deadline['category'] ?? '';
$date      = $deadline['date'] ?? '';
$month     = $deadline['month'] ?? '';
$day       = $deadline['day'] ?? '';
$days_left = $deadline['days_left'] ?? '';
$url       = $deadline['url'] ?? '#';
$accent    = $deadline['accent'] ?? 'blue';
?>

<article class="deadline-card deadline-card--<?php echo esc_attr( $accent ); ?>">

	<div class="deadline-card__date">

		<?php if ( $month ) : ?>

			<span class="deadline-card__month">
				<?php echo esc_html( $month ); ?>
			</span>

		<?php endif; ?>

		<?php if ( $day ) : ?>

			<span class="deadline-card__day">
				<?php echo esc_html( $day ); ?>
			</span>

		<?php endif; ?>

	</div>

	<div class="deadline-card__content">

		<?php if ( $category ) : ?>

			<span class="deadline-card__category">
				<?php echo esc_html( $category ); ?>
			</span>

		<?php endif; ?>

		<h3 class="deadline-card__title">

			<a href="<?php echo esc_url( $url ); ?>">
				<?php echo esc_html( $title ); ?>
			</a>

		</h3>

		<?php if ( $date || $days_left ) : ?>

			<div class="deadline-card__meta">

				<?php if ( $date ) : ?>

					<time>
						<?php echo esc_html( $date ); ?>
					</time>

				<?php endif; ?>

				<?php if ( $days_left ) : ?>

					<span
						class="deadline-card__remaining"
						aria-label="<?php echo esc_attr( $days_left ); ?>"
					>
						<?php echo esc_html( $days_left ); ?>
					</span>

				<?php endif; ?>

			</div>

		<?php endif; ?>

	</div>

	<a
		class="deadline-card__arrow"
		href="<?php echo esc_url( $url ); ?>"
		aria-label="<?php echo esc_attr( 'View ' . $title ); ?>"
	>
		<?php echo gyad_icon( 'arrow-right' ); ?>
	</a>

</article>