<?php

namespace App\Framework\Http;

/**
 * A service for managing session state.
 *
 * @method mixed name()
 */
final class Session {
	/**
	 * Whether or not the session has been started.
	 *
	 * @private
	 */
	private static $started = false;

	/**
	 * Starts the session if it is not already started.
	 */
	public function __construct() {
		if (!self::$started) {
			session_start();
			self::$started = true;
		}
	}

	/**
	 * Gets the value of a session variable.
	 *
	 * @param string $key The name of the session variable.
	 * @return mixed The value of the session variable, or null if the variable does not exist.
	 */
	public function getValue($key) {
		return $_SESSION[$key];
	}

	/**
	 * Sets the value of a session variable.
	 *
	 * @param string $key The name of the session variable.
	 * @param mixed $value The value to set for the session variable.
	 */
	public function setValue($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * Checks if a session variable exists.
	 *
	 * @param string $key The name of the session variable.
	 * @return bool Whether or not the session variable exists.
	 */
	public function hasValue($key) {
		return isset($_SESSION[$key]);
	}

	/**
	 * Removes a session variable.
	 *
	 * @param string $key The name of the session variable.
	 */
	public function removeValue($key) {
		unset($_SESSION[$key]);
	}

	/**
	 * Destroys the session.
	 *
	 * @return bool Whether or not the session was destroyed.
	 */
	public function destroySession(): bool {
		return session_destroy();
	}
}
