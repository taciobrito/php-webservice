<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->get('/medicos', 'MedicoController@index');

$router->group([
		'prefix' => 'api/medicos',
		// 'namespace' => 'App\Http\Controllers',
], function() use ($router) {
		$router->get('', 'MedicoController@index');
		$router->get('{id}', 'MedicoController@show');
		$router->post('', 'MedicoController@store');
		$router->put('{id}', 'MedicoController@update');
		$router->delete('{id}', 'MedicoController@destroy');
});

$router->group([
		'prefix' => 'api/medicos/{medico}/especialidades',
		// 'namespace' => 'App\Http\Controllers',
], function() use ($router) {
		$router->get('', 'EspecialidadeController@index');
		$router->get('{id}', 'EspecialidadeController@show');
		$router->post('', 'EspecialidadeController@store');
		$router->put('{id}', 'EspecialidadeController@update');
		$router->delete('{id}', 'EspecialidadeController@destroy');
});

$router->get('tcu', function(){
	$client = new \Zend\Soap\Client('http://contas.tcu.gov.br/debito/CalculoDebito?wsdl');

	echo 'Informações do Servidor: ';
	print_r($client->getOptions());
	echo 'Funções: ';
	print_r($client->getFunctions());
	echo 'Tipos: ';
	print_r($client->getTypes());
	echo "Resultado: ";
	print_r($client->obterSaldoAtualizado([
			'parcelas' => [
					'parcela' => [
							'data' => '1995-01-01',
							'tipo' => 'D',
							'valor' => 35000
					]
			],
			'aplicaJuros' => true,
			'dataAtualizacao' => '2016-12-31'
	]));
});

$uri = 'http://localhost:8000';
$router->get('son-soap.wsdl', function() use ($uri) {
	$autoDiscover = new \Zend\Soap\AutoDiscover();
	$autoDiscover
		->setUri("$uri/server")
		->setServiceName('SONSOAP')
		->addFunction('soma')
		->handle();
});

$router->post('server', function() use ($uri) {
	$server = new \Zend\Soap\Server("$uri/son-soap.wsdl", [
			'cache_wsdl' => WSDL_CACHE_NONE
	]);
	$server->setUri("$uri/server");
	return $server
			->setReturnResponse(true)
			->addFunction('soma')
			->handle();
});

$router->get('teste', function() use ($uri) {
	$client = new \Zend\Soap\Client("$uri/son-soap.wsdl", [
			'cache_wsdl' => WSDL_CACHE_NONE
	]);
	print_r($client->soma(2,5));
});

// SOAP SERVER COM CLIENT
$uriMedico = "$uri/medico";
$router->get('medico/son-soap.wsdl', function() use ($uriMedico) {
	$autoDiscover = new \Zend\Soap\AutoDiscover();
	$autoDiscover
		->setUri("$uriMedico/server")
		->setServiceName('SONSOAP')
		->setClass(\App\Soap\MedicoSoapController::class)
		->handle();
});

$router->post('medico/server', function() use ($uriMedico) {
	$server = new \Zend\Soap\Server("$uriMedico/son-soap.wsdl", [
			'cache_wsdl' => WSDL_CACHE_NONE
	]);
	$server->setUri("$uriMedico/server");
	return $server
			->setReturnResponse(true)
			->setClass(\App\Soap\MedicoSoapController::class)
			->handle();
});


$router->get('soap-medico', function() use ($uriMedico) {
	$client = new \Zend\Soap\Client("$uriMedico/son-soap.wsdl", [
			'cache_wsdl' => WSDL_CACHE_NONE
	]);
	// print_r($client);
	// print_r($client->listAll());
	print_r($client->create([
		'nome' => 'Luiz Carlos',
    'especialidade_id' => 1,
    'turno' => 'Noturno',
	]));
});


/**
* @param int $num1
* @param int $num2
*	@return int
*/
function soma($num1, $num2) {
	return $num1 + $num2;
}