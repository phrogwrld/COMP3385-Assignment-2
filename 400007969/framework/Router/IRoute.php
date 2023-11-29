<?php

namespace App\Framework\Router;

use Closure;

/**
 * Interface IRoute
 *
 * Represents a route and its associated handler and URI.
 *
 * @package App\Framework\Router
 */
interface IRoute {
	public function getMethod(): string|Closure;
	public function getHandler(): array|Closure;
	public function getAction(): ?string;
	public function getMiddleware(): ?array;
	public function matches(string $uri): bool;
	public function middleware(...$middleware): IRoute;
}
