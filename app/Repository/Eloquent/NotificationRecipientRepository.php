<?php

namespace App\Repository\Eloquent;

use App\Models\NotificationRecipient;
use App\Repository\Constracts\NotificationRecipientRepositoryInterface;

class NotificationRecipientRepository extends BaseRepository implements NotificationRecipientRepositoryInterface
{
    public function getModel()
    {
        return NotificationRecipient::class;
    }
}
