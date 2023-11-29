<?php

namespace App\Middlewares;

use App\Framework\Http\Request;
use App\Framework\Http\Response;
use App\Framework\Router\IMiddleware;

class SecondTestMiddleware implements IMiddleware {
	public function handle(Request $req, Response $res, $next) {
		echo 'Second Middleware';
	}
}
