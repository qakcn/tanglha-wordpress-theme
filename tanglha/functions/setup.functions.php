<?php
/* Setup for theme */
function tanglha_setup() {
    /* Disable Emoji */
    remove_action( 'admin_print_scripts',   'print_emoji_detection_script');
    remove_action( 'admin_print_styles',    'print_emoji_styles');
    remove_action( 'wp_head',       'print_emoji_detection_script', 7);
    remove_action( 'wp_print_styles',   'print_emoji_styles');
    remove_filter( 'the_content_feed',  'wp_staticize_emoji');
    remove_filter( 'comment_text_rss',  'wp_staticize_emoji');
    remove_filter( 'wp_mail',       'wp_staticize_emoji_for_email');

    /* Disable admin bar */
    add_filter('show_admin_bar', '__return_false');

    /* Add feed link in wp_head() */
    add_theme_support( 'automatic-feed-links' );

    /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    */
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    set_post_thumbnail_size( 825, 510, true );

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support('html5', array('gallery', 'caption', 'search-form', 'comment-form', 'comment-list'));

    /*
    * Enable support for Post Formats.
    *
    * See: https://codex.wordpress.org/Post_Formats
    */
    /*add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );
    */

    add_theme_support( 'custom-header', array(
        'width' => 1000,
        'height' => 400,
        'flex-height' => true,
        'uploads' => true,
        'header-text' => false,
    ) );

    /*
    * This theme styles the visual editor to resemble the theme style,
    * specifically font, colors, icons, and column width.
    */
    add_editor_style( array( 'css/editor-style.css', 'fonts/fonts.css' ) );

    add_image_size('tanglha_header_image', 1000, 500, true);
}
add_action( 'after_setup_theme', 'tanglha_setup' );

/* Embed inline scripts */
function tanglha_inline_scripts() {
    echo '<script>';
    echo 'loading_image="'.get_template_directory_uri().'/images/loading.svg";';
    echo '</script>';
}
add_action('wp_footer', 'tanglha_inline_scripts');

/* Embed script files */
function tanglha_scripts() {
    //Variants
    $jsdir = get_template_directory_uri().'/js/';
    $cssdir = get_template_directory_uri().'/css/';
    $fontdir = get_template_directory_uri().'/fonts/';

    /*
     * Register Styles
     */
    wp_register_style('tanglha-font', $fontdir . 'fonts.css', array(), false);
    wp_register_style('tanglha-iconfont', $fontdir . 'iconfont.css', array(), false);
    wp_register_style('normalize', $cssdir . 'normalize.css', array(), '3.0.2');
    wp_register_style('tanglha-general', $cssdir . 'general.css', array('normalize','tanglha-font','tanglha-iconfont'), false);
    wp_register_style('tanglha-single', $cssdir . 'single.css', array('normalize','tanglha-font','tanglha-iconfont'), false);
    wp_register_style('tanglha-archive', $cssdir . 'archive.css', array('normalize','tanglha-font','tanglha-iconfont'), false);
    wp_register_style('tanglha-no-js', $cssdir . 'no-js.css', array(), false);
    wp_register_style('tanglha-fuck-plugins', $cssdir . 'fuck-plugins.css', array(), false);
    wp_register_style('tanglha-custom', $cssdir . 'custom.css', array(), false);
    wp_register_style('highlightjs', $cssdir . 'highlight.css', array(), '9.4.0');
    //For local development only
    wp_register_script('angularjs', $jsdir . 'angular.min.js', array(), '1.4.8', true); /*
    wp_register_script('angularjs', '//code.angularjs.org/1.4.8/angular.min.js', array(), '1.4.8', true);
    //*/
    wp_register_script('tanglha-common', $jsdir . 'common.js', array('angularjs'), false, true);


    //Styles
    if(is_singular()) {
        wp_enqueue_style('tanglha-single');
    }else if(is_archive() || is_search()) {
        wp_enqueue_style('tanglha-archive');
    }else {
        wp_enqueue_style('tanglha-general');
    }
    wp_enqueue_style('tanglha-no-js');
    wp_enqueue_style('tanglha-fuck-plugins');
    wp_enqueue_style('tanglha-custom');
    wp_enqueue_style('highlightjs');

    wp_add_inline_style( 'tanglha-custom', tanglha_color_styles() );

    //Scripts
    wp_enqueue_script('tanglha-common');
    if(is_singular()) {
        wp_enqueue_script( "comment-reply" );
    }
}
add_action('wp_enqueue_scripts', 'tanglha_scripts');

/* Title of a page */
function tanglha_title($titleorig){
    $bloginfo = get_bloginfo('name').' - '.get_bloginfo('description');
    if(is_home()) {
        $title = get_bloginfo('name').' - '.get_bloginfo('description');
    }else {
        $title = '';
        switch(true) {
            case is_tag():
                $title = 'tag: ';
                break;
            case is_author():
                $title = 'author: ';
                break;
            case is_category():
                $title = 'category: ';
                break;
            case is_attachment():
                $title = 'attachment: ';
                break;
            case is_date():
                $title = 'date: ';
                break;
        }

        $title.='&#12302;' . $titleorig . '&#12303; ' . $bloginfo;
    }
    return $title;
}
add_filter('wp_title', 'tanglha_title');
