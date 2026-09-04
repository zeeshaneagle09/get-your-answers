<?php
/**
 * Archive header.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title       = $args['title'] ?? get_the_archive_title();
$description = $args['description'] ?? get_the_archive_description();
?>

<header class="archive-header">

	<div class="archive-header__content">

		<span class="archive-header__eyebrow">
			Get Your Answers Daily
		</span>

		<h1 class="archive-header__title">
			<?php echo esc_html( $title ); ?>
		</h1>

		<?php if ( $description ) : ?>

			<div class="archive-header__description">
				<?php echo wp_kses_post( $description ); ?>
			</div>

		<?php endif; ?>

	</div>

</header>