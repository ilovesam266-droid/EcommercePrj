<?php

namespace App\Repository\Eloquent;

use App\Models\MailRecipient;
use App\Repository\Constracts\MailRecipientRepositoryInterface;
use App\Repository\Constracts\MailRepositoryInterface;

class MailRecipientRepository extends BaseRepository implements MailRecipientRepositoryInterface
{
    public function getModel(){
        return MailRecipient::class;
    }
}
