<?php

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Http\Session;
use App\Core\Router\Router;
use App\Core\Validator\RuleManager;
use App\Core\View\ParserManager;

/**
 * Class Mimikyu
 *
 * The core of the application, managing requests, responses, and routing.
 * Centralizes essential components and serves as the application's entry point.
 *
 * @package App\Core
 *
 * @property Router $router Router object
 * @property Request $request Request object
 * @property Response $response Response object
 *
 * @method void run() Runs the router
 * @method void start() Starts the application
 *
 */
class Mimikyu {
	/**
	 *⠀⠀⠀⠀⠀⠀⣀⣤⡤⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⠀⢀⣾⣿⠋⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⣠⣾⣿⡟⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⢸⠛⠉⢹⠃⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⡠⠄⠠⣀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⡘⠀⠀⠀⡀⠀⠀⠀⠀⠀⠀⠀⠀⣠⠖⠉⠀⠀⠀⣾⣿⣦⡀⠀⠀⠀⠀⠀
	 *⠀⠀⡇⠀⠀⠀⢡⠄⠀⠀⣀⣀⣀⣠⠊⠀⠀⠀⠀⡠⠞⠛⠛⠛⠛⠀⠀⠀⠀⠀
	 *⠀⠀⢃⠀⠀⠀⠀⠗⠚⠉⠉⠀⠈⠁⠀⠀⠀⢀⡔⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠸⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣴⣶⣄⠲⡎⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⠃⠀⠀⢠⣤⡀⠀⠀⠀⠀⣿⣿⣿⠀⠘⡄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⡆⠀⠀⣿⣿⡇⠀⠀⠀⠀⠈⠛⠉⣴⣆⢹⡄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⣇⢰⡧⣉⡉⠀⠀⢀⡀⠀⣀⣀⣠⣿⡷⢠⡇⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⢻⠘⠃⠈⠻⢦⠞⠋⠙⠺⠋⠉⠉⠉⢡⠟⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⠀⠳⢄⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢠⠋⠀⠀⠀⠀⠀⠀⠀⠀⠀⣀⣀⠀
	 *⠀⠀⠀⠀⠀⠀⠈⠁⢲⡄⠀⠀⠀⠀⠀⠀⠘⡆⠀⠀⠀⣀⣤⣴⣶⣿⣿⣿⣿⡇
	 *⠀⠀⠀⠀⠀⠀⠀⡰⠋⠀⠀⠀⠀⠀⠀⠀⠀⢿⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃
	 *⠀⠀⠀⠀⠀⢀⡞⠁⠀⠀⣾⠀⠀⣶⠀⠀⠀⢸⣦⣴⣿⣿⣿⠛⠉⠉⠉⠉⠁⠀
	 *⠀⠀⢀⣀⡰⠏⠀⠀⠀⠀⠉⠀⠈⠋⠀⠀⠀⠘⣿⣿⣿⠛⠋⠀⠀⠀⠀⠀⠀⠀
	 *⠰⣮⣉⣀⣀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠻⣿⡋⠀⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠈⠉⠻⠥⠤⢤⣶⢄⠀⢀⣠⣄⠀⠀⢠⣶⣤⣄⠈⠑⡄⠀⠀⠀⠀⠀⠀⠀⠀
	 *⠀⠀⠀⠀⠀⠀⠀⠀⠀⠉⠁⠈⠋⠁⠠⠁⠀⠈⠁⠀⠀⠀⠀⠀⠀
	 */

	public static Mimikyu $app;
	public Router $router;
	public Request $request;
	public Response $response;
	public ParserManager $parserManager;
	public RuleManager $ruleManager;
	public Session $session;

	/**
	 * Mimikyu constructor.
	 */
	public function __construct() {
		self::$app = $this;
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		$this->parserManager = new ParserManager();
		$this->session = new Session();
		$this->ruleManager = new RuleManager();
	}

	/**
	 * Runs the router.
	 *
	 * @return void
	 */
	private function run() {
		$this->router->run();
	}

	/**
	 * Starts the application.
	 *
	 * @return void
	 */
	public static function start() {
		self::$app->run();
	}

	public function getParserManager() {
		return $this->parserManager;
	}

	public function __get($name) {
		if (property_exists($this, $name)) {
			return $this->$name;
		}
	}
}
