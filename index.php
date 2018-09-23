<?php

use Basecamp\Models\Post;

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['posts'] = new Timber\PostQuery();
$context['pagination'] = Timber::get_pagination($pagination_mid_size);

Timber::render('index.twig', $context);
