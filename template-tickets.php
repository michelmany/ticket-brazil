<?php
/*
* Template Name: Tickets
*/

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'http://ticketbrazil.test', 
    'ck_8db54871486ec2f920fbc42f646cc865ea3106f4', 
    'cs_60b1d1958cb781b502983b03875442a8a9ca4006',
    [
        'wp_api' => true,
        'version' => 'wc/v2',
        'verify_ssl' => false,
    ]
);

$context         = Timber::get_context();
$post            = new TimberPost();
$context['post'] = $post;

$products = array();

$data = array(
    'status' => 'publish',
    'orderby' => 'date',
    'order' => 'asc'
);

$products = $woocommerce->get('products', $data);

$context['products'] = $products;

// Adding ACF to each product
foreach ($products as $key => $product) {
    $context['products'][$key]->acf = get_fields($product->id);
}

Timber::render('template-tickets.twig', $context);