<?php

use App\Core\Http\StatusCode;
use App\Core\Mimikyu;
use App\Controllers\TestController;
use App\Controllers\HomeController;
use App\Middlewares\SecondTestMiddleware;
use App\Middlewares\TestMiddleware;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Middlewares\AuthMiddleware;
use App\Rules\PasswordExists;
use App\Rules\UniqueUsername;
use App\Middlewares\AuthorizationMiddleware;
use App\Helpers\Role;
use App\Controllers\CreateResearcherController;
use App\Controllers\APIAuthController;

require __DIR__ . '/400007969/autoload.php';

// require_once './400007969/core/Router/IMiddleware.php';
// require_once './400007969/core/Http/Request.php';
// require_once './400007969/core/Http/Response.php';
// require_once './400007969/core/Router/Router.php';
// require_once './400007969/core/Router/Route.php';
// require_once './400007969/core/Http/StatusCode.php';
// require_once './400007969/core/Http/Method.php';
// require_once './400007969/core/Controller/BaseController.php';
// require_once './400007969/core/Application.php';
// require_once './400007969/app/Controllers/TestController.php';
// require_once './400007969/core/Controller/BaseController.php';
// require_once './400007969/app/Controllers/HomeController.php';
// require_once './400007969/app/Controllers/AuthController.php';
// require_once './400007969/app/Controllers/APIAuthController.php';
// require_once './400007969/core/View/ParserManager.php';
// require_once './400007969/core/View/Parsers/IParser.php';
// require_once './400007969/core/View/View.php';
// require_once './400007969/core/View/TemplateEngine.php';
// require_once './400007969/core/View/TemplateEngineException.php';
// require_once './400007969/core/View/Parsers/ContentParser.php';
// require_once './400007969/core/View/Parsers/ForEachParser.php';
// require_once './400007969/core/View/Parsers/ForParser.php';
// require_once './400007969/core/View/Parsers/IfStatementParser.php';
// require_once './400007969/app/Middlewares/TestMiddleware.php';
// require_once './400007969/app/Middlewares/SecondTestMiddleware.php';
// require_once './400007969/core/Http/Session.php';
// require_once './400007969/core/Validator/RuleManager.php';
// require_once './400007969/core/Validator/Rules/IRule.php';
// require_once './400007969/core/Validator/Rules/RequiredRule.php';
// require_once './400007969/core/Validator/Rules/EmailRule.php';
// require_once './400007969/core/Validator/Rules/PasswordRule.php';
// require_once './400007969/core/Validator/Validator.php';
// require_once './400007969/core/Database/DatabaseConnection.php';
// require_once './400007969/core/Database/DatabaseException.php';
// require_once './400007969/app/Controllers/DashboardController.php';
// require_once './400007969/app/Middlewares/AuthMiddleware.php';
// require_once './400007969/app/Models/Entity/User.php';
// require_once './400007969/app/Models/IRepository.php';
// require_once './400007969/app/Models/Repository/UserRepository.php';
// require_once './400007969/app/Helpers/Role.php';
// require_once './400007969/app/Rules/UniqueUsername.php';
// require_once './400007969/app/Rules/PasswordExists.php';
// require_once './400007969/app/Controllers/CreateResearcherController.php';
// require_once './400007969/app/Middlewares/AuthorizationMiddleware.php';

$app = new Mimikyu();

$app->getRuleManager()->addRule(new UniqueUsername());
$app->getRuleManager()->addRule(new PasswordExists());

$app->router->get('/', function($req, $res) {
  echo 'Hello World';
  $res->status(StatusCode::ACCEPTED)->send();
})->middleware(TestMiddleware::class, SecondTestMiddleware::class);

$app->router->get('/test', [TestController::class, 'index']);

$app->router->get('/test2', [HomeController::class, 'index']);

$app->router->get('/login', [AuthController::class, 'renderLogin']);

$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'renderRegister']);

$app->router->post('/register', [AuthController::class, 'register']);

$app->router->post('/logout', [AuthController::class, 'logout']);

$app->router->get(
  '/dashboard', [DashboardController::class, 'index']
)->middleware(AuthMiddleware::class);

$app->router->get(
  '/createResearcher', [CreateResearcherController::class, 'index']
)->middleware(AuthMiddleware::class, new AuthorizationMiddleware(Role::ResearchGroupManager));

$app->router->post(
  '/createResearcher', [CreateResearcherController::class, 'createResearcher']
)->middleware(AuthMiddleware::class, new AuthorizationMiddleware(Role::ResearchGroupManager));

$app->router->post('/api/login', [APIAuthController::class, 'login']);

$app->router->fallback(function($_, $res) {
  echo '404';
  $res->status(404)->send();
});

Mimikyu::start();