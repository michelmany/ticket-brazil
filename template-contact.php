<?php
/*
* Template Name: Contact
*/

$context         = Timber::get_context();
$post            = new TimberPost();
$context['post'] = $post;

$context['contact_shortcode'] = do_shortcode(get_field('contact_form_shortcode'));

Timber::render('template-contact.twig', $context);