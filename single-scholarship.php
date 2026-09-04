<?php
/**
 * Single Scholarship.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="single-page">

	<div class="container">

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="single-layout">

				<article class="single-main">

					<?php
					get_template_part(
						'template-parts/single/single-header'
					);

					get_template_part(
						'template-parts/single/single-content'
					);
					?>

				</article>

				<?php
				get_template_part(
					'template-parts/single/single-sidebar'
				);
				?>

			</div>

			<?php
			get_template_part(
				'template-parts/single/related-content'
			);
			?>

		<?php endwhile; ?>

	</div>

</main>

<?php get_footer(); ?>