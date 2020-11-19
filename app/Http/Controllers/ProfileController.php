<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return response()->view("profile.edit");
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'old_password' => [
                'required',

                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Kata sandi lama anda tidak cocok');
                    }
                }
            ],
            'new_password' => [
                'required', 'min:6', 'confirmed', 'different:old_password'
            ]
        ]);

        $user->fill([
            'password' => Hash::make($validated['new_password'])
        ])->save();

        return redirect()->back()->with('success', 'Kata sandi sudah diganti');
    }
}
