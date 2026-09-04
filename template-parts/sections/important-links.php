<?php
/**
 * Important links section.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$link_settings = array(
	'hec_url'   => 'HEC Portal',
	'ppsc_url'  => 'PPSC',
	'fpsc_url'  => 'FPSC',
	'nts_url'   => 'NTS',
	'etea_url'  => 'ETEA',
	'bise_url'  => 'BISE Boards',
	'nacta_url' => 'NACTA',
	'pec_url'   => 'PEC',
);

$links = array();

foreach ( $link_settings as $option_key => $label ) {

	$url = gyad_get_theme_option( $option_key );

	if ( $url ) {

		$links[] = array(
			'label' => $label,
			'url'   => $url,
		);

	}
}
?>

<section class="important-links-section">

	<div class="container">

		<div class="important-links">

			<div class="important-links__intro">

				<h2>
					Important Links
				</h2>

				<p>
					Quick access to the official portals and
					education authorities you use most.
				</p>

				<a
					class="important-links__intro-link"
					href="<?php echo esc_url( home_url( '/links/' ) ); ?>"
				>
					<span>View all resources</span>
					<?php echo gyad_icon( 'arrow-right' ); ?>
				</a>

			</div>

			<div class="important-links__grid">

				<?php if ( $links ) : ?>

					<?php foreach ( $links as $link ) : ?>

						<a
							class="important-link"
							href="<?php echo esc_url( $link['url'] ); ?>"
							target="_blank"
							rel="noopener noreferrer"
						>

							<span class="important-link__label">
								<?php echo esc_html( $link['label'] ); ?>
							</span>

							<span class="important-link__arrow">
								<?php echo gyad_icon( 'arrow-right' ); ?>
							</span>

						</a>

					<?php endforeach; ?>

				<?php else : ?>

					<div class="important-links__empty">

						<p>
							Add your official portals from
							Settings → GYAD Theme Settings.
						</p>

					</div>

				<?php endif; ?>

			</div>

		</div>

	</div>

</section>