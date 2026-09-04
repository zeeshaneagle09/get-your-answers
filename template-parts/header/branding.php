<?php
/**
 * Header branding.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="site-branding">

	<div class="container">

		<div class="site-branding__inner">

			<a
				class="site-branding__logo"
				href="<?php echo esc_url( home_url( '/' ) ); ?>"
				aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
			>

				<span class="site-branding__logo-mark">
					<?php echo gyad_icon( 'home' ); ?>
				</span>

				<span class="site-branding__logo-text">
					<span>GET YOUR</span>
					<strong>ANSWERS</strong>
					<span>DAILY</span>
				</span>

			</a>


			<div class="header-search">

				<form
					role="search"
					method="get"
					class="header-search__form"
					action="<?php echo esc_url( home_url( '/' ) ); ?>"
				>

					<div class="header-search__field">

						<?php echo gyad_icon( 'search' ); ?>

						<input
							type="search"
							name="s"
							value="<?php echo esc_attr( get_search_query() ); ?>"
							placeholder="Search education content..."
							aria-label="Search education content"
							autocomplete="off"
						>

					</div>


					<div class="header-search__select-wrap">

						<label
							class="screen-reader-text"
							for="header-search-category"
						>
							Search category
						</label>

						<select
							id="header-search-category"
							name="content_type"
							class="header-search__category"
						>
							<option value="">All Categories</option>
							<option value="admission">Admissions</option>
							<option value="job">Jobs</option>
							<option value="result">Results</option>
							<option value="exam">Exams</option>
							<option value="scholarship">Scholarships</option>
							<option value="course">Courses</option>
						</select>

					</div>


					<button
						type="submit"
						class="header-search__button"
					>
						<?php echo gyad_icon( 'search' ); ?>
						<span>Search</span>
					</button>

				</form>

			</div>


			<button
				class="mobile-menu-button"
				type="button"
				aria-expanded="false"
				aria-controls="primary-menu"
				aria-label="Open menu"
			>

				<span class="mobile-menu-button__line"></span>
				<span class="mobile-menu-button__line"></span>
				<span class="mobile-menu-button__line"></span>

			</button>

		</div>

	</div>

</div>