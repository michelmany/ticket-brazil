<?php

use Basecamp\Models\Post;

$context               = Timber::get_context();
$articles_args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'orderby' => array(
        'date' => 'DESC'
    )
);
$context['posts']      = new Timber\PostQuery($articles_args);
$context['is_front_page'] = true;
$args = array(
    'post_type' => 'tour',
    'posts_per_page' => -1,
    'orderby' => array(
        'date' => 'DESC'
    )
);

$context['tours'] = Timber::get_posts( $args );
$context['acf'] = get_fields();
$context['options'] = get_fields('options');

Timber::render('front-page.twig', $context);
