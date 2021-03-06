<?php

/**
 * Register scripts and styles and enqueue them
 */
function base_camp_scripts_and_styles()
{
    // Register styles
    wp_register_style('slick-style', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', [], '', 'all');
    wp_register_style('base-camp-styles', assets('app.css'), [], '', 'all');

    // Register scripts
    wp_register_script('base-camp-vendor', assets('vendor.js'), [], '', true);
    wp_register_script('base-camp-scripts', assets('app.js'), ['base-camp-vendor'], '', true);

    // Enqueue scripts and styles
    wp_enqueue_script('base-camp-scripts');
    wp_enqueue_script('base-camp-vendor');
    wp_enqueue_style('slick-style');
    wp_enqueue_style('base-camp-styles');

    wp_localize_script('base-camp-scripts', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ));   

    // comment reply script for threaded comments
    if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'base_camp_scripts_and_styles', 999);

add_action( 'wp_ajax_my_save_options', 'my_save_options' );
add_action( 'wp_ajax_nopriv_my_save_options', 'my_save_options' );


/**
 * Register Login Page scripts and styles and enqueue them
 */
function base_camp_login_scripts_and_styles()
{
    // Register styles
    wp_register_style('base-camp-login-styles', assets('login.css'), [], '', 'all');

    // Enqueue scripts and styles
    wp_enqueue_style('base-camp-login-styles');
}

add_action('login_enqueue_scripts', 'base_camp_login_scripts_and_styles', 999);

/**
 * Register Admin Page scripts and styles and enqueue them
 */
function base_camp_admin_scripts_and_styles()
{
    // Register styles
    wp_register_style('base-camp-admin-styles', assets('admin.css'), [], '', 'all');

    // Enqueue scripts and styles
    wp_enqueue_style('base-camp-admin-styles');
}

add_action('admin_enqueue_scripts', 'base_camp_admin_scripts_and_styles', 999);
