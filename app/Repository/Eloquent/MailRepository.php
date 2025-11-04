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
}
