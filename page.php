<?php
/**
 * Default page template.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="page-main">

	<div class="container">

		<?php while ( have_posts() ) : the_post(); ?>

			<article class="page-article">

				<header class="page-article__header">

					<h1 class="page-article__title">
						<?php the_title(); ?>
					</h1>

					<?php if ( has_excerpt() ) : ?>

						<div class="page-article__excerpt">
							<?php echo esc_html( get_the_excerpt() ); ?>
						</div>

					<?php endif; ?>

				</header>

				<div class="page-article__content">

					<?php the_content(); ?>

				</div>

			</article>

		<?php endwhile; ?>

	</div>

</main>

<?php get_footer(); ?>