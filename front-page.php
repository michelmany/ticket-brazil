<?php

use Basecamp\Models\Post;

$context               = Timber::get_context();
$context['posts']      = new Timber\PostQuery();

$context['is_front_page'] = true;

$args = array(
    'post_type' => 'tour',
    'posts_per_page' => -1,
    'orderby' => array(
        'date' => 'DESC'
    )
);

$context['tours'] = Timber::get_posts( $args );

Timber::render('front-page.twig', $context);
