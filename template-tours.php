<?php
/*
* Template Name: Tours
*/

$context         = Timber::get_context();
$post            = new TimberPost();
$context['post'] = $post;

$args = array(
    'post_type' => 'tour',
    'posts_per_page' => -1,
    'orderby' => array(
        'date' => 'DESC'
    )
);

$context['tours'] = Timber::get_posts( $args );

Timber::render('template-tours.twig', $context);