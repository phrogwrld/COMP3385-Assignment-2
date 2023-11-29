<?php

namespace App\Controllers;

use App\Framework\Controller\BaseController;

class HomeController extends BaseController {
	public function index() {
		$this->view('./400007969/app/View/test.php', [
			'title' => 'Home',
			'content' => 'Hello world!',
			'list' => ['one', 'two', 'three', 'four', 'five'],
		]);
	}
}
