<?php
/**
 * Premium related content system.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();

$related = function_exists( 'gyad_get_related_posts' )
	? gyad_get_related_posts( get_post( $post_id ), 6 )
	: array();

if ( empty( $related ) ) {
	return;
}
?>

<section class="related-content" aria-labelledby="related-content-title">
	<div class="related-content__heading">
		<div>
			<span class="related-content__eyebrow">Keep exploring</span>
			<h2 id="related-content-title" class="related-content__title">Related Content</h2>
		</div>
	</div>

	<div class="related-content__grid">
		<?php foreach ( $related as $related_post ) : ?>
			<?php
			global $post;
			$post = $related_post;
			setup_postdata( $post );
			?>

			<?php get_template_part( 'template-parts/archive/archive-card' ); ?>
		<?php endforeach; ?>
	</div>
</section>

<?php wp_reset_postdata(); ?>