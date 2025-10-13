<?php

namespace App\Enums;

enum NotificationRecipientStatus : string
{
    //unread, read, failed
    case UNREAD = 'unread';
    case READ = 'read';
    case FAILED = 'failed';
}
