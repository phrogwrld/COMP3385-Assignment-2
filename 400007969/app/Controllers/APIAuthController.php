<?php

namespace App\Controllers;

use App\Framework\Controller\BaseController;
use App\Framework\Mimikyu;
use App\Framework\Validator\Validator;
use App\Models\Repository\UserRepository;

class APIAuthController extends BaseController {
	public function login() {
		$rawBody = $this->request->getBody();
		$body = json_decode($rawBody);

		if (json_last_error() !== JSON_ERROR_NONE) {
			// Handle JSON decoding error
			echo 'Error decoding JSON: ' . json_last_error_msg();
		}

		$email = $body->email;
		$password = $body->password;

		$validator = new Validator();

		$userRepo = new UserRepository(Mimikyu::$app->db);

		$user = $userRepo->findByEmail($email);

		$pdo = Mimikyu::$app->db->getConnection();

		$hash = $pdo->prepare('SELECT password FROM users WHERE email = :email');
		$hash->execute([
			'email' => $email,
		]);

		$hash = $hash->fetchColumn();

		if (!($hash && password_verify($password, $hash))) {
			return $this->json(
				[
					'message' => 'Invalid credentials',
					'email' => $email,
					'password' => $password,
				],
				401,
			);
		}

		// Mimikyu::$app->session->setValue('email', $email);
		// Mimikyu::$app->session->setValue('username', $user->getUsername());
		// Mimikyu::$app->session->setValue('role', $user->getRole()->value);

		return $this->json([
			'message' => 'Authenticated successfully with Basic Auth',
			'user' => [
				'email' => $email,
				'username' => $user->getUsername(),
				'role' => $user->getRole()->value,
			],
		]);
	}
}
