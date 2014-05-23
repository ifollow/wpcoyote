

<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to werock_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package werock
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>



	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
	<div class="comments">
		<h1 class="comments-title">
			<?php
				printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'werock' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h1>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'werock' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Comentários Antigos', 'werock' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Novos Comentários &rarr;', 'werock' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use werock_comment() to format the comments.
				 * If you want to override this in a child theme, then you can
				 * define werock_comment() and that will be used instead.
				 * See werock_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'werock_comment' ) );
			?>
		</ol><!-- .comment-list -->
</div>


		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'werock' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'werock' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'werock' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'werock' ); ?></p>
	<?php endif; ?>
   <?php
	    $fields =  array(
	    'title_reply'=>'Deixar uma resposta',
	    'comment_notes_before' => '',
	    'comment_notes_after' => '',
	    'label_submit' => __( 'Enviar resposta', 'werock'),
	    'fields' => apply_filters( 'comment_form_default_fields', array (
	    'author' =>

	    '<div class="row">
		    <div class="col-lg-3 col-md-3 col-sm-3">
		    <input type="text" placeholder="Nome"  name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ).
		    '" size="60" placeholder="Nome*" required />
		    </div>',

	  		'email' =>
	        ' <div class="col-lg-3 col-md-3 col-sm-3">
	        <input type="email"  placeholder="Email" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ).
	    	'" size="30" placeholder="Email*" required />
	        </div>',

	        'url' =>
	            '<div class="col-lg-3 col-md-3 col-sm-3">
	            <input type="text"  placeholder="Website" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ).
	    		'" size="30" placeholder="Website" />
	            </div>
	    </div>',
	    
	    )),
	    'comment_field' =>
	    '<div class="clearfix"></div>
	    <div class="row">
	    <div class="col-lg-12 col-md-12 fields">
	    	<textarea id="your-comment" class="input-block-level" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	    </div>
	    </div>'
	   
    ); ?>
    <article class="post-comments">
		<?php comment_form($fields); ?>
	   </article><!--//post comments-->
	




   