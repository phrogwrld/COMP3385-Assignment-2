<?php

namespace App\Core\Http;

/**
 * Enum Class StatusCode
 *
 * Defines HTTP status codes as constants
 * @package App\Core\Http
 */
final class StatusCode {
	const OK = 200; // Represents a successful response
	const CREATED = 201; // Represents a resource creation success
	const ACCEPTED = 202; // Represents that the request was accepted for processing, but not yet completed
	const NO_CONTENT = 204; // Represents a successful request with no content to return
	const PERMANENT_REDIRECT = 301; // Represents a permanent redirect status
	const TEMPORARY_REDIRECT = 302; // Represents a temporary redirect status
	const NOT_MODIFIED = 304; // Represents that the requested resource has not been modified
	const BAD_REQUEST = 400; // Represents a client error due to invalid request
	const UNAUTHORIZED = 401; // Represents that the request requires user authentication
	const FORBIDDEN = 403; // Represents that the server understood the request, but refuses to authorize it
	const NOT_FOUND = 404; // Represents that the requested resource could not be found
	const METHOD_NOT_ALLOWED = 405; // Represents that the method specified in the request is not allowed for the resource
	const INTERNAL_SERVER_ERROR = 500; // Represents a server error
	const NOT_IMPLEMENTED = 501; // Represents that the server does not support the functionality required to fulfill the request
}
