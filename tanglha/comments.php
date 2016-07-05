<?php
if ( post_password_required() ) {
    return;
}
?>
<section id="comments">
    <h2 class="comment-header"><?php
    switch($comment_num = get_comments_number()) {
        case 0:
            echo 'no comment';
            break;
        case 1:
            echo '1 comment';
            break;
        default:
            echo $comment_num.' comments';
    }
    ?></h2>

    <ol class="comment-list">
        <?php
        wp_list_comments(array('style'=>'ol', 'reply_text'=>'reply', 'avatar_size' => 80));
        ?>
    </ol>

    <nav class="post-page comment-page">
    <?php
    echo paginate_comments_links(array(
        'prev_text' => 'prev',
        'next_text' => 'next',
        'type' => 'list',
    ));
    echo '</nav>';

    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
        echo '<p class="no-comments">comment denied.</p>';
    }
    comment_form(array(
        'title_reply' => 'reply',
        'title_reply_to' => 'reply to %s',
        'cancel_reply_link' => 'cancel',
        'label_submit' => 'submit',
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="leave your comment here"></textarea></p>',
        'must_log_in' => sprintf('<p class="must-log-in">need to be <a href="%s">logged in</a> to comment.</p>', wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) )),
        'logged_in_as' => sprintf('<p class="logged-in-as">logged in as <a href="%s">%s</a> (<a href="%s" title="log out">log out</a>).</p>',admin_url( 'profile.php' ),$user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )),
        'comment_notes_before' => '<p class="comment-notes">your email will keep secret. (* required).</p>',
        'comment_notes_after' => sprintf('<p class="form-allowed-tags">you can use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: <code>%s</code>.</p>',allowed_tags()),

    ));
?>
</section>
