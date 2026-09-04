<?php
/**
 * Top utility bar.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$facebook_url  = function_exists( 'gyad_get_theme_option' )
	? gyad_get_theme_option( 'facebook_url' )
	: '';

$instagram_url = function_exists( 'gyad_get_theme_option' )
	? gyad_get_theme_option( 'instagram_url' )
	: '';

$youtube_url = function_exists( 'gyad_get_theme_option' )
	? gyad_get_theme_option( 'youtube_url' )
	: '';
?>

<div class="site-header__topbar">

	<div class="container">

		<div class="site-header__topbar-inner">

			<div class="site-header__topbar-left">

				<span>
					<?php echo esc_html( wp_date( 'l, F j, Y' ) ); ?>
				</span>

				<span aria-hidden="true">•</span>

				<span>
					Pakistan
				</span>

			</div>


			<div class="site-header__topbar-right">

				<nav
					class="site-header__topbar-links"
					aria-label="Utility Navigation"
				>

					<a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">
						About Us
					</a>

					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
						Contact Us
					</a>

					<a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">
						Privacy Policy
					</a>

				</nav>


				<?php if ( $facebook_url || $instagram_url || $youtube_url ) : ?>

					<div class="site-header__topbar-social">

						<?php if ( $facebook_url ) : ?>

							<a
								href="<?php echo esc_url( $facebook_url ); ?>"
								target="_blank"
								rel="noopener noreferrer"
								aria-label="Facebook"
							>
								<?php echo gyad_icon( 'facebook' ); ?>
							</a>

						<?php endif; ?>


						<?php if ( $instagram_url ) : ?>

							<a
								href="<?php echo esc_url( $instagram_url ); ?>"
								target="_blank"
								rel="noopener noreferrer"
								aria-label="Instagram"
							>
								<?php echo gyad_icon( 'instagram' ); ?>
							</a>

						<?php endif; ?>


						<?php if ( $youtube_url ) : ?>

							<a
								href="<?php echo esc_url( $youtube_url ); ?>"
								target="_blank"
								rel="noopener noreferrer"
								aria-label="YouTube"
							>
								<?php echo gyad_icon( 'youtube' ); ?>
							</a>

						<?php endif; ?>

					</div>

				<?php endif; ?>

			</div>

		</div>

	</div>

</div>