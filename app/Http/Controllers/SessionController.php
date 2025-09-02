<?php

namespace App\Http\Controllers;

use App\Models\GroupSession as Session;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    // عرض جميع الجلسات
    public function index()
    {
        $sessions = Session::with('group')
            ->whereHas('group', function($query) {
                $query->where('teacher_id', Auth::id());
            })
            ->latest()
            ->paginate(10);
            
        $groups = Group::where('teacher_id', Auth::id())->get();
        
        return view('sessions.index', compact('sessions', 'groups'));
    }

    // عرض فورم إنشاء جلسة
    public function create()
    {
        $groups = Group::where('teacher_id', Auth::id())->get();
        return view('sessions.create', compact('groups'));
    }

    // حفظ جلسة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time' => 'required|date',
            'link' => 'nullable|url',
            'group_id' => 'required|exists:groups,id',
        ]);

        // التحقق من أن المجموعة تابعة للمعلم
        $group = Group::where('id', $request->group_id)
                    ->where('teacher_id', Auth::id())
                    ->firstOrFail();

        Session::create([
            'title' => $request->title,
            'description' => $request->description,
            'time' => $request->time,
            'link' => $request->link,
            'group_id' => $request->group_id,
        ]);

        return redirect()->route('sessions.index')
                         ->with('success', 'تم إنشاء الجلسة بنجاح');
    }

    // عرض جلسة معينة
    public function show(Session $session)
    {
        // التحقق من أن الجلسة تابعة للمعلم
        if ($session->group->teacher_id !== Auth::id()) {
            abort(403);
        }

        $session->load('group');
        return view('sessions.show', compact('session'));
    }

    // عرض فورم تعديل جلسة
    public function edit(Session $session)
    {
        // التحقق من أن الجلسة تابعة للمعلم
        if ($session->group->teacher_id !== Auth::id()) {
            abort(403);
        }

        $groups = Group::where('teacher_id', Auth::id())->get();
        return view('sessions.edit', compact('session', 'groups'));
    }

    // تحديث الجلسة
    public function update(Request $request, Session $session)
    {
        // التحقق من أن الجلسة تابعة للمعلم
        if ($session->group->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time' => 'required|date',
            'link' => 'nullable|url',
            'group_id' => 'required|exists:groups,id',
        ]);

        // التحقق من أن المجموعة الجديدة تابعة للمعلم
        $group = Group::where('id', $request->group_id)
                    ->where('teacher_id', Auth::id())
                    ->firstOrFail();

        $session->update([
            'title' => $request->title,
            'description' => $request->description,
            'time' => $request->time,
            'link' => $request->link,
            'group_id' => $request->group_id,
        ]);

        return redirect()->route('sessions.index')
                         ->with('success', 'تم تحديث الجلسة بنجاح');
    }

    // حذف جلسة
    public function destroy(Session $session)
    {
        // التحقق من أن الجلسة تابعة للمعلم
        if ($session->group->teacher_id !== Auth::id()) {
            abort(403);
        }

        $session->delete();

        return redirect()->route('sessions.index')
                         ->with('success', 'تم حذف الجلسة بنجاح');
    }
}