<?php
/**
 * Category card.
 *
 * Expected variables:
 * $card
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $card ) || ! is_array( $card ) ) {
	return;
}

$title       = $card['title'] ?? '';
$description = $card['description'] ?? '';
$url         = $card['url'] ?? '#';
$icon        = $card['icon'] ?? '';
$accent      = $card['accent'] ?? 'blue';
$action      = $card['action'] ?? 'Explore';
?>

<a
	class="category-card category-card--<?php echo esc_attr( $accent ); ?>"
	href="<?php echo esc_url( $url ); ?>"
>

	<div class="category-card__top">

		<div class="category-card__icon">
			<?php echo $icon; ?>
		</div>

		<span class="category-card__arrow">
			<?php echo gyad_icon( 'arrow-right' ); ?>
		</span>

	</div>

	<div class="category-card__content">

		<h2 class="category-card__title">
			<?php echo esc_html( $title ); ?>
		</h2>

		<p class="category-card__description">
			<?php echo esc_html( $description ); ?>
		</p>

	</div>

	<span class="category-card__action">
		<?php echo esc_html( $action ); ?>

		<?php echo gyad_icon( 'arrow-right' ); ?>
	</span>

</a>