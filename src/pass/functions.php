<?php

function get_data()
{
    $string = file_get_contents("data/data.json");
    return json_decode($string);
}

function get_cart($cart = NULL) {

    if ( !is_array($cart) ) {
        if (!isset($_COOKIE['cart']) || empty($_COOKIE['cart'])) {
            return array();
        }
        
        $cart = json_decode($_COOKIE['cart']);
    }

    $data = get_data();
    $output = array(
        'items'     => array(),
        'shipping'  => 0,
        'total'     => 0
    );

    foreach ($data as $key => $row) {
        if (in_array($key, $cart)) {
            $output['items'][$key] = $row;
            $output[$row->type][$key] = $row;
            $output['total'] += $row->price;
        }
    }
    
    if (isset($output['paper']) && count($output['paper'])) {
        $output['shipping'] = 5;
        $output['total'] += $output['shipping'];
    }
    
    return $output;
}

// function send_letters($email, $to, $address) {
    
//     // Pt. 1. E-mail to customer
//     $subject = 'Magazine';
//     $message = 'Test';
//     $headers = 'From: Magazine <noreply@cherenkevich.com>' . "\r\n" .
//         'Reply-To: Aleksey Cherenkevich <cherenkevich.com@gmail.com>' . "\r\n" .
//         "X-Mailer: PHP/" . phpversion();

//     mail($email, $subject, $message, $headers);

//     // Pt. 2. E-mail to me
//     $my_email = '<cherenkevich.com@gmail.com>';
//     $subject = 'New Order';
//     $message = 'Test';
//     $headers = 'From: Magazine <noreply@cherenkevich.com>' . "\r\n" .
//         'Reply-To: <Customer Name" . $email . ">' . "\r\n" .
//         "X-Mailer: PHP/" . phpversion();
//     echo $headers;
//     mail($my_email, $subject, $message, $headers);

//     exit;
// }