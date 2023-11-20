<?php

namespace App\Core\Database;

use App\Core\Mimikyu;

class QueryBuilder {
	protected $pdo;

	protected $table;

	public function __construct(string $table) {
		$this->table = $table;
		$this->pdo = new DatabaseConnection();
	}
}
