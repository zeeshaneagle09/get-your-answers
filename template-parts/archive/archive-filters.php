<?php
/**
 * Archive filters.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_type = isset( $args['post_type'] ) ? sanitize_key( $args['post_type'] ) : get_post_type();
$config = function_exists( 'gyad_get_archive_query_config' ) ? gyad_get_archive_query_config( $post_type ) : array();

if ( empty( $config ) ) {
	return;
}

$taxonomy = ! empty( $config['taxonomy'] ) ? $config['taxonomy'] : '';
$label    = ! empty( $config['tax_label'] ) ? $config['tax_label'] : 'Category';

$selected_term = $taxonomy ? sanitize_title( (string) get_query_var( $taxonomy ) ) : '';
$current_sort = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : 'latest';
$allowed_sorts = array( 'latest', 'oldest', 'deadline' );

if ( ! in_array( $current_sort, $allowed_sorts, true ) ) {
	$current_sort = 'latest';
}

$terms = $taxonomy
	? get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	)
	: array();

$archive_url = get_post_type_archive_link( $post_type );
$search_value = get_search_query();
?>

<form
	class="archive-filters"
	method="get"
	action="<?php echo esc_url( $archive_url ); ?>"
	role="search"
>
	<div class="archive-filters__search">
		<label class="screen-reader-text" for="archive-search-<?php echo esc_attr( $post_type ); ?>">
			Search <?php echo esc_html( $label ); ?>
		</label>
		<input
			id="archive-search-<?php echo esc_attr( $post_type ); ?>"
			type="search"
			name="s"
			value="<?php echo esc_attr( $search_value ); ?>"
			placeholder="Search <?php echo esc_attr( strtolower( $label ) ); ?>..."
			autocomplete="off"
		>
	</div>

	<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
		<div class="archive-filters__select">
			<label class="screen-reader-text" for="archive-taxonomy-<?php echo esc_attr( $post_type ); ?>">
				<?php echo esc_html( $label ); ?>
			</label>
			<select
				id="archive-taxonomy-<?php echo esc_attr( $post_type ); ?>"
				name="<?php echo esc_attr( $taxonomy ); ?>"
			>
				<option value="">All <?php echo esc_html( $label ); ?></option>
				<?php foreach ( $terms as $term ) : ?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $selected_term, $term->slug ); ?>>
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	<?php endif; ?>

	<div class="archive-filters__select">
		<label class="screen-reader-text" for="archive-sort-<?php echo esc_attr( $post_type ); ?>">
			Sort Results
		</label>
		<select id="archive-sort-<?php echo esc_attr( $post_type ); ?>" name="sort">
			<option value="latest" <?php selected( $current_sort, 'latest' ); ?>>Latest First</option>
			<option value="oldest" <?php selected( $current_sort, 'oldest' ); ?>>Oldest First</option>
			<?php if ( ! empty( $config['sort_meta'] ) ) : ?>
				<option value="deadline" <?php selected( $current_sort, 'deadline' ); ?>>Upcoming Date</option>
			<?php endif; ?>
		</select>
	</div>

	<button type="submit" class="archive-filters__button">
		<?php echo gyad_icon( 'search' ); ?>
		<span>Filter Results</span>
	</button>

	<?php if ( $search_value || $selected_term || 'latest' !== $current_sort ) : ?>
		<a class="archive-filters__reset" href="<?php echo esc_url( $archive_url ); ?>">
			Reset
		</a>
	<?php endif; ?>
</form>