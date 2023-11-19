<?php

namespace App\Core\Validator\Rules;

use App\Core\Validator\Rules\IRule;

class PasswordRule implements IRule {
	protected $field;
	protected $name = 'password';

	public function validate($field, $value, $params): bool {
		$this->field = $field;

		return preg_match('/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{10,}$/', $value);
	}

	public function getErrorMessage(): string {
		return "The {$this->field} field must be at least 8 characters long, contain at least one uppercase letter & a digit.";
	}

	public function getName(): string {
		return $this->name;
	}
}
