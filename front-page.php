<?php

use Basecamp\Models\Post;

$context               = Timber::get_context();
$context['posts']      = new Timber\PostQuery();

$context['is_front_page'] = true;

Timber::render('front-page.twig', $context);
