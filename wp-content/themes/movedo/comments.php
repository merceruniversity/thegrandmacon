<?php
	if ( post_password_required() ) {
?>
		<div class="help">
			<p class="no-comments"><?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'movedo' ); ?></p>
		</div>
<?php
		return;
	}
?>

<?php if ( have_comments() ) : ?>

	<!-- Comments -->
	<div id="grve-comments" class="grve-margin-top-3x grve-padding-top-3x grve-margin-bottom-3x grve-border">
		<div class="grve-comments-header grve-margin-bottom-1x">
			<h6 class="grve-comments-number">
			<?php comments_number(); ?>
			</h6>
			<nav class="grve-comment-nav grve-link-text grve-heading-color">
				<ul>
			  		<li><?php previous_comments_link(); ?></li>
			  		<li><?php next_comments_link(); ?></li>
			 	</ul>
			</nav>
		</div>
		<ul>
		<?php wp_list_comments( 'type=comment&callback=movedo_grve_comments' ); ?>
		</ul>
	</div>
	<!-- End Comments -->

<?php endif; ?>


<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

	<div id="grve-comments" class="grve-padding-top-md grve-margin-top-sm grve-border grve-border-top clearfix">
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'movedo' ); ?></p>
	</div>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );

		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'grve-comment-submit-button',
			'title_reply'       => esc_html__( 'Leave a Reply', 'movedo' ),
			'title_reply_to'    => esc_html__( 'Leave a Reply to', 'movedo' ) . ' %s',
			'cancel_reply_link' => esc_html__( 'Cancel Reply', 'movedo' ),
			'label_submit'      => esc_html__( 'Submit Comment', 'movedo' ),
			'submit_button'     => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',

			'comment_field' =>
				'<div class="grve-form-textarea grve-border">'.
				'<textarea style="resize:none;" id="comment" name="comment" placeholder="' . esc_attr__( 'Your Comment Here...', 'movedo' ) . '" cols="45" rows="15" aria-required="true">' .
				'</textarea></div>',

			'must_log_in' =>
				'<p class="must-log-in">' . esc_html__( 'You must be', 'movedo' ) .
				'<a href="' .  wp_login_url( get_permalink() ) . '">' . esc_html__( 'logged in', 'movedo' ) . '</a> ' . esc_html__( 'to post a comment.', 'movedo' ) . '</p>',

			'logged_in_as' =>
				'<div class="logged-in-as grve-link-text">' .  esc_html__('Logged in as','movedo') .
				'<a class="grve-text-content grve-text-hover-primary-1" href="' . esc_url( admin_url( 'profile.php' ) ) . '"> ' . $user_identity . '</a>. ' .
				'<a class="grve-text-content grve-text-hover-primary-1" href="' . wp_logout_url( get_permalink() ) . '" title="' . esc_attr__( 'Log out of this account', 'movedo' ) . '"> ' . esc_html__( 'Log out', 'movedo' ) . '</a></div>',

			'comment_notes_before' => '',
			'comment_notes_after' => '' ,

			'fields' => apply_filters(
				'comment_form_default_fields',
				array(
					'author' =>
						'<div class="grve-form-input grve-border">' .
						'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' .
						' placeholder="' . esc_attr__( 'Name', 'movedo' ) . ' ' . ( $req ? esc_attr__( '(required)', 'movedo' ) : '' ) . '" />' .
						'</div>',

					'email' =>
						'<div class="grve-form-input grve-border">' .
						'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' .
						' placeholder="' . esc_attr__( 'E-mail', 'movedo' ) . ' ' . ( $req ? esc_attr__( '(required)', 'movedo' ) : '' ) . '" />' .
						'</div>',

					'url' =>
						'<div class="grve-form-input grve-border">' .
						'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"' .
						' placeholder="' . esc_attr__( 'Website', 'movedo' )  . '" />' .
						'</div>',
					)
				),
		);
?>
		<div id="grve-comment-form" class="grve-margin-top-3x clearfix">
			<?php
				//Use comment_form() with no parameters if you want the default form instead.
				comment_form( $args );
			?>
		</div>


<?php endif;

//Omit closing PHP tag to avoid accidental whitespace output errors.