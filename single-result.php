<?php
/**
 * Single Result.
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
					<?php get_template_part( 'template-parts/single/single-header' ); ?>
					<?php get_template_part( 'template-parts/single/single-content' ); ?>
					<?php get_template_part( 'template-parts/single/author-card' ); ?>
					<?php get_template_part( 'template-parts/single/post-continuation' ); ?>
				</article>
				<?php get_template_part( 'template-parts/single/single-sidebar' ); ?>
			</div>
			<?php get_template_part( 'template-parts/single/related-content' ); ?>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer(); ?>
