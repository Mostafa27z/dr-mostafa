<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function renew(User $teacher)
    {
        $latestSubscription = $teacher->latestSubscription();
        return view('admin.teachers.renew', compact('teacher', 'latestSubscription'));
    }

    public function processRenewal(Request $request, User $teacher)
    {
        $request->validate([
            'ends_at' => 'required|date|after:today',
            'plan_name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
        ]);

        // If there's an active one, mark as canceled/expired or just replace
        // For simplicity, we create a new subscription record
        Subscription::create([
            'user_id' => $teacher->id,
            'plan_name' => $request->plan_name,
            'starts_at' => now(),
            'ends_at' => $request->ends_at,
            'status' => 'active',
            'price' => $request->price ?? 0,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'تم تجديد الاشتراك بنجاح');
    }
}
