<?php

namespace App\Controllers;

use App\Core\Controller\BaseController;

class TestController extends BaseController {
	public function index() {
		$this->json([
			'hello' => 'world',
		]);
	}
}
