<?php

namespace App\Middlewares;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Router\IMiddleware;
use App\Core\Mimikyu;

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
