<?php

/* Output header image */
function tanglha_header() {
    if(is_single() && has_post_thumbnail()) {
        preg_match('/src="(.*?)"/',get_the_post_thumbnail(null, 'tanglha_header_image'), $match);
        echo $match[1];
    }else {
        if(get_header_image()) {
            header_image();
        }else {
            echo get_template_directory_uri().'/images/header.jpg';
        }
    }
}

/* Format geolocation */
function tanglha_geolocation() {
    global $post;
    if ( get_post_meta($post->ID, 'geo_public', true)==1 or (get_post_meta($post->ID, 'geo_latitude', true) && get_post_meta($post->ID, 'geo_longitude', true)) ) {
        $geolat=(float)get_post_meta($post->ID, 'geo_latitude', true);
        $geolon=(float)get_post_meta($post->ID, 'geo_longitude', true);
        $geolat_p=$geolat > 0 ? sprintf('%.3fN', $geolat) : sprintf('%.3fS',-$geolat) ;
        $geolon_p=$geolon > 0 ? sprintf('%.3fE',$geolon) : sprintf('%.3fW',-$geolon) ;
        $geoformat=', geolocation: "<a class="geolocation" href="http://maps.google.com/maps/api/staticmap?size=500x500&format=png&maptype=hybrid&language=zh-CN&sensor=false&markers=color:orange|label:H|%f,%f&KeepThis=true&TB_iframe=true&height=520&width=520" title="Google Maps" target="_blank">%s,%s</a>"';
        printf($geoformat,$geolat,$geolon,$geolat_p,$geolon_p);
    }
}

/* Format references */
function tanglha_reference() {
    global $post;
    $reference=get_post_meta($post->ID, 'reference');
    $num = 'a';
    if (count($reference) == 1) {
        $value = $reference[0];
        echo '<p class="post-info">reference: ';
        echo '<a href="'.$value.'" target="_blank">reference</a>';
    }else if(count($reference) > 1)
        echo '<p class="post-info">references: ';
        foreach($reference as $key => $ref) {
            $num = $key+1;
            echo '<a href="'.$ref.'" target="_blank">reference'.$num.'</a>';
        }
}

/* Format article */
function tanglha_article() {
    ?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <header>
            <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?=sprintf(__('link to &#12302;%s&#12303;', 'tanglha'), the_title()) ?>"><?php the_title(); ?></a></h2>
            <p class="post-info post-metadata">
                <b class="author"><?php the_author_posts_link(); ?></b>
                <time><?php the_time(get_option('date_format')); ?></time>
                <?php
                if(!(is_page() || is_attachment())) {
                ?>
                    <b class="category"><?php the_category(', ') ?></b>
                <?php
                }
                tanglha_geolocation();
                ?>
            </p>
        </header>
        <section class="entry">
            <?php
                if(is_search() || is_archive()) {
                    the_excerpt();
                    echo '<p><a href="'.get_permalink().'" rel="bookmark" title="'.sprintf(__('read more about &#12302;%s&#12303;', 'tanglha'), get_the_title()).'"><span class="more">'.__('read more...', 'tanglha').'</span></a></p>';
                }else {
                    the_content('<span class="more">'.__('read more...', 'tanglha').'</span>');
                }
            ?>
        </section>
        <?php
        wp_link_pages( array(
            'before'      => '<section class="page-links"><span>',
            'after'       => '</span></section>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => '%',
            'separator'   => '</span><span>',
            ) );
        ?>
        <footer>
            <?php
            $tags = get_the_tags();
            if($tags) {
            ?>
            <p class="post-info post-tags"><?php the_tags('', '', ''); ?>.</p>
            <?php } ?>
            <p class="post-info post-comment">
            <?php
                if(!is_singular()) comments_popup_link('0', '1', '%');
            ?>
            </p>
        </footer>
    </article>
    <?php
}

/* Output the user zone in global menu */
function tanglha_user() {
    if(is_user_logged_in()) {
        $user = wp_get_current_user();
        $avatar = get_avatar($user->ID, 100, null, 'user avatar');
        echo '<dt class="user" role="menuitem" id="submenu-user" submenu>';
        echo $avatar;
        echo '<div class="info">';
        echo '<div class="name">'.$user->display_name.'</div>';
        echo '<div class="loginname">'.$user->user_login.'</div>';
        echo '</div></dt>';

        echo '<dd submenu-for="submenu-user"><ul role="menu" class="submenu"><li class="admin"><a rel="nofollow" target="_target" href="'.admin_url().'">'.__('dashboard', 'tanglha').'</a></li><li class="logout">';
        wp_loginout($_SERVER['REQUEST_URI']);
        echo '</li></ul></dd>';
    }else {
        $avatar = '<img src="'.esc_url(get_template_directory_uri().'/images/guest.jpg').'" alt="guest">';
        echo '<dt class="user" role="menuitem" id="submenu-user" submenu="expanded">';
        echo $avatar;
        echo '<div class="info">';
        echo '<div class="name">'.__('guest', 'tanglha').'</div>';
        echo '<div class="loginname">'.__('you\'re welcomingly welcome', 'tanglha').'</div>';
        echo '</div></dt>';

        echo '<dd class="loggedout" submenu-for="submenu-user"><ul role="menu" class="submenu"><li class="login">';
        wp_loginout($_SERVER['REQUEST_URI']);
        echo '</li></ul></dd>';
    }

}

/* Output the global menu */
function tanglha_menu() {
    echo '<dl class="menu" role="menu">';
    tanglha_user();

    echo '<dt class="nomenu home" role="menuitem" aria-haspopup="false"><a rel="index" href="'.home_url().'">'.__('home', 'tanglha').'</a></dt><dd></dd>';

    $categories = get_categories(array(
        'parent' => 0,
    ));
    if(count($categories)>0) {
        $catclass=is_category()?'submenu="expanded"':'submenu';
        $cattitle=_n('category','categories',count($categories),'tanglha');
        echo '<dt class="category" id="submenu-cat" '.$catclass.' role="menuitem" aria-haspopup="true"><a>'.$cattitle.'</a></dt><dd submenu-for="submenu-cat"><ul class="submenu" role="menu">';
        wp_list_categories(array(
            'orderby' => 'term_group,slug',
            'depth' => 1,
            'title_li' => '',
            'show_option_none' => '',
        ));
        echo '</ul></dd>';
    }

    $pages = get_pages(array(
        'sort_column' => 'menu_order,post_name',
    ));
    $pages_sort = array();
    foreach($pages as $page) {
        if($page->post_parent == 0) {
            $pages_sort[$page->ID]['title'] = $page->post_title;
            $pages_sort[$page->ID]['link'] = get_permalink($page);
            $pages_sort[$page->ID]['icon'] = get_post_meta($page->ID, 'tanglha-page-icon', true);
            $pages_sort[$page->ID]['is_page'] = is_page($page->ID);
        }else if(isset($pages_sort[$page->post_parent])) {
            $pages_sort[$page->post_parent]['children'][$page->ID]['title'] = $page->post_title;
            $pages_sort[$page->post_parent]['children'][$page->ID]['link'] = get_permalink($page);
            $pages_sort[$page->post_parent]['children'][$page->ID]['icon'] = get_post_meta($page->ID, 'tanglha-page-icon', true);
            $pages_sort[$page->post_parent]['is_subpage'] = $pages_sort[$page->post_parent]['children'][$page->ID]['is_page'] = is_page($page->ID);
        }
    }
    $pages = $pages_sort;
    unset($pages_sort);
    foreach($pages as $id => $page) {
        $icon = $page['icon'] ? 'icon-'.$page['icon'].' ' : '';
        if(isset($page['children'])) {
            $pageclass = $page['is_page'] || $page['is_subpage'] ? 'submenu="expanded"':'submenu';
            $currentpage = $page['is_page'] ? 'current_page_item ' : '';
            echo '<dt class="'.$icon.' page" id="submenu-page-'.$id.'" '.$pageclass.' role="menuitem" aria-haspopup="true"><a>'.$page['title'].'</a></dt><dd submenu-for="submenu-page-'.$id.'"><ul class="submenu" role="menu">';
            echo '<li class="'.$currentpage.'page_item page-item-'.$id.'" ><a href="'.$page['link'].'">index</a></li>';
            foreach($page['children'] as $id => $page) {
                $currentpage = $page['is_page'] ? 'current_page_item ':'';
                $icon = $page['icon'] ? 'icon-'.$page['icon'].' ' : '';
                echo '<li class="'.$currentpage.'page_item page-item-'.$id.'" ><a href="'.$page['link'].'">'.$page['title'].'</a></li>';
            }
            echo '</ul></dd>';
        }else {
            $currentpage = $page['is_page'] ? 'current_page_item ':'';
            echo '<dt class="'.$currentpage.$icon.'nomenu page page_item page-item-'.$id.'" role="menuitem"  aria-haspopup="false"><a href="'.$page['link'].'">'.$page['title'].'</a></dt><dd></dd>';
        }
    }

    $links = get_bookmarks(array(
        'orderby' => 'rating,name',
    ));
    if(count($links) > 0) {
        $linktitle = _n('link','links',count($links),'tanglha');
        echo '<dt class="link" submenu id="submenu-bookmark" role="menuitem" aria-haspopup="true"><a>'.$linktitle.'</a></dt><dd submenu-for="submenu-bookmark"><ul class="submenu" role="menu">';
        wp_list_bookmarks(array(
            'orderby' => 'rating,name',
            'title_li' => '',
            'categorize' => 0,
        ));
        echo '</ul></dd>';
    }

    echo '</dl>';
}

$tanglha_global_buttons = array(); // Store registered global buttons

/* Register the global button */
function tanglha_global_button_register($name, $type, $icon, $action, $title) {
    global $tanglha_global_buttons;
    $tanglha_global_buttons[$name] = array('type' => $type, 'icon' => $icon, 'action' => $action, 'title' => $title);
}

/* Output the global button */
function tanglha_global_button() {
    global $tanglha_global_buttons;
    if(count($tanglha_global_buttons) > 0) {
        foreach($tanglha_global_buttons as $name => $button) {
            echo '<button class="iconfont '.$button['type'].'" id="gb-'.$name.'" title="'.$button['title'].'" data-action="'.$button['action'].'" role="button">'.$button['icon'].'</button>';
        }
        echo '<button class="iconfont" id="gb-main" title="'.__('more...', 'tanglha').'" role="button" aria-haspopup="true">&#58880;</button>';
    }
}
