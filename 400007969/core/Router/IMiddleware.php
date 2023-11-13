<?php

namespace App\Core\Router;

use App\Core\Http\Request;
use App\Core\Http\Response;

/**
 * Interface IMiddleware
 * @package App\Core\Router
 */
interface IMiddleware {
	public function handle(Request $request, Response $response, $next);
}
