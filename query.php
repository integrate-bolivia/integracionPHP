<?php
require __DIR__ . '/vendor/autoload.php';

$accessToken = "[TOKEN_JWT]";
$endpoint = "https://demo.isipass.com.bo/api";

$query = <<<GQL
query PERFIL_DATOS {
	perfil{
		miEmpresa{
			razonSocial
			codigoModalidad
			codigoAmbiente
			fechaValidezToken
			tienda
		}
		razonSocial
		nombres
		apellidos
		avatar
		cargo
		ci
		correo
		rol
		sigla
		dominio
		tipo
		vigente
		sucursal {
			codigo
			direccion
			telefono
			departamento {
				codigo
				codigoPais
				sigla
				departamento
			}
			direccion
		}
		puntoVenta {
			codigo
			descripcion
			nombre
			tipoPuntoVenta {
				codigoClasificador
				descripcion
			}
		}
		actividadEconomica {
			codigoCaeb
			descripcion
			tipoActividad
		}
		moneda {
			codigo
			descripcion
			sigla
		}
		monedaTienda {
			codigo
			descripcion
			sigla
		}
	}
}
GQL;

$client = new \GuzzleHttp\Client();

try {
    $response = $client->request('POST', $endpoint, [
        'headers' => [
            'Content-type' => 'application/json',
            'Authorization' => sprintf("Bearer %s", $accessToken),
        ],
        'json' => [
            'query' => $query
        ]
    ]);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e->getMessage());
}

$json = $response->getBody()->getContents();
$body = json_decode($json);
// Se ha generado algun error?
if(isset($body->errors)) {
    // Codigo para generar excepción
    var_dump($body->errors[0]);
}
// Obtenemos los datos de login
$data = $body->data;

// Mostramos en pantalla
echo json_encode($data, JSON_PRETTY_PRINT);

