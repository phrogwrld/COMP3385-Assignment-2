<?php

namespace App\Framework\Database;

use App\Framework\Database\DatabaseException;
use PDO;
use PDOException;

class DatabaseConnection {
	/**
	 * The hostname of the database server.
	 *
	 * @var ?string
	 */
	private ?string $host = 'localhost';

	/**
	 * The port number of the database server.
	 *
	 * @var ?int
	 */
	private ?int $port = 3306;

	/**
	 * The username for the database connection.
	 *
	 * @var ?string
	 */
	private ?string $username = 'root';

	/**
	 * The password for the database connection.
	 *
	 * @var ?string
	 */
	private ?string $password = '';

	/**
	 * The name of the database to connect to.
	 *
	 * @var string
	 */
	private string $database = 'user_management_system';

	/**
	 * The PDO connection object.
	 *
	 * @var ?PDO
	 */
	private ?PDO $connection = null;

	/**
	 * Constructor.
	 *
	 * @param ?string $host The hostname of the database server.
	 * @param ?int $port The port number of the database server.
	 * @param ?string $username The username for the database connection.
	 * @param ?string $password The password for the database connection.
	 * @param string $database The name of the database to connect to.
	 */
	public function __construct(
		?string $host = 'localhost',
		?int $port = 3306,
		?string $username = 'root',
		?string $password = null,
		string $database = 'user_management_system',
	) {
		$this->host = $host ?? $this->host;
		$this->port = $port ?? $this->port;
		$this->username = $username ?? $this->username;
		$this->password = $password ?? $this->password;
		$this->database = $database ?? $this->database;
	}

	/**
	 * Connect to the database.
	 *
	 * @throws \Exception if the connection fails.
	 */
	protected function connect(): void {
		try {
			if (!$this->connection) {
				$this->connection = new PDO(
					'mysql:host=' . $this->host . ';dbname=' . $this->database,
					$this->username,
					$this->password,
				);
			}
		} catch (PDOException $e) {
			throw new DatabaseException('MySQL connection failed: ' . $e->getMessage());
		}
	}

	/**
	 * Disconnect from the database.
	 */
	protected function disconnect(): void {
		if ($this->connection) {
			$this->connection = null;
		}
	}

	/**
	 * Gets the PDO connection object.
	 *
	 * @return PDO The PDO connection object.
	 */
	public function getConnection(): PDO {
		$this->connect();
		return $this->connection;
	}
}
