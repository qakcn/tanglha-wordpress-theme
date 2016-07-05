<?php
function tanglha_admin_menu() {
    add_theme_page('Theme Tanglha Settings', 'Tanglha Settings', 'edit_theme_options', 'tanglha-settings', 'tanglha_theme_page');
}
add_action('admin_menu', 'tanglha_admin_menu');

function tanglha_theme_page() {

}
