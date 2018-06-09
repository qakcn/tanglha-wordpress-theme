<?php
if ( post_password_required() ) {
    return;
}
?>
<section id="comments">
    <h2 class="comment-header"><?php
    switch($comment_num = get_comments_number()) {
        case 0:
            _e('no comment', 'tanglha');
            break;
        case 1:
            _e('1 comment', 'tanglha');
            break;
        default:
            sprintf(__('%d comments', 'tanglha'), $comment_num);
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
        'title_reply' => __('reply', 'tanglha'),
        'title_reply_to' => __('reply to %s', 'tanglha'),
        'cancel_reply_link' => __('cancel', 'tanglha'),
        'label_submit' => __('submit', 'tanglha'),
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.__('leave your comment here', 'tanglha').'"></textarea></p>',
        'must_log_in' => sprintf('<p class="must-log-in">'.__('need to be <a href="%s">logged in</a> to comment.', 'tanglha').'</p>', wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) )),
        'logged_in_as' => sprintf('<p class="logged-in-as">'.__('logged in as <a href="%s">%s</a> (<a href="%s" title="log out">log out</a>).', 'tanglha').'</p>',admin_url( 'profile.php' ),$user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )),
        'comment_notes_before' => '<p class="comment-notes">'.__('your email will keep secret. (* required).').'</p>',
        'comment_notes_after' => sprintf('<p class="form-allowed-tags">'.__('you can use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: <code>%s</code>.', 'tanglha').'</p>',allowed_tags()),

    ));
?>
</section>
