<?php

namespace App\Core\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;

abstract class BaseController {
	protected $request;
	protected $response;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	public function json($data = [], $status = 200) {
		$this->response
			->json($data)
			->status($status)
			->send();
		return $this;
	}

	public function view($view, $data = []) {
	}
}
