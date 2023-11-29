<?php

namespace App\Framework\Validator\Rules;

class EmailRule implements IRule {
	protected $field;
	protected $name = 'email';

	public function validate($field, $value, $params): bool {
		$this->field = $field;

		return filter_var($value, FILTER_VALIDATE_EMAIL);
	}

	public function getErrorMessage(): string {
		return "The {$this->field} field must be a valid email address.";
	}

	public function getName(): string {
		return $this->name;
	}
}
