<?php

use App\Core\Http\StatusCode;
use App\Core\Mimikyu;
use App\Controllers\TestController;
use App\Controllers\HomeController;
use App\Middlewares\SecondTestMiddleware;
use App\Middlewares\TestMiddleware;

require_once './400007969/core/Router/IMiddleware.php';
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
require_once './400007969/app/Controllers/HomeController.php';
require_once './400007969/core/View/ParserManager.php';
require_once './400007969/core/View/Parsers/IParser.php';
require_once './400007969/core/View/View.php';
require_once './400007969/core/View/TemplateEngine.php';
require_once './400007969/core/View/TemplateEngineException.php';
require_once './400007969/core/View/Parsers/ContentParser.php';
require_once './400007969/core/View/Parsers/ForEachParser.php';
require_once './400007969/core/View/Parsers/ForParser.php';
require_once './400007969/core/View/Parsers/IfStatementParser.php';
require_once './400007969/app/Middlewares/TestMiddleware.php';
require_once './400007969/app/Middlewares/SecondTestMiddleware.php';


$app = new Mimikyu();

$app->router->get('/', function($req, $res) {
  echo 'Hello World';
  $res->status(StatusCode::ACCEPTED)->send();
})->middleware(TestMiddleware::class, SecondTestMiddleware::class);

$app->router->get('/test', [TestController::class, 'index']);

$app->router->get('/test2', [HomeController::class, 'index']);

$app->router->fallback(function($_, $res) {
  echo '404';
  $res->status(404)->send();
});

Mimikyu::start();