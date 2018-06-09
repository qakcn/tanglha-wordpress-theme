<?php get_header(); ?>

<div class="archive-header">
    <?php
    the_archive_title( '<h1 class="page-title">', '</h1>' );
    the_archive_description( '<div class="taxonomy-description">', '</div>' );
    ?>
</div>

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
            <p><?=__('nothing here.', 'tanglha') ?></p>
        </section>
    </article>
    <?php
}

get_footer(); ?>
