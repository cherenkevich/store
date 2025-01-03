<?php
if (empty($cart['items'])) {
    header('location: /');
}

$purchases = array();
foreach($cart['items'] as $key => $row) {
    $purchases[$key] = $row->type == 'pdf' ? $row->download : '';
}
$purchases = json_encode($purchases);

require_once '3rdparty/stripe-php/init.php';
require_once 'secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

$config = array(
    'line_items' => [],
    'mode' => 'payment',
    'success_url' => $domain . '/success/?ids=' . $purchases,
    'cancel_url' => $domain . '/cart/',
);

foreach ($cart['items'] as $key => $row) {

    // if (property_exists($row, 'cover')) {
    //     $cover = $row->cover[0];
    // }

    $config['line_items'][] = [
        'price_data' => [
            'product_data' => [
                'name' => $row->title,
                'description' => ($row->type == "paper" ? "Paper version" : "PDF-version")
            ],
            'currency' => 'eur',
            'unit_amount' => $row->price * 100,
        ],
        'quantity' => 1,
    ];
}

if ($cart['shipping']) {
    $config['shipping_address_collection'] = [
        'allowed_countries' => ['AD', 'AL', 'AT', 'AX', 'BA', 'BE', 'BG', 'BY', 'CH', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FO', 'FR', 'GB', 'GG', 'GI', 'GR', 'HR', 'HU', 'IE', 'IM', 'IS', 'IT', 'JE', 'LI', 'LT', 'LU', 'LV', 'MC', 'MD', 'ME', 'MK', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'RS', 'SE', 'SI', 'SJ', 'SK', 'SM', 'VA', 'XK'],
    ];

    $config['shipping_options'] = [
        [
            'shipping_rate_data'    => [
                'type'              => 'fixed_amount',
                'fixed_amount'      => [
                    'amount'        => $cart['shipping'] * 100,
                    'currency'      => 'eur'
                ],
                'display_name'      => 'Over Europe'
            ]
        ]
    ];
}

$checkout_session = \Stripe\Checkout\Session::create($config);

// print_r($config);
// exit;

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);