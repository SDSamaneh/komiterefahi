<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Rules\IranianNationalCode;
use App\Rules\IranianMobile;
use App\Rules\PersianAlpha;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', new PersianAlpha],
            'idCard' => ['required', new IranianNationalCode, 'unique:users,idCard,' . $user->id],
            'phone_number' => ['required', new IranianMobile],
            'email'        => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password'     => 'nullable|string|min:4|confirmed',
        ]);


        $user->name = $request->name;
        $user->idCard = $request->idCard;
        $user->email = $request->filled('email') ? $request->email : null;
        $user->phone_number = $request->phone_number;

        // اگر کاربر پسورد وارد کرده بود
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'پروفایل با موفقیت بروزرسانی شد.');
    }
}
