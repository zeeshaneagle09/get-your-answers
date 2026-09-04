<?php
/**
 * SEO and structured data.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
|--------------------------------------------------------------------------
| Basic SEO
|--------------------------------------------------------------------------
*/

/**
 * Get the current page title.
 *
 * @return string
 */
function gyad_get_seo_title() {

	if ( is_front_page() ) {
		return get_bloginfo( 'name' ) . ' — Education, Jobs, Admissions & Results';
	}

	if ( is_singular() ) {
		return wp_strip_all_tags( get_the_title() ) . ' | ' . get_bloginfo( 'name' );
	}

	if ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		$obj       = $post_type ? get_post_type_object( $post_type ) : false;

		if ( $obj ) {
			return $obj->labels->name . ' | ' . get_bloginfo( 'name' );
		}
	}

	if ( is_search() ) {
		return 'Search Results for "' . get_search_query() . '" | ' . get_bloginfo( 'name' );
	}

	if ( is_404() ) {
		return 'Page Not Found | ' . get_bloginfo( 'name' );
	}

	if ( is_archive() ) {
		$title = get_the_archive_title();

		return wp_strip_all_tags( $title ) . ' | ' . get_bloginfo( 'name' );
	}

	return get_bloginfo( 'name' );
}


/**
 * Get the current page description.
 *
 * @return string
 */
function gyad_get_seo_description() {

	if ( is_front_page() ) {
		return 'Get the latest admissions, jobs, examination results, scholarships, courses and education news in one place.';
	}

	if ( is_singular() ) {

		$description = get_the_excerpt();

		if ( $description ) {
			return wp_trim_words(
				wp_strip_all_tags( $description ),
				30,
				'...'
			);
		}

		$content = get_post_field(
			'post_content',
			get_the_ID()
		);

		if ( $content ) {
			return wp_trim_words(
				wp_strip_all_tags( $content ),
				30,
				'...'
			);
		}
	}

	if ( is_search() ) {
		return 'Search Get Your Answers Daily for admissions, jobs, results, exams, scholarships, courses and education news.';
	}

	if ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		$obj       = $post_type ? get_post_type_object( $post_type ) : false;

		if ( $obj ) {
			return 'Browse the latest ' . strtolower( $obj->labels->name ) . ' updates on Get Your Answers Daily.';
		}
	}

	return get_bloginfo( 'description' );
}


/*
|--------------------------------------------------------------------------
| Head metadata
|--------------------------------------------------------------------------
*/

/**
 * Output SEO metadata.
 *
 * @return void
 */
function gyad_output_seo_meta() {

	$title       = gyad_get_seo_title();
	$description = gyad_get_seo_description();
	$canonical   = gyad_get_canonical_url();

	?>
	<title><?php echo esc_html( $title ); ?></title>

	<meta
		name="description"
		content="<?php echo esc_attr( $description ); ?>"
	>

	<link
		rel="canonical"
		href="<?php echo esc_url( $canonical ); ?>"
	>

	<meta name="robots" content="index, follow">

	<meta property="og:type" content="<?php echo esc_attr( is_singular() ? 'article' : 'website' ); ?>">

	<meta
		property="og:title"
		content="<?php echo esc_attr( $title ); ?>"
	>

	<meta
		property="og:description"
		content="<?php echo esc_attr( $description ); ?>"
	>

	<meta
		property="og:url"
		content="<?php echo esc_url( $canonical ); ?>"
	>

	<meta
		property="og:site_name"
		content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
	>

	<?php
	$image = gyad_get_social_image();

	if ( $image ) :
		?>

		<meta
			property="og:image"
			content="<?php echo esc_url( $image ); ?>"
		>

	<?php endif; ?>

	<meta name="twitter:card" content="summary_large_image">

	<meta
		name="twitter:title"
		content="<?php echo esc_attr( $title ); ?>"
	>

	<meta
		name="twitter:description"
		content="<?php echo esc_attr( $description ); ?>"
	>

	<?php if ( $image ) : ?>

		<meta
			name="twitter:image"
			content="<?php echo esc_url( $image ); ?>"
		>

	<?php endif; ?>

	<?php
}

add_action(
	'wp_head',
	'gyad_output_seo_meta',
	1
);


/*
|--------------------------------------------------------------------------
| Canonical URL
|--------------------------------------------------------------------------
*/

/**
 * Get canonical URL.
 *
 * @return string
 */
function gyad_get_canonical_url() {

	if ( is_front_page() ) {
		return home_url( '/' );
	}

	if ( is_singular() ) {
		return get_permalink();
	}

	if ( is_post_type_archive() ) {

		$post_type = get_query_var( 'post_type' );

		if ( is_string( $post_type ) ) {
			$url = get_post_type_archive_link( $post_type );

			if ( $url ) {
				return $url;
			}
		}
	}

	if ( is_tax() || is_category() || is_tag() ) {
		return get_term_link(
			get_queried_object()
		);
	}

	if ( is_search() ) {
		return home_url( '/' );
	}

	return home_url(
		add_query_arg(
			array(),
			$GLOBALS['wp']->request
		)
	);
}


/*
|--------------------------------------------------------------------------
| Social image
|--------------------------------------------------------------------------
*/

/**
 * Get social sharing image.
 *
 * @return string
 */
function gyad_get_social_image() {

	if ( is_singular() && has_post_thumbnail() ) {

		$image = wp_get_attachment_image_url(
			get_post_thumbnail_id(),
			'large'
		);

		if ( $image ) {
			return $image;
		}
	}

	return '';
}


/*
|--------------------------------------------------------------------------
| Schema
|--------------------------------------------------------------------------
*/

/**
 * Output JSON-LD structured data.
 *
 * @return void
 */
function gyad_output_schema() {

	$site_url = home_url( '/' );

	$organization = array(
		'@type' => 'Organization',
		'@id'   => $site_url . '#organization',
		'name'  => get_bloginfo( 'name' ),
		'url'   => $site_url,
	);

	$website = array(
		'@type'        => 'WebSite',
		'@id'          => $site_url . '#website',
		'url'          => $site_url,
		'name'         => get_bloginfo( 'name' ),
		'description'  => get_bloginfo( 'description' ),
		'publisher'    => array(
			'@id' => $site_url . '#organization',
		),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);

	$graph = array(
		$organization,
		$website,
	);

	if ( is_singular() ) {

		$graph[] = array(
			'@type'         => 'Article',
			'@id'           => get_permalink() . '#article',
			'url'           => get_permalink(),
			'headline'      => wp_strip_all_tags( get_the_title() ),
			'description'   => gyad_get_seo_description(),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
			'author'        => array(
				'@type' => 'Person',
				'name'  => get_the_author(),
			),
			'publisher'     => array(
				'@id' => $site_url . '#organization',
			),
		);
	}

	?>
	<script type="application/ld+json">
	<?php
	echo wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	);
	?>
	</script>
	<?php
}

add_action(
	'wp_head',
	'gyad_output_schema',
	5
);


/*
|--------------------------------------------------------------------------
| Breadcrumbs helper
|--------------------------------------------------------------------------
*/

/**
 * Render breadcrumbs.
 *
 * @return void
 */
function gyad_breadcrumbs() {

	if ( is_front_page() ) {
		return;
	}

	?>
	<nav
		class="gyad-breadcrumbs"
		aria-label="Breadcrumb"
	>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			Home
		</a>

		<span aria-hidden="true">/</span>

		<?php if ( is_singular() ) : ?>

			<?php
			$post_type = get_post_type();
			$archive   = $post_type
				? get_post_type_archive_link( $post_type )
				: false;
			?>

			<?php if ( $archive && $post_type ) : ?>

				<a href="<?php echo esc_url( $archive ); ?>">
					<?php
					$obj = get_post_type_object( $post_type );

					echo esc_html(
						$obj
							? $obj->labels->name
							: 'Content'
					);
					?>
				</a>

				<span aria-hidden="true">/</span>

			<?php endif; ?>

			<span aria-current="page">
				<?php the_title(); ?>
			</span>

		<?php elseif ( is_post_type_archive() ) : ?>

			<span aria-current="page">
				<?php
				$post_type = get_query_var( 'post_type' );
				$obj       = $post_type
					? get_post_type_object( $post_type )
					: false;

				echo esc_html(
					$obj
						? $obj->labels->name
						: 'Archive'
				);
				?>
			</span>

		<?php elseif ( is_search() ) : ?>

			<span aria-current="page">
				Search
			</span>

		<?php elseif ( is_404() ) : ?>

			<span aria-current="page">
				Page Not Found
			</span>

		<?php else : ?>

			<span aria-current="page">
				<?php the_title(); ?>
			</span>

		<?php endif; ?>

	</nav>
	<?php
}