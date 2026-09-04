<?php
/**
 * Archive filters.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_type = isset( $args['post_type'] )
	? $args['post_type']
	: get_post_type();

$config = gyad_get_archive_query_config( $post_type );

if ( empty( $config ) ) {
	return;
}

$taxonomy = $config['taxonomy'];
$label    = $config['tax_label'];

$selected_term = $taxonomy
	? get_query_var( $taxonomy )
	: '';

$current_sort = isset( $_GET['sort'] )
	? sanitize_key(
		wp_unslash(
			$_GET['sort']
		)
	)
	: 'latest';

$terms = $taxonomy
	? get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
		)
	)
	: array();

$archive_url = get_post_type_archive_link(
	$post_type
);
?>

<form
	class="archive-filters"
	method="get"
	action="<?php echo esc_url( $archive_url ); ?>"
>

	<div class="archive-filters__search">

		<label
			class="screen-reader-text"
			for="archive-search"
		>
			Search <?php echo esc_html( $label ); ?>
		</label>

		<input
			id="archive-search"
			type="search"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="Search <?php echo esc_attr( strtolower( $label ) ); ?>..."
		>

	</div>


	<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>

		<div class="archive-filters__select">

			<label
				class="screen-reader-text"
				for="archive-taxonomy"
			>
				<?php echo esc_html( $label ); ?>
			</label>

			<select
				id="archive-taxonomy"
				name="<?php echo esc_attr( $taxonomy ); ?>"
			>

				<option value="">
					All <?php echo esc_html( $label ); ?>
				</option>

				<?php foreach ( $terms as $term ) : ?>

					<option
						value="<?php echo esc_attr( $term->slug ); ?>"
						<?php selected( $selected_term, $term->slug ); ?>
					>
						<?php echo esc_html( $term->name ); ?>
					</option>

				<?php endforeach; ?>

			</select>

		</div>

	<?php endif; ?>


	<div class="archive-filters__select">

		<label
			class="screen-reader-text"
			for="archive-sort"
		>
			Sort Results
		</label>

		<select
			id="archive-sort"
			name="sort"
		>

			<option
				value="latest"
				<?php selected( $current_sort, 'latest' ); ?>
			>
				Latest First
			</option>

			<option
				value="oldest"
				<?php selected( $current_sort, 'oldest' ); ?>
			>
				Oldest First
			</option>

			<?php if ( ! empty( $config['sort_meta'] ) ) : ?>

				<option
					value="deadline"
					<?php selected( $current_sort, 'deadline' ); ?>
				>
					Upcoming Date
				</option>

			<?php endif; ?>

		</select>

	</div>


	<button
		type="submit"
		class="archive-filters__button"
	>
		<?php echo gyad_icon( 'search' ); ?>
		<span>Apply</span>
	</button>


	<?php if (
		get_search_query() ||
		$selected_term ||
		'latest' !== $current_sort
	) : ?>

		<a
			class="archive-filters__reset"
			href="<?php echo esc_url( $archive_url ); ?>"
		>
			Reset
		</a>

	<?php endif; ?>

</form>