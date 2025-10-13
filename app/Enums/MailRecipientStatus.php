<?php

namespace App\Enums;

enum MailRecipientStatus : string
{
    //unread, read, failed
    case UNREAD = 'unread';
    case READ = 'read';
    case FAILED = 'failed';
}
