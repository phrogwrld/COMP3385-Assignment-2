<?php

namespace App\Framework\View;

use App\Framework\View\Parsers\IParser;

class ParserManager {
	/**
	 * @var IParser[]
	 */
	private array $parsers = [];

	public function __construct() {
		$this->addDefaultParsers();
	}

	public function addParser(IParser $parser) {
		if (is_a($parser, IParser::class)) {
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
			$class = 'App\\Framework\\View\\Parsers\\' . pathinfo($file, PATHINFO_FILENAME);
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
