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
});