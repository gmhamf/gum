<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gym\Auth\LoginController as GymLoginController;
use App\Http\Controllers\Trainer\Auth\LoginController as TrainerLoginController;
use App\Http\Controllers\Member\Auth\LoginController as MemberLoginController;
use App\Http\Controllers\Gym\DashboardController as GymDashboardController;
use App\Http\Controllers\Gym\TrainerController;
use App\Http\Controllers\Gym\MemberController;
use App\Http\Controllers\Gym\SubscriptionController;
use App\Http\Controllers\Gym\ReportController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\WorkoutController as MemberWorkoutController;
use App\Http\Controllers\Member\DietController as MemberDietController;
use App\Http\Controllers\Member\ProgressController as MemberProgressController;
use App\Http\Controllers\Member\NotificationController as MemberNotificationController;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Trainer\MemberController as TrainerMemberController;
use App\Http\Controllers\Trainer\WorkoutController as TrainerWorkoutController;
use App\Http\Controllers\Trainer\DietController as TrainerDietController;
use App\Http\Controllers\Trainer\NotificationController as TrainerNotificationController;

Route::get('/', function () {
    return view('welcome');
});

// مسارات تسجيل الدخول
Route::prefix('gym')->group(function () {
    Route::get('/login', [GymLoginController::class, 'showLoginForm'])->name('gym.login');
    Route::post('/login', [GymLoginController::class, 'login']);
    Route::post('/logout', [GymLoginController::class, 'logout'])->name('gym.logout');
});

Route::prefix('trainer')->group(function () {
    Route::get('/login', [TrainerLoginController::class, 'showLoginForm'])->name('trainer.login');
    Route::post('/login', [TrainerLoginController::class, 'login']);
    Route::post('/logout', [TrainerLoginController::class, 'logout'])->name('trainer.logout');
});

Route::prefix('member')->group(function () {
    Route::get('/login', [MemberLoginController::class, 'showLoginForm'])->name('member.login');
    Route::post('/login', [MemberLoginController::class, 'login']);
    Route::post('/logout', [MemberLoginController::class, 'logout'])->name('member.logout');
});

// مسارات صاحب القاعة (محمية)
Route::middleware(['auth:gym'])->prefix('gym')->name('gym.')->group(function () {
    Route::get('/dashboard', [GymDashboardController::class, 'index'])->name('dashboard');
    Route::resource('trainers', TrainerController::class);
    Route::resource('members', MemberController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::post('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])->name('subscriptions.renew');
    Route::post('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
});

// مسارات اللاعب (Member)
Route::middleware(['auth:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
    Route::get('/workouts', [MemberWorkoutController::class, 'index'])->name('workouts.index');
    Route::get('/workouts/{workout}', [MemberWorkoutController::class, 'show'])->name('workouts.show');
    Route::get('/diets', [MemberDietController::class, 'index'])->name('diets.index');
    Route::get('/progress', [MemberProgressController::class, 'index'])->name('progress.index');
    Route::get('/progress/create', [MemberProgressController::class, 'create'])->name('progress.create');
    Route::post('/progress', [MemberProgressController::class, 'store'])->name('progress.store');
    Route::delete('/progress/{progress}', [MemberProgressController::class, 'destroy'])->name('progress.destroy');

    // إشعارات العضو
    Route::get('/notifications', [MemberNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [MemberNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/{notification}/read', [MemberNotificationController::class, 'markAsReadSingle'])->name('notifications.read');
    Route::delete('/notifications/{notification}', [MemberNotificationController::class, 'destroy'])->name('notifications.destroy');
});
// مسارات المدرب (Trainer)
Route::middleware(['auth:trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');

    // --- التعديل هنا ---

    // بدلاً من كتابة كل رابط يدوياً، نستخدم resource لإنشاء Create و Store و Edit وغيرها
    Route::resource('members', TrainerMemberController::class);

    // راوت التقدم (Progress) مخصص لذلك نتركه كما هو، لكن تأكد أن دالة progress موجودة في الكنترولر
    Route::get('/members/{member}/progress', [TrainerMemberController::class, 'progress'])->name('members.progress');

    // -------------------

    // الجداول التدريبية
    Route::resource('workouts', TrainerWorkoutController::class);
    Route::post('/workouts/{workout}/assign', [TrainerWorkoutController::class, 'assignToMember'])->name('workouts.assign');

    // الأنظمة الغذائية
    Route::resource('diets', TrainerDietController::class);
    Route::post('/diets/{diet}/assign', [TrainerDietController::class, 'assignToMember'])->name('diets.assign');

    // الإشعارات
    Route::get('/notifications', [TrainerNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [TrainerNotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [TrainerNotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications/mark-as-read', [TrainerNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{notification}', [TrainerNotificationController::class, 'destroy'])->name('notifications.destroy');
});
// مسارات إضافية للواجهات العامة
Route::middleware(['auth:gym,trainer,member'])->group(function () {
    Route::get('/profile', function () {
        // تحديد نوع المستخدم وتوجيهه للبروفايل المناسب
        if (auth()->guard('gym')->check()) {
            return redirect()->route('gym.dashboard');
        } elseif (auth()->guard('trainer')->check()) {
            return redirect()->route('trainer.dashboard');
        } else {
            return redirect()->route('member.dashboard');
        }
    })->name('profile');
});
