<?php get_header(); ?>

<?php
while ( have_posts() ) {
    the_post();

    if($link = get_edit_post_link($post->ID)) {
        tanglha_global_button_register('edit-post', 'link', '&#x1F589;', $link, 'edit this post');
    }

    tanglha_article();

    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
}
?>

<?php get_footer(); ?>
