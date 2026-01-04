<?php
// app/Http/Controllers/Member/NotificationController.php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * عرض قائمة الإشعارات مع التصفح.
     */
    public function index()
    {
        $member = auth()->guard('member')->user();

        // استخدام paginate بدل get() لكي تعمل links()
        $notifications = $member->notifications()->latest()->paginate(10);

        // تحديث كل الإشعارات الغير مقروءة كمقروءة
        $member->notifications()->where('seen', false)->update(['seen' => true]);

        return view('member.notifications.index', compact('notifications'));
    }

    /**
     * تعليم إشعار كمقروء.
     */
    public function markAsRead(Notification $notification)
    {
        $memberId = auth()->guard('member')->id();

        if ($notification->member_id !== $memberId) {
            abort(403); // منع الوصول غير المصرح به
        }

        $notification->update(['seen' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * حذف إشعار.
     */
    public function destroy(Notification $notification)
    {
        $memberId = auth()->guard('member')->id();

        if ($notification->member_id !== $memberId) {
            abort(403);
        }

        $notification->delete();

        return redirect()
            ->route('member.notifications.index')
            ->with('success', 'تم حذف الإشعار بنجاح');
    }
}
