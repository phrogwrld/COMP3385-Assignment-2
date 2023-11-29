<?php

namespace App\Middlewares;

use App\Framework\Http\Request;
use App\Framework\Http\Response;
use App\Framework\Router\IMiddleware;
use App\Framework\Mimikyu;

class AuthMiddleware implements IMiddleware {
	public function handle(Request $req, Response $res, $next) {
		if (
			!Mimikyu::$app->session->hasValue('email') ||
			!Mimikyu::$app->session->hasValue('username') ||
			!Mimikyu::$app->session->hasValue('role')
		) {
			$res->redirect('/login');
		}
		// else {
		// 	$next();
		// }
	}
}
