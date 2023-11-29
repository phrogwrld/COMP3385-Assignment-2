<?php

namespace App\Controllers;

use App\Framework\Controller\BaseController;

class TestController extends BaseController {
	public function index() {
		$this->json([
			'hello' => 'world',
		]);
	}
}
