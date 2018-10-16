<?php

function my_custom_endpoint( $request_data ) {
    
    $lang = $request_data->get_param( 'lang' );

    $args = array(
        'status' => 'publish',
        'orderby' => 'name',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'lang' => $lang
    );

    add_filter('posts_orderby', 'orderby_post_title_int' );

    $products = wc_get_products( $args );

    remove_filter('posts_orderby', 'orderby_post_title_int' );

    foreach ($products as $key => $product) {
        $products[$key]->ID = $product->get_id();
        $products[$key]->sku = $product->get_sku();
        $products[$key]->name = $product->get_title();
        $products[$key]->slug = $product->get_slug();
        $products[$key]->price = $product->get_price();
        $products[$key]->status = $product->get_status();
        $products[$key]->in_stock = $product->get_stock_status();
        // $products[$key]->image = $product->get_image();
        $products[$key]->acf = get_fields($product->get_id());
    }

	return $products;
}

// register the endpoint
add_action( 'rest_api_init', function () {
	register_rest_route( 'tickets/v1', '/products/(?P<lang>\w+)', array(
		'methods' => 'GET',
		'callback' => 'my_custom_endpoint',
		)
	);
});

// Changing the orderby param
function orderby_post_title_int( $orderby ) { 
    return '(wp_posts.post_title+0) ASC'; 
}