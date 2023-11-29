<?php

namespace App\Framework\Router;

use App\Framework\Http\Request;
use App\Framework\Http\Response;
use Closure;

interface IRouter {
	public function get(string $path, $handler);
	public function post(string $path, $handler);
	public function put(string $path, $handler);
	public function delete(string $path, $handler);
	public function register(string $method, string $uri, $handler);
	public function handle(Route $route);
	public function run();
	public function fallback(Closure $handler);
}
