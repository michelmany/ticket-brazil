<?php

// Register Custom Post Type Tour
// Post Type Key: tour
function create_tour_cpt() {

	$labels = array(
		'name' => __( 'Tours', 'Post Type General Name', 'base-camp' ),
		'singular_name' => __( 'Tour', 'Post Type Singular Name', 'base-camp' ),
		'menu_name' => __( 'Tours', 'base-camp' ),
		'name_admin_bar' => __( 'Tour', 'base-camp' ),
		'archives' => __( 'Tour Archives', 'base-camp' ),
		'attributes' => __( 'Tour Attributes', 'base-camp' ),
		'parent_item_colon' => __( 'Parent Tour:', 'base-camp' ),
		'all_items' => __( 'All Tours', 'base-camp' ),
		'add_new_item' => __( 'Add New Tour', 'base-camp' ),
		'add_new' => __( 'Add New', 'base-camp' ),
		'new_item' => __( 'New Tour', 'base-camp' ),
		'edit_item' => __( 'Edit Tour', 'base-camp' ),
		'update_item' => __( 'Update Tour', 'base-camp' ),
		'view_item' => __( 'View Tour', 'base-camp' ),
		'view_items' => __( 'View Tours', 'base-camp' ),
		'search_items' => __( 'Search Tour', 'base-camp' ),
		'not_found' => __( 'Not found', 'base-camp' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'base-camp' ),
		'featured_image' => __( 'Featured Image', 'base-camp' ),
		'set_featured_image' => __( 'Set featured image', 'base-camp' ),
		'remove_featured_image' => __( 'Remove featured image', 'base-camp' ),
		'use_featured_image' => __( 'Use as featured image', 'base-camp' ),
		'insert_into_item' => __( 'Insert into Tour', 'base-camp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Tour', 'base-camp' ),
		'items_list' => __( 'Tours list', 'base-camp' ),
		'items_list_navigation' => __( 'Tours list navigation', 'base-camp' ),
		'filter_items_list' => __( 'Filter Tours list', 'base-camp' ),
	);
	$args = array(
		'label' => __( 'Tour', 'base-camp' ),
		'description' => __( 'Tours', 'base-camp' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-location-alt',
		'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'trackbacks', 'page-attributes', ),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 10,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'page',
	);
	register_post_type( 'tour', $args );

}
add_action( 'init', 'create_tour_cpt', 0 );