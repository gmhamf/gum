<?php
// app/Http/Controllers/Member/DietController.php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diet;
use Carbon\Carbon;

class DietController extends Controller
{
    public function index(Request $request)
    {
        $member = auth()->guard('member')->user();

        $query = $member->diets();

        // البحث باسم الوجبة
        if ($request->has('search') && $request->search != '') {
            $query->where('meal_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // التصفية باليوم
        if ($request->has('day') && $request->day != '') {
            $query->where('day', $request->day);
        }

        // التصفية بالوقت
        if ($request->has('time') && $request->time != '') {
            $query->where('time', $request->time);
        }

        $diets = $query->orderBy('day', 'desc')->orderBy('time')->get();

        $search = $request->search;
        $selectedDay = $request->day;
        $selectedTime = $request->time;

        return view('member.diets.index', compact(
            'diets',
            'search',
            'selectedDay',
            'selectedTime'
        ));
    }
}
