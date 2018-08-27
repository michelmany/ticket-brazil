<?php

// Send notice to user if Timber Class cannot be found
if (!class_exists('Timber')) {
    // Notice on admin pages
    add_action('admin_notices', function () {
        echo '<div class="error">
                  <p>Timber not activated. Make sure you activate the plugin in
                      <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a>
                  </p>
              </div>';
    });

    // Notice on front pages
    add_filter('template_include', function () {
        return get_stylesheet_directory() . '/no-timber.html';
    });

    return 0;
}

/*
|--------------------------------------------------------------------------
| Pagination mid size
|--------------------------------------------------------------------------
|
| Here you can define that how many pagination items there are before and after current
| pagination item in pagination list. First and last item are always visible.
|
| For example:
| $pagination_mid_size = 1 => 1 ... 5 [6] 7 ... 11
| $pagination_mid_size = 2 => 1 ... 4 5 [6] 7 8 ... 11
| $pagination_mid_size = 3 => 1 ... 3 4 5 [6] 7 8 9 ... 11
| $pagination_mid_size = 3 => 1 2 3 4 [5] 6 7 8 ... 11
|
| Supported Mid size value: 1 - n
|
*/

$pagination_mid_size = 2;

$pagination_mid_size += 2; // DON'T TOUCH

/*
|--------------------------------------------------------------------------
| Template paths
|--------------------------------------------------------------------------
|
| Here you may specify an array of paths where to load templates.
|
| Default path: 'resources/views'
|
*/

Timber::$dirname = ['resources/views'];

/**
 * Adds data to Timber context.
 *
 * @param $data
 *
 * @return mixed
 */
function add_to_context($data)
{
    // Add Main Menu to Timber context object
    $data['menu'] = new TimberMenu();

    // Add main-sidebar to Timber context object
    $data['main_sidebar'] = Timber::get_widgets('main-sidebar');

    // Add Locale strings to Timber context object
    $data['messages'] = get_template_messages();

    // Logo
    $data['logo'] = images_path('base-camp-logo.png');

    // Favicon
    $data['favicon'] = images_path('favicon.png');

    // Extend TimberSite object
    $data['site'] = new BaseCampSite();

    return $data;
}

add_filter('timber_context', 'add_to_context');
