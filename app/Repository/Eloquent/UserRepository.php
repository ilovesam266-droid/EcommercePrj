<?php

namespace App\Repository\Eloquent;

use App\Repository\Constracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
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
