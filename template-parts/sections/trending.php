<?php
/**
 * Trending section.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$trending_items = function_exists( 'gyad_get_discovery_posts' )
	? gyad_get_discovery_posts( 5, 'post' )
	: get_posts( array( 'post_type' => 'post', 'posts_per_page' => 5 ) );
?>

<aside class="trending-panel">
	<div class="trending-panel__heading">
		<div class="trending-panel__title">
			<span class="trending-panel__symbol" aria-hidden="true">↗</span>
			<div>
				<h2>Trending Now</h2>
				<span class="trending-panel__subtitle">What students are reading</span>
			</div>
		</div>
	</div>

	<?php if ( ! empty( $trending_items ) ) : ?>
		<div class="trending-list">
			<?php foreach ( $trending_items as $rank => $item ) : ?>
				<a class="trending-item" href="<?php echo esc_url( get_permalink( $item ) ); ?>">
					<span class="trending-item__number"><?php echo esc_html( sprintf( '%02d', $rank + 1 ) ); ?></span>
					<div class="trending-item__content">
						<h3><?php echo esc_html( get_the_title( $item ) ); ?></h3>
						<div class="trending-item__meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c', $item ) ); ?>"><?php echo esc_html( get_the_date( '', $item ) ); ?></time>
							<span aria-hidden="true">•</span>
							<span>
								<?php
								$views = function_exists( 'gyad_get_post_views' ) ? gyad_get_post_views( $item ) : 0;
								echo esc_html( $views > 0 ? number_format_i18n( $views ) . ' reads' : 'Latest update' );
								?>
							</span>
						</div>
					</div>
					<span class="trending-item__arrow" aria-hidden="true"><?php echo gyad_icon( 'arrow-right' ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<div class="trending-empty">Publish posts to populate trending content.</div>
	<?php endif; ?>
</aside>
