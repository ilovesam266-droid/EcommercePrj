<?php

namespace Database\Seeders;

use App\Enums\MailType;
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

        // $templates = [
        //     [
        //         'title' => 'Welcome New User',
        //         'created_by' => 1,
        //         'body' => '<p>Hello {{$fullname}},</p>
        //         <p>Thank you for registering an account at {{$app_name}}.</p>
        //         <p>Please confirm your account by clicking <a href="{{verification_link}}">this link</a>.</p>',
        //         'type' => 'user_registered',
        //         'variables' => json_encode([
        //             '{{$fullname}}' => 'User name',
        //             '{{$user_email}}' => 'User email',
        //             '{{$verification_link}}' => 'Account verification link',
        //             '{{$app_name}}' => 'Application name',
        //         ]),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ],
        //     [
        //         'title' => 'Order Confirmed',
        //         'created_by' => 1,
        //         'body' => '<p>Hello {{$fullname}},</p>
        // <p>Your order {{$order_id}} has been confirmed.</p>',
        //         'type' => 'order_confirmed',
        //         'variables' => json_encode([
        //             '{{$fullname}}' => 'Customer name',
        //             '{{$order_id}}' => 'Order code',
        //         ]),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ],
        //     [
        //         'title' => 'Order Shipping',
        //         'created_by' => 1,
        //         'body' => '<p>Hello {{$fullname}},</p>
        // <p>Your order {{$order_id}} is on the way.</p>',
        //         'type' => 'order_shipping',
        //         'variables' => json_encode([
        //             '{{$fullname}}' => 'Customer name',
        //             '{{$order_id}}' => 'Order code',
        //         ]),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ],
        //     [
        //         'title' => 'Order Delivered Successfully',
        //         'created_by' => 1,
        //         'body' => '<p>Hello {{$fullname}},</p>
        // <p>We confirm that your order {{$order_id}} was delivered on {{$done_at}}.</p>
        // <p>Thank you for shopping at {{$app_name}}!</p>',
        //         'type' => 'order_done',
        //         'variables' => json_encode([
        //             '{{$fullname}}' => 'Customer name',
        //             '{{$order_id}}' => 'Order code',
        //             '{{$done_at}}' => 'Delivery date',
        //             '{{$app_name}}' => 'Application name',
        //         ]),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ],
        //     [
        //         'title' => 'Order Failed',
        //         'created_by' => 1,
        //         'body' => '<p>Hello {{$fullname}},</p>
        // <p>Unfortunately, your order {{$order_id}} could not be processed.</p>',
        //         'type' => 'order_failed',
        //         'variables' => json_encode([
        //             '{{$fullname}}' => 'Customer name',
        //             '{{$order_id}}' => 'Order code',
        //         ]),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ],
        //     [
        //         'title' => 'Personal Offer Just for You',
        //         'created_by' => 1,
        //         'body' => '<p>Hello {{$fullname}},</p>
        // <p>You’ve received a {{$offer_discount}} discount with code: {{$offer_code}}.</p>
        // <p>Valid until {{$offer_expiry_date}}. <a href="{{$offer_link}}">Click to activate</a>.</p>',
        //         'type' => 'personal_offer',
        //         'variables' => json_encode([
        //             '{{$fullname}}' => 'Customer name',
        //             '{{$offer_code}}' => 'Offer code',
        //             '{{$offer_discount}}' => 'Discount amount',
        //             '{{$offer_expiry_date}}' => 'Expiration date',
        //             '{{$offer_link}}' => 'Offer activation link',
        //         ]),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ],
        //     [
        //         'title' => 'Newsletter / Periodic Promotion',
        //         'created_by' => 1,
        //         'body' => '<h3>{{$newsletter_title}}</h3>
        // <p>{{$newsletter_content}}</p>
        // <p><a href="{{$unsubscribe_link}}">Unsubscribe</a></p>',
        //         'type' => 'newsletter',
        //         'variables' => json_encode([
        //             '{{$fullname}}' => 'Recipient name',
        //             '{{$newsletter_title}}' => 'Newsletter title',
        //             '{{$newsletter_content}}' => 'Newsletter content',
        //             '{{$unsubscribe_link}}' => 'Unsubscribe link',
        //         ]),
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ],
        // ];

        $templates = [
            [
                'title' => 'Order Cancelled',
                'created_by' => 1,
                'body' => '<p>Hi {{$fullname}},</p>
                    <p>Your order <strong>#{{$order_number}}</strong> placed on {{$order_date}} has been cancelled.</p>

                    <p>Reason for cancellation: {{$cancel_reason}}</p>

                    <p>Order details:</p>
                    <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{$order_items}}
                        </tbody>
                    </table>

                    <p>If you have any questions, please contact our support team at {{$support_email}}.</p>',
                                    'type' => 'order_canceled',
                                    'variables' => json_encode([
                                        '{{$fullname}}' => 'Customer full name',
                                        '{{$order_number}}' => 'Order number',
                                        '{{$order_date}}' => 'Date when order was placed',
                                        '{{$cancel_reason}}' => 'Reason why order was cancelled',
                                        '{{$support_email}}' => 'Support contact email',
                                        '{{$order_items}}' => 'HTML table rows of all products in the order',

                                        // Các biến chi tiết cho từng item (có thể dùng trong loop)
                                        '{{$item.name}}' => 'Product name',
                                        '{{$item.variant}}' => 'Product variant/size',
                                        '{{$item.sku}}' => 'Product SKU',
                                        '{{$item.quantity}}' => 'Quantity ordered',
                                        '{{$item.price}}' => 'Unit price',
                                        '{{$item.subtotal}}' => 'Subtotal (price * quantity)',
                                    ]),
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                ],
                            ];

        DB::table('mails')->insert($templates);
    }
}
