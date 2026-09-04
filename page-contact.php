<?php
/**
 * Contact page.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="portal-page">

	<div class="container">

		<header class="portal-page-header">

			<span class="portal-page-header__eyebrow">
				Get In Touch
			</span>

			<h1 class="portal-page-header__title">
				Contact Us
			</h1>

			<p class="portal-page-header__description">
				Have a question, suggestion or correction?
				We'd love to hear from you.
			</p>

		</header>


		<div class="contact-layout">

			<section class="contact-card">

				<h2>
					Send a Message
				</h2>

				<p>
					Use the form below to get in touch with the
					Get Your Answers Daily team.
				</p>

				<form
					class="contact-form"
					method="post"
					action=""
				>

					<div class="contact-form__field">

						<label for="contact-name">
							Name
						</label>

						<input
							id="contact-name"
							type="text"
							name="name"
							autocomplete="name"
							required
						>

					</div>


					<div class="contact-form__field">

						<label for="contact-email">
							Email
						</label>

						<input
							id="contact-email"
							type="email"
							name="email"
							autocomplete="email"
							required
						>

					</div>


					<div class="contact-form__field">

						<label for="contact-subject">
							Subject
						</label>

						<input
							id="contact-subject"
							type="text"
							name="subject"
							required
						>

					</div>


					<div class="contact-form__field">

						<label for="contact-message">
							Message
						</label>

						<textarea
							id="contact-message"
							name="message"
							rows="6"
							required
						></textarea>

					</div>


					<button
						type="submit"
						class="contact-form__button"
					>
						Send Message
					</button>

				</form>

			</section>


			<aside class="contact-card contact-card--aside">

				<h2>
					Other Ways to Reach Us
				</h2>

				<p>
					For official applications, results and
					registrations, always use the relevant official
					portal linked on the site.
				</p>

				<a
					class="contact-card__link"
					href="<?php echo esc_url( home_url( '/categories/' ) ); ?>"
				>
					Explore the portal
					<?php echo gyad_icon( 'arrow-right' ); ?>
				</a>

			</aside>

		</div>

	</div>

</main>

<?php get_footer(); ?>