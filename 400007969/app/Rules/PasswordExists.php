<?php

namespace App\Rules;

use App\Framework\Mimikyu;
use App\Framework\Validator\Rules\IRule;

final class PasswordExists implements IRule {
	protected $field;

	public function getName(): string {
		return 'passwordexists';
	}

	public function validate($field, $value, $params): bool {
		$this->field = $field;

		$pdo = Mimikyu::$app->db->getConnection();

		$password = $pdo->prepare('SELECT password FROM users WHERE email = :email');
		$password->execute([
			'email' => $_POST['email'],
		]);

		$hash = $password->fetchColumn();

		if ($hash && password_verify($value, $hash)) {
			return true;
		}

		return false;
	}

	public function getErrorMessage(): string {
		return "This {$this->field} is incorrect.";
	}
}
