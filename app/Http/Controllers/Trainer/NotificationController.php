<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Member;

class NotificationController extends Controller
{
    public function index()
    {
        $trainer = auth()->guard('trainer')->user();

        // جلب الأعضاء النشطين للمدرب
        $members = $trainer->members()->where('status', true)->get();

        // جلب كل الإشعارات الخاصة بأعضاء المدرب
        $notifications = Notification::whereIn('member_id', $members->pluck('id'))
            ->latest()
            ->get();

        return view('trainer.notifications.index', compact('members', 'notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        $trainer = auth()->guard('trainer')->user();

        // التأكد أن العضو تابع للمدرب
        $member = $trainer->members()->where('id', $request->member_id)->first();
        if (!$member) {
            return back()->withErrors(['member_id' => 'هذا العضو غير مسجل لديك']);
        }

        Notification::create([
            'member_id' => $request->member_id,
            'title' => $request->title,
            'message' => $request->message,
            'seen' => false
        ]);

        return redirect()->route('trainer.notifications.index')->with('success', 'تم إرسال الإشعار بنجاح');
    }
}
