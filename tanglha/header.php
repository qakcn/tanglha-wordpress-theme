<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" ng-app="tanglha">
<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php wp_title(''); ?></title>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">

    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <![endif]-->
    <script>(function(){var cl = document.documentElement.classList;cl.remove('no-js');cl.add('js');})();</script>
    <script>
        addEventListener('load', function() {
            var codes = document.querySelectorAll('pre code');
            if(codes.length > 0) {
                for(var i=0; i<codes.length;i++) {
                    var code=codes[i];
                    var msg = {
                        lang: Array.prototype.slice.call(code.classList),
                        content: code.textContent
                    };
                    var worker = new Worker('<?=esc_url( get_template_directory_uri() ) ?>/js/highlight-worker.js');
                    worker.onmessage = function(c) {
                        return function(event) { c.innerHTML = event.data; }
                    }(code);
                    worker.postMessage(msg);
                }
            }
        });
    </script>

    <?php wp_head(); ?>

</head>

<body <?php body_class() ?> autoload-background="<?php tanglha_header(); ?>">
    <header class="main">
        <aside id="global-actionbar">
            <button id="ga-main" title="menu" class="iconfont" aria-haspopup="true" global-menu-button>&#58881;</button>
            <h1><?php bloginfo('name'); ?></h1>
            <p><?php bloginfo('description'); ?></p>
            <?php get_search_form(); ?>
        </aside>


        <img id="header-image" alt="header image" src="<?php tanglha_header(); ?>" header-loaded>
    </header>

    <main class="main">
