<?php
/**
 * Premium single article content.
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
		'label'        => 'Education News',
		'accent'       => 'blue',
		'action_label' => '',
	);

$institution = function_exists( 'gyad_get_single_institution' )
	? gyad_get_single_institution( $post_id )
	: get_post_meta(
		$post_id,
		'institution_name',
		true
	);

$official_url = function_exists( 'gyad_get_single_official_url' )
	? gyad_get_single_official_url( $post_id )
	: get_post_meta(
		$post_id,
		'official_url',
		true
	);

$primary_date = function_exists( 'gyad_get_single_primary_date' )
	? gyad_get_single_primary_date( $post_id )
	: '';

$date_state = $primary_date && function_exists( 'gyad_get_single_date_state' )
	? gyad_get_single_date_state( $primary_date )
	: '';

$date_status = $primary_date && function_exists( 'gyad_get_single_date_status_text' )
	? gyad_get_single_date_status_text( $primary_date )
	: '';

$taxonomy_terms = function_exists( 'gyad_get_single_terms' )
	? gyad_get_single_terms( $post_id )
	: array();

$date_label = '';

switch ( $post_type ) {

	case 'admission':
	case 'job':
	case 'scholarship':
		$date_label = 'Application Deadline';
		break;

	case 'result':
		$date_label = 'Result Date';
		break;

	case 'exam':
		$date_label = 'Exam Date';
		break;
}


/*
|--------------------------------------------------------------------------
| Additional content-type data
|--------------------------------------------------------------------------
*/

$secondary_items = array();

switch ( $post_type ) {

	case 'admission':

		$secondary_items = array(
			'application_fee' => array(
				'label' => 'Application Fee',
				'value' => get_post_meta(
					$post_id,
					'application_fee',
					true
				),
			),
			'location' => array(
				'label' => 'Location',
				'value' => get_post_meta(
					$post_id,
					'location',
					true
				),
			),
		);

		break;


	case 'job':

		$secondary_items = array(
			'location' => array(
				'label' => 'Location',
				'value' => get_post_meta(
					$post_id,
					'location',
					true
				),
			),
			'salary' => array(
				'label' => 'Salary',
				'value' => get_post_meta(
					$post_id,
					'salary',
					true
				),
			),
		);

		break;


	case 'result':

		$secondary_items = array(
			'class' => array(
				'label' => 'Examination',
				'value' => get_post_meta(
					$post_id,
					'result_class',
					true
				),
			),
		);

		break;


	case 'course':

		$secondary_items = array(
			'duration' => array(
				'label' => 'Duration',
				'value' => get_post_meta(
					$post_id,
					'course_duration',
					true
				),
			),
			'level' => array(
				'label' => 'Level',
				'value' => get_post_meta(
					$post_id,
					'course_level',
					true
				),
			),
		);

		break;
}


/*
|--------------------------------------------------------------------------
| Remove empty metadata rows
|--------------------------------------------------------------------------
*/

$secondary_items = array_filter(
	$secondary_items,
	function ( $item ) {
		return ! empty( $item['value'] );
	}
);

$has_structured_info = (
	! empty( $institution ) ||
	! empty( $primary_date ) ||
	! empty( $secondary_items )
);


/*
|--------------------------------------------------------------------------
| Featured image
|--------------------------------------------------------------------------
*/

if ( has_post_thumbnail( $post_id ) ) :

	$thumbnail_id = get_post_thumbnail_id(
		$post_id
	);

	$caption = wp_get_attachment_caption(
		$thumbnail_id
	);

	?>

	<figure class="single-featured-media">

		<?php
		echo wp_get_attachment_image(
			$thumbnail_id,
			'gyad-single',
			false,
			array(
				'class'    => 'single-featured-media__image',
				'loading'  => 'eager',
				'decoding' => 'async',
				'fetchpriority' => 'high',
			)
		);
		?>

		<?php if ( $caption ) : ?>

			<figcaption class="single-featured-media__caption">
				<?php echo esc_html( $caption ); ?>
			</figcaption>

		<?php endif; ?>

	</figure>

<?php endif; ?>


<?php
/*
|--------------------------------------------------------------------------
| Article content wrapper
|--------------------------------------------------------------------------
*/
?>

<div class="article-content-wrap">


	<?php
	/*
	|--------------------------------------------------------------------------
	| Desktop tools
	|--------------------------------------------------------------------------
	*/
	?>

	<div class="article-tools" aria-label="Article tools">

		<button
			type="button"
			class="article-tools__button"
			data-copy-url="<?php echo esc_attr( get_permalink( $post_id ) ); ?>"
			aria-label="Copy article link"
			title="Copy link"
		>
			↗
		</button>

	</div>


	<?php
	/*
	|--------------------------------------------------------------------------
	| Main reading article
	|--------------------------------------------------------------------------
	*/
	?>

	<article class="single-article">


		<?php
		/*
		|--------------------------------------------------------------------------
		| At a glance
		|--------------------------------------------------------------------------
		*/

		if ( $has_structured_info ) :
		?>

			<section class="article-info-card">

				<div class="article-info-card__label">
					At a glance
				</div>

				<h2 class="article-info-card__title">
					<?php echo esc_html( $config['label'] ); ?> information
				</h2>


				<div class="article-info-grid">


					<?php if ( $institution ) : ?>

						<div class="article-info-item">

							<span class="article-info-item__label">
								<?php
								echo esc_html(
									in_array(
										$post_type,
										array(
											'job',
											'scholarship',
										),
										true
									)
										? 'Organization'
										: (
											'course' === $post_type
												? 'Provider'
												: 'Institution'
										)
								);
								?>
							</span>

							<strong class="article-info-item__value">
								<?php echo esc_html( $institution ); ?>
							</strong>

						</div>

					<?php endif; ?>


					<?php if ( $primary_date && $date_label ) : ?>

						<div class="article-info-item">

							<span class="article-info-item__label">
								<?php echo esc_html( $date_label ); ?>
							</span>

							<strong class="article-info-item__value">

								<?php
								$timestamp = strtotime(
									$primary_date
								);

								echo esc_html(
									$timestamp
										? wp_date(
											get_option( 'date_format' ),
											$timestamp
										)
										: $primary_date
								);
								?>

							</strong>

						</div>

					<?php endif; ?>


					<?php foreach ( $secondary_items as $item ) : ?>

						<div class="article-info-item">

							<span class="article-info-item__label">
								<?php echo esc_html( $item['label'] ); ?>
							</span>

							<strong class="article-info-item__value">
								<?php echo esc_html( $item['value'] ); ?>
							</strong>

						</div>

					<?php endforeach; ?>


				</div>


				<?php if ( $date_status ) : ?>

					<div
						class="article-info-card__status article-info-card__status--<?php echo esc_attr( $date_state ); ?>"
					>
						<?php echo esc_html( $date_status ); ?>
					</div>

				<?php endif; ?>


				<?php if ( $official_url && ! empty( $config['action_label'] ) ) : ?>

					<div class="article-info-card__action">

						<a
							class="article-cta__button"
							href="<?php echo esc_url( $official_url ); ?>"
							target="_blank"
							rel="noopener noreferrer"
						>
							<?php echo esc_html( $config['action_label'] ); ?>
							<?php echo gyad_icon( 'arrow-right' ); ?>
						</a>

					</div>

				<?php endif; ?>

			</section>

		<?php endif; ?>


		<?php
		/*
		|--------------------------------------------------------------------------
		| Key points
		|--------------------------------------------------------------------------
		|
		| Editors can create this later using the summary component.
		| We intentionally don't fabricate article claims here.
		*/
		?>

		<?php if ( has_excerpt( $post_id ) ) : ?>

			<section class="article-summary">

				<div class="article-summary__label">
					Key information
				</div>

				<h2 class="article-summary__title">
					What you should know
				</h2>

				<p>
					<?php echo esc_html( get_the_excerpt( $post_id ) ); ?>
				</p>

			</section>

		<?php endif; ?>


		<?php
		/*
		|--------------------------------------------------------------------------
		| Actual article content
		|--------------------------------------------------------------------------
		*/
		?>

		<div class="single-article__body">

			<?php the_content(); ?>

		</div>


		<?php
		/*
		|--------------------------------------------------------------------------
		| Official source / CTA
		|--------------------------------------------------------------------------
		*/

		if ( $official_url ) :
		?>

			<section class="article-source">

				<div class="article-source__label">
					Official source
				</div>

				<h2 class="article-source__title">
					Verify this information
				</h2>

				<div class="article-source__row">

					<p class="article-source__text">
						<?php
						echo esc_html(
							sprintf(
								'Check the official %s source for the latest information, changes and requirements.',
								strtolower( $config['label'] )
							)
						);
						?>
					</p>

					<a
						class="article-source__button"
						href="<?php echo esc_url( $official_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						Visit Official Source
						<?php echo gyad_icon( 'arrow-right' ); ?>
					</a>

				</div>

			</section>

		<?php endif; ?>


		<?php
		/*
		|--------------------------------------------------------------------------
		| Topic tags
		|--------------------------------------------------------------------------
		*/

		$tags = get_the_tags( $post_id );

		if ( $tags || ! empty( $taxonomy_terms ) ) :
		?>

			<div class="article-tags">

				<span class="article-tags__label">
					Topics
				</span>


				<?php foreach ( $taxonomy_terms as $term ) : ?>

					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
						<?php echo esc_html( $term->name ); ?>
					</a>

				<?php endforeach; ?>


				<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>

					<?php foreach ( $tags as $tag ) : ?>

						<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">
							<?php echo esc_html( $tag->name ); ?>
						</a>

					<?php endforeach; ?>

				<?php endif; ?>

			</div>

		<?php endif; ?>


	</article>

</div>