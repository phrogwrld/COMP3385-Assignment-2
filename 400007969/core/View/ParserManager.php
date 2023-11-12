<?php

namespace App\Core\View;

use App\Core\View\Parsers\IParser;
use ReflectionClass;

class ParserManager {
	/**
	 * @var IParser[]
	 */
	private array $parsers = [];

	public function __construct() {
		$this->addDefaultParsers();
	}

	public function addParser(IParser $parser) {
		$reflection = new ReflectionClass($parser);
		if ($reflection->implementsInterface(IParser::class)) {
			$this->parsers[] = $parser;
		} else {
			throw new \InvalidArgumentException('All parsers must implement the IParser interface');
		}
	}

	private function addDefaultParsers() {
		$files = glob(__DIR__ . '/Parsers/*.php');
		if ($files === false) {
			throw new \RuntimeException('Failed to read the parser directory.');
		}

		foreach ($files as $file) {
			$class = 'App\\Core\\View\\Parsers\\' . pathinfo($file, PATHINFO_FILENAME);
			$this->loadAndAddParser($class);
		}
	}

	private function loadAndAddParser(string $class) {
		if (class_exists($class)) {
			$instance = new $class();

			if ($instance instanceof IParser) {
				$this->addParser($instance);
			} else {
				throw new \InvalidArgumentException('All parsers must implement the IParser interface');
			}
		}
	}

	public function getParsers(): array {
		return $this->parsers;
	}
}
