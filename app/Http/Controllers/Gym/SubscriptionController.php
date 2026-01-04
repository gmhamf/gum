<?php
// app/Http/Controllers/Gym/GymSubscriptionController.php

namespace App\Http\Controllers\Gym;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Member;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $gym = auth()->guard('gym')->user();

        $query = Subscription::whereHas('member', function($query) use ($gym) {
            $query->where('gym_id', $gym->id);
        })->with('member');

        // البحث بالاسم
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('member', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('member_code', 'like', '%' . $request->search . '%');
            });
        }

        // التصفية بنوع الاشتراك
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // التصفية بالحالة
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // التصفية بالتاريخ
        if ($request->has('date_filter') && $request->date_filter != '') {
            $this->applyDateFilter($query, $request->date_filter);
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->get();

        $search = $request->search;
        $selectedType = $request->type;
        $selectedStatus = $request->status;
        $selectedDateFilter = $request->date_filter;

        return view('gym.subscriptions.index', compact(
            'subscriptions',
            'search',
            'selectedType',
            'selectedStatus',
            'selectedDateFilter'
        ));
    }

    private function applyDateFilter($query, $filter)
    {
        $today = Carbon::today();

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', $today);
                break;
            case 'week':
                $query->whereBetween('created_at', [$today->startOfWeek(), $today->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', $today->month)
                      ->whereYear('created_at', $today->year);
                break;
            case 'expiring_soon':
                $query->where('end_date', '<=', $today->addDays(7))
                      ->where('end_date', '>=', $today)
                      ->where('status', 'active');
                break;
            case 'expired':
                $query->where('end_date', '<', $today)
                      ->where('status', 'active');
                break;
        }
    }

    public function create()
    {
        $gym = auth()->guard('gym')->user();
        $members = Member::where('gym_id', $gym->id)->where('status', true)->get();
        return view('gym.subscriptions.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:daily,weekly,monthly,yearly',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $this->calculateEndDate($startDate, $request->type);

        Subscription::create([
            'member_id' => $request->member_id,
            'type' => $request->type,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'amount' => $request->amount,
            'status' => 'active'
        ]);

        return redirect()->route('gym.subscriptions.index')->with('success', 'تم إضافة الاشتراك بنجاح');
    }

    private function calculateEndDate($startDate, $type)
    {
        switch ($type) {
            case 'daily':
                return $startDate->copy()->addDay();
            case 'weekly':
                return $startDate->copy()->addWeek();
            case 'monthly':
                return $startDate->copy()->addMonth();
            case 'yearly':
                return $startDate->copy()->addYear();
            default:
                return $startDate->copy()->addMonth();
        }
    }

    public function renew(Subscription $subscription)
    {
        // التحقق من أن الاشتراك يتبع القاعة الحالية
        if ($subscription->member->gym_id !== auth()->guard('gym')->id()) {
            abort(403);
        }

        $startDate = now();
        $endDate = $this->calculateEndDate($startDate, $subscription->type);

        $subscription->update([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active'
        ]);

        return redirect()->route('gym.subscriptions.index')->with('success', 'تم تجديد الاشتراك بنجاح');
    }

    public function cancel(Subscription $subscription)
    {
        // التحقق من أن الاشتراك يتبع القاعة الحالية
        if ($subscription->member->gym_id !== auth()->guard('gym')->id()) {
            abort(403);
        }

        $subscription->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('gym.subscriptions.index')->with('success', 'تم إلغاء الاشتراك بنجاح');
    }

    public function destroy(Subscription $subscription)
    {
        // التحقق من أن الاشتراك يتبع القاعة الحالية
        if ($subscription->member->gym_id !== auth()->guard('gym')->id()) {
            abort(403);
        }

        $subscription->delete();

        return redirect()->route('gym.subscriptions.index')->with('success', 'تم حذف الاشتراك بنجاح');
    }
}
