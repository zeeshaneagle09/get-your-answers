<?php
/**
 * Premium archive card.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id   = get_the_ID();
$post_type = get_post_type( $post_id );

$config = function_exists( 'gyad_get_single_config' )
	? gyad_get_single_config( $post_type )
	: array(
		'taxonomy' => '',
		'label'    => 'Education',
		'accent'   => 'blue',
	);

$terms = ! empty( $config['taxonomy'] )
	? get_the_terms( $post_id, $config['taxonomy'] )
	: array();

$term_name = '';
if ( $terms && ! is_wp_error( $terms ) ) {
	$term_name = $terms[0]->name;
}

$primary_date = function_exists( 'gyad_get_single_primary_date' )
	? gyad_get_single_primary_date( $post_id )
	: '';

$date_state = $primary_date && function_exists( 'gyad_get_single_date_state' )
	? gyad_get_single_date_state( $primary_date )
	: '';

$date_status = $primary_date && function_exists( 'gyad_get_single_date_status_text' )
	? gyad_get_single_date_status_text( $primary_date )
	: '';

$reading_time = function_exists( 'gyad_get_reading_time' )
	? gyad_get_reading_time( $post_id )
	: 1;

$thumbnail_id = get_post_thumbnail_id( $post_id );
?>

<article class="archive-card archive-card--<?php echo esc_attr( $config['accent'] ); ?>">

	<a
		class="archive-card__image"
		href="<?php the_permalink(); ?>"
		aria-label="<?php the_title_attribute(); ?>"
	>
		<?php if ( $thumbnail_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$thumbnail_id,
				'gyad-archive',
				false,
				array(
					'class'    => 'archive-card__img',
					'alt'     => get_the_title( $post_id ),
					'loading' => 'lazy',
					'decoding' => 'async',
				)
			);
			?>
		<?php else : ?>
			<span class="archive-card__placeholder archive-card__placeholder--<?php echo esc_attr( $config['accent'] ); ?>">
				<?php echo esc_html( strtoupper( $config['label'] ) ); ?>
			</span>
		<?php endif; ?>

		<span class="archive-card__image-overlay" aria-hidden="true"></span>
	</a>

	<div class="archive-card__body">

		<div class="archive-card__meta">
			<span class="archive-card__type">
				<?php echo esc_html( $term_name ?: $config['label'] ); ?>
			</span>

			<span aria-hidden="true">•</span>

			<time datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
				<?php echo esc_html( get_the_date( get_option( 'date_format' ), $post_id ) ); ?>
			</time>

			<span aria-hidden="true">•</span>

			<span><?php echo esc_html( function_exists( 'gyad_format_reading_time' ) ? gyad_format_reading_time( $reading_time ) : $reading_time . ' min' ); ?></span>
		</div>

		<h2 class="archive-card__title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>

		<?php if ( has_excerpt() ) : ?>
			<p class="archive-card__excerpt">
				<?php echo esc_html( get_the_excerpt() ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $primary_date && $date_status ) : ?>
			<div class="archive-card__deadline archive-card__deadline--<?php echo esc_attr( $date_state ); ?>">
				<span class="archive-card__deadline-label">
					<?php echo esc_html( $config['date_label'] ?? 'Important date' ); ?>
				</span>
				<time datetime="<?php echo esc_attr( $primary_date ); ?>">
					<?php echo esc_html( wp_date( get_option( 'date_format' ), strtotime( $primary_date ) ) ); ?>
				</time>
				<span class="archive-card__deadline-status">
					<?php echo esc_html( $date_status ); ?>
				</span>
			</div>
		<?php endif; ?>

		<div class="archive-card__footer">
			<a class="archive-card__link" href="<?php the_permalink(); ?>">
				<span>Read More</span>
				<?php echo gyad_icon( 'arrow-right' ); ?>
			</a>
		</div>

	</div>

</article>