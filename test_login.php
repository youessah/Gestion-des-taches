<?php
$url = 'http://127.0.0.1:8000/index.php?p=login';
$data = ['statut' => 'admin', 'password' => 'admin', 'connexion' => 'Connexion'];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
        'ignore_errors' => true
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
print_r($http_response_header);
?>
