<?php

namespace App\Middlewares;

use App\Framework\Router\IMiddleware;
use App\Framework\Mimikyu;
use App\Helpers\Role;

final class AuthorizationMiddleware implements IMiddleware {
	protected $requiredRole;

	public function __construct($requiredRole) {
		$this->requiredRole = $requiredRole;
	}

	public function handle($req, $res, $next) {
		$role = Mimikyu::$app->session->getValue('role');
		$role = Role::from($role);

		$rolesHierarchy = [Role::ResearchGroupManager, Role::ResearchStudyManager, Role::Researcher];

		echo array_search($role, $rolesHierarchy) > array_search($this->requiredRole, $rolesHierarchy);

		if (
			in_array($role, $rolesHierarchy) &&
			array_search($role, $rolesHierarchy) > array_search($this->requiredRole, $rolesHierarchy)
		) {
			$res->redirect('/dashboard');
		}
		// else {
		// $next();
		// }
	}
}
