<?php

namespace App\Middlewares;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Router\IMiddleware;

class TestMiddleware implements IMiddleware {
	public function handle(Request $req, Response $res, $next) {
		echo 'Middleware';
	}
}
