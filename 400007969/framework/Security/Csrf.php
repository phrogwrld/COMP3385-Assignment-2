<?php

namespace App\Framework\Security;

use App\Framework\Mimikyu;

class Csrf {
	public function __construct() {
		Mimikyu::$app->session->setValue('csrf_token', bin2hex(random_bytes(32)));
	}
}
