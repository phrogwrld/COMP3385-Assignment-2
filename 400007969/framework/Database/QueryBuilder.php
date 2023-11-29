<?php

namespace App\Framework\Database;

use App\Framework\Mimikyu;

class QueryBuilder {
	protected $pdo;

	protected $table;

	public function __construct(string $table) {
		$this->table = $table;
		$this->pdo = new DatabaseConnection();
	}
}
