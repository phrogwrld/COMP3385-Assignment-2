<?php

namespace App\Framework;

use App\Framework\Database\DatabaseConnection;
use App\Framework\Http\Request;
use App\Framework\Http\Response;
use App\Framework\Http\Session;
use App\Framework\Router\Router;
use App\Framework\Validator\RuleManager;
use App\Framework\View\ParserManager;

/**
 * Class Mimikyu
 *
 * The core of the application, managing requests, responses, and routing.
 * Centralizes essential components and serves as the application's entry point.
 *
 * @package App\Framework
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
	public DatabaseConnection $db;
	private array $config;

	/**
	 * Mimikyu constructor.
	 */
	public function __construct() {
		self::$app = $this;
		$this->loadConfig();
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		$this->parserManager = new ParserManager();
		$this->session = new Session();
		$this->ruleManager = new RuleManager();
		$this->db = new DatabaseConnection(
			$this->getDatabaseConfig()['host'],
			$this->getDatabaseConfig()['port'],
			$this->getDatabaseConfig()['username'],
			$this->getDatabaseConfig()['password'],
			$this->getDatabaseConfig()['database'],
		);
	}

	/**
	 * Loads the configuration file.
	 *
	 * @return void
	 */
	private function loadConfig() {
		$configFile = str_replace(
			'framework\\',
			'',
			__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.ini',
		);
		if (!file_exists($configFile)) {
			throw new \RuntimeException('Configuration file not found');
		} else {
			$this->config = parse_ini_file($configFile, true);
		}
	}

	/**
	 * Get a specific configuration value by key.
	 *
	 * @param string $key The key of the configuration value
	 * @return mixed|null The configuration value or null if the key is not found
	 */
	public function getConfig(string $key) {
		return $this->config[$key] ?? null;
	}

	/**
	 * Get the database configuration.
	 *
	 * @return array The database configuration
	 */
	public function getDatabaseConfig(): array {
		return $this->config['database'] ?? [];
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

	public function getRuleManager() {
		return $this->ruleManager;
	}

	public function __get($name) {
		if (property_exists($this, $name)) {
			return $this->$name;
		}
	}
}
