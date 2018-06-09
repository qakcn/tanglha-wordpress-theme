<?php get_header(); ?>

<div class="archive-header">
    <h1 class="page-title"><?=sprintf(__('search for &#12302;%s&#12303;', 'tanglha'), get_search_query()) ?></h1>
    <div class="taxonomy-description"></div>
</div>

<?php
if (have_posts()) {
    while(have_posts()) {
        the_post();
        tanglha_article();
    }
    echo '<nav class="post-page">';
    echo paginate_links(array(
        'prev_text' => __('prev', 'tanglha'),
        'next_text' => __('next', 'tanglha'),
        'type' => __('list', 'tanglha'),
    ));
    echo '</nav>';
}else {
    $hostname = urlencode($_SERVER['HTTP_HOST']).'+'.urlencode(get_search_query());
    ?>
    <article class="hentry">
        <section class="entry">
            <p><?=sprintf(__('nothing found when searching <em>%s</em>.', 'tanglha'), get_search_query()) ?></p>
            <p><?=__('you can <b>search</b> another keyword within this site.', 'tanglha') ?></p>
            <p><?=sprintf(__('as well you can seach this site using <a href="https://www.google.com/search?q=site%%3A%s">Google</a>, <a href="https://www.bing.com/search?q=site%%3A%s">Bing</a>, <a href="https://search.yahoo.com/search?p=site%%3A%s">Yahoo!</a> or <a href="https://duckduckgo.com/?q=site%%3A%s">DuckDuckGo</a>.', 'tanglha'), $hostname, $hostname, $hostname, $hostname) ?></p>
        </section>
    </article>
    <?php
}


?>

<?php get_footer(); ?>
