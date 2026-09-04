<?php
/**
 * Explore by category section.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$explore_categories = array(

	array(
		'name'   => 'Matric Results',
		'action' => 'Check Results',
		'url'    => home_url( '/results/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<path d="M8 17 24 8l16 9-16 9L8 17Z"></path>
				<path d="M13 21v10l11 6 11-6V21"></path>
				<path d="M40 18v11"></path>
			</svg>
		',
	),

	array(
		'name'   => 'Inter Results',
		'action' => 'Check Results',
		'url'    => home_url( '/results/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<circle cx="24" cy="24" r="16"></circle>
				<path d="M24 16v9l6 4"></path>
			</svg>
		',
	),

	array(
		'name'   => 'Universities',
		'action' => 'Explore',
		'url'    => home_url( '/admissions/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<path d="M6 19 24 9l18 10-18 10L6 19Z"></path>
				<path d="M11 22v14M19 25v11M29 25v11M37 22v14"></path>
				<path d="M7 38h34"></path>
			</svg>
		',
	),

	array(
		'name'   => 'Colleges',
		'action' => 'Explore',
		'url'    => home_url( '/admissions/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<path d="M9 37h30"></path>
				<path d="M13 37V18l11-7 11 7v19"></path>
				<path d="M18 23h3M27 23h3M18 29h3M27 29h3"></path>
			</svg>
		',
	),

	array(
		'name'   => 'Past Papers',
		'action' => 'Browse Papers',
		'url'    => home_url( '/exams/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<path d="M13 6h16l8 8v28H13V6Z"></path>
				<path d="M29 6v9h8"></path>
				<path d="M19 23h12M19 29h12M19 35h8"></path>
			</svg>
		',
	),

	array(
		'name'   => 'Date Sheets',
		'action' => 'View Dates',
		'url'    => home_url( '/exams/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<rect x="8" y="10" width="32" height="30" rx="3"></rect>
				<path d="M15 6v8M33 6v8M8 18h32"></path>
				<path d="M16 25h5M27 25h5M16 32h5M27 32h5"></path>
			</svg>
		',
	),

	array(
		'name'   => 'Roll No Slips',
		'action' => 'Find Slip',
		'url'    => home_url( '/exams/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<rect x="9" y="6" width="30" height="36" rx="3"></rect>
				<circle cx="19" cy="18" r="4"></circle>
				<path d="M27 15h6M27 20h6M15 29h18M15 34h12"></path>
			</svg>
		',
	),

	array(
		'name'   => 'Online Tests',
		'action' => 'Start Practice',
		'url'    => home_url( '/courses/' ),
		'icon'   => '
			<svg viewBox="0 0 48 48" aria-hidden="true">
				<rect x="8" y="10" width="32" height="25" rx="3"></rect>
				<path d="M20 40h8M24 35v5"></path>
				<path d="m19 22 3 3 7-8"></path>
			</svg>
		',
	),

);
?>

<section class="explore-section">

	<div class="container">

		<div class="section-heading section-heading--clean">

			<div>
				<h2>Explore by Category</h2>
			</div>

			<a
				class="section-heading__link"
				href="<?php echo esc_url( home_url( '/categories/' ) ); ?>"
			>
				<span>View All</span>
				<?php echo gyad_icon( 'arrow-right' ); ?>
			</a>

		</div>

		<div class="explore-grid">

			<?php foreach ( $explore_categories as $index => $category ) : ?>

				<a
					class="explore-item"
					href="<?php echo esc_url( $category['url'] ); ?>"
				>

					<span class="explore-item__index">
						<?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?>
					</span>

					<span class="explore-item__icon">
						<?php echo $category['icon']; ?>
					</span>

					<span class="explore-item__name">
						<?php echo esc_html( $category['name'] ); ?>
					</span>

					<span class="explore-item__action">
						<?php echo esc_html( $category['action'] ); ?>
						<?php echo gyad_icon( 'arrow-right' ); ?>
					</span>

				</a>

			<?php endforeach; ?>

		</div>

	</div>

</section>