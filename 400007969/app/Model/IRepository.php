<?php
/**
 * An interface for repositories. A repository is responsible for managing a model (Simple CRUD).
 */

namespace App\Models;

interface IRepository {
	/**
	 * Create a new model.
	 *
	 * @param object $model The model to create.
	 *
	 * @return bool True if the model was created successfully, false otherwise.
	 */
	public function create(object $model): bool;

	/**
	 * Find a model by its ID.
	 *
	 * @param int $id The ID of the model to find.
	 *
	 * @return ?object The model, or null if the model could not be found.
	 */
	public function find(int $id): ?object;

	/**
	 * Find all models.
	 *
	 * @return array An array of models.
	 */
	public function findAll(): array;

	/**
	 * Update a model.
	 *
	 * @param object $model The model to update.
	 *
	 * @return bool True if the model was updated successfully, false otherwise.
	 */
	public function update(object $model): bool;

	/**
	 * Delete a model.
	 *
	 * @param object $model The model to delete.
	 *
	 * @return bool True if the model was deleted successfully, false otherwise.
	 */
	public function delete(object $model): bool;
}
