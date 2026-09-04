<?php
/**
 * Single article author card.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
$author  = function_exists( 'gyad_get_author_data' )
	? gyad_get_author_data( get_post( $post_id ) )
	: array();

if ( empty( $author['id'] ) ) {
	return;
}
?>

<section class="article-author-card" aria-labelledby="article-author-title">
	<div class="article-author-card__avatar-wrap">
		<img class="article-author-card__avatar" src="<?php echo esc_url( $author['avatar'] ); ?>" alt="<?php echo esc_attr( $author['name'] ); ?>" width="80" height="80" loading="lazy" decoding="async">
	</div>

	<div class="article-author-card__body">
		<span class="article-author-card__eyebrow">Written by</span>
		<h2 id="article-author-title" class="article-author-card__name">
			<a href="<?php echo esc_url( $author['url'] ); ?>"><?php echo esc_html( $author['name'] ); ?></a>
		</h2>

		<?php if ( ! empty( $author['description'] ) ) : ?>
			<p class="article-author-card__description"><?php echo esc_html( $author['description'] ); ?></p>
		<?php endif; ?>

		<a class="article-author-card__link" href="<?php echo esc_url( $author['url'] ); ?>">View more from this author</a>
	</div>
</section>