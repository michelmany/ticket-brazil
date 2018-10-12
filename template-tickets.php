<?php
/*
* Template Name: Tickets
*/

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    getenv('WOO_HOST'),
    getenv('WOO_CK'), 
    getenv('WOO_CS'),
    [
        'wp_api' => true,
        'version' => 'wc/v2',
        'verify_ssl' => false,
    ]
);

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$products = array();

$data = array(
    'status' => 'publish',
    'orderby' => 'date',
    'order' => 'asc'
);

$products = $woocommerce->get('products', $data);

$context['products'] = $products;

$steps_labels = [
    'parade' => __('Select the parade type', 'base-camp'),
    'date' => __('Select the date', 'base-camp'),
    'seat' => __('Select the seat type', 'base-camp'),
    'sector' => __('Select the sector', 'base-camp'),
    'quantity' => __('Enter the quantity', 'base-camp'),
    'add_to_cart' => __('Add to cart', 'base-camp'),
];

$context['steps_labels'] = $steps_labels;

$productsAttr = array(
    [
        'name' => __('Preliminary Parades', 'base-camp'),
        'dates' => [
            ['name' => __('Friday (March 01)', 'base-camp'), 'slug' => 'friday-march-01'],
            ['name' => __('Saturday (March 02)', 'base-camp'), 'slug' => 'saturday-march-02']
        ],
        'seats' => [
            ['name' => __('Grandstand tickets', 'base-camp'), 'slug' => 'grandstand-tickets'],
            ['name' => __('Open Front Box seats', 'base-camp'), 'slug' => 'open-front-box-seats']
        ]
    ],
    [
        'name' => __('Main Parades', 'base-camp'),
        'dates' => [
            ['name' => __('Sunday (March 03)', 'base-camp'), 'slug' => 'sunday-march-03'],
            ['name' => __('Monday (March 04)', 'base-camp'), 'slug' => 'monday-march-04']
        ],
        'seats' => [
            ['name' => __('Grandstand tickets', 'base-camp'), 'slug' => 'grandstand-tickets' ],
            ['name' => __('Open Front Box seats', 'base-camp'), 'slug' => 'open-front-box-seats' ],
            ['name' => __('Private Chairs', 'base-camp'), 'slug' => 'private-chairs' ]
        ]
    ],
    [
        'name' => __('Champions’ Parade', 'base-camp'),
        'dates' => [
            ['name' => __('Saturday (March 09)', 'base-camp'), 'slug' => 'saturday-march-09'],
        ],
        'seats' => [
            ['name' => __('Grandstand tickets', 'base-camp'), 'slug' => 'grandstand-tickets'],
            ['name' => __('Open Front Box seats', 'base-camp'), 'slug' => 'open-front-box-seats'],
            ['name' => __('Private Chairs', 'base-camp'), 'slug' => 'private-chairs']
        ]
    ]                   
);

$context['products_attr'] = $productsAttr;

$context['tickets_acf'] = get_fields();

// Adding ACF to each product
foreach ($products as $key => $product) {
    $context['products'][$key]->acf = get_fields($product->id);
}

Timber::render('template-tickets.twig', $context);

