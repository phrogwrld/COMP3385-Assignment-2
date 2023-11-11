<?php

use App\Core\Http\StatusCode;
use App\Core\Mimikyu;
use App\Controllers\TestController;

require_once './400007969/core/Http/Request.php';
require_once './400007969/core/Http/Response.php';
require_once './400007969/core/Router/Router.php';
require_once './400007969/core/Router/Route.php';
require_once './400007969/core/Http/StatusCode.php';
require_once './400007969/core/Http/Method.php';
require_once './400007969/core/Controller/BaseController.php';
require_once './400007969/core/Application.php';
require_once './400007969/app/Controllers/TestController.php';
require_once './400007969/core/Controller/BaseController.php';

$app = new Mimikyu();

$app->router->get('/', function($req, $res) {
  echo 'Hello World';
  $res->status(StatusCode::ACCEPTED)->send();
});

$app->router->get('/test', [TestController::class, 'index']);
;

$app->router->fallback(function($_, $res) {
  echo '404';
  $res->status(404)->send();
});

Mimikyu::start();