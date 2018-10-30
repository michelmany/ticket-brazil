<?php
/*
* Template Name: About
*/

$context         = Timber::get_context();
$post            = new TimberPost();
$context['post'] = $post;

$context['privacy_text_box'] = get_field('privacy_text_box');
$context['sidebar_image'] = get_field('sidebar_image');

Timber::render('template-about.twig', $context);