<?php

namespace App\Services;

use App\Enums\UserStatus;
use App\Repository\Constracts\UserRepositoryInterface;
use Illuminate\Database\QueryException;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo
    ) {}

    public function toggleStatus(int $userId): ?string
    {
        $user = $this->userRepo->find($userId);
        if (!$user) return null;

        $user->status = $user->status === UserStatus::ACTIVE
            ? UserStatus::INACTIVE
            : UserStatus::ACTIVE;

        $user->save();

        return $user->status->value;
    }

    public function deleteUser(int $userId): bool
    {
        try {
            return $this->userRepo->delete($userId);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function getUsers($perPage, $sort, $search, $filter)
    {
        return $this->userRepo->getAllUser($perPage, $sort, $search, $filter);
    }

    public function countActive()
    {
        return $this->userRepo->countActive();
    }

    public function countNeedingAttention()
    {
        return $this->userRepo->countNeedingAttention();
    }
}
