<?php

namespace App\Repository\Constracts;

use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    /**
     * @param array $relations Relationship required
     * @param bool $withTrashed Does it have any softdelete record?
     * @return Builder
     */
    public function query(array $relations = [], bool $withTrashed = false);

    /**
     * Retrieve all records or records matching the given filters and sorting.
     * Supports pagination.
     *
     * @param array $filters Filtering conditions (e.g. ['status' => 'active', 'name' => '%john%']).
     * @param array $sort Sorting conditions (e.g. ['name' => 'asc', 'created_at' => 'desc']).
     * @param ?int $perPage Number of records per page (if null, retrieves all).
     * @param array $columns Columns to select.
     * @param array $relations Relationships to load (e.g. ['posts']).
     * @param bool $withTrashed Include soft-deleted records?
     * @return
     */
    public function all(array|callable $criteria = [], array $sort = [], ?int $perPage = null, array $columns = ['*'], array $relations = [], bool $withTrashed = false);

    /**
     * Find a single record by ID or by an array of conditions.
     *
     * @param int|array $criteria The record ID or an array of conditions.
     * @param array $relations Relationships to load.
     * @param bool $withTrashed Whether to include soft-deleted records.
     * @return Model|null
     */
    public function find(int|string|array|callable $criteria, array $relations = [], bool $withTrashed = false);

    /**
     * Create a new record
     * @param array $data Data for create a record
     * @return Model
     */
    public function create(array $data);

    /**
     * Update a record by its ID.
     *
     * @param int $id The ID of the record to update.
     * @param array $data The data to update.
     * @return Model|null The updated record, or null if not found.
     */
    public function update(int $id, array $data);

    /**
     * Delete a record by its ID.
     *
     * @param int $id The ID of the record to delete.
     * @param bool $forceDelete True to force delete, false (default) for soft delete.
     * @return bool True if deletion was successful, false if not found or an error occurred.
     */
    public function delete(int $id, bool $forceDelete = false);

    /**
     * Delete multiple records based on filtering conditions.
     *
     * @param array $filters Conditions used to select the records to delete.
     * @param bool $forceDelete True to force delete, false (default) for soft delete.
     * @return int Number of records deleted.
     */
    public function deleteBulk(array|callable $criteria, bool $forceDelete = false);

    /**
     * Restore a soft-deleted record.
     *
     * @param int|array $criteria Criteria to locate the record (ID or an array of conditions).
     */
    public function restoreSoft(int|array|callable $criteria);

    public function buildCriteria(Builder $query, mixed $criteria);

    public function handleCriteria(Builder $query, $field, $value);

    public function exists(array|callable $criteria);
}
