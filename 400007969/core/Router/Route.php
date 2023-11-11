<?php

namespace App\Core\Router;
use Closure;

/**
 * Class Route
 *
 * Represents a route and its associated handler and URI.
 *
 * @package App\Core\Router
 * @property string $uri The URI associated with the route
 * @property array|Closure $handler The handler for the route
 * @property string|Closure $method The method to be invoked as the handler
 * @property string|null $action The specific action associated with the handler
 *
 * @method string getUri() Retrieves the URI for the route
 * @method array|Closure getHandler() Retrieves the handler for the route
 * @method array|Closure getMethod() Retrieves the method for the handler
 * @method string|null getAction() Retrieves the action associated with the handler
 */
class Route {
	public const CONTROLLER_DELIMITER = '@';
	protected $uri;
	protected $handler;
	protected $method;
	protected $action;

	/**
	 * Route constructor.
	 *
	 * @param string $uri      The URI for the route
	 * @param array|Closure $handler The handler for the route
	 */
	public function __construct(string $uri, array|Closure $handler) {
		// Set and sanitize the URI, ensuring a default of '/' if empty
		$this->uri = rtrim($uri, '/') ?: '/';
		$this->loadHandler($handler);
	}

	/**
	 * Loads the provided handler and sets the method and action accordingly.
	 *
	 * @param array|Closure $handler The handler to be loaded
	 *
	 * @throws \InvalidArgumentException If the provided handler format is invalid
	 */
	public function loadHandler(array|Closure $handler) {
		$this->handler = $handler;

		if (is_callable($handler)) {
			$this->method = $handler;
			return;
		}
		if (is_array($handler)) {
			if (count($handler) !== 2) {
				throw new \InvalidArgumentException('Invalid array handler format');
			}

			[$method, $action] = $handler;

			if (!is_string($method) || !is_string($action)) {
				throw new \InvalidArgumentException('Invalid array handler format');
			}

			$this->method = $method;
			$this->action = $action;

			return;
		}
		throw new \InvalidArgumentException('Invalid handler format');
	}

	/**
	 * Get the URI for the route.
	 *
	 * @return string The URI for the route
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * Get the method for the route handler.
	 *
	 * @return string|Closure The method for the route handler
	 */
	public function getMethod(): string|Closure {
		return $this->method;
	}

	/**
	 * Get the handler for the route.
	 *
	 * @return array|Closure The handler for the route
	 */
	public function getHandler(): array|Closure {
		return $this->handler;
	}

	/**
	 * Get the action associated with the handler.
	 *
	 * @return string|null The action associated with the handler
	 */
	public function getAction(): ?string {
		return $this->action;
	}
}
