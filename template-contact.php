<?php
/*
* Template Name: Contact
*/

$context         = Timber::get_context();
$post            = new TimberPost();
$context['post'] = $post;

$context['contact_shortcode'] = do_shortcode(get_field('contact_form_shortcode'));
$context['security_warning_image'] = get_field('security_warning_image');
$context['security_warning_text'] = get_field('security_warning_text');

Timber::render('template-contact.twig', $context);