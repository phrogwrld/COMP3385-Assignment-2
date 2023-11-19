<?php

namespace App\Middlewares;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Router\IMiddleware;

class SecondTestMiddleware implements IMiddleware {
	public function handle(Request $req, Response $res, $next) {
		echo 'Second Middleware';
	}
}
