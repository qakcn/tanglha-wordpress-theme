<?php

function tanglha_customize_register( $wp_customize ) {

    // Add custom color setting and control.
    $wp_customize->add_setting( 'page_background_color', array(
        'default'           => '#eaeaea',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_background_color', array(
        'label'       => 'page background color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'actionbar_background_color', array(
        'default'           => '#1E90FF',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'actionbar_background_color', array(
        'label'       => 'top-bar background color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'content_background_color', array(
        'default'           => '#f8f8f8',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_background_color', array(
        'label'       => 'content background color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'textcolor', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'textcolor', array(
        'label'       => 'text color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'secondary_textcolor', array(
        'default'           => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_textcolor', array(
        'label'       => 'secondary text color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'link_color', array(
        'default'           => '#006892',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
        'label'       => 'link color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'link_hover_color', array(
        'default'           => '#46AECE',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
        'label'       => 'link hover color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'title_link_color', array(
        'default'           => '#006892',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'title_link_color', array(
        'label'       => 'title color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'title_link_hover_color', array(
        'default'           => '#46AECE',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'title_link_hover_color', array(
        'label'       => 'title hover color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'secondary_link_color', array(
        'default'           => '#5599B2',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_link_color', array(
        'label'       => 'secondary link color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'secondary_link_hover_color', array(
        'default'           => '#46AECE',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_link_hover_color', array(
        'label'       => 'secondary link hover color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'line_color', array(
        'default'           => '#ccc',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'line_color', array(
        'label'       => 'line color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'quote_background_color', array(
        'default'           => '#eaeaea',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'quote_background_color', array(
        'label'       => 'quote background color',
        'section'     => 'colors',
    ) ) );

    $wp_customize->add_setting( 'quote_textcolor', array(
        'default'           => '#000',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'quote_textcolor', array(
        'label'       => 'quote text color',
        'section'     => 'colors',
    ) ) );

    // Add theme infomation customize
    $wp_customize->add_section('tanglha_info', array(
        'title' => 'information',
        'description' => 'gather some information that will be shown',
    ));

    $wp_customize->add_setting('tanglha_info_host', array(
        'default' => 'my server',
        'sanitize_callback' => 'tanglha_sanitize_info',
    ));

    $wp_customize->add_control('tanglha_info_host_control', array(
        'label' => 'hosted on',
        'section' => 'tanglha_info',
        'type' => 'textarea',
        'settings' => 'tanglha_info_host',
    ));

    $wp_customize->add_setting('tanglha_info_license', array(
        'default' => '<a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons BY-NC-SA 4.0</a>',
        'sanitize_callback' => 'tanglha_sanitize_info',
    ));

    $wp_customize->add_control('tanglha_info_license_control', array(
        'label' => 'license under',
        'section' => 'tanglha_info',
        'type' => 'textarea',
        'settings' => 'tanglha_info_license',
    ));

    $wp_customize->add_setting('tanglha_info_statistic', array(
        'default' => '',
        'sanitize_callback' => 'tanglha_sanitize_info',
    ));

    $wp_customize->add_control('tanglha_info_statistic_control', array(
        'label' => 'statistic code',
        'section' => 'tanglha_info',
        'type' => 'textarea',
        'settings' => 'tanglha_info_statistic',
    ));


}
add_action( 'customize_register', 'tanglha_customize_register', 11 );

function tanglha_color_styles() {
    $colors = array();
    $default = array(
        'page_background_color'            => '#eaeaea',
        'actionbar_background_color' => '#1E90FF',
        'content_background_color' => '#f8f8f8',
        'textcolor'                   => '#000000',
        'secondary_textcolor' => '#666666',
        'link_color'         => '#006892',
        'link_hover_color'                => '#46AECE',
        'title_link_color' => '#006892',
        'title_link_hover_color' => '#46AECE',
        'secondary_link_color' => '#5599B2',
        'secondary_link_hover_color' => '#46AECE',
        'line_color' => '#ccc',
        'quote_background_color' => '#eaeaea',
        'quote_textcolor' => '#000',
    );
    foreach ($default as $dk => $dv) {
        $colors[$dk] = get_theme_mod($dk);
    }
    $colors = wp_parse_args( $colors, $default );
    $css = '';
    if(strtolower($colors['page_background_color']) != strtolower($default['page_background_color'])) {
        $css .= "body { background-color: $colors[page_background_color]; }\n";
    }
    if(strtolower($colors['textcolor']) != strtolower($default['textcolor'])) {
        $css .= "body,.wp-caption-text, .gallery-caption { color: $colors[textcolor]; }\n";
    }
    if(strtolower($colors['actionbar_background_color']) != strtolower($default['actionbar_background_color'])) {
        $css .= "aside#global-actionbar,aside#global-button button { background-color: $colors[actionbar_background_color]; }\n";
    }
    if(strtolower($colors['content_background_color']) != strtolower($default['content_background_color'])) {
        $css .= "article.hentry,section#comments,nav.post-page,footer.main,.gallery .gallery-item { background-color: $colors[content_background_color]; }\n";
    }
    if(strtolower($colors['secondary_textcolor']) != strtolower($default['secondary_textcolor'])) {
        $css .= "article.hentry p.post-info,ol.comment-list article.comment-body footer.comment-meta div.comment-author span.says,div#respond p { color: $colors[secondary_textcolor]; }\n";
    }
    if(strtolower($colors['link_color']) != strtolower($default['link_color'])) {
        $css .= "a,article.hentry header h2 a { color: $colors[link_color]; }\n";
    }
    if(strtolower($colors['link_hover_color']) != strtolower($default['link_hover_color'])) {
        $css .= "a:hover,article.hentry header h2 a:hover { color: $colors[link_hover_color]; }\ninput#submit:hover,textarea#comment:focus, textarea#comment:hover,aside#global-actionbar form#search-form input.search-field:focus, aside#global-actionbar form#search-form input:hover { border-color: $colors[link_hover_color]; }";
    }
    if(strtolower($colors['title_link_color']) != strtolower($default['title_link_color']) || strtolower($colors['title_link_color']) != strtolower($colors['link_color'])) {
        $css .= "article.hentry header h2 a { color: $colors[title_link_color]; }\n";
    }
    if(strtolower($colors['title_link_hover_color']) != strtolower($default['title_link_hover_color']) || strtolower($colors['title_link_hover_color']) != strtolower($colors['link_hover_color'])) {
        $css .= "article.hentry header h2 a:hover { color: $colors[title_link_hover_color]; }\n";
    }
    if(strtolower($colors['secondary_link_color']) != strtolower($default['secondary_link_color'])) {
        $css .= "article.hentry p.post-info a,ol.comment-list article.comment-body footer.comment-meta div.comment-metadata a, ol.comment-list article.comment-body div.reply a, div#respond p a { color: $colors[secondary_link_color]; }\n";
    }
    if(strtolower($colors['secondary_link_hover_color']) != strtolower($default['secondary_link_hover_color'])) {
        $css .= "article.hentry p.post-info a:hover,ol.comment-list article.comment-body footer.comment-meta div.comment-metadata a:hover, ol.comment-list article.comment-body div.reply a:hover, div#respond p a:hover { color: $colors[secondary_link_hover_color]; }\n";
    }
    if(strtolower($colors['quote_background_color']) != strtolower($default['quote_background_color'])) {
        $css .= "code,.gallery,.yarpp-related { background-color: $colors[quote_background_color]; }\n";
    }
    if(strtolower($colors['quote_textcolor']) != strtolower($default['quote_textcolor'])) {
        $css .= "code,.yarpp-related { color: $colors[quote_textcolor]; }\n";
    }
    if(strtolower($colors['line_color']) != strtolower($default['line_color'])) {
        $css .= ".wp-caption,blockquote,.gallery,.gallery .gallery-item,article.hentry header,article.hentry footer,ol.comment-list li.depth-1,ol.comment-list ol.children,.yarpp-related { border-color: $colors[line_color]; }\n";
    }

    return $css;

}

function tanglha_info($name) {
    $default = array(
        'host' => 'my server',
        'license' => '<a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons BY-NC-SA 4.0</a>',
        'statistic' => '',
    );

    $value = get_theme_mod('tanglha_info_'.$name);

    $value = wp_parse_args(array($name => $value), $default);

    echo $value[$name];
}

function tanglha_sanitize_info($str) {
    return trim($str);
}
