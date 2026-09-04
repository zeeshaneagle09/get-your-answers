<?php
/**
 * Search results template.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$content_types = function_exists( 'gyad_search_content_types' )
	? gyad_search_content_types()
	: array(
		''            => 'All Categories',
		'post'        => 'Education News',
		'admission'   => 'Admissions',
		'job'         => 'Jobs',
		'result'      => 'Results',
		'exam'        => 'Exams',
		'scholarship' => 'Scholarships',
		'course'      => 'Courses',
	);

$selected_type = function_exists( 'gyad_get_selected_content_type' )
	? gyad_get_selected_content_type()
	: '';
?>

<main class="search-page">

	<div class="container">

		<header class="search-page__header">

			<span class="search-page__eyebrow">
				Search
			</span>

			<h1 class="search-page__title">

				<?php if ( get_search_query() ) : ?>

					Results for
					“<?php echo esc_html( get_search_query() ); ?>”

				<?php else : ?>

					Search Education Resources

				<?php endif; ?>

			</h1>

			<p class="search-page__description">
				Search admissions, jobs, results, exams, scholarships,
				courses and education news from one place.
			</p>

		</header>


		<form
			class="search-page__form"
			role="search"
			method="get"
			action="<?php echo esc_url( home_url( '/' ) ); ?>"
		>

			<div class="search-page__field">

				<?php echo gyad_icon( 'search' ); ?>

				<input
					type="search"
					name="s"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					placeholder="Search education content..."
					aria-label="Search education content"
				>

			</div>


			<div class="search-page__type">

				<label
					class="screen-reader-text"
					for="search-content-type"
				>
					Content Type
				</label>

				<select
					id="search-content-type"
					name="content_type"
				>

					<?php foreach ( $content_types as $value => $label ) : ?>

						<option
							value="<?php echo esc_attr( $value ); ?>"
							<?php selected( $selected_type, $value ); ?>
						>
							<?php echo esc_html( $label ); ?>
						</option>

					<?php endforeach; ?>

				</select>

			</div>


			<button type="submit">

				<?php echo gyad_icon( 'search' ); ?>

				<span>Search</span>

			</button>

		</form>


		<?php if ( have_posts() ) : ?>

			<div class="search-results-bar">

				<div>

					<p>
						<?php
						printf(
							esc_html(
								_n(
									'%s result found',
									'%s results found',
									(int) $wp_query->found_posts,
									'get-your-answers-daily'
								)
							),
							number_format_i18n(
								$wp_query->found_posts
							)
						);
						?>
					</p>

					<?php if (
						$selected_type &&
						isset( $content_types[ $selected_type ] )
					) : ?>

						<span>
							<?php
							echo esc_html(
								$content_types[ $selected_type ]
							);
							?>
						</span>

					<?php endif; ?>

				</div>

			</div>


			<div class="search-results">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
					get_template_part(
						'template-parts/archive/archive-card'
					);
					?>

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

			<div class="search-empty">

				<div class="search-empty__icon">
					<?php echo gyad_icon( 'search' ); ?>
				</div>

				<h2>
					No results found
				</h2>

				<p>

					<?php if ( get_search_query() ) : ?>

						Nothing matched
						“<?php echo esc_html( get_search_query() ); ?>”.

					<?php else : ?>

						Enter a keyword to search the education portal.

					<?php endif; ?>

				</p>

				<a
					class="search-empty__button"
					href="<?php echo esc_url( home_url( '/' ) ); ?>"
				>
					Back to Home
				</a>

			</div>

		<?php endif; ?>

	</div>

</main>

<?php get_footer(); ?>