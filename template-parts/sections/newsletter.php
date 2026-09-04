<?php
/**
 * Newsletter section.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="newsletter-section">

	<div class="container">

		<div class="newsletter">

			<div class="newsletter__content">

				<span class="newsletter__eyebrow">
					Stay Updated
				</span>

				<h2>
					Get important education updates in your inbox.
				</h2>

				<p>
					Admissions, jobs, scholarships, results and
					important deadlines — without the noise.
				</p>

			</div>

			<form
				class="newsletter__form"
				action="#"
				method="post"
			>

				<label
					class="screen-reader-text"
					for="newsletter-email"
				>
					Email address
				</label>

				<input
					type="email"
					id="newsletter-email"
					name="email"
					placeholder="Enter your email address"
					autocomplete="email"
					required
				>

				<button type="submit">
					Subscribe
				</button>

			</form>

		</div>

	</div>

</section>