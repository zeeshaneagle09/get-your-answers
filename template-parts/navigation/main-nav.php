<?php
/**
 * Main navigation.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<nav
	class="main-navigation"
	aria-label="<?php echo esc_attr__( 'Primary Navigation', 'get-your-answers-daily' ); ?>"
>

	<div class="container main-navigation__inner">

		<div
			id="primary-menu"
			class="main-menu"
		>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>

			<?php else : ?>

				<ul class="primary-menu">

					<li class="current-menu-item">

						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">

							<?php echo gyad_icon( 'home' ); ?>

							<span>Home</span>

						</a>

					</li>


					<li class="menu-item-has-children">

						<a href="<?php echo esc_url( home_url( '/admissions/' ) ); ?>">

							<span>Admissions</span>

							<?php echo gyad_icon( 'chevron-down' ); ?>

						</a>

						<ul class="sub-menu">

							<li>
								<a href="<?php echo esc_url( home_url( '/admissions/universities/' ) ); ?>">
									Universities
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/admissions/colleges/' ) ); ?>">
									Colleges
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/admissions/' ) ); ?>">
									Latest Admissions
								</a>
							</li>

						</ul>

					</li>


					<li class="menu-item-has-children">

						<a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">

							<span>Jobs</span>

							<?php echo gyad_icon( 'chevron-down' ); ?>

						</a>

						<ul class="sub-menu">

							<li>
								<a href="<?php echo esc_url( home_url( '/jobs/government/' ) ); ?>">
									Government Jobs
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/jobs/private/' ) ); ?>">
									Private Jobs
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/jobs/' ) ); ?>">
									Latest Jobs
								</a>
							</li>

						</ul>

					</li>


					<li class="menu-item-has-children">

						<a href="<?php echo esc_url( home_url( '/results/' ) ); ?>">

							<span>Results</span>

							<?php echo gyad_icon( 'chevron-down' ); ?>

						</a>

						<ul class="sub-menu">

							<li>
								<a href="<?php echo esc_url( home_url( '/results/matric/' ) ); ?>">
									Matric Results
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/results/inter/' ) ); ?>">
									Inter Results
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/results/' ) ); ?>">
									All Results
								</a>
							</li>

						</ul>

					</li>


					<li class="menu-item-has-children">

						<a href="<?php echo esc_url( home_url( '/exams/' ) ); ?>">

							<span>Exams</span>

							<?php echo gyad_icon( 'chevron-down' ); ?>

						</a>

						<ul class="sub-menu">

							<li>
								<a href="<?php echo esc_url( home_url( '/exams/date-sheets/' ) ); ?>">
									Date Sheets
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/exams/past-papers/' ) ); ?>">
									Past Papers
								</a>
							</li>

							<li>
								<a href="<?php echo esc_url( home_url( '/exams/roll-no-slips/' ) ); ?>">
									Roll No Slips
								</a>
							</li>

						</ul>

					</li>


					<li>
						<a href="<?php echo esc_url( home_url( '/scholarships/' ) ); ?>">
							Scholarships
						</a>
					</li>


					<li>
						<a href="<?php echo esc_url( home_url( '/courses/' ) ); ?>">
							Courses
						</a>
					</li>


					<li>
						<a href="<?php echo esc_url( home_url( '/education-news/' ) ); ?>">
							Education News
						</a>
					</li>


					<li>
						<a href="<?php echo esc_url( home_url( '/guides/' ) ); ?>">
							Guides
						</a>
					</li>


					<li class="primary-menu__notification">

						<a
							href="#"
							aria-label="Notifications"
						>

							<?php echo gyad_icon( 'bell' ); ?>

						</a>

					</li>

				</ul>

			<?php endif; ?>

		</div>

	</div>

</nav>