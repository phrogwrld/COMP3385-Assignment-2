<?php

namespace App\Framework\Router;

use App\Framework\Http\Request;
use App\Framework\Http\Response;

/**
 * Interface IMiddleware
 * @package App\Framework\Router
 */
interface IMiddleware {
	public function handle(Request $request, Response $response, $next);
}
