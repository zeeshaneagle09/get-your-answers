<?php
/**
 * Admissions / Jobs / Results columns.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$columns = array(

	array(
		'title'       => 'Admissions',
		'description' => 'Latest university and college admissions.',
		'post_type'   => 'admission',
		'accent'      => 'blue',
		'url'         => home_url( '/admissions/' ),
		'taxonomy'    => 'admission_type',
	),

	array(
		'title'       => 'Jobs',
		'description' => 'Fresh government and private vacancies.',
		'post_type'   => 'job',
		'accent'      => 'green',
		'url'         => home_url( '/jobs/' ),
		'taxonomy'    => 'job_type',
	),

	array(
		'title'       => 'Results',
		'description' => 'Latest board and examination results.',
		'post_type'   => 'result',
		'accent'      => 'purple',
		'url'         => home_url( '/results/' ),
		'taxonomy'    => 'result_board',
	),

);
?>

<section class="content-columns-section">

	<div class="container">

		<div class="content-columns">

			<?php foreach ( $columns as $column ) : ?>

				<?php
				$query = new WP_Query(
					array(
						'post_type'           => $column['post_type'],
						'post_status'         => 'publish',
						'posts_per_page'      => 3,
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					)
				);
				?>

				<section class="content-column content-column--<?php echo esc_attr( $column['accent'] ); ?>">

					<header class="content-column__header">

						<div class="content-column__title">

							<span class="content-column__indicator"></span>

							<div>

								<h2>
									<?php echo esc_html( $column['title'] ); ?>
								</h2>

								<p>
									<?php echo esc_html( $column['description'] ); ?>
								</p>

							</div>

						</div>

						<a
							class="content-column__view-all"
							href="<?php echo esc_url( $column['url'] ); ?>"
							aria-label="<?php echo esc_attr( 'View all ' . $column['title'] ); ?>"
						>
							<span>View All</span>
							<?php echo gyad_icon( 'arrow-right' ); ?>
						</a>

					</header>

					<div class="content-column__items">

						<?php if ( $query->have_posts() ) : ?>

							<?php while ( $query->have_posts() ) : ?>

								<?php $query->the_post(); ?>

								<?php
								$terms = get_the_terms(
									get_the_ID(),
									$column['taxonomy']
								);

								$meta = '';

								if (
									$terms &&
									! is_wp_error( $terms )
								) {
									$meta = $terms[0]->name;
								}

								$item = array(
									'title'  => get_the_title(),
									'date'   => get_the_date(),
									'meta'   => $meta,
									'image'  => get_the_post_thumbnail_url(
										get_the_ID(),
										'medium'
									),
									'url'    => get_permalink(),
									'accent' => $column['accent'],
								);

								get_template_part(
									'template-parts/cards/compact-item-card',
									null,
									array(
										'item' => $item,
									)
								);
								?>

							<?php endwhile; ?>

						<?php else : ?>

							<div class="content-column__empty">

								<span class="content-column__empty-icon">
									<?php echo gyad_icon( 'search' ); ?>
								</span>

								<p>
									No <?php echo esc_html( strtolower( $column['title'] ) ); ?> available yet.
								</p>

							</div>

						<?php endif; ?>

					</div>

					<a
						class="content-column__footer-link"
						href="<?php echo esc_url( $column['url'] ); ?>"
					>
						<span>
							Browse all <?php echo esc_html( strtolower( $column['title'] ) ); ?>
						</span>

						<?php echo gyad_icon( 'arrow-right' ); ?>
					</a>

				</section>

				<?php wp_reset_postdata(); ?>

			<?php endforeach; ?>

		</div>

	</div>

</section>