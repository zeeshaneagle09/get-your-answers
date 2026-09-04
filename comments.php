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

if ( ! function_exists( 'gyad_render_comment' ) ) {
	function gyad_render_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'article-comment', $comment ); ?>>
			<article class="article-comment__body">
				<div class="article-comment__avatar">
					<?php echo get_avatar( $comment, 48, '', get_comment_author(), array( 'class' => array( 'article-comment__avatar-image' ) ) ); ?>
				</div>
				<div class="article-comment__content">
					<header class="article-comment__meta">
						<strong class="article-comment__author"><?php echo esc_html( get_comment_author() ); ?></strong>
						<time datetime="<?php echo esc_attr( get_comment_time( 'c' ) ); ?>"><?php echo esc_html( get_comment_date() ); ?></time>
					</header>
					<div class="article-comment__text"><?php comment_text(); ?></div>
					<?php if ( comments_open() ) : ?>
						<div class="article-comment__reply">
							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'reply_text' => 'Reply',
										'add_below' => 'comment',
										'depth' => $depth,
										'max_depth' => $args['max_depth'],
									)
								)
							);
							?>
						</div>
					<?php endif; ?>
				</div>
			</article>
		</li>
		<?php
	}
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
					'style' => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
					'callback' => 'gyad_render_comment',
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
