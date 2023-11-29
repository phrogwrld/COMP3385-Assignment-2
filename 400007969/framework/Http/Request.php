<?php

namespace App\Framework\Http;

/**
 * Class Request
 *
 * Represents an incoming HTTP request.
 *
 * @package App\Framework\Http
 *
 * @property string $uri The request URI
 * @property string $method The request method
 * @property array $params The request parameters
 * @property string $body The request body
 * @property array $headers The request headers
 *
 * @method string getUri() Retrieves the request URI
 * @method string getMethod() Retrieves the request method
 * @method array getParams() Retrieves the request parameters
 * @method string getBody() Retrieves the request body
 * @method array getHeaders() Retrieves the request headers
 * @method string|null getHeader($header) Retrieves the specified request header
 */
class Request {
	private $uri;
	private $method;
	private $params;
	private $body;
	private $headers;
	protected $queryParams = [];

	public function __construct() {
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
		$this->params = $_REQUEST;
		$this->body = file_get_contents('php://input');
		$this->headers = getallheaders();
	}
	/**
	 * Retrieves the request URI.
	 *
	 * @return string The request URI
	 */
	public function getUri(): string {
		return $this->uri;
	}

	public function getMethod() {
		return $this->method;
	}

	/**
	 * Retrieves the request parameters.
	 *
	 * @return array The request parameters
	 */
	public function getParams(): array {
		return $this->params;
	}

	/**
	 * Retrieves the request body content.
	 *
	 * @return mixed The request body content
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * Retrieves a specific header from the request.
	 *
	 * @param string $header The name of the header to retrieve
	 *
	 * @return string|null The value of the specified header, or null if not found
	 */
	public function getHeader($header): ?string {
		return $this->headers[$header] ?? null;
	}

	/**
	 * Retrieves all headers from the request.
	 *
	 * @return array The request headers
	 */
	public function getHeaders(): array {
		return $this->headers;
	}

	/**
	 * Set a header.
	 *
	 * @param string $header The header name
	 *
	 * @param string $value The header value
	 */
	public function setHeader($header, $value) {
		$this->headers[$header] = $value;
	}

	/**
	 * Set query parameters.
	 *
	 * @param array $params The query parameters
	 */
	public function setQueryParams(array $params) {
		$this->queryParams = $params;
	}

	/**
	 * Get query parameters.
	 *
	 * @return array The query parameters
	 */
	public function getQueryParams() {
		return $this->queryParams;
	}
}
