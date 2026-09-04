<?php
/**
 * Author archive.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$author = get_queried_object();
$author_id = isset( $author->ID ) ? (int) $author->ID : 0;
$author_name = $author_id ? get_the_author_meta( 'display_name', $author_id ) : '';
$author_bio = $author_id ? get_the_author_meta( 'description', $author_id ) : '';
$author_url = $author_id ? get_author_posts_url( $author_id ) : home_url( '/' );
?>

<div class="container">
	<header class="author-archive-header">
		<div class="author-archive-header__avatar">
			<?php echo get_avatar( $author_id, 112, '', $author_name, array( 'loading' => 'eager', 'decoding' => 'async' ) ); ?>
		</div>
		<div class="author-archive-header__body">
			<span class="author-archive-header__eyebrow">Contributor</span>
			<h1><?php echo esc_html( $author_name ); ?></h1>
			<?php if ( $author_bio ) : ?>
				<p><?php echo esc_html( $author_bio ); ?></p>
			<?php endif; ?>
			<span class="author-archive-header__url"><?php echo esc_url( $author_url ); ?></span>
		</div>
	</header>

	<main id="content-start" class="author-archive-content">
		<div class="section-heading">
			<span class="section-heading__eyebrow">Author archive</span>
			<h2>Latest articles by <?php echo esc_html( $author_name ); ?></h2>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="archive-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/archive/archive-card' ); ?>
				<?php endwhile; ?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => '← Previous',
					'next_text' => 'Next →',
					'aria_label' => 'Author articles navigation',
				)
			);
			?>
		<?php else : ?>
			<div class="empty-state">
				<h2>No articles yet</h2>
				<p>This contributor has not published any articles yet.</p>
			</div>
		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
