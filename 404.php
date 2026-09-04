<?php
/**
 * 404 page.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="error-page">

	<div class="container">

		<section class="error-page__inner">

			<span class="error-page__code">
				404
			</span>

			<h1>
				Page not found
			</h1>

			<p>
				The page you're looking for doesn't exist or may have
				moved. Try searching for what you need instead.
			</p>

			<form
				class="error-page__search"
				role="search"
				method="get"
				action="<?php echo esc_url( home_url( '/' ) ); ?>"
			>

				<div class="error-page__field">

					<?php echo gyad_icon( 'search' ); ?>

					<input
						type="search"
						name="s"
						placeholder="Search education content..."
						aria-label="Search education content"
					>

				</div>

				<button type="submit">
					Search
				</button>

			</form>

			<a
				class="error-page__home"
				href="<?php echo esc_url( home_url( '/' ) ); ?>"
			>
				Back to Home
			</a>

		</section>

	</div>

</main>

<?php get_footer(); ?>