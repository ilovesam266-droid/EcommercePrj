<?php

namespace App\Repository\Eloquent;

use App\Enums\UserStatus;
use App\Repository\Constracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getAllUser($perPage, $sort, $search, $filter)
    {
        return $this->all($this->getFilteredUsers(
            $filter,
            $search
        ), ['created_at' => $sort], $perPage, ['*'], ['defaultAddress'], false);
    }

    /**
     * Count active users (example: status = 1)
     */
    public function countActive(): int
    {
        return $this->model->where('status', UserStatus::ACTIVE)->count();
    }

    /**
     * Count users needing attention (example: missing profile fields)
     */
    public function countNeedingAttention(array $requiredFields = ['first_name', 'last_name', 'email_verified_at', 'remember_token', 'email', 'role']): int
    {
        return $this->model->where(function ($q) use ($requiredFields) {
            foreach ($requiredFields as $field) {
                $q->orWhereNull($field)->orWhere($field, '');
            }
        })->count();
    }

    public function getFilteredUsers(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($filter, $search) {
            // Lọc theo status hoặc role nếu có
            if (!empty($filter['status']) || !empty($filter['role'])) {
                $this->buildCriteria($query, $filter);
            }

            // Tìm kiếm theo từ khóa
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
        };
    }
}
