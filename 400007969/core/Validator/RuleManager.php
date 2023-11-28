<?php

namespace App\Core\Validator;

use App\Core\Validator\Rules\IRule;

class RuleManager {
	/**
	 * @var IRules[]
	 */
	private $rules = [];

	public function __construct() {
		$this->addDefaultRules();
	}

	private function addDefaultRules() {
		$files = glob(__DIR__ . '/Rules/*.php');
		if ($files === false) {
			throw new \RuntimeException('Failed to read the rule directory.');
		}

		foreach ($files as $file) {
			$class = 'App\\Core\\Validator\\Rules\\' . pathinfo($file, PATHINFO_FILENAME);
			$this->loadAndAddRules($class);
		}
	}

	private function loadAndAddRules(string $class) {
		if (class_exists($class)) {
			$instance = new $class();

			if ($instance instanceof IRule) {
				$this->addRule($instance);
			} else {
				throw new \InvalidArgumentException('All rules must implement the IRules interface');
			}
		}
	}

	public function addRule(IRule $rule) {
		if (is_a($rule, IRule::class)) {
			$this->rules[] = $rule;
		} else {
			throw new \InvalidArgumentException('All rules must implement the IRules interface');
		}
	}

	public function getRules(): array {
		return $this->rules;
	}
}
