<?php get_header(); ?>

<div class="archive-header">
    <h1 class="page-title">search for &#12302;<?php echo get_search_query(); ?>&#12303;</h1>
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
        'prev_text' => 'prev',
        'next_text' => 'next',
        'type' => 'list',
    ));
    echo '</nav>';
}else {
    $hostname = urlencode($_SERVER['HTTP_HOST']).'+'.urlencode(get_search_query());
    ?>
    <article class="hentry">
        <section class="entry">
            <p>nothing found when searching <em><?php echo get_search_query(); ?></em>.</p>
            <p>you can <b>search</b> another keyword within this site.</p>
            <p>as well you can seach this site using <a href="https://www.google.com/search?q=site%3A<?php echo $hostname; ?>">Google</a>, <a href="https://www.bing.com/search?q=site%3A<?php echo $hostname; ?>">Bing</a>, <a href="https://search.yahoo.com/search?p=site%3A<?php echo $hostname; ?>">Yahoo!</a> or <a href="https://duckduckgo.com/?q=site%3A<?php echo $hostname; ?>">DuckDuckGo</a>.</p>
        </section>
    </article>
    <?php
}


?>

<?php get_footer(); ?>
