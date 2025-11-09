<?php

namespace App\Repository\Eloquent;

use App\Models\Mail;
use App\Repository\Constracts\MailRepositoryInterface;

class MailRepository extends BaseRepository implements MailRepositoryInterface
{
    public function getModel()
    {
        return Mail::class;
    }

    public function findByType(string $type): ?Mail
    {
        return $this->model->where('type', $type)->first();
    }
}
