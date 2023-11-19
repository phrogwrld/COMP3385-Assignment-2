<?php

namespace App\Core\Validator\Rules;

use App\Core\Validator\Rules\IRule;

class RequiredRule implements IRule {
	protected $field;
	protected $name = 'required';

	public function validate($field, $value, $params): bool {
		$this->field = $field;

		return $value !== null && !empty($value);
	}

	public function getErrorMessage(): string {
		return "The {$this->field} field is required.";
	}

	public function getName(): string {
		return $this->name;
	}
}
