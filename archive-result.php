<?php
/**
 * Results archive.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="archive-page">

	<div class="container">

		<?php
		get_template_part(
			'template-parts/archive/archive-header',
			null,
			array(
				'title'       => 'Results',
				'description' => 'Latest examination results, board results and result updates.',
			)
		);

		get_template_part(
			'template-parts/archive/archive-filters',
			null,
			array(
				'post_type' => 'result',
			)
		);
		?>

		<div class="archive-results-bar">

			<p>
				<?php
				printf(
					esc_html(
						_n(
							'%s result found',
							'%s results found',
							(int) $wp_query->found_posts,
							'gyad'
						)
					),
					number_format_i18n( $wp_query->found_posts )
				);
				?>
			</p>

		</div>

		<?php if ( have_posts() ) : ?>

			<div class="archive-results">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/archive/archive-card' ); ?>

				<?php endwhile; ?>

			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => 'Previous',
					'next_text' => 'Next',
				)
			);
			?>

		<?php else : ?>

			<div class="archive-empty">
				<h2>No results found.</h2>
				<p>New examination results will appear here.</p>
			</div>

		<?php endif; ?>

	</div>

</main>

<?php get_footer(); ?>