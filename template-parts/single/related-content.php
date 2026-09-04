<?php
/**
 * Related content.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_type = get_post_type();

$taxonomy_map = array(
	'admission'   => 'admission_type',
	'job'         => 'job_type',
	'result'      => 'result_board',
	'exam'        => 'exam_type',
	'scholarship' => 'scholarship_type',
	'course'      => 'course_category',
);

$taxonomy = $taxonomy_map[ $post_type ] ?? '';

$term_ids = array();

if ( $taxonomy ) {

	$terms = get_the_terms(
		get_the_ID(),
		$taxonomy
	);

	if ( $terms && ! is_wp_error( $terms ) ) {

		foreach ( $terms as $term ) {
			$term_ids[] = $term->term_id;
		}
	}
}

$query_args = array(
	'post_type'           => $post_type,
	'post_status'         => 'publish',
	'posts_per_page'      => 3,
	'post__not_in'        => array( get_the_ID() ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( $taxonomy && $term_ids ) {

	$query_args['tax_query'] = array(
		array(
			'taxonomy' => $taxonomy,
			'field'    => 'term_id',
			'terms'    => $term_ids,
		),
	);
}

$related_query = new WP_Query( $query_args );
?>

<?php if ( $related_query->have_posts() ) : ?>

	<section class="related-content">

		<div class="section-heading section-heading--clean">

			<h2>Related Content</h2>

		</div>

		<div class="related-content__grid">

			<?php while ( $related_query->have_posts() ) : ?>

				<?php $related_query->the_post(); ?>

				<?php get_template_part( 'template-parts/archive/archive-card' ); ?>

			<?php endwhile; ?>

		</div>

	</section>

<?php endif; ?>

<?php wp_reset_postdata(); ?>