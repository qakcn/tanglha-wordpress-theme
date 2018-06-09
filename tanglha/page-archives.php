<?php
/*
Template Name: archives list
*/
$yearstr=wp_get_archives(array(
    'type' => 'yearly',
    'show_post_count' => 1,
    'format' => 'custom',
    'before' => '<li>',
    'after' => '</li>',
    'echo' => 0,
));

preg_match_all('/<li>(.*?href=(\'|")(.*?(\d{4}).*?)(\'|").*?)<\/li>/', $yearstr, $matches, PREG_SET_ORDER);

$datelist = array();

foreach($matches as $match) {
    $html = $match[1];
    $year = $match[4];
    $datelist[$year]['html'] = $html;
}

$monthstr = wp_get_archives(array(
    'type' => 'monthly',
    'show_post_count' => 1,
    'format' => 'custom',
    'before' => '<li>',
    'after' => '</li>',
    'echo' => 0,
));

preg_match_all('/<li>(.*?href=(\'|")(.*?(\d{4}).*?(\d{2}).*?)(\'|").*?)<\/li>/', $monthstr, $matches, PREG_SET_ORDER);

foreach($matches as $match) {
    $html = $match[1];
    $year = $match[4];
    $month = $match[5];
    $datelist[$year]['month'][$month]['html'] = $html;
}

wp_enqueue_style('tanglha-page-archives', get_template_directory_uri().'/css/page-archives.css', array('tanglha-archive'), false);

get_header();

?>

<div class="archive-header">
    <h1 class="page-title"><?=__('list of archives', 'tanglha') ?></h1>
    <div class="taxonomy-description"></div>
</div>

<article class="hentry">
    <header>
        <h2><?=__('by date', 'tanglha') ?></h2>
    </header>
    <section class="entry">
        <ul class="list" role="tree">
            <?php
            foreach ($datelist as $year => $yd) {
                echo '<li>'.$yd['html'].'<ul class="children">';
                foreach ($yd['month'] as $month => $md) {
                    echo '<li>'.$md['html'].'</li>';
                }
                echo '</ul></li>';
            }
            ?>
        </ul>
    </section>
    <footer>
    </footer>
</article>

<article class="hentry">
    <header>
        <h2><?=__('by author', 'tanglha') ?></h2>
    </header>
    <section class="entry">
        <ul class="list" role="tree"><?php wp_list_authors('exclude_admin=0&optioncount=1&title_li='); ?></ul>
    </section>
    <footer>
    </footer>
</article>

<article class="hentry">
    <header>
        <h2><?=__('by categories', 'tanglha') ?></h2>
    </header>
    <section class="entry">
        <ul class="list" role="tree">
            <?php wp_list_categories(array(
                'show_count' => 1,
                'hide_empty ' => 0,
                'title_li' => '',
            )); ?>
        </ul>
    </section>
    <footer>
    </footer>
</article>

<article class="hentry">
    <header>
        <h2><?=__('by tags', 'tanglha') ?></h2>
    </header>
    <section class="entry">
        <ul class="tag-list">
            <?php
            $tags = wp_tag_cloud(array(
                'format' => 'array',
                'orderby' => 'name',
                'echo' => 0,
                'smallest' => 10,
                'largest' => 40,
            ));
            /*$outtags = array();
            for($i = count($tags); $i > 0; $i--) {
                if($i % 2 ==0) {
                    array_push($outtags, array_pop($tags));
                }else {
                    array_unshift($outtags, array_pop($tags));
                }
            }*/

            echo '<li>'.implode('</li><li>', $tags).'</li>';

            ?>
        </ul>
    </section>
    <footer>
    </footer>
</article>

<?php

get_footer();

?>
