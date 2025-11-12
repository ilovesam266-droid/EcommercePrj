<?php

namespace Database\Seeders;

use App\Models\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Mail::factory()->count(20)->create();
        $now = now();

        $templates = [
            [
                'title' => 'Welcome New User',
                'created_by' => 1,
                'body' => '<p>Hello {{$fullname}},</p>
                <p>Thank you for registering an account at {{$app_name}}.</p>
                <p>Please confirm your account by clicking <a href="{{verification_link}}">this link</a>.</p>',
                'type' => 'user_registered',
                'variables' => json_encode([
                    '{{$fullname}}' => 'User name',
                    '{{$user_email}}' => 'User email',
                    '{{$verification_link}}' => 'Account verification link',
                    '{{$app_name}}' => 'Application name',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Confirmed',
                'created_by' => 1,
                'body' => '<p>Hello {{$fullname}},</p>
        <p>Your order {{$order_id}} has been confirmed.</p>',
                'type' => 'order_confirmed',
                'variables' => json_encode([
                    '{{$fullname}}' => 'Customer name',
                    '{{$order_id}}' => 'Order code',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Shipping',
                'created_by' => 1,
                'body' => '<p>Hello {{$fullname}},</p>
        <p>Your order {{$order_id}} is on the way.</p>',
                'type' => 'order_shipping',
                'variables' => json_encode([
                    '{{$fullname}}' => 'Customer name',
                    '{{$order_id}}' => 'Order code',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Delivered Successfully',
                'created_by' => 1,
                'body' => '<p>Hello {{$fullname}},</p>
        <p>We confirm that your order {{$order_id}} was delivered on {{$done_at}}.</p>
        <p>Thank you for shopping at {{$app_name}}!</p>',
                'type' => 'order_done',
                'variables' => json_encode([
                    '{{$fullname}}' => 'Customer name',
                    '{{$order_id}}' => 'Order code',
                    '{{$done_at}}' => 'Delivery date',
                    '{{$app_name}}' => 'Application name',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Order Failed',
                'created_by' => 1,
                'body' => '<p>Hello {{$fullname}},</p>
        <p>Unfortunately, your order {{$order_id}} could not be processed.</p>',
                'type' => 'order_failed',
                'variables' => json_encode([
                    '{{$fullname}}' => 'Customer name',
                    '{{$order_id}}' => 'Order code',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Personal Offer Just for You',
                'created_by' => 1,
                'body' => '<p>Hello {{$fullname}},</p>
        <p>You’ve received a {{$offer_discount}} discount with code: {{$offer_code}}.</p>
        <p>Valid until {{$offer_expiry_date}}. <a href="{{$offer_link}}">Click to activate</a>.</p>',
                'type' => 'personal_offer',
                'variables' => json_encode([
                    '{{$fullname}}' => 'Customer name',
                    '{{$offer_code}}' => 'Offer code',
                    '{{$offer_discount}}' => 'Discount amount',
                    '{{$offer_expiry_date}}' => 'Expiration date',
                    '{{$offer_link}}' => 'Offer activation link',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Newsletter / Periodic Promotion',
                'created_by' => 1,
                'body' => '<h3>{{$newsletter_title}}</h3>
        <p>{{$newsletter_content}}</p>
        <p><a href="{{$unsubscribe_link}}">Unsubscribe</a></p>',
                'type' => 'newsletter',
                'variables' => json_encode([
                    '{{$fullname}}' => 'Recipient name',
                    '{{$newsletter_title}}' => 'Newsletter title',
                    '{{$newsletter_content}}' => 'Newsletter content',
                    '{{$unsubscribe_link}}' => 'Unsubscribe link',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('mails')->insert($templates);
    }
}
