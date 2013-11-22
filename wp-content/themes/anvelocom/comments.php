<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			Mesaje
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 74,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'twentythirteen' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentythirteen' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentythirteen' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'twentythirteen' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	
	

	<?php comment_form(array(
	  'title_reply'       => 'Mesajul Dvs.',
    'title_reply_to'    => 'Mesajul Dvs. pentru %s',
    'cancel_reply_link' => __( 'Cancel Reply' ),
    'label_submit'      => 'Trimitere mesaj',
    'must_log_in' => '',
    'logged_in_as' => '',
    'comment_notes_after' => '',
    'comment_notes_before' => '',
    'comment_field' =>  '<p class="comment-form-comment"><label for="comment">Mesaj' .
      '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
      '</textarea></p>',
    'fields' => apply_filters( 'comment_form_default_fields', array(
      'author' =>
        '<p class="comment-form-author">' .
        '<label for="author">Nume</label> ' .
        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30"' .  ' /></p>',

      'email' =>
        '<p class="comment-form-email"><label for="email">Email</label> ' .
        '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30"' . ' /></p>'
    ))
	)); ?>

</div><!-- #comments -->
