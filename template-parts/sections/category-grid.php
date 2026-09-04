<?php
/**
 * Main category cards.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = array(

	array(
		'title'       => 'Admissions',
		'description' => 'Find university and college admissions.',
		'url'         => home_url( '/admissions/' ),
		'accent'      => 'blue',
		'action'      => 'View Admissions',
		'icon'        => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<path d="M8 19h32L24 10 8 19Z"></path>
				<path d="M12 21v13M20 21v13M28 21v13M36 21v13"></path>
				<path d="M7 37h34"></path>
			</svg>
		',
	),

	array(
		'title'       => 'Jobs',
		'description' => 'Find the latest government and private jobs.',
		'url'         => home_url( '/jobs/' ),
		'accent'      => 'green',
		'action'      => 'View Jobs',
		'icon'        => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<rect x="7" y="16" width="34" height="22" rx="3"></rect>
				<path d="M18 16v-3a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v3"></path>
				<path d="M7 25h34"></path>
				<path d="M21 25v3h6v-3"></path>
			</svg>
		',
	),

	array(
		'title'       => 'Results',
		'description' => 'Check exam and academic results quickly.',
		'url'         => home_url( '/results/' ),
		'accent'      => 'purple',
		'action'      => 'Check Results',
		'icon'        => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<path d="M24 8 39 17v14L24 40 9 31V17L24 8Z"></path>
				<path d="M9 17 24 26l15-9"></path>
				<path d="M24 26v14"></path>
			</svg>
		',
	),

	array(
		'title'       => 'Exams',
		'description' => 'Get exam schedules, dates and updates.',
		'url'         => home_url( '/exams/' ),
		'accent'      => 'orange',
		'action'      => 'View Exams',
		'icon'        => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<rect x="10" y="6" width="28" height="36" rx="3"></rect>
				<path d="M17 13h14"></path>
				<path d="M17 21h14M17 27h14M17 33h9"></path>
			</svg>
		',
	),

	array(
		'title'       => 'Scholarships',
		'description' => 'Discover scholarships and funding opportunities.',
		'url'         => home_url( '/scholarships/' ),
		'accent'      => 'teal',
		'action'      => 'View Scholarships',
		'icon'        => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<path d="M7 17 24 8l17 9-17 9L7 17Z"></path>
				<path d="M13 21v11l11 6 11-6V21"></path>
				<path d="M41 18v12"></path>
				<circle cx="41" cy="34" r="2"></circle>
			</svg>
		',
	),

);
?>

<section class="home-categories">

	<div class="container">

		<div class="category-grid">

			<?php foreach ( $categories as $card ) : ?>

				<?php
				get_template_part(
					'template-parts/cards/category-card',
					null,
					array(
						'card' => $card,
					)
				);
				?>

			<?php endforeach; ?>

		</div>

	</div>

</section>