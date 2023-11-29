<?php

namespace App\Framework\Http;

/**
 * Class Response
 * @package App\Framework\Http
 *
 * @property array $headers
 * @property string $content
 * @property int|StatusCode $status
 *
 * @method Response json($data) Set response content as JSON
 * @method Response status($status) Set the response status code
 * @method Response sendHeaders() Send HTTP headers
 * @method Response send() Send the complete response
 * @method Response cors($origin, $methods, bool $credentials, $headers) Set CORS headers
 */
class Response {
	private $content = null;

	/**
	 * @var int|StatusCode - HTTP status code
	 */
	private int|StatusCode $status = 200;

	protected $headers = [];

	/**
	 * Initialize response object
	 */
	public function __construct() {
		$this->headers = getallheaders();
		$this->cors('*', 'GET, POST, PUT, DELETE, OPTIONS', true, 'Content-Type, Authorization, Accept');
	}

	// public function __construct($content = null, $status = 200) {
	//   $this->content = $content;
	//   $this->status = $status;
	// }

	/**
	 * Set response content as JSON
	 * @param mixed $data - Data to be converted to JSON
	 * @return Response - Returns the Response object for method chaining
	 */
	public function json($data) {
		$this->headers['Content-Type'] = 'application/json';
		$this->content = json_encode($data, JSON_PRETTY_PRINT);
		return $this;
	}

	/**
	 * Set response content as HTML
	 * @param string $html - HTML content
	 * @return Response - Returns the Response object for method chaining
	 */
	public function html($html) {
		$this->headers['Content-Type'] = 'text/html';
		$this->content = $html;
		return $this;
	}

	/**
	 * Set the response status code
	 * @param int $status - HTTP status code
	 * @return Response - Returns the Response object for method chaining
	 */
	public function status($status) {
		$this->status = $status;
		return $this;
	}

	/**
	 * Send HTTP headers
	 * @return string - Returns the response content
	 */
	public function sendHeaders() {
		http_response_code($this->status);
		foreach ($this->headers as $key => $value) {
			header("{$key}: {$value}");
		}

		echo $this->content;

		return $this->content;
	}

	/**
	 * Send the complete response
	 */
	public function send() {
		if (!headers_sent()) {
			$this->sendHeaders();
		}
	}

	/**
	 * Redirect to a new URI
	 *
	 * @param string $uri - URI to redirect to
	 * @param int $status - HTTP status code
	 */
	public function redirect($uri, $status = 302) {
		$this->status($status);
		$this->headers['Location'] = $uri;
		$this->send();
	}
	/**
	 * Set CORS headers
	 * @param string $origin - Allowed origin
	 * @param string $methods - Allowed HTTP methods
	 * @param bool $credentials - Indicates if credentials are allowed
	 * @param string $headers - Allowed headers
	 */
	private function cors($origin, $methods, bool $credentials, $headers) {
		$this->headers['Access-Control-Allow-Origin'] = $origin;
		$this->headers['Access-Control-Allow-Methods'] = $methods;
		$this->headers['Access-Control-Allow-Credentials'] = $credentials;
		$this->headers['Access-Control-Allow-Headers'] = $headers;
	}
}
