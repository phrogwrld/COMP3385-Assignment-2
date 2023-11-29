<?php

namespace App\Models\Repository;

use App\Framework\Database\DatabaseConnection;
use App\Helpers\Role;
use App\Models\IRepository;
use App\Models\Entity\User;

use PDO;

final class UserRepository implements IRepository {
	private DatabaseConnection $database;

	public function __construct(DatabaseConnection $database) {
		$this->database = $database;
	}

	/**
	 * Creates a new user in the database.
	 *
	 * @param User $user The user to create.
	 *
	 * @return bool True if the user was created successfully, false otherwise.
	 */
	public function create(object $user): bool {
		if (!$user instanceof User) {
			throw new \InvalidArgumentException('The user must be an instance of User.');
		}
		$sql = 'INSERT INTO users(username, password, email, role) VALUES (?, ?, ?, ?) ';
		$stmt = $this->database->getConnection()->prepare($sql);

		$username = $user->getUsername();
		$email = $user->getEmail();
		$password = $user->getPassword();
		$role = $user->getRole()->value;

		$stmt->execute([$username, $password, $email, $role]);

		return $stmt->rowCount() > 0;
	}

	/**
	 * Finds a user by their ID.
	 *
	 * @param int $id The ID of the user to find.
	 *
	 * @return User|null The user, or null if the user was not found.
	 */
	public function find(int $id): ?User {
		$sql = 'SELECT * FROM users WHERE id = ?';
		$stmt = $this->database->getConnection()->prepare($sql);

		$stmt->execute([$id]);

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$user) {
			return null;
		}

		return new User($user['id'], $user['username'], $user['email'], $user['password'], Role::fromString($user['role']));
	}

	/**
	 * Finds a user by their email.
	 *
	 * @param string $email The email of the user to find.
	 *
	 * @return User|null The user, or null if the user was not found.
	 */
	public function findByEmail(string $email): ?User {
		$sql = 'SELECT * FROM users WHERE email = ?';
		$stmt = $this->database->getConnection()->prepare($sql);

		$stmt->execute([$email]);

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$user) {
			return null;
		}

		return new User($user['id'], $user['username'], $user['email'], $user['password'], Role::fromString($user['role']));
	}

	/**
	 * Finds all users.
	 *
	 * @return User[] An array of users.
	 */
	public function findAll(): array {
		$sql = 'SELECT * FROM users';
		$stmt = $this->database->getConnection()->prepare($sql);

		$stmt->execute();

		$users = [];

		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user) {
			$users[] = new User(
				$user['id'],
				$user['username'],
				$user['email'],
				$user['password'],
				Role::fromString($user['role']),
			);
		}

		return $users;
	}

	/**
	 * Updates a user.
	 *
	 * @param User $user The user to update.
	 *
	 * @return bool True if the user was updated successfully, false otherwise.
	 */
	public function update(object $user): bool {
		if (!$user instanceof User) {
			throw new \InvalidArgumentException('The user must be an instance of User.');
		}
		$sql = 'UPDATE users SET username = ?, password = ?, email = ?, role = ? WHERE id = ?';
		$stmt = $this->database->getConnection()->prepare($sql);

		$username = $user->getUsername();
		$email = $user->getEmail();
		$password = $user->getPassword();
		$role = $user->getRole();
		$id = $user->getId();

		$stmt->execute([$username, $password, $email, $role, $id]);

		return $stmt->rowCount() > 0;
	}

	/**
	 * Deletes a user.
	 *
	 * @param User $user The user to delete.
	 *
	 * @return bool True if the user was deleted successfully, false otherwise.
	 */
	public function delete(object $user): bool {
		if (!$user instanceof User) {
			throw new \InvalidArgumentException('The user must be an instance of User.');
		}
		$sql = 'DELETE FROM users WHERE id = ?';
		$stmt = $this->database->getConnection()->prepare($sql);

		$id = $user->getId();

		$stmt->execute([$id]);

		return $stmt->rowCount() > 0;
	}
}
