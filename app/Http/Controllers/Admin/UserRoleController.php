<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;

class UserRoleController extends Controller
{

    public function index(Request $request)
    {
        $query = User::with('roles'); // شروع کوئری

        // اگر فیلد جستجو پر شده بود
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('idCard', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10);
        $userCount = User::count();
        $roles = Role::all();
        return view('dashboard/allUserRoles', compact('users', 'roles', 'userCount'));
    }

    // فرم اختصاص نقش
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('dashboard/editUserRoles', compact('user', 'roles'));
    }

    // ذخیره نقش‌ها
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);
        $user->roles()->sync($request->roles);


        return redirect()->route('admin.user_roles.index')->with('success', 'نقش‌ها با موفقیت به‌روزرسانی شد.');
    }
}
