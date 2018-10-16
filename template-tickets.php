<?php
/*
* Template Name: Tickets
*/

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$lang = pll_current_language();
$context['current_lang'] = $lang;

$data = array(
    'status' => 'publish',
    'orderby' => 'date',
    'order' => 'asc',
    'per_page' => 100
);

$steps_labels = [
    'parade' => __('Select the parade type', 'base-camp'),
    'date' => __('Select the date', 'base-camp'),
    'seat' => __('Select the seat type', 'base-camp'),
    'sector' => __('Select the sector', 'base-camp'),
    'quantity' => __('Enter the quantity', 'base-camp'),
    'add_to_cart' => __('Add to cart', 'base-camp'),
];

$context['steps_labels'] = $steps_labels;

// Repetir modo de listagem do Rio Carnival
$listParades = [
    "en" => [
        ["id" => "135", "name" => "Preliminary Parades"],
        ["id" => "137", "name" => "Main Parades"],
        ["id" => "139", "name" => "Champion's Parade"]
    ],
    "br" => [
        ["id" => "150", "name" => "Grupo da Série A"],
        ["id" => "162", "name" => "Grupo Especial"],
        ["id" => "164", "name" => "Desfile das Campeães"]
    ]
];

$listDates = [
    "en" => [
        ["id" => "127", "name" => "Friday (March 01)", "parade_id" => "135"],
        ["id" => "129", "name" => "Saturday (March 02)", "parade_id" => "135"],
        ["id" => "131", "name" => "Sunday (March 03)", "parade_id" => "137"],
        ["id" => "133", "name" => "Monday (March 04)", "parade_id" => "137"],
        ["id" => "168", "name" => "Saturday (March 09)", "parade_id" => "139"]
    ],
    "br" => [
        ["id" => "147", "name" => "Sexta (01 de Março)", "parade_id" => "150"],
        ["id" => "158", "name" => "Sábado (02 de Março)", "parade_id" => "150"],
        ["id" => "160", "name" => "Domingo (03 de Março)", "parade_id" => "162"],
        ["id" => "156", "name" => "Segunda (04 de Março)", "parade_id" => "162"],
        ["id" => "166", "name" => "Sábado (09 de Março)", "parade_id" => "164"]
    ]
];

$listSeats = [
    "en" => [
        ["id" => "141", "name" => "Grandstand tickets", "parade_id" => ["135","137","139"]],
        ["id" => "143", "name" => "Open Front Box seats", "parade_id" => ["135", "137","139"]],
        ["id" => "145", "name" => "Private Chairs", "parade_id" => ["137","139"]]
    ],
    "br" => [
        ["id" => "153", "name" => "Arquibancadas", "parade_id" => ["150","162","164"]],
        ["id" => "170", "name" => "Lugares na frisa", "parade_id" => ["150","162","164"]],
        ["id" => "172", "name" => "Cadeiras Individuais", "parade_id" => ["162","164"]]
    ]
];

$context['parades_list'] = $listParades[$lang];
$context['dates_list'] = $listDates[$lang];
$context['seats_list'] = $listSeats[$lang];
$context['tickets_acf'] = get_fields();

Timber::render('template-tickets.twig', $context);
