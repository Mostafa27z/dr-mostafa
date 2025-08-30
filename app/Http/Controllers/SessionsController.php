<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Group;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    // عرض جميع الجلسات لمجموعة
    public function index(Group $group)
    {
        $sessions = $group->sessions()->latest()->paginate(10);
        return view('groups.sessions', compact('group', 'sessions'));
    }

    // عرض فورم إنشاء جلسة
    public function create(Group $group)
    {
        return view('groups.sessions-create', compact('group'));
    }

    // حفظ جلسة جديدة
    public function store(Request $request, Group $group)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'time'              => 'required|date',
            'interactive_link'  => 'nullable|url',
        ]);

        $group->sessions()->create([
            'title'            => $request->title,
            'description'      => $request->description,
            'time'             => $request->time,
            'interactive_link' => $request->interactive_link,
        ]);

        return redirect()->route('groups.sessions.index', $group->id)
                         ->with('success', 'تم إنشاء الجلسة بنجاح');
    }
}
