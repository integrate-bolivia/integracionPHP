<?php
require __DIR__ . '/vendor/autoload.php';

// URL DE ACCESO A ISIPASS
$endpoint = "https://demo.isipass.com.bo/api";

// Consulta prediseñada
$query = <<<GQL
mutation LOGIN {
	login(
		shop: "%s"
		email: "%s"
		password: "%s"
	) {
		token
		refreshToken
		perfil {
			miEmpresa{
				tienda
				razonSocial
				codigoModalidad
				codigoAmbiente
				fechaValidezToken
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
}
GQL;

// Iniciamos la libreria HTTP
$client = new \GuzzleHttp\Client();

try {
    $response = $client->request('POST', $endpoint, [
        'headers' => [
            'Content-type' => 'application/json'
        ],
        'json' => [
            'query' =>sprintf($query, "[tienda]", "[email]", "[password]")
        ]
    ]);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e->getMessage());
}
// Obtenemos el contenido del Body
$json = $response->getBody()->getContents();

// Decodificamos a formato JSON
$body = json_decode($json);

// Se ha generado algun error?
if(isset($body->errors)) {
    // Codigo para generar excepción
    var_dump($body->errors[0]);
}

// Obtenemos los datos de login
$data = $body->data->login;

// Mostramos en pantalla
echo json_encode($data, JSON_PRETTY_PRINT);

