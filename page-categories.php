<?php
/**
 * Categories directory.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$categories = array(

	array(
		'title'       => 'Admissions',
		'description' => 'Universities, colleges and admission opportunities.',
		'url'         => home_url( '/admissions/' ),
		'accent'      => 'blue',
	),

	array(
		'title'       => 'Jobs',
		'description' => 'Government, private and education-related vacancies.',
		'url'         => home_url( '/jobs/' ),
		'accent'      => 'green',
	),

	array(
		'title'       => 'Results',
		'description' => 'Board results and examination result updates.',
		'url'         => home_url( '/results/' ),
		'accent'      => 'purple',
	),

	array(
		'title'       => 'Exams',
		'description' => 'Date sheets, past papers and examination updates.',
		'url'         => home_url( '/exams/' ),
		'accent'      => 'orange',
	),

	array(
		'title'       => 'Scholarships',
		'description' => 'Scholarship opportunities and application information.',
		'url'         => home_url( '/scholarships/' ),
		'accent'      => 'teal',
	),

	array(
		'title'       => 'Courses',
		'description' => 'Courses, learning opportunities and resources.',
		'url'         => home_url( '/courses/' ),
		'accent'      => 'blue',
	),

	array(
		'title'       => 'Education News',
		'description' => 'Latest education news and important updates.',
		'url'         => home_url( '/education-news/' ),
		'accent'      => 'purple',
	),

	array(
		'title'       => 'Important Deadlines',
		'description' => 'Upcoming dates you should not miss.',
		'url'         => home_url( '/deadlines/' ),
		'accent'      => 'orange',
	),

);
?>

<main class="categories-page">

	<div class="container">

		<header class="portal-page-header">

			<span class="portal-page-header__eyebrow">
				Explore
			</span>

			<h1 class="portal-page-header__title">
				Explore All Categories
			</h1>

			<p class="portal-page-header__description">
				Everything students need, organized into one simple
				education portal.
			</p>

		</header>


		<div class="categories-directory">

			<?php foreach ( $categories as $index => $category ) : ?>

				<a
					class="category-directory-card category-directory-card--<?php echo esc_attr( $category['accent'] ); ?>"
					href="<?php echo esc_url( $category['url'] ); ?>"
				>

					<span class="category-directory-card__number">
						<?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?>
					</span>

					<span class="category-directory-card__content">

						<strong>
							<?php echo esc_html( $category['title'] ); ?>
						</strong>

						<span>
							<?php echo esc_html( $category['description'] ); ?>
						</span>

					</span>

					<span class="category-directory-card__arrow">
						<?php echo gyad_icon( 'arrow-right' ); ?>
					</span>

				</a>

			<?php endforeach; ?>

		</div>

	</div>

</main>

<?php get_footer(); ?>