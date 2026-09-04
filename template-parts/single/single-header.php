<?php
/**
 * Premium single article header.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id   = get_the_ID();
$post_type = get_post_type( $post_id );

$config = function_exists( 'gyad_get_single_config' )
	? gyad_get_single_config( $post_type )
	: array(
		'label'         => 'Education News',
		'taxonomy'      => 'category',
		'date_label'    => 'Published',
		'action_label'  => '',
		'accent'        => 'blue',
	);

$primary_term = function_exists( 'gyad_get_primary_single_term' )
	? gyad_get_primary_single_term( $post_id )
	: null;

$reading_time = function_exists( 'gyad_get_reading_time' )
	? gyad_get_reading_time( $post_id )
	: 1;

$view_count = function_exists( 'gyad_get_post_views' )
	? gyad_get_post_views( $post_id )
	: 0;

$author_id = (int) get_post_field(
	'post_author',
	$post_id
);

$author_name = get_the_author_meta(
	'display_name',
	$author_id
);

$author_role = get_the_author_meta(
	'description',
	$author_id
);

$author_avatar = get_avatar_url(
	$author_id,
	array(
		'size' => 96,
	)
);

$published_timestamp = get_post_time(
	'U',
	true,
	$post_id
);

$modified_timestamp = get_post_modified_time(
	'U',
	true,
	$post_id
);

$has_updates = (
	$modified_timestamp &&
	$published_timestamp &&
	$modified_timestamp > $published_timestamp
);

$share_url = get_permalink( $post_id );
$share_title = get_the_title( $post_id );
?>

<div class="article-reading-progress" aria-hidden="true">
	<div class="article-reading-progress__bar"></div>
</div>


<header class="single-article-header">

	<?php
	/*
	|--------------------------------------------------------------------------
	| Breadcrumbs
	|--------------------------------------------------------------------------
	*/
	?>

	<?php if ( function_exists( 'gyad_breadcrumbs' ) ) : ?>

		<div class="single-breadcrumbs">

			<?php gyad_breadcrumbs(); ?>

		</div>

	<?php endif; ?>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Type / Category
	|--------------------------------------------------------------------------
	*/
	?>

	<div class="single-article-header__top">

		<span
			class="single-article-header__type single-article-header__type--<?php echo esc_attr( $config['accent'] ); ?>"
		>
			<?php echo esc_html( $primary_term ? $primary_term->name : $config['label'] ); ?>
		</span>

		<?php if ( $primary_term && $primary_term->name !== $config['label'] ) : ?>

			<span class="single-article-header__category">
				<?php echo esc_html( $config['label'] ); ?>
			</span>

		<?php endif; ?>

	</div>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Title
	|--------------------------------------------------------------------------
	*/
	?>

	<h1 class="single-article-header__title">
		<?php the_title(); ?>
	</h1>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Standfirst
	|--------------------------------------------------------------------------
	*/

	$excerpt = get_the_excerpt( $post_id );

	if ( $excerpt ) :
	?>

		<p class="single-article-header__excerpt">
			<?php echo esc_html( $excerpt ); ?>
		</p>

	<?php endif; ?>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Author + article metadata
	|--------------------------------------------------------------------------
	*/

	?>

	<div class="single-article-meta">

		<a
			class="single-article-meta__author"
			href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>"
		>

			<img
				class="single-article-meta__avatar"
				src="<?php echo esc_url( $author_avatar ); ?>"
				alt="<?php echo esc_attr( $author_name ); ?>"
				width="34"
				height="34"
				loading="eager"
				decoding="async"
			>

			<span class="single-article-meta__author-name">

				<span>
					<?php echo esc_html( $author_name ); ?>
				</span>

				<?php if ( $author_role ) : ?>

					<small>
						<?php echo esc_html( wp_trim_words( $author_role, 5, '…' ) ); ?>
					</small>

				<?php else : ?>

					<small>
						<?php echo esc_html( $config['label'] ); ?> Editor
					</small>

				<?php endif; ?>

			</span>

		</a>


		<span
			class="single-article-meta__divider"
			aria-hidden="true"
		></span>


		<span class="single-article-meta__item">

			<time datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
				<?php echo esc_html( get_the_date( get_option( 'date_format' ), $post_id ) ); ?>
			</time>

		</span>


		<?php if ( $has_updates ) : ?>

			<span class="single-article-meta__item">

				<span>Updated</span>

				<time datetime="<?php echo esc_attr( get_post_modified_time( 'c', true, $post_id ) ); ?>">
					<?php echo esc_html( get_the_modified_date( get_option( 'date_format' ), $post_id ) ); ?>
				</time>

			</span>

		<?php endif; ?>


		<span class="single-article-meta__item">
			<?php echo esc_html( function_exists( 'gyad_format_reading_time' ) ? gyad_format_reading_time( $reading_time ) : $reading_time . ' min read' ); ?>
		</span>


		<?php if ( $view_count > 0 ) : ?>

			<span class="single-article-meta__item">
				<?php echo esc_html( number_format_i18n( $view_count ) ); ?>
				views
			</span>

		<?php endif; ?>

	</div>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Share actions
	|--------------------------------------------------------------------------
	*/
	?>

	<div class="article-share">

		<span class="article-share__label">
			Share
		</span>


		<a
			class="article-share__button"
			href="<?php echo esc_url( function_exists( 'gyad_get_share_url' ) ? gyad_get_share_url( 'facebook', $share_url, $share_title ) : 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $share_url ) ); ?>"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="Share on Facebook"
			title="Share on Facebook"
		>
			f
		</a>


		<a
			class="article-share__button"
			href="<?php echo esc_url( function_exists( 'gyad_get_share_url' ) ? gyad_get_share_url( 'whatsapp', $share_url, $share_title ) : 'https://wa.me/?text=' . rawurlencode( $share_title . ' ' . $share_url ) ); ?>"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="Share on WhatsApp"
			title="Share on WhatsApp"
		>
			WA
		</a>


		<a
			class="article-share__button"
			href="<?php echo esc_url( function_exists( 'gyad_get_share_url' ) ? gyad_get_share_url( 'x', $share_url, $share_title ) : 'https://twitter.com/intent/tweet?text=' . rawurlencode( $share_title ) . '&url=' . rawurlencode( $share_url ) ); ?>"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="Share on X"
			title="Share on X"
		>
			𝕏
		</a>


		<button
			type="button"
			class="article-share__button"
			data-copy-url="<?php echo esc_attr( $share_url ); ?>"
			aria-label="Copy link"
			title="Copy link"
		>
			<span data-copy-label>
				↗
			</span>
		</button>

	</div>

</header>