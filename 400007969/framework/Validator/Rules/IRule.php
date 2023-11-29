<?php

namespace App\Framework\Validator\Rules;

interface IRule {
	public function getName(): string;
	public function validate($field, $value, $params): bool;
	public function getErrorMessage(): string;
}
