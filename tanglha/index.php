<?php get_header(); ?>

<?php
if (have_posts()) {
    while(have_posts()) {
        the_post();

        tanglha_article();
    }
    echo '<nav class="post-page">';
    echo paginate_links(array(
        'prev_text' => 'prev',
        'next_text' => 'next',
        'type' => 'list',
    ));
    echo '</nav>';
}else {
    ?>
    <article class="hentry">
        <section class="entry">
            <p>oops! this blog is fresh new and nothing to show.</p>
        </section>
    </article>
    <?php
}



?>

<?php get_footer(); ?>
