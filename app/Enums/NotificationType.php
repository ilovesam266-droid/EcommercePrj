<?php

namespace App\Enums;

enum NotificationType: string
{
    case OrderConfirmed = 'order_confirmed';
    case OrderCanceled = 'order_canceled';
    case OrderShipping = 'order_shipping';
    case OrderFailed = 'order_failed';
    case OrderDone = 'order_done';
    case PersonalOffer = 'personal_offer';
    case Newsletter = 'newsletter';
    case UserRegistered = 'user_registered';
    case EmailVerification = 'email_verification';
    case SystemAlert = 'system_alert'; // ✅ thêm mới

    public function label(): string
    {
        return match($this) {
            self::OrderConfirmed => 'order_confirmed',
            self::OrderCanceled => 'order_canceled',
            self::OrderShipping => 'order_shipping',
            self::OrderFailed => 'order_failed',
            self::OrderDone => 'order_done',
            self::PersonalOffer => 'personal_offer',
            self::Newsletter => 'newsletter',
            self::UserRegistered => 'user_registered',
            self::EmailVerification => 'email_verification',
            self::SystemAlert => 'system_alert', // ✅ thêm mới
        };
    }

    public function colorClass(): string
    {
        return match ($this) {
            self::OrderConfirmed => 'bg-warning text-white',
            self::OrderCanceled => 'bg-secondary text-white',
            self::OrderShipping => 'bg-info text-white',
            self::OrderFailed => 'bg-dark text-white',
            self::OrderDone => 'bg-primary text-white',
            self::PersonalOffer => 'bg-danger text-white',
            self::Newsletter => 'bg-success text-white',
            self::UserRegistered => 'bg-success text-white',
            self::EmailVerification => 'bg-success text-white',
            self::SystemAlert => 'bg-light text-danger', // ✅ màu riêng cho cảnh báo hệ thống
        };
    }
}
