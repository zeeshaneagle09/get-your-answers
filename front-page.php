<?php
/**
 * Front page.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>


<?php
/*
|--------------------------------------------------------------------------
| Hero
|--------------------------------------------------------------------------
*/
?>

<section class="home-hero">

	<div class="container">

		<div class="home-hero__inner">

			<div class="home-hero__content">

				<div class="home-hero__eyebrow">

					<span class="home-hero__eyebrow-line"></span>

					<span>
						YOUR EDUCATION HUB
					</span>

				</div>


				<h1 class="home-hero__title">
					Everything you need
					to move <span>forward.</span>
				</h1>


				<p class="home-hero__description">
					Admissions, jobs, results, exams, scholarships
					and the latest education updates — all in one place.
				</p>


				<div class="home-hero__search">

					<form
						role="search"
						method="get"
						action="<?php echo esc_url( home_url( '/' ) ); ?>"
					>

						<div class="home-hero__search-field">

							<?php echo gyad_icon( 'search' ); ?>

							<input
								type="search"
								name="s"
								value="<?php echo esc_attr( get_search_query() ); ?>"
								placeholder="Search admissions, jobs, results..."
								aria-label="Search education content"
								autocomplete="off"
							>

						</div>


						<button type="submit">

							<?php echo gyad_icon( 'search' ); ?>

							<span>
								Search
							</span>

						</button>

					</form>

				</div>

			</div>

		</div>

	</div>

</section>


<?php
/*
|--------------------------------------------------------------------------
| Editorial feature
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/home/featured-stories'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Quick portal navigation
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/home/quick-access'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Existing category system
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/category-grid'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Latest + trending
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/latest-updates'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Explore by category
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/explore-categories'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Admissions / Jobs / Results
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/content-columns'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Important links
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/important-links'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Important deadlines
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/deadlines'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Education news
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/education-news'
);
?>


<?php
/*
|--------------------------------------------------------------------------
| Newsletter
|--------------------------------------------------------------------------
*/

get_template_part(
	'template-parts/sections/newsletter'
);
?>


<?php get_footer(); ?>