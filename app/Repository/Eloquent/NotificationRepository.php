<?php

namespace App\Repository\Eloquent;

use App\Models\Notification;
use App\Repository\Constracts\NotificationRepositoryInterface;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function getModel()
    {
        return Notification::class;
    }
    public function findByType(string $type): ?Notification
    {
        return $this->model->where('type', $type)->first();
    }
}
