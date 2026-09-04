<?php
/**
 * Article authority and source verification helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gyad_get_article_author_authority( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id ) { return array(); }
	$author_id = (int) get_post_field( 'post_author', $post_id );
	if ( ! $author_id ) { return array(); }
	return array(
		'id' => $author_id,
		'name' => get_the_author_meta( 'display_name', $author_id ),
		'url' => get_author_posts_url( $author_id ),
		'bio' => get_the_author_meta( 'description', $author_id ),
		'role' => get_the_author_meta( 'job_title', $author_id ),
		'avatar' => get_avatar_url( $author_id, array( 'size' => 144, 'default' => 'mystery' ) ),
		'posts_count' => (int) count_user_posts( $author_id, 'post' ),
	);
}

function gyad_get_article_source_verification( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id ) { return array(); }
	$url = function_exists( 'gyad_get_single_official_url' ) ? gyad_get_single_official_url( $post_id ) : '';
	if ( ! $url ) {
		return array( 'available' => false, 'url' => '', 'domain' => '', 'label' => 'Official source not provided' );
	}
	$parsed = wp_parse_url( $url );
	$domain = isset( $parsed['host'] ) ? preg_replace( '/^www\./i', '', $parsed['host'] ) : '';
	return array(
		'available' => true,
		'url' => esc_url( $url ),
		'domain' => $domain,
		'label' => function_exists( 'gyad_get_single_source_label' ) ? gyad_get_single_source_label( $post_id ) : 'Official source',
	);
}

function gyad_render_article_author_authority( $post_id = 0 ) {
	$data = gyad_get_article_author_authority( $post_id );
	if ( empty( $data ) ) { return; }
	?>
	<section class="article-author-authority" aria-labelledby="article-author-authority-title">
		<img class="article-author-authority__avatar" src="<?php echo esc_url( $data['avatar'] ); ?>" alt="" width="72" height="72" loading="lazy" decoding="async">
		<div>
			<span class="article-author-authority__eyebrow">Written by</span>
			<h2 id="article-author-authority-title" class="article-author-authority__name"><a href="<?php echo esc_url( $data['url'] ); ?>"><?php echo esc_html( $data['name'] ); ?></a></h2>
			<?php if ( $data['bio'] ) : ?><p class="article-author-authority__bio"><?php echo esc_html( wp_trim_words( $data['bio'], 28 ) ); ?></p><?php endif; ?>
			<div class="article-author-authority__meta">
				<?php if ( $data['role'] ) : ?><span><?php echo esc_html( $data['role'] ); ?></span><?php endif; ?>
				<?php if ( $data['posts_count'] > 0 ) : ?><span><?php echo esc_html( number_format_i18n( $data['posts_count'] ) ); ?> published articles</span><?php endif; ?>
			</div>
		</div>
	</section>
	<?php
}

function gyad_render_article_source_verification( $post_id = 0 ) {
	$data = gyad_get_article_source_verification( $post_id );
	if ( empty( $data ) ) { return; }
	?>
	<section class="article-source-verification <?php echo $data['available'] ? '' : 'article-source-verification--missing'; ?>" aria-labelledby="article-source-verification-title">
		<div class="article-source-verification__top">
			<div>
				<span class="article-source-verification__eyebrow">Source check</span>
				<h2 id="article-source-verification-title" class="article-source-verification__title"><?php echo $data['available'] ? 'Official source' : 'Source information'; ?></h2>
				<p class="article-source-verification__text"><?php echo $data['available'] ? 'Use the official source below to verify dates, requirements, notices, or other details.' : 'No official source link has been added to this article yet.'; ?></p>
			</div>
			<span class="article-source-verification__badge"><?php echo $data['available'] ? 'Verified link' : 'Unavailable'; ?></span>
		</div>
		<?php if ( $data['available'] ) : ?>
			<a class="article-source-verification__link" href="<?php echo esc_url( $data['url'] ); ?>" target="_blank" rel="noopener noreferrer nofollow"><?php echo esc_html( $data['label'] ); ?> <span aria-hidden="true">↗</span></a>
			<?php if ( $data['domain'] ) : ?><span class="article-source-verification__domain"><?php echo esc_html( $data['domain'] ); ?></span><?php endif; ?>
		<?php endif; ?>
	</section>
	<?php
}
