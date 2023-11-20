<?php

namespace App\Core\Security;

use App\Core\Mimikyu;

class Csrf {
	public function __construct() {
		Mimikyu::$app->session->setValue('csrf_token', bin2hex(random_bytes(32)));
	}
}
