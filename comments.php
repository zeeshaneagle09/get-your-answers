<?php
/**
 * Theme comments template.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="article-comments" aria-labelledby="comments-title">
	<div class="article-comments__heading">
		<span class="article-comments__eyebrow">Community</span>
		<h2 id="comments-title">
			<?php
			printf(
				esc_html( _nx( '%1$s comment', '%1$s comments', get_comments_number(), 'comments title', 'gyad' ) ),
				number_format_i18n( get_comments_number() )
			);
			?>
		</h2>
		<p>Have a question or useful information? Join the discussion.</p>
	</div>

	<?php if ( have_comments() ) : ?>
		<ol class="article-comments__list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
					'callback'   => 'gyad_render_comment',
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<div class="article-comments__form">
			<?php
			comment_form(
				array(
					'class_form' => 'comment-form article-comment-form',
					'title_reply' => 'Join the discussion',
					'comment_notes_before' => '<p class="comment-notes">Your email address will not be published.</p>',
					'label_submit' => 'Post Comment',
				)
			);
			?>
		</div>
	<?php elseif ( get_comments_number() ) : ?>
		<p class="article-comments__closed">Comments are closed.</p>
	<?php endif; ?>
</section>
