<?php
/**
 * Premium post continuation system.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id   = get_the_ID();
$post_type = get_post_type( $post_id );

$previous = get_previous_post( false );
$next     = get_next_post( false );

$author_more = function_exists( 'gyad_get_more_from_author' )
	? gyad_get_more_from_author( get_post( $post_id ), 4 )
	: array();

$category_more = function_exists( 'gyad_get_more_from_category' )
	? gyad_get_more_from_category( get_post( $post_id ), 4 )
	: array();

$seen_ids = array( $post_id );

foreach ( array( $author_more, $category_more ) as $items ) {
	foreach ( $items as $item ) {
		if ( $item instanceof WP_Post ) {
			$seen_ids[] = (int) $item->ID;
		}
	}
}

$category_more = array_values(
	array_filter(
		$category_more,
		function ( $item ) use ( $seen_ids ) {
			return $item instanceof WP_Post && ! in_array( (int) $item->ID, $seen_ids, true );
		}
	)
);
?>

<section class="article-continuation" aria-label="Continue reading">

	<div class="article-continuation__share">
		<div>
			<span class="article-continuation__eyebrow">Enjoyed this?</span>
			<h2 class="article-continuation__title">Share this article</h2>
		</div>

		<div class="article-continuation__share-actions" aria-label="Share this article again">
			<button type="button" class="article-continuation__button" data-share-web>Share</button>
			<button type="button" class="article-continuation__button" data-copy-url="<?php echo esc_attr( get_permalink( $post_id ) ); ?>">
				<span data-copy-label>Copy link</span>
			</button>
		</div>
	</div>

	<div class="article-feedback" role="group" aria-label="Article helpfulness">
		<span class="article-feedback__question">Was this helpful?</span>
		<div class="article-feedback__actions">
			<button type="button" class="article-feedback__button" data-feedback="yes" aria-pressed="false">Yes</button>
			<button type="button" class="article-feedback__button" data-feedback="no" aria-pressed="false">Not quite</button>
		</div>
		<span class="article-feedback__status" data-feedback-status aria-live="polite"></span>
	</div>

	<?php if ( $previous || $next ) : ?>
		<nav class="article-post-nav" aria-label="Article navigation">
			<?php if ( $previous ) : ?>
				<a class="article-post-nav__item article-post-nav__item--previous" href="<?php echo esc_url( get_permalink( $previous ) ); ?>">
					<span class="article-post-nav__label">Previous</span>
					<strong><?php echo esc_html( get_the_title( $previous ) ); ?></strong>
				</a>
			<?php endif; ?>

			<?php if ( $next ) : ?>
				<a class="article-post-nav__item article-post-nav__item--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
					<span class="article-post-nav__label">Next</span>
					<strong><?php echo esc_html( get_the_title( $next ) ); ?></strong>
				</a>
			<?php endif; ?>
		</nav>
	<?php endif; ?>

	<?php if ( ! empty( $author_more ) ) : ?>
		<section class="article-more-section" aria-labelledby="more-author-title">
			<div class="article-more-section__heading">
				<span class="article-more-section__eyebrow">From the author</span>
				<h2 id="more-author-title">More from this author</h2>
			</div>
			<div class="article-more-section__grid">
				<?php foreach ( $author_more as $item ) : ?>
					<?php
					global $post;
					$post = $item;
					setup_postdata( $post );
					get_template_part( 'template-parts/archive/archive-card' );
					?>
				<?php endforeach; ?>
			</div>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

	<?php if ( ! empty( $category_more ) ) : ?>
		<section class="article-more-section" aria-labelledby="more-category-title">
			<div class="article-more-section__heading">
				<span class="article-more-section__eyebrow">Keep exploring</span>
				<h2 id="more-category-title">More in this section</h2>
			</div>
			<div class="article-more-section__grid">
				<?php foreach ( $category_more as $item ) : ?>
					<?php
					global $post;
					$post = $item;
					setup_postdata( $post );
					get_template_part( 'template-parts/archive/archive-card' );
					?>
				<?php endforeach; ?>
			</div>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

	<button type="button" class="article-back-top" aria-label="Back to top">↑ Back to top</button>

</section>
