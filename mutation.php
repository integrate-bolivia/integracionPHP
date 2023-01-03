<?php
require __DIR__ . '/vendor/autoload.php';

$endpoint = "https://demo.isipass.com.bo/api";

// Generamos los datos de la mutación
$query = '
mutation LOGIN($shop: String!, $email: String!, $password: String!) {
	login(
		shop: $shop
		email: $email
		password: $password
	) {
		token
		refreshToken
	}
}
';

// Generamos las variables
$request_data = array(
    'query' => $query,
    'variables' => array(
        'shop' => 'sandbox',
        'email' => 'richi617@gmail.com',
        'password' => '6176816',
    ),
);

$client = new \GuzzleHttp\Client();

try {
    $response = $client->request('POST', $endpoint, [
        'headers' => [
            'Content-type' => 'application/json',
            // 'Authorization' => sprintf("Bearer %s", $accessToken),
        ],
        'json' => $request_data
    ]);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e->getMessage());
}

$json = $response->getBody()->getContents();
$body = json_decode($json);
// Se ha generado algun error?
if (isset($body->errors)) {
    // Codigo para generar excepción
    var_dump($body->errors[0]);
}
// Obtenemos los datos de login
$data = $body->data;

// Mostramos en pantalla
echo json_encode($data, JSON_PRETTY_PRINT);

