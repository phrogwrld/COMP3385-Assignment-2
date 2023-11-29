<?php

namespace App\Framework\Validator;

use App\Framework\Mimikyu;

class Validator {
	/**
	 * @var array
	 */
	protected $errors = [];

	/**
	 * @var array
	 */
	protected $rules = [];

	private $ruleManager;

	public function __construct() {
		$this->ruleManager = Mimikyu::$app->getRuleManager();

		$this->rules = $this->ruleManager->getRules();
	}

	public function validate(array $data, array $rules) {
		foreach ($rules as $field => $fieldRules) {
			$fieldRules = explode('|', $fieldRules);

			foreach ($fieldRules as $rule) {
				$ruleName = null;
				$params = null;

				// Extract rule name and parameters
				[$ruleName, $params] = $this->parseRule($rule);

				$ruleInstance = $this->getRule($ruleName);

				if ($ruleInstance === null) {
					throw new \InvalidArgumentException("The {$ruleName} rule does not exist.");
				}

				if (!$ruleInstance->validate($field, $data[$field], $params)) {
					if (isset($this->errors[$field])) {
						continue;
					}
					$this->errors[$field] = $ruleInstance->getErrorMessage();
				}
			}
		}
	}

	private function parseRule($rule): array {
		$segments = explode(':', $rule, 2);
		$ruleName = $segments[0];
		$params = isset($segments[1]) ? $segments[1] : null;

		return [$ruleName, $params];
	}

	private function getRule(string $ruleName) {
		foreach ($this->rules as $rule) {
			if ($rule->getName() === $ruleName) {
				return $rule;
			}
		}

		return null;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function hasErrors() {
		return count($this->errors) > 0;
	}
}
