<?php
/**
 * Theme footer.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$facebook_url  = gyad_get_theme_option( 'facebook_url' );
$instagram_url = gyad_get_theme_option( 'instagram_url' );
$youtube_url   = gyad_get_theme_option( 'youtube_url' );
?>

	</main>

	<footer class="site-footer">
		<div class="container">
			<div class="site-footer__main">
				<div class="site-footer__brand">
					<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<span class="footer-logo__mark"><?php echo gyad_icon( 'home' ); ?></span>
						<span>GET YOUR <strong>ANSWERS</strong> DAILY</span>
					</a>
					<p>A modern education platform helping students find admissions, jobs, results, scholarships, exams and useful education resources.</p>

					<?php if ( $facebook_url || $instagram_url || $youtube_url ) : ?>
						<div class="footer-socials" aria-label="Social media">
							<?php if ( $facebook_url ) : ?><a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><?php echo gyad_icon( 'facebook' ); ?></a><?php endif; ?>
							<?php if ( $instagram_url ) : ?><a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><?php echo gyad_icon( 'instagram' ); ?></a><?php endif; ?>
							<?php if ( $youtube_url ) : ?><a href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><?php echo gyad_icon( 'youtube' ); ?></a><?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="site-footer__column">
					<h3>Explore</h3>
					<ul>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'admission' ) ?: home_url( '/admissions/' ) ); ?>">Admissions</a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'job' ) ?: home_url( '/jobs/' ) ); ?>">Jobs</a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'result' ) ?: home_url( '/results/' ) ); ?>">Results</a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'exam' ) ?: home_url( '/exams/' ) ); ?>">Exams</a></li>
					</ul>
				</div>

				<div class="site-footer__column">
					<h3>Resources</h3>
					<ul>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'scholarship' ) ?: home_url( '/scholarships/' ) ); ?>">Scholarships</a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'course' ) ?: home_url( '/courses/' ) ); ?>">Courses</a></li>
						<li><a href="<?php echo esc_url( home_url( '/education-news/' ) ); ?>">Education News</a></li>
						<li><a href="<?php echo esc_url( home_url( '/categories/' ) ); ?>">Categories</a></li>
					</ul>
				</div>

				<div class="site-footer__column">
					<h3>Company</h3>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Us</a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
						<li><a href="<?php echo esc_url( home_url( '/privacy/' ) ); ?>">Privacy Policy</a></li>
						<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>">Terms &amp; Conditions</a></li>
					</ul>
				</div>
			</div>

			<div class="site-footer__bottom">
				<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Get Your Answers Daily. All rights reserved.</p>
				<p>Built for students. Built for the future.</p>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
