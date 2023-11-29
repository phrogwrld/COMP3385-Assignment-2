<?php

namespace App\Controllers;

use App\Framework\Controller\BaseController;
use App\Framework\Mimikyu;
use App\Framework\Validator\Validator;
use App\Models\Entity\User;
use App\Models\Repository\UserRepository;
use App\Helpers\Role;

final class createResearcherController extends BaseController {
	public function index() {
		$role = Mimikyu::$app->session->getValue('role');
		$role = Role::from($role);

		$email = Mimikyu::$app->session->getValue('email');
		$username = Mimikyu::$app->session->getValue('username');

		// options array that passes all the roles in the enun
		$options = [
			Role::Researcher->value,
			Role::ResearchStudyManager->value,
			// Role::ResearchGroupManager->value,
		];

		$this->view('./400007969/app/View/createResearcher.php', [
			'title' => 'Admin | Create Researcher',
			'role' => $role,
			'email' => $email,
			'username' => $username,
			'options' => $options,
			'createEmail' => null,
			'createUsername' => null,
			'createPassword' => null,
		]);
	}

	public function createResearcher() {
		$role = Mimikyu::$app->session->getValue('role');
		$role = Role::from($role);

		$email = Mimikyu::$app->session->getValue('email');
		$username = Mimikyu::$app->session->getValue('username');

		// options array that passes all the roles in the enun
		$options = [
			Role::Researcher->value,
			Role::ResearchStudyManager->value,
			// Role::ResearchGroupManager->value,
		];

		$createEmail = $_POST['email'];
		$createUsername = $_POST['username'];
		$createPassword = $_POST['password'];
		$createRole = $_POST['role'];

		$validator = new Validator();

		$validator->validate(
			[
				'email' => $createEmail,
				'username' => $createUsername,
				'password' => $createPassword,
				'role' => $createRole,
			],
			[
				'email' => 'required|email',
				'username' => 'required|uniqueusername',
				'password' => 'required',
				'role' => 'required',
			],
		);

		if ($validator->hasErrors()) {
			return $this->view('./400007969/app/View/createResearcher.php', [
				'title' => 'Admin | Create Researcher',
				'errors' => $validator->getErrors(),
				'role' => $role,
				'email' => $email,
				'username' => $username,
				'options' => $options,
				'createEmail' => $createEmail ? $createEmail : null,
				'createUsername' => $createUsername ? $createUsername : null,
				'createPassword' => $createPassword ? $createPassword : null,
			]);
		}

		$userRepo = new UserRepository(Mimikyu::$app->db);

		$user = new User(null, $createUsername, $createEmail, $createPassword, Role::fromString($createRole));

		$userRepo->create($user);

		$this->view('./400007969/app/View/createResearcher.php', [
			'title' => 'Admin | Create Researcher',
			'role' => $role,
			'email' => $email,
			'username' => $username,
			'options' => $options,
			'success' => 'Researcher created successfully!',
		]);
	}
}
