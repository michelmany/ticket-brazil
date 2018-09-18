<?php

$context                = Timber::get_context();
$post                   = new TimberPost();
$context['post']        = $post;
$context['cancel_link'] = get_cancel_comment_reply_link(__('Cancel reply', 'base-camp'));
$context['tour_gallery'] = get_field('tour_gallery');
$cover_image_id = $post->cover_image;
$context['tours']['cover_image'] = new TimberImage($cover_image_id);

if (post_password_required($post->ID)) {
    Timber::render('single-password.twig', $context);
} else {
    Timber::render(['single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'], $context);
}
