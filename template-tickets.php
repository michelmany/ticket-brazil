<?php

/*
* Template Name: Tickets
*/

$context         = Timber::get_context();
$post            = new TimberPost();
$context['post'] = $post;

Timber::render('template-tickets.twig', $context);
