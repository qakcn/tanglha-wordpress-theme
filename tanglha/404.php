<?php

get_header();

$hostname = urlencode($_SERVER['HTTP_HOST']);

?>
<article class="hentry">
    <header>
        <h2>HTTP 404</h2>
    </header>
    <section class="entry">
        <p><?=sprintf(__('%s not found.', 'tanglha'), '<code>'.$_SERVER['REQUEST_URI'].'</code>') ?></code> not found.</p>
        <p><?=__('you can <a onclick="event.stopPropagation();document.getElementById(\'ga-search\').click();" href="javascript:void(0);">search</a> within this site.', 'tanglha') ?></p>
        <p><?=sprintf(__('as well you can seach this site using <a href="https://www.google.com/search?q=site%%3A%s">Google</a>, <a href="https://www.bing.com/search?q=site%%3A%s">Bing</a>, <a href="https://search.yahoo.com/search?p=site%%3A%s">Yahoo!</a> or <a href="https://duckduckgo.com/?q=site%%3A%s">DuckDuckGo</a>.', 'tanglha'), $hostname, $hostname, $hostname, $hostname) ?></p>
    </section>
</article>

<?php get_footer(); ?>
