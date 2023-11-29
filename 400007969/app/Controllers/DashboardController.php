<?php

namespace App\Controllers;

use App\Framework\Controller\BaseController;
use App\Framework\Mimikyu;
use App\Helpers\Role;

final class DashboardController extends BaseController {
	public function index() {
		$role = Mimikyu::$app->session->getValue('role');
		$role = Role::from($role);

		$email = Mimikyu::$app->session->getValue('email');
		$username = Mimikyu::$app->session->getValue('username');

		$options = [
			Role::Researcher->value => ['View All Studies' => '/view'],
			Role::ResearchStudyManager->value => [
				'View All Studies' => '/view',
				'Create New Study' => '/create',
				'Delete Previous Study' => '/delete',
			],
			Role::ResearchGroupManager->value => [
				'View All Studies' => '/view',
				'Create New Study' => '/create',
				'Delete Previous Study' => '/delete',
				'Create New Researchers' => '/createResearcher',
			],
		];

		$this->view('./400007969/app/View/dashboard.php', [
			'title' => 'Dashboard',
			'role' => $role,
			'email' => $email,
			'username' => $username,
			'options' => $options[$role->value],
		]);
	}
}
