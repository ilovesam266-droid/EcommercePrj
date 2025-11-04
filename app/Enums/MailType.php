<?php

namespace App\Enums;

enum MailType :string
{
    case Transactional = 'transactional'; // Email giao dịch (xác nhận đơn hàng, reset mật khẩu...)
    case Marketing = 'marketing';         // Email quảng cáo, khuyến mãi
    case Newsletter = 'newsletter';       // Bản tin định kỳ
    case Onboarding = 'onboarding';       // Hướng dẫn người dùng mới
    case Retention = 'retention';         // Giữ chân người dùng
    case Feedback = 'feedback';           // Khảo sát, đánh giá
    case Notification = 'notification';   // Thông báo hệ thống
    case Event = 'event';                 // Mời tham gia hoặc nhắc sự kiện

    public function label(): string
    {
        return match($this) {
            self::Transactional => 'Transactional',
            self::Marketing => 'Marketing',
            self::Newsletter => 'Newsletter',
            self::Onboarding => 'Onboarding',
            self::Retention => 'Retention',
            self::Feedback => 'Feedback',
            self::Notification => 'Notification',
            self::Event => 'Event',
        };
    }

    public function colorClass(): string
    {
        return match ($this) {
            self::Transactional => 'bg-warning text-white',
            self::Marketing => 'bg-info text-white',
            self::Newsletter => 'bg-primary text-white',
            self::Onboarding => 'bg-secondary text-white',
            self::Retention => 'bg-danger text-white',
            self::Feedback => 'bg-success text-white',
            self::Notification => 'bg-black text-white',
            self::Event => 'bg-greendark text-white',
        };
    }
}
