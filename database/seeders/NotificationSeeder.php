<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $notifications = [
            [
                'title' => 'Welcome New User',
                'created_by' => 1,
                'type' => 'user_registered',
                'body' => 'Hello {{$fullname}}, welcome to {{$app_name}}!',
                'variables' => json_encode([
                    '{{$fullname}}' => 'User name',
                    '{{$app_name}}' => 'Application name',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Confirmed',
                'created_by' => 1,
                'type' => 'order_confirmed',
                'body' => 'Your order {{$order_id}} has been confirmed.',
                'variables' => json_encode([
                    '{{$order_id}}' => 'Order code',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Shipping',
                'created_by' => 1,
                'type' => 'order_shipping',
                'body' => 'Your order {{$order_id}} is on the way.',
                'variables' => json_encode([
                    '{{$order_id}}' => 'Order code',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Delivered',
                'created_by' => 1,
                'type' => 'order_done',
                'body' => 'Your order {{$order_id}} was delivered successfully.',
                'variables' => json_encode([
                    '{{$order_id}}' => 'Order code',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Canceled',
                'created_by' => 1,
                'type' => 'order_canceled',
                'body' => 'Your order {{$order_id}} has been canceled.',
                'variables' => json_encode([
                    '{{$order_id}}' => 'Order code',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'System Alert',
                'created_by' => 1,
                'type' => 'system_alert',
                'body' => 'System maintenance scheduled at {{$maintenance_time}}.',
                'variables' => json_encode([
                    '{{$maintenance_time}}' => 'Scheduled time',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('notifications')->insert($notifications);
    }
}
