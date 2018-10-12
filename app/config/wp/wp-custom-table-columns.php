<?php

function change_columns_filter( $columns ) {
    unset($columns['thumb']);
    unset($columns['is_in_stock']);
    unset($columns['sku']);
    unset($columns['price']);
    $columns['pa_parade'] = __( 'Parade type', 'base-camp' );
    $columns['pa_date'] = __( 'Date', 'base-camp' );
    $columns['pa_seat'] = __( 'Seat type', 'base-camp' );
    $columns['sku'] = __( 'SKU', 'woocommerce' );
    $columns['price'] = __('Price', 'woocommerce');
    $columns['is_in_stock'] = __('Stock', 'woocommerce');
    unset($columns['product_cat']);
    unset($columns['product_tag']);
    unset($columns['featured']);
    unset($columns['product_type']);
    unset($columns['date']);

    return $columns;
}
add_filter( 'manage_edit-product_columns', 'change_columns_filter',10, 1 );

 
function add_columns_value_to_product_grid( $sAttributeCode, $iPostId ) {
    if ( $sAttributeCode == 'pa_parade' ) {
        $parade = get_field('parade', $iPostId);
        echo esc_attr( $parade->name );
    }
    if ( $sAttributeCode == 'pa_date' ) {
        $date = get_field('date', $iPostId);
        echo esc_attr( $date->name );
    }
    if ( $sAttributeCode == 'pa_seat' ) {
        $seat = get_field('seat_type', $iPostId);
        echo esc_attr( $seat->name );
    }
}
add_action( 'manage_product_posts_custom_column', 'add_columns_value_to_product_grid', 10, 2 );