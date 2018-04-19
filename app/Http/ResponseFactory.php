<?php

namespace App\Http;
use Laravel\Lumen\Http\ResponseFactory as Response;
use Zend\Config\Config;
use Zend\Config\Writer\Xml;
use Illuminate\Contracts\Support\Arrayable;


class ResponseFactory extends Response {

	public function make($conteudo = '', $status = 200, array $headers = []) {
		$request = app('request');
		$acceptHeader = $request->header('accept');

		$result = '';
		switch ($acceptHeader) {
			case 'application/json':
				$result = $this->json($conteudo, $status, $headers);
				break;
			case 'application/xml':
				$result = parent::make($this->getXML($conteudo),$status, $headers);
				break;
			default: $result = $this->json($conteudo, $status, $headers);
				break;
		}
		return $result;
	}

	protected function getXML($data) {
		if ($data instanceof Arrayable){
			$data = $data->toArray();
		}
		$config = new Config(['result' => $data], true);
		$xmlWriter = new Xml();
		return $xmlWriter->toString($config);
	}

}