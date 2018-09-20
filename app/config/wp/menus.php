<?php

/**
 * Registers a custom Navigation Menu in the custom menu editor
 */
function base_camp_register_menus()
{
    register_nav_menu('main_menu', __('Main menu', 'base-camp'));
    register_nav_menu('lang_menu', __('Lang menu', 'base-camp'));
    register_nav_menu('shop_icons_menu', __('Shop icons menu', 'base-camp'));
}

add_action('after_setup_theme', 'base_camp_register_menus');
