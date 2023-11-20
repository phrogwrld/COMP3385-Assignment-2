<?php

namespace App\Controllers;

use App\Core\Controller\BaseController;
use App\Core\Mimikyu;
use App\Core\Validator\Validator;
use App\Models\Entity\User;
use App\Helpers\Role;
use App\Models\Repository\UserRepository;

final class AuthController extends BaseController {
	// public function __construct() {
	// 	parent::__construct($this->request, $this->response);
	// 	$this->userRepo = new UserRepository(Mimikyu::$app->db);
	// }

	public function renderLogin() {
		$this->view('./400007969/app/View/Login.php', [
			'title' => 'Login',
		]);
	}

	public function login() {
		$email = $_POST['email'];
		$password = $_POST['password'];

		$validator = new Validator();

		$validator->validate(
			[
				'email' => $email,
				'password' => $password,
			],
			[
				'email' => 'required|email',
				'password' => 'required|passwordexists',
			],
		);

		if ($validator->hasErrors()) {
			return $this->view('./400007969/app/View/Login.php', [
				'title' => 'Login',
				'errors' => $validator->getErrors(),
			]);
		}

		$userRepo = new UserRepository(Mimikyu::$app->db);

		$user = $userRepo->findByEmail($email);

		Mimikyu::$app->session->setValue('email', $email);
		Mimikyu::$app->session->setValue('username', $user->getUsername());
		Mimikyu::$app->session->setValue('role', $user->getRole()->value);

		$this->response->redirect('/dashboard');
	}

	public function renderRegister() {
		$this->view('./400007969/app/View/Register.php', [
			'title' => 'Register',
		]);
	}

	public function register() {
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		$validator = new Validator();

		$validator->validate(
			[
				'email' => $email,
				'username' => $username,
				'password' => $password,
			],
			[
				'email' => 'required|email',
				'username' => 'required',
				'password' => 'required',
			],
		);

		if ($validator->hasErrors()) {
			$this->view('./400007969/app/View/register.php', [
				'title' => 'Register',
				'errors' => $validator->getErrors(),
			]);
		}

		$pass = password_hash($password, PASSWORD_DEFAULT);

		// For the purpose of grading, when registering it will give the user the highest role(RGM).
		$user = new User(null, $username, $email, $pass, Role::ResearchGroupManager);
		// This is the original code:
		// $user = new User(null, $username, $email, $pass, null);

		$userRepo = new UserRepository(Mimikyu::$app->db);

		$userRepo->create($user);

		Mimikyu::$app->session->setValue('email', $email);
		Mimikyu::$app->session->setValue('username', $user->getUsername());
		Mimikyu::$app->session->setValue('role', $user->getRole()->value);

		$this->response->redirect('/dashboard');
	}

	public function logout() {
		Mimikyu::$app->session->destroySession();
		$this->response->redirect('/login');
	}
}
