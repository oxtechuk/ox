<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:super_admin,admin,editor',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'تم إضافة المستخدم بنجاح!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:super_admin,admin,editor',
            'is_active' => 'nullable|boolean',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح!');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الحالي أثناء تسجيل الدخول.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
