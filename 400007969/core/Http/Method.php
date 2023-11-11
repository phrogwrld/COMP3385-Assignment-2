<?php

namespace App\Core\Http;

/**
 * Enum Class Method
 *
 * Defines HTTP methods as constants
 * @package App\Core\Http
 */
final class Method {
	const GET = 'GET'; // Represents the HTTP GET method
	const POST = 'POST'; // Represents the HTTP POST method
	const PUT = 'PUT'; // Represents the HTTP PUT method
	const DELETE = 'DELETE'; // Represents the HTTP DELETE method
	const PATCH = 'PATCH'; // Represents the HTTP PATCH method
	const OPTIONS = 'OPTIONS'; // Represents the HTTP OPTIONS method
}
