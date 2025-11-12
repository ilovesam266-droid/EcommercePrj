<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Admin\Addresses;
use App\Livewire\Admin\Blog\CreateBlog;
use App\Livewire\Admin\Blog\EditBlog;
use App\Livewire\Admin\Blogs;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Comments;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\User\CreateUser;
use App\Livewire\Admin\Images;
use App\Livewire\Admin\Mail\EditMail;
use App\Livewire\Admin\Order\EditOrder;
use App\Livewire\Admin\Order\CreateOrder;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Product\CreateProduct;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Mails;
use App\Livewire\Admin\Mail\CreateMail;
use App\Livewire\Admin\Notification\CreateNotification;
use App\Livewire\Admin\Notification\EditNotification;
use App\Livewire\Admin\Notifications;
use App\Livewire\Admin\Product\EditProduct;
use App\Livewire\Admin\Reviews;
use App\Mail\OrderCancelledMail;
use App\Models\Mail;
use App\Models\Order;
use App\Notifications\OrderCancelledNotification;
use Illuminate\Support\Facades\Mail as MailFacade;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Check action view
 */
// Route::prefix('admin')->name('admin.')->group(function(){
//         Route::view('/', 'admin.pages.auth.login')->name('login');
//         Route::view('/login', 'admin.pages.auth.login')->name('login');
//         Route::view('/register', 'admin.pages.auth.register')->name('register');
//         Route::view('/forgot-password', 'admin.pages.auth.forgot')->name('password.request');
//         Route::view('/dashboard', 'admin.pages.dashboard')->name('dashboard');
//         Route::view('/alert', 'admin.components.alert')->name('alert');
// });

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginShow'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user', Users::class)->name('user');
    Route::post('/user/create', CreateUser::class)->name('create_user');
    Route::get('/images', Images::class)->name('images');
    Route::get('/products', Products::class)->name('products');
    Route::get('/products/create', CreateProduct::class)->name('create_product');
    Route::get('/products/{editingProductId}/edit', EditProduct::class)->name('edit_product');
    Route::get('/orders', Orders::class)->name('orders');
    Route::get('/orders/create', CreateOrder::class)->name('create_order');
    Route::get('/mails', Mails::class)->name('mails');
    Route::get('/mails/create', CreateMail::class)->name('create_mail');
    Route::get('/mails/{editingMailId}/edit', EditMail::class)->name('edit_mail');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/notifications/create', CreateNotification::class)->name('create_notification');
    Route::get('/notifications/{editingNotificationId}/edit', EditNotification::class)->name('edit_notification');
    Route::get('/blogs', Blogs::class)->name('blogs');
    Route::get('/blogs/create', CreateBlog::class)->name('create_blog');
    Route::get('/blogs/{editingBlogId}/edit', EditBlog::class)->name('edit_blog');
    Route::get('/reviews', Reviews::class)->name('review');
    Route::get('/comments', Comments::class)->name('comments');
    Route::get('/addresses', Addresses::class)->name('addresses');
    Route::get('categories', Categories::class)->name('categories');
});
// Route::get('/test-mail', function () {
//     $template = Mail::first();
//     $variables = [
//         'user_name' => 'Mai Huy',
//         'order_code' => 'ORD123',
//         'cancel_reason' => 'Customer request',
//         'app_name' => config('app.name'),
//     ];

//     MailFacade::to('your_email@gmail.com')->sendNow(new OrderCancelledMail($template, $variables));
//     return 'Đã gửi mail thử';
// });
// Route::get('/test-notification', function () {
//     // Giả sử bạn có 1 order để test
//     $order = Order::with('owner')->first();
//     // dd($order);
//     if (!$order || !$order->owner) {
//         return 'Không tìm thấy order hoặc user.';
//     }

//     // Gửi notification (chạy ngay, không queue)
//     $order->owner->notify(new OrderCancelledNotification($order));

//     return '✅ Notification đã gửi — kiểm tra bảng notification_recipients nhé!';
// });
Route::view('/toast', 'admin.components.toast');
