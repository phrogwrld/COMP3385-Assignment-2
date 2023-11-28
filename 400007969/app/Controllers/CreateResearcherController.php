<?php

namespace App\Controllers;

use App\Core\Controller\BaseController;
use App\Core\Mimikyu;
use App\Core\Validator\Validator;
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
		]);
	}

	public function createResearcher() {
		// options array that passes all the roles in the enun
		$options = [
			Role::Researcher->value,
			Role::ResearchStudyManager->value,
			// Role::ResearchGroupManager->value,
		];

		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = $_POST['role'];

		$validator = new Validator();

		$validator->validate(
			[
				'email' => $email,
				'username' => $username,
				'password' => $password,
				'role' => $role,
			],
			[
				'email' => 'required|email',
				'username' => 'required|uniqueusername',
				'password' => 'required',
				'role' => 'required',
			],
		);

		if ($validator->hasErrors()) {
			foreach ($validator->getErrors() as $error) {
				echo $error;
			}

			return $this->view('./400007969/app/View/createResearcher.php', [
				'title' => 'Admin | Create Researcher',
				'errors' => $validator->getErrors(),
				'role' => $role,
				'email' => $email,
				'username' => $username,
				'options' => $options,
			]);
		}

		$userRepo = new UserRepository(Mimikyu::$app->db);

		$user = new User(null, $username, $email, $password, Role::fromString($role));

		$userRepo->create($user);

		$this->view('./400007969/app/View/createResearcher.php', [
			'title' => 'Admin | Create Researcher',
			'role' => Role::from(Mimikyu::$app->session->getValue('role')),
			'email' => Mimikyu::$app->session->getValue('email'),
			'username' => Mimikyu::$app->session->getValue('username'),
			'options' => $options,
			'success' => 'Researcher created successfully!',
		]);
	}
}
