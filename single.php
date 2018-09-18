<?php

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['cancel_link'] = get_cancel_comment_reply_link(__('Cancel reply', 'base-camp'));
$context['tour_gallery'] = get_field('tour_gallery');

if (post_password_required($post->ID)) {
    Timber::render('single-password.twig', $context);
} else {
    Timber::render(['single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'], $context);
}
