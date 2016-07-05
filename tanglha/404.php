<?php

get_header();

$hostname = urlencode($_SERVER['HTTP_HOST']);

?>
<article class="hentry">
    <header>
        <h2>HTTP 404</h2>
    </header>
    <section class="entry">
        <p><code><?php echo $_SERVER['REQUEST_URI']; ?></code> not found.</p>
        <p>you can <a onclick="event.stopPropagation();document.getElementById('ga-search').click();" href="javascript:void(0);">search</a> within this site.</p>
        <p>as well you can seach this site using <a href="https://www.google.com/search?q=site%3A<?php echo $hostname; ?>">Google</a>, <a href="https://www.bing.com/search?q=site%3A<?php echo $hostname; ?>">Bing</a>, <a href="https://search.yahoo.com/search?p=site%3A<?php echo $hostname; ?>">Yahoo!</a> or <a href="https://duckduckgo.com/?q=site%3A<?php echo $hostname; ?>">DuckDuckGo</a>.</p>
    </section>
</article>

<?php get_footer(); ?>
