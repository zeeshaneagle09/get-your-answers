<?php
/**
 * Single post template.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="single-page">

	<div class="container">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/single/single-header' ); ?>

			<div class="single-article-layout">

				<main class="single-article-main">

					<?php get_template_part( 'template-parts/single/single-content' ); ?>

				</main>

				<?php get_template_part( 'template-parts/single/single-sidebar' ); ?>

			</div>

		<?php endwhile; ?>

	</div>

</div>

<?php get_footer(); ?>