<?php
// app/Http/Controllers/Member/ProgressController.php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;
use Illuminate\Support\Facades\Storage;

class ProgressController extends Controller
{
  public function index()
{
    $member = auth()->guard('member')->user();

    // بدل get() استخدم paginate()
    $progress = $member->progress()->latest()->paginate(10);

    return view('member.progress.index', compact('progress'));
}


    public function create()
    {
        $member = auth()->guard('member')->user();
        $latestProgress = $member->latestProgress();

        return view('member.progress.create', compact('latestProgress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'chest' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'arms' => 'nullable|numeric|min:0',
            'thighs' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:1000',
            'image_before' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'image_after' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $member = auth()->guard('member')->user();

        $progressData = [
            'member_id' => $member->id,
            'date' => now(),
            'weight' => $request->weight,
            'height' => $request->height,
            'chest' => $request->chest,
            'waist' => $request->waist,
            'arms' => $request->arms,
            'thighs' => $request->thighs,
            'note' => $request->note
        ];

        // رفع صورة قبل
        if ($request->hasFile('image_before')) {
            $progressData['image_before'] = $request->file('image_before')->store('progress', 'public');
        }

        // رفع صورة بعد
        if ($request->hasFile('image_after')) {
            $progressData['image_after'] = $request->file('image_after')->store('progress', 'public');
        }

        Progress::create($progressData);

        return redirect()->route('member.progress.index')->with('success', 'تم تحديث التقدم بنجاح');
    }

    public function destroy(Progress $progress)
    {
        // التأكد من أن التقدم يخص اللاعب
        if ($progress->member_id !== auth()->guard('member')->id()) {
            abort(403);
        }

        // حذف الصور إذا وجدت
        if ($progress->image_before) {
            Storage::disk('public')->delete($progress->image_before);
        }
        if ($progress->image_after) {
            Storage::disk('public')->delete($progress->image_after);
        }

        $progress->delete();

        return redirect()->route('member.progress.index')->with('success', 'تم حذف سجل التقدم بنجاح');
    }
}
