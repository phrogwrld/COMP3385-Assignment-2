<?php

namespace App\Core\Router;

use App\Core\Http\Request;
use App\Core\Http\Response;
use Closure;

/**
 * Class Router
 *
 * A router that manages HTTP request routing and handling.
 *
 * @package App\Core\Router
 * @method get(string $path, $handler) Define a GET route
 * @method post(string $path, $handler) Define a POST route
 * @method put(string $path, $handler) Define a PUT route
 * @method delete(string $path, $handler) Define a DELETE route
 */
class Router {
	protected $routes = [];

	protected $request;

	protected $response;

	protected $fallback = null;

	/**
	 * Router constructor.
	 *
	 * @param Request $request The request object
	 * @param Response $response The response object
	 */
	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	/**
	 * Checks if the provided method is allowed
	 *
	 * @param string $method The HTTP method
	 *
	 * @return void
	 *
	 * @throws \InvalidArgumentException If the provided method is not allowed
	 */
	private function allowed_methods(string $method) {
		if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
			throw new \InvalidArgumentException("Method {$method} not allowed");
		}
	}

	// public function __call($name, $arguments) {
	// 	$method = strtoupper($name);
	// 	$path = $arguments[0];
	// 	$handler = $arguments[1];

	// 	return $this->register($method, $path, $handler);
	// }

	/**
	 * Registers a GET route
	 *
	 * @param string $path The route URI
	 * @param Closure|array $handler The route handler
	 *
	 * @return Route The route object
	 */
	public function get(string $path, $handler) {
		$this->allowed_methods('GET');
		$route = $this->register('GET', $path, $handler);
		return $route;
	}

	/**
	 * Registers a POST route
	 *
	 * @param string $path The route URI
	 * @param Closure|array $handler The route handler
	 *
	 * @return Route The route object
	 */
	public function post(string $path, $handler) {
		$this->allowed_methods('POST');
		$route = $this->register('POST', $path, $handler);
		return $route;
	}

	/**
	 * Registers a PUT route
	 *
	 * @param string $path The route URI
	 * @param Closure|array $handler The route handler
	 *
	 * @return $this
	 */
	public function put(string $path, $handler) {
		$this->allowed_methods('PUT');
		$route = $this->register('PUT', $path, $handler);
		return $route;
	}

	/**
	 * Registers a DELETE route
	 *
	 * @param string $path The route URI
	 * @param Closure|array $handler The route handler
	 *
	 * @return $this
	 */
	public function delete(string $path, $handler) {
		$this->allowed_methods('DELETE');
		$route = $this->register('DELETE', $path, $handler);
		return $route;
	}

	/**
	 * Registers a route
	 *
	 * @param string $method The HTTP method
	 * @param string $uri The route URI
	 * @param Closure|array $handler The route handler
	 *
	 * @return Route The route object
	 *
	 * @throws \InvalidArgumentException If the provided method is not allowed
	 */
	public function register(string $method, string $uri, $handler) {
		$this->allowed_methods($method);

		$route = new Route($uri, $handler);

		if (!isset($this->routes[$method])) {
			$this->routes[$method] = [];
		}

		$this->routes[$method][$route->getUri()] = $route;

		return $route;
	}

	/**
	 * Matches the requested route and handles it.
	 * If the route is not found, the fallback route is handled.
	 *
	 * @return void
	 */
	private function match(): void {
		$uri = $this->request->getUri();
		$method = $this->request->getMethod();

		if (!isset($this->routes[$method])) {
			$this->response->status(404);
			return;
		}

		$routes = $this->routes[$method];

		if (isset($routes[$uri])) {
			$this->handle($routes[$uri]);
			return;
		}

		$this->response->status(404);
		if ($this->fallback) {
			$fallbackRoute = new Route($uri, $this->fallback);
			$this->handle($fallbackRoute);
		}
	}

	/**
	 * Handles the route by calling the handler.
	 * The handler can be a closure or an array.
	 *
	 * @param Route $route The route to be handled
	 *
	 * @return void
	 *
	 * @throws \InvalidArgumentException If the provided handler format is invalid
	 */
	public function handle(Route $route) {
		$method = $route->getMethod();
		$handler = $route->getHandler();
		$action = $route->getAction();

		$middleware = $route->getMiddleware();

		foreach ($middleware as $m) {
			$m->handle($this->request, $this->response, function ($req, $res) {
				$this->request = $req;
				$this->response = $res;
			});
		}

		if (is_callable($method)) {
			$method($this->request, $this->response);
			return;
		}

		if (is_array($handler)) {
			$controller = new $method($this->request, $this->response);
			$controller->$action();
			return;
		}

		throw new \InvalidArgumentException('Invalid handler format');
	}

	/**
	 * Initiates the routing process by matching the requested route.
	 *
	 * @return void
	 */
	public function run() {
		$this->match();
	}

	/**
	 * Sets a fallback route in case of routes not being found.
	 * @param Closure $handler The fallback handler
	 *
	 * @return void
	 */
	public function fallback(Closure $handler) {
		$this->fallback = $handler;
	}
}
