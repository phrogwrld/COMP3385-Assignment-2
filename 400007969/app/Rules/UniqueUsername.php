<?php

namespace App\Rules;

use App\Core\Mimikyu;
use App\Core\Validator\Rules\IRule;

final class UniqueUsername implements IRule {
	protected $field;

	public function getName(): string {
		return 'uniqueusername';
	}

	public function validate($field, $value, $params): bool {
		$this->field = $field;

		$pdo = Mimikyu::$app->db->getConnection();

		$users = $pdo->prepare('SELECT * FROM users WHERE username = :username');
		$users->execute([
			'username' => $value,
		]);

		$users = $users->fetchAll();

		return count($users) === 0;
	}

	public function getErrorMessage(): string {
		return "This {$this->field} is already taken.";
	}
}
