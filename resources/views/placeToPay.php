<?php
// Creating a random reference for the test
$seed = date('c', strtotime('+4 minutes'));
$secretKey = '024h1IlD';
$trankey = sha1($seed . $secretKey);

$placetopay = new Dnetix\Redirection\PlacetoPay([
    'login' => '6dd490faf9cb87a9862245da41170ff2',
    'tranKey' => $secretKey,
    'url' => 'https://test.placetopay.com/redirection',
    'rest' => [
        'timeout' => 30, // (optional) 15 by default
        'connect_timeout' => 5, // (optional) 5 by default
    ]
]);

$request = [
    'payment' => [
        'reference' => '1',
        'description' => 'Testing payment',
        'amount' => [
            'currency' => 'USD',
            'total' => 120,
        ],
        "payer" => [
            "name" => "Luis Felipe Garcia",
            "email" => "luisfelipegarciacsj@gmail.com",
            "mobile" => "3152807334"
        ],
        "buyer" => [
            "name" => "Luis Felipe Garcia",
            "email" => "luisfelipegarciacsj@gmail.com",
            "mobile" => "3152807334"
        ],
        "shipping" => [
            "name" => "Luis Felipe Garcia",
            "email" => "luisfelipegarciacsj@gmail.com",
            "mobile" => "3152807334"
        ]
    ],
    'expiration' => date('c', strtotime('+2 days')),
    'returnUrl' => 'http://localhost:8000',
    'ipAddress' => '127.0.0.1',
    'userAgent' => $_SERVER['HTTP_USER_AGENT']
];

try {
    $response = $placetopay->request($request);
    print_r($request);
    if ($response->isSuccessful()) {
        // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order

        // Redirect the client to the processUrl or display it on the JS extension
        print_r($response->processUrl());
        header("Location: " . $response->processUrl());
        exit;
    } else {
        $response->status()->message();
    }
} catch (Exception $e) {
    var_dump($e->getMessage());
}




// $response = $placetopay->query('THE_REQUEST_ID_TO_QUERY');

// if ($response->isSuccessful()) {
//     // In order to use the functions please refer to the Dnetix\Redirection\Message\RedirectInformation class

//     if ($response->status()->isApproved()) {
//         // The payment has been approved
//     }
// } else {
//     // There was some error with the connection so check the message
//     print_r($response->status()->message() . "\n");
// }